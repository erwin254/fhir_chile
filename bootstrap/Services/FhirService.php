<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FhirService
{
    protected $client;
    protected $baseUrl;
    protected $chileCoreUrl;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => config('fhir.timeout', 30),
            'headers' => config('fhir.headers', [
                'Accept' => 'application/fhir+json',
                'Content-Type' => 'application/fhir+json',
            ])
        ]);
        
        $this->baseUrl = config('fhir.server_url', 'https://hapi.fhir.org/baseR4');
        $this->chileCoreUrl = config('fhir.chile_core_url', 'https://hl7chile.cl/fhir/ig/clcore/ImplementationGuide/hl7.fhir.cl.clcore');
    }

    /**
     * Obtener un recurso FHIR por ID
     */
    public function getResource($resourceType, $id)
    {
        try {
            $url = "{$this->baseUrl}/{$resourceType}/{$id}";
            $response = $this->client->get($url);
            
            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true),
                'status_code' => $response->getStatusCode()
            ];
        } catch (RequestException $e) {
            Log::error('Error al obtener recurso FHIR', [
                'resource_type' => $resourceType,
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => $e->getCode()
            ];
        }
    }

    /**
     * Buscar recursos FHIR
     */
    public function searchResources($resourceType, $params = [])
    {
        try {
            $url = "{$this->baseUrl}/{$resourceType}";
            
            if (!empty($params)) {
                $url .= '?' . http_build_query($params);
            }
            
            $response = $this->client->get($url);
            
            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true),
                'status_code' => $response->getStatusCode()
            ];
        } catch (RequestException $e) {
            Log::error('Error al buscar recursos FHIR', [
                'resource_type' => $resourceType,
                'params' => $params,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => $e->getCode()
            ];
        }
    }

    /**
     * Crear un nuevo recurso FHIR
     */
    public function createResource($resourceType, $data)
    {
        try {
            $url = "{$this->baseUrl}/{$resourceType}";
            $response = $this->client->post($url, [
                'json' => $data
            ]);
            
            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true),
                'status_code' => $response->getStatusCode()
            ];
        } catch (RequestException $e) {
            Log::error('Error al crear recurso FHIR', [
                'resource_type' => $resourceType,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => $e->getCode()
            ];
        }
    }

    /**
     * Actualizar un recurso FHIR existente
     */
    public function updateResource($resourceType, $id, $data)
    {
        try {
            $url = "{$this->baseUrl}/{$resourceType}/{$id}";
            $response = $this->client->put($url, [
                'json' => $data
            ]);
            
            return [
                'success' => true,
                'data' => json_decode($response->getBody()->getContents(), true),
                'status_code' => $response->getStatusCode()
            ];
        } catch (RequestException $e) {
            Log::error('Error al actualizar recurso FHIR', [
                'resource_type' => $resourceType,
                'id' => $id,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => $e->getCode()
            ];
        }
    }

    /**
     * Validar un recurso FHIR contra el perfil chileno
     */
    public function validateResource($resourceType, $data)
    {
        try {
            // Por ahora, validación básica
            // En una implementación real, se conectaría con un validador FHIR
            $validationResult = [
                'valid' => true,
                'errors' => [],
                'warnings' => []
            ];

            // Validaciones básicas para recursos chilenos
            if ($resourceType === 'Patient') {
                $validationResult = $this->validateChileanPatient($data);
            } elseif ($resourceType === 'Encounter') {
                $validationResult = $this->validateChileanEncounter($data);
            }

            return [
                'success' => true,
                'validation' => $validationResult
            ];
        } catch (\Exception $e) {
            Log::error('Error al validar recurso FHIR', [
                'resource_type' => $resourceType,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Validar un Patient chileno
     */
    private function validateChileanPatient($data)
    {
        $errors = [];
        $warnings = [];

        // Verificar que tenga identificador RUT
        if (!isset($data['identifier']) || empty($data['identifier'])) {
            $errors[] = 'El paciente debe tener al menos un identificador';
        } else {
            $hasRut = false;
            foreach ($data['identifier'] as $identifier) {
                if (isset($identifier['system']) && strpos($identifier['system'], 'rut') !== false) {
                    $hasRut = true;
                    break;
                }
            }
            
            if (!$hasRut) {
                $warnings[] = 'Se recomienda incluir un identificador RUT para pacientes chilenos';
            }
        }

        // Verificar dirección chilena
        if (isset($data['address']) && !empty($data['address'])) {
            foreach ($data['address'] as $address) {
                if (!isset($address['country']) || $address['country'] !== 'CL') {
                    $warnings[] = 'Se recomienda especificar el país como "CL" para direcciones chilenas';
                }
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings
        ];
    }

    /**
     * Validar un Encounter chileno
     */
    private function validateChileanEncounter($data)
    {
        $errors = [];
        $warnings = [];

        // Verificar que tenga referencia al paciente
        if (!isset($data['subject']) || !isset($data['subject']['reference'])) {
            $errors[] = 'El encuentro debe tener una referencia al paciente';
        }

        // Verificar que tenga clase de encuentro
        if (!isset($data['class']) || !isset($data['class']['code'])) {
            $errors[] = 'El encuentro debe tener una clase definida';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'warnings' => $warnings
        ];
    }

    /**
     * Obtener información del Core Chileno
     */
    public function getChileCoreInfo()
    {
        $resources = [];
        foreach (config('fhir.resources', []) as $resourceType => $config) {
            $resources[$resourceType] = $config['description'];
        }

        return [
            'name' => 'HL7 Chile Core',
            'url' => $this->chileCoreUrl,
            'description' => 'Perfil chileno de FHIR para interoperabilidad en salud',
            'version' => '1.0.0',
            'resources' => $resources,
            'chile_config' => config('fhir.chile', [])
        ];
    }
}
