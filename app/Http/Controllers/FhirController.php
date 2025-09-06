<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FhirService;

class FhirController extends Controller
{
    protected $fhirService;

    public function __construct(FhirService $fhirService)
    {
        $this->fhirService = $fhirService;
    }

    /**
     * Mostrar información del Core Chileno
     */
    public function chileCore()
    {
        $chileCoreInfo = $this->fhirService->getChileCoreInfo();
        
        return view('fhir.chile-core', compact('chileCoreInfo'));
    }

    /**
     * Validar un recurso FHIR
     */
    public function validateResource(Request $request)
    {
        $request->validate([
            'resource_type' => 'required|string',
            'resource_data' => 'required|json'
        ]);

        $resourceType = $request->resource_type;
        $resourceData = json_decode($request->resource_data, true);

        $result = $this->fhirService->validateResource($resourceType, $resourceData);

        return response()->json($result);
    }

    /**
     * Buscar recursos en el servidor FHIR
     */
    public function searchResources(Request $request)
    {
        $request->validate([
            'resource_type' => 'required|string',
            'search_params' => 'sometimes|array'
        ]);

        $resourceType = $request->resource_type;
        $searchParams = $request->search_params ?? [];

        $result = $this->fhirService->searchResources($resourceType, $searchParams);

        return response()->json($result);
    }

    /**
     * Obtener un recurso específico
     */
    public function getResource(Request $request, $resourceType, $id)
    {
        $result = $this->fhirService->getResource($resourceType, $id);

        return response()->json($result);
    }

    /**
     * Crear un nuevo recurso
     */
    public function createResource(Request $request)
    {
        $request->validate([
            'resource_type' => 'required|string',
            'resource_data' => 'required|array'
        ]);

        $resourceType = $request->resource_type;
        $resourceData = $request->resource_data;

        $result = $this->fhirService->createResource($resourceType, $resourceData);

        return response()->json($result);
    }
}
