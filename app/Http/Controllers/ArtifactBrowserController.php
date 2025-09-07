<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class ArtifactBrowserController extends Controller
{
    protected $artifactsPath;
    protected $canonicalsPath;

    public function __construct()
    {
        $this->artifactsPath = base_path('temp-ig/site');
        $this->canonicalsPath = base_path('temp-ig/site/canonicals.json');
    }

    /**
     * Mostrar el buscador de artefactos
     */
    public function index()
    {
        $artifacts = $this->getAllArtifacts();
        $categories = $this->getCategories();
        
        return view('fhir.artifact-browser', compact('artifacts', 'categories'));
    }

    /**
     * Buscar artefactos
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $type = $request->get('type', '');
            $category = $request->get('category', '');
            
            $artifacts = $this->getAllArtifacts();
            
            if (!$artifacts || $artifacts->isEmpty()) {
                return response()->json([
                    'artifacts' => [],
                    'total' => 0
                ]);
            }
            
            // Filtrar por búsqueda
            if (!empty($query)) {
                $artifacts = $artifacts->filter(function ($artifact) use ($query) {
                    return stripos($artifact['name'], $query) !== false ||
                           stripos($artifact['title'], $query) !== false ||
                           stripos($artifact['description'], $query) !== false;
                });
            }
            
            // Filtrar por tipo
            if (!empty($type)) {
                $artifacts = $artifacts->filter(function ($artifact) use ($type) {
                    return $artifact['type'] === $type;
                });
            }
            
            // Filtrar por categoría
            if (!empty($category)) {
                $artifacts = $artifacts->filter(function ($artifact) use ($category) {
                    return $this->getArtifactCategory($artifact) === $category;
                });
            }
            
            return response()->json([
                'artifacts' => $artifacts->values()->toArray(),
                'total' => $artifacts->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error searching artifacts: ' . $e->getMessage());
            return response()->json([
                'artifacts' => [],
                'total' => 0,
                'error' => 'Error al buscar artefactos'
            ], 500);
        }
    }

    /**
     * Obtener detalles de un artefacto específico
     */
    public function show($id)
    {
        $artifact = $this->getArtifactById($id);
        
        if (!$artifact) {
            abort(404, 'Artefacto no encontrado');
        }
        
        return view('fhir.artifact-detail', compact('artifact'));
    }

    /**
     * Obtener todos los artefactos
     */
    private function getAllArtifacts()
    {
        return Cache::remember('fhir_artifacts', 3600, function () {
            $artifacts = collect();
            
            try {
                if (File::exists($this->canonicalsPath)) {
                    $canonicals = json_decode(File::get($this->canonicalsPath), true);
                    
                    if (is_array($canonicals)) {
                        foreach ($canonicals as $canonical) {
                            if (is_array($canonical) && isset($canonical['id'], $canonical['type'])) {
                                $artifact = $this->loadArtifactDetails($canonical);
                                if ($artifact) {
                                    $artifacts->push($artifact);
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error loading artifacts: ' . $e->getMessage());
            }
            
            return $artifacts;
        });
    }

    /**
     * Cargar detalles de un artefacto
     */
    private function loadArtifactDetails($canonical)
    {
        $filename = $this->getArtifactFilename($canonical);
        $filePath = $this->artifactsPath . '/' . $filename;
        
        if (!File::exists($filePath)) {
            return null;
        }
        
        $content = json_decode(File::get($filePath), true);
        
        return [
            'id' => $canonical['id'],
            'type' => $canonical['type'],
            'name' => $canonical['name'],
            'url' => $canonical['url'],
            'version' => $canonical['version'],
            'title' => $content['title'] ?? $canonical['name'],
            'description' => $content['description'] ?? '',
            'status' => $content['status'] ?? 'unknown',
            'date' => $content['date'] ?? null,
            'publisher' => $content['publisher'] ?? 'HL7 Chile',
            'content' => $content,
            'category' => $this->getArtifactCategory($canonical),
            'icon' => $this->getArtifactIcon($canonical['type']),
            'color' => $this->getArtifactColor($canonical['type'])
        ];
    }

    /**
     * Obtener nombre del archivo del artefacto
     */
    private function getArtifactFilename($canonical)
    {
        $type = $canonical['type'];
        $id = $canonical['id'];
        
        switch ($type) {
            case 'StructureDefinition':
                return "StructureDefinition-{$id}.json";
            case 'CodeSystem':
                return "CodeSystem-{$id}.json";
            case 'ValueSet':
                return "ValueSet-{$id}.json";
            case 'CapabilityStatement':
                return "CapabilityStatement-{$id}.json";
            case 'ImplementationGuide':
                return "ImplementationGuide-{$id}.json";
            default:
                return "{$type}-{$id}.json";
        }
    }

    /**
     * Obtener categoría del artefacto
     */
    private function getArtifactCategory($artifact)
    {
        $type = $artifact['type'];
        $name = $artifact['name'];
        
        switch ($type) {
            case 'StructureDefinition':
                if (strpos($name, 'Core') === 0) {
                    return 'Core Profiles';
                } elseif (strpos($name, 'Cl') !== false) {
                    return 'Chilean Extensions';
                } else {
                    return 'Structure Definitions';
                }
            case 'CodeSystem':
                if (strpos($name, 'CS') === 0) {
                    return 'Chilean Code Systems';
                } else {
                    return 'Code Systems';
                }
            case 'ValueSet':
                if (strpos($name, 'VS') === 0) {
                    return 'Chilean Value Sets';
                } else {
                    return 'Value Sets';
                }
            case 'CapabilityStatement':
                return 'Capability Statements';
            case 'ImplementationGuide':
                return 'Implementation Guide';
            default:
                return 'Other';
        }
    }

    /**
     * Obtener icono del artefacto
     */
    private function getArtifactIcon($type)
    {
        switch ($type) {
            case 'StructureDefinition':
                return 'fas fa-sitemap';
            case 'CodeSystem':
                return 'fas fa-list-ul';
            case 'ValueSet':
                return 'fas fa-tags';
            case 'CapabilityStatement':
                return 'fas fa-server';
            case 'ImplementationGuide':
                return 'fas fa-book';
            default:
                return 'fas fa-file-code';
        }
    }

    /**
     * Obtener color del artefacto
     */
    private function getArtifactColor($type)
    {
        switch ($type) {
            case 'StructureDefinition':
                return '#3B82F6';
            case 'CodeSystem':
                return '#10B981';
            case 'ValueSet':
                return '#F59E0B';
            case 'CapabilityStatement':
                return '#8B5CF6';
            case 'ImplementationGuide':
                return '#EF4444';
            default:
                return '#6B7280';
        }
    }

    /**
     * Obtener categorías disponibles
     */
    private function getCategories()
    {
        return [
            'Core Profiles' => 'Perfiles principales del Core Chileno',
            'Chilean Extensions' => 'Extensiones específicas para Chile',
            'Structure Definitions' => 'Definiciones de estructura generales',
            'Chilean Code Systems' => 'Sistemas de códigos específicos de Chile',
            'Code Systems' => 'Sistemas de códigos generales',
            'Chilean Value Sets' => 'Conjuntos de valores específicos de Chile',
            'Value Sets' => 'Conjuntos de valores generales',
            'Capability Statements' => 'Declaraciones de capacidad',
            'Implementation Guide' => 'Guía de implementación'
        ];
    }

    /**
     * Obtener artefacto por ID
     */
    private function getArtifactById($id)
    {
        $artifacts = $this->getAllArtifacts();
        return $artifacts->firstWhere('id', $id);
    }

    /**
     * Obtener artefactos por tipo
     */
    public function getByType($type)
    {
        $artifacts = $this->getAllArtifacts();
        $filtered = $artifacts->where('type', $type);
        
        return response()->json([
            'artifacts' => $filtered->values(),
            'total' => $filtered->count()
        ]);
    }

    /**
     * Obtener estadísticas de artefactos
     */
    public function getStats()
    {
        try {
            $artifacts = $this->getAllArtifacts();
            
            if (!$artifacts || $artifacts->isEmpty()) {
                return response()->json([
                    'total' => 0,
                    'by_type' => [],
                    'by_category' => [],
                    'by_status' => []
                ]);
            }
            
            $stats = [
                'total' => $artifacts->count(),
                'by_type' => $artifacts->groupBy('type')->map->count()->toArray(),
                'by_category' => $artifacts->groupBy('category')->map->count()->toArray(),
                'by_status' => $artifacts->groupBy('status')->map->count()->toArray()
            ];
            
            return response()->json($stats);
        } catch (\Exception $e) {
            \Log::error('Error getting stats: ' . $e->getMessage());
            return response()->json([
                'total' => 0,
                'by_type' => [],
                'by_category' => [],
                'by_status' => [],
                'error' => 'Error al obtener estadísticas'
            ], 500);
        }
    }
}
