<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ArtifactBrowserController extends Controller
{
    protected $artifactsBaseUrl;
    protected $artifactsPath;
    protected $useLocalFallback;

    public function __construct()
    {
        $this->artifactsBaseUrl = config('fhir.artifacts_url', config('app.url') . '/fhir/artifacts');
        $this->artifactsPath = base_path('node_modules/hl7.fhir.cl.clcore');
        $this->useLocalFallback = config('fhir.use_local_fallback', true);
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
        
        // Get FHIR translations for the current locale
        $translations = trans('fhir');
        
        return view('fhir.artifact-detail', compact('artifact', 'translations'));
    }

    /**
     * Obtener todos los artefactos
     */
    private function getAllArtifacts()
    {
        return Cache::remember('fhir_artifacts_remote', 3600, function () {
            $artifacts = collect();
            
            // Try remote endpoint first
            try {
                $response = Http::timeout(10)->get($this->artifactsBaseUrl);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Handle different response formats
                    if (isset($data['artifacts']) && is_array($data['artifacts'])) {
                        // Response format: { "artifacts": [...] }
                        foreach ($data['artifacts'] as $artifactData) {
                            $artifact = $this->processArtifactData($artifactData);
                            if ($artifact) {
                                $artifacts->push($artifact);
                            }
                        }
                    } elseif (is_array($data)) {
                        // Response format: direct array of artifacts
                        foreach ($data as $artifactData) {
                            $artifact = $this->processArtifactData($artifactData);
                            if ($artifact) {
                                $artifacts->push($artifact);
                            }
                        }
                    }
                    
                    // If we got artifacts from remote, return them
                    if ($artifacts->isNotEmpty()) {
                        \Log::info('Successfully loaded ' . $artifacts->count() . ' artifacts from remote endpoint');
                        return $artifacts;
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Remote endpoint failed, trying local fallback: ' . $e->getMessage());
            }
            
            // Fallback to local files if remote fails or returns empty
            if ($this->useLocalFallback && File::exists($this->artifactsPath)) {
                \Log::info('Using local fallback for artifacts');
                $artifacts = $this->loadArtifactsFromLocal();
            }
            
            return $artifacts;
        });
    }

    /**
     * Cargar artefactos desde archivos locales (fallback)
     */
    private function loadArtifactsFromLocal()
    {
        $artifacts = collect();
        
        try {
            if (File::exists($this->artifactsPath)) {
                // Leer todos los archivos JSON del directorio del paquete npm
                $files = File::glob($this->artifactsPath . '/*.json');
                
                foreach ($files as $file) {
                    $filename = basename($file);
                    
                    // Saltar package.json y otros archivos no relevantes
                    if (in_array($filename, ['package.json'])) {
                        continue;
                    }
                    
                    $artifact = $this->loadArtifactFromFile($file, $filename);
                    if ($artifact) {
                        $artifacts->push($artifact);
                    }
                }
                
                \Log::info('Loaded ' . $artifacts->count() . ' artifacts from local files');
            }
        } catch (\Exception $e) {
            \Log::error('Error loading artifacts from local files: ' . $e->getMessage());
        }
        
        return $artifacts;
    }

    /**
     * Procesar datos de artefacto desde la respuesta remota
     */
    private function processArtifactData($artifactData)
    {
        try {
            // Si ya viene procesado desde el endpoint remoto
            if (isset($artifactData['id']) && isset($artifactData['type'])) {
                return $artifactData;
            }
            
            // Si viene como contenido FHIR crudo, procesarlo
            if (isset($artifactData['resourceType'])) {
                return $this->loadArtifactFromContent($artifactData);
            }
            
            return null;
        } catch (\Exception $e) {
            \Log::error("Error processing artifact data: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cargar artefacto desde contenido FHIR
     */
    private function loadArtifactFromContent($content)
    {
        try {
            if (!$content || !isset($content['resourceType'])) {
                return null;
            }
            
            $type = $content['resourceType'];
            $id = $content['id'] ?? 'unknown';
            $name = $content['name'] ?? $id;
            $title = $content['title'] ?? $name;
            $description = $content['description'] ?? '';
            $status = $content['status'] ?? 'unknown';
            $date = $content['date'] ?? null;
            $publisher = $content['publisher'] ?? 'HL7 Chile';
            $url = $content['url'] ?? '';
            $version = $content['version'] ?? '1.9.3';
            
            return [
                'id' => $id,
                'type' => $type,
                'name' => $name,
                'url' => $url,
                'version' => $version,
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'date' => $date,
                'publisher' => $publisher,
                'content' => $content,
                'category' => $this->getArtifactCategory(['type' => $type, 'name' => $name]),
                'icon' => $this->getArtifactIcon($type),
                'color' => $this->getArtifactColor($type)
            ];
        } catch (\Exception $e) {
            \Log::error("Error loading artifact from content: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cargar artefacto desde archivo (método legacy)
     */
    private function loadArtifactFromFile($filePath, $filename)
    {
        try {
            $content = json_decode(File::get($filePath), true);
            
            if (!$content || !isset($content['resourceType'])) {
                return null;
            }
            
            // Use the new method to process the content
            return $this->loadArtifactFromContent($content);
        } catch (\Exception $e) {
            \Log::error("Error loading artifact from file {$filename}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cargar detalles de un artefacto (método legacy)
     */
    private function loadArtifactDetails($canonical)
    {
        $filename = $this->getArtifactFilename($canonical);
        $filePath = $this->artifactsPath . '/' . $filename;
        
        if (!File::exists($filePath)) {
            return null;
        }
        
        return $this->loadArtifactFromFile($filePath, $filename);
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
        $artifact = $artifacts->firstWhere('id', $id);
        
        // If not found in cache, try to fetch directly from remote endpoint
        if (!$artifact) {
            try {
                $response = Http::timeout(30)->get($this->artifactsBaseUrl . '/' . $id);
                
                if ($response->successful()) {
                    $data = $response->json();
                    $artifact = $this->processArtifactData($data);
                }
            } catch (\Exception $e) {
                \Log::error("Error fetching artifact {$id} from remote endpoint: " . $e->getMessage());
            }
        }
        
        return $artifact;
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
