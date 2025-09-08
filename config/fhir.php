<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FHIR Server Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for FHIR server connections and endpoints
    |
    */

    'server_url' => env('FHIR_SERVER_URL', 'https://hapi.fhir.org/baseR4'),
    
    'chile_core_url' => env('FHIR_CHILE_CORE_URL', 'https://hl7chile.cl/fhir/ig/clcore/ImplementationGuide/hl7.fhir.cl.clcore'),
    
    'artifacts_url' => env('FHIR_ARTIFACTS_URL', env('APP_URL') . '/fhir/artifacts'),
    
    'use_local_fallback' => env('FHIR_USE_LOCAL_FALLBACK', true),
    
    'timeout' => env('FHIR_TIMEOUT', 30),
    
    'headers' => [
        'Accept' => 'application/fhir+json',
        'Content-Type' => 'application/fhir+json',
    ],

    /*
    |--------------------------------------------------------------------------
    | FHIR Resources Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for FHIR resources and their Chilean profiles
    |
    */

    'resources' => [
        'Patient' => [
            'profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClPatient',
            'description' => 'Paciente con identificadores chilenos (RUT)',
        ],
        'Encounter' => [
            'profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClEncounter',
            'description' => 'Encuentro médico con códigos locales',
        ],
        'Observation' => [
            'profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClObservation',
            'description' => 'Observaciones clínicas con terminologías chilenas',
        ],
        'Organization' => [
            'profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClOrganization',
            'description' => 'Organizaciones de salud chilenas',
        ],
        'Practitioner' => [
            'profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClPractitioner',
            'description' => 'Profesionales de la salud chilenos',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chilean Healthcare System Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration specific to the Chilean healthcare system
    |
    */

    'chile' => [
        'country_code' => 'CL',
        'rut_system' => 'http://www.registrocivil.cl/run',
        'fondo_system' => 'http://www.fonasa.cl',
        'isapre_system' => 'http://www.isapre.cl',
        'regions' => [
            'Región de Arica y Parinacota',
            'Región de Tarapacá',
            'Región de Antofagasta',
            'Región de Atacama',
            'Región de Coquimbo',
            'Región de Valparaíso',
            'Región Metropolitana',
            'Región del Libertador General Bernardo O\'Higgins',
            'Región del Maule',
            'Región de Ñuble',
            'Región del Biobío',
            'Región de La Araucanía',
            'Región de Los Ríos',
            'Región de Los Lagos',
            'Región Aysén del General Carlos Ibáñez del Campo',
            'Región de Magallanes y de la Antártica Chilena',
        ],
    ],
];

