<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Module;
use App\Models\FhirResource;
use App\Models\Lesson;

class FhirElearningSeeder extends Seeder
{
    public function run()
    {
        // Crear áreas
        $hospitalizado = Area::create([
            'name' => 'Hospitalizado',
            'slug' => 'hospitalizado',
            'description' => 'Módulos enfocados en el flujo de atención hospitalaria, desde el ingreso hasta el egreso del paciente.',
            'icon' => 'fas fa-hospital',
            'color' => '#3B82F6',
            'order' => 1,
            'is_active' => true
        ]);

        $urgencia = Area::create([
            'name' => 'Urgencia',
            'slug' => 'urgencia',
            'description' => 'Módulos para el manejo de pacientes en servicios de urgencia y emergencias médicas.',
            'icon' => 'fas fa-ambulance',
            'color' => '#EF4444',
            'order' => 2,
            'is_active' => true
        ]);

        $centroMedico = Area::create([
            'name' => 'Centro Médico',
            'slug' => 'centro-medico',
            'description' => 'Módulos para atención ambulatoria y consultas médicas en centros de salud.',
            'icon' => 'fas fa-user-md',
            'color' => '#10B981',
            'order' => 3,
            'is_active' => true
        ]);

        // Crear recursos FHIR
        $patientResource = FhirResource::create([
            'resource_type' => 'Patient',
            'name' => 'Paciente',
            'description' => 'Recurso que representa la información demográfica y administrativa de un paciente.',
            'example_data' => [
                'resourceType' => 'Patient',
                'id' => 'example-patient',
                'identifier' => [
                    [
                        'use' => 'usual',
                        'type' => [
                            'coding' => [
                                [
                                    'system' => 'http://terminology.hl7.org/CodeSystem/v2-0203',
                                    'code' => 'MR',
                                    'display' => 'Medical Record Number'
                                ]
                            ]
                        ],
                        'system' => 'http://hospital.sanidad.gob.cl',
                        'value' => '12345678-9'
                    ]
                ],
                'name' => [
                    [
                        'use' => 'official',
                        'family' => 'González',
                        'given' => ['Juan', 'Carlos']
                    ]
                ],
                'gender' => 'male',
                'birthDate' => '1985-03-15',
                'address' => [
                    [
                        'use' => 'home',
                        'line' => ['Av. Libertador Bernardo O\'Higgins 1234'],
                        'city' => 'Santiago',
                        'state' => 'Región Metropolitana',
                        'postalCode' => '8320000',
                        'country' => 'CL'
                    ]
                ]
            ],
            'explanation' => 'El recurso Patient contiene información demográfica básica del paciente, incluyendo identificadores, nombre, fecha de nacimiento, género y dirección.',
            'chile_core_profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClPatient',
            'is_active' => true
        ]);

        $encounterResource = FhirResource::create([
            'resource_type' => 'Encounter',
            'name' => 'Encuentro',
            'description' => 'Recurso que representa una interacción entre un paciente y un proveedor de atención médica.',
            'example_data' => [
                'resourceType' => 'Encounter',
                'id' => 'example-encounter',
                'status' => 'in-progress',
                'class' => [
                    'system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                    'code' => 'IMP',
                    'display' => 'inpatient encounter'
                ],
                'subject' => [
                    'reference' => 'Patient/example-patient'
                ],
                'period' => [
                    'start' => '2024-01-15T08:00:00Z'
                ],
                'reasonCode' => [
                    [
                        'coding' => [
                            [
                                'system' => 'http://snomed.info/sct',
                                'code' => '22298006',
                                'display' => 'Myocardial infarction'
                            ]
                        ]
                    ]
                ]
            ],
            'explanation' => 'El recurso Encounter representa un encuentro médico específico, incluyendo el tipo de encuentro, el paciente involucrado, el período de tiempo y la razón del encuentro.',
            'chile_core_profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClEncounter',
            'is_active' => true
        ]);

        // Crear más recursos FHIR
        $observationResource = FhirResource::create([
            'resource_type' => 'Observation',
            'name' => 'Observación',
            'description' => 'Recurso que representa una observación médica, resultado de laboratorio o medición vital.',
            'example_data' => [
                'resourceType' => 'Observation',
                'id' => 'example-observation',
                'status' => 'final',
                'category' => [
                    [
                        'coding' => [
                            [
                                'system' => 'http://terminology.hl7.org/CodeSystem/observation-category',
                                'code' => 'vital-signs',
                                'display' => 'Vital Signs'
                            ]
                        ]
                    ]
                ],
                'code' => [
                    'coding' => [
                        [
                            'system' => 'http://loinc.org',
                            'code' => '8310-5',
                            'display' => 'Body temperature'
                        ]
                    ]
                ],
                'subject' => [
                    'reference' => 'Patient/example-patient'
                ],
                'effectiveDateTime' => '2024-01-15T10:30:00Z',
                'valueQuantity' => [
                    'value' => 37.2,
                    'unit' => '°C',
                    'system' => 'http://unitsofmeasure.org',
                    'code' => 'Cel'
                ]
            ],
            'explanation' => 'El recurso Observation captura datos clínicos como signos vitales, resultados de laboratorio, y otras mediciones médicas.',
            'chile_core_profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClObservation',
            'is_active' => true
        ]);

        $practitionerResource = FhirResource::create([
            'resource_type' => 'Practitioner',
            'name' => 'Profesional de la Salud',
            'description' => 'Recurso que representa a un profesional de la salud que participa en la atención del paciente.',
            'example_data' => [
                'resourceType' => 'Practitioner',
                'id' => 'example-practitioner',
                'identifier' => [
                    [
                        'use' => 'official',
                        'system' => 'http://www.superdesalud.gob.cl',
                        'value' => '12345678'
                    ]
                ],
                'name' => [
                    [
                        'use' => 'official',
                        'family' => 'Rodríguez',
                        'given' => ['María', 'Elena']
                    ]
                ],
                'telecom' => [
                    [
                        'system' => 'phone',
                        'value' => '+56-2-2345-6789',
                        'use' => 'work'
                    ],
                    [
                        'system' => 'email',
                        'value' => 'maria.rodriguez@hospital.cl',
                        'use' => 'work'
                    ]
                ],
                'address' => [
                    [
                        'use' => 'work',
                        'line' => ['Av. Providencia 1234'],
                        'city' => 'Santiago',
                        'state' => 'Región Metropolitana',
                        'postalCode' => '7500000',
                        'country' => 'CL'
                    ]
                ]
            ],
            'explanation' => 'El recurso Practitioner representa a profesionales de la salud como médicos, enfermeras, y otros proveedores de atención.',
            'chile_core_profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClPractitioner',
            'is_active' => true
        ]);

        $medicationResource = FhirResource::create([
            'resource_type' => 'Medication',
            'name' => 'Medicamento',
            'description' => 'Recurso que representa un medicamento o sustancia farmacológica.',
            'example_data' => [
                'resourceType' => 'Medication',
                'id' => 'example-medication',
                'code' => [
                    'coding' => [
                        [
                            'system' => 'http://www.whocc.no/atc',
                            'code' => 'C09AA02',
                            'display' => 'Enalapril'
                        ]
                    ]
                ],
                'form' => [
                    'coding' => [
                        [
                            'system' => 'http://snomed.info/sct',
                            'code' => '385219001',
                            'display' => 'Tablet'
                        ]
                    ]
                ],
                'ingredient' => [
                    [
                        'itemCodeableConcept' => [
                            'coding' => [
                                [
                                    'system' => 'http://www.whocc.no/atc',
                                    'code' => 'C09AA02',
                                    'display' => 'Enalapril'
                                ]
                            ]
                        ],
                        'strength' => [
                            'numerator' => [
                                'value' => 10,
                                'unit' => 'mg',
                                'system' => 'http://unitsofmeasure.org',
                                'code' => 'mg'
                            ],
                            'denominator' => [
                                'value' => 1,
                                'unit' => 'tablet',
                                'system' => 'http://unitsofmeasure.org',
                                'code' => '{tblt}'
                            ]
                        ]
                    ]
                ]
            ],
            'explanation' => 'El recurso Medication define medicamentos y sus propiedades, incluyendo ingredientes activos y concentraciones.',
            'chile_core_profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClMedication',
            'is_active' => true
        ]);

        $diagnosticReportResource = FhirResource::create([
            'resource_type' => 'DiagnosticReport',
            'name' => 'Reporte Diagnóstico',
            'description' => 'Recurso que representa un reporte de resultados de estudios diagnósticos.',
            'example_data' => [
                'resourceType' => 'DiagnosticReport',
                'id' => 'example-diagnostic-report',
                'status' => 'final',
                'category' => [
                    [
                        'coding' => [
                            [
                                'system' => 'http://terminology.hl7.org/CodeSystem/v2-0074',
                                'code' => 'LAB',
                                'display' => 'Laboratory'
                            ]
                        ]
                    ]
                ],
                'code' => [
                    'coding' => [
                        [
                            'system' => 'http://loinc.org',
                            'code' => '24323-8',
                            'display' => 'Comprehensive metabolic panel'
                        ]
                    ]
                ],
                'subject' => [
                    'reference' => 'Patient/example-patient'
                ],
                'effectiveDateTime' => '2024-01-15T08:00:00Z',
                'issued' => '2024-01-15T10:00:00Z',
                'performer' => [
                    [
                        'reference' => 'Practitioner/example-practitioner'
                    ]
                ],
                'result' => [
                    [
                        'reference' => 'Observation/example-observation'
                    ]
                ],
                'conclusion' => 'Panel metabólico completo dentro de rangos normales.'
            ],
            'explanation' => 'El recurso DiagnosticReport contiene resultados de estudios diagnósticos como laboratorios, imágenes, y otros exámenes.',
            'chile_core_profile' => 'https://hl7chile.cl/fhir/ig/clcore/StructureDefinition/ClDiagnosticReport',
            'is_active' => true
        ]);

        // Crear módulos para Hospitalizado
        $moduloIngreso = Module::create([
            'area_id' => $hospitalizado->id,
            'name' => 'Ingreso Hospitalario',
            'slug' => 'ingreso-hospitalario',
            'description' => 'Proceso de ingreso de pacientes al hospital, incluyendo admisión, evaluación inicial y asignación de cama.',
            'objectives' => 'Al finalizar este módulo, el estudiante será capaz de: 1) Identificar los recursos FHIR necesarios para el ingreso hospitalario, 2) Crear y estructurar un recurso Patient con información chilena, 3) Configurar un Encounter de tipo hospitalario.',
            'icon' => 'fas fa-door-open',
            'order' => 1,
            'is_active' => true
        ]);

        $moduloEgreso = Module::create([
            'area_id' => $hospitalizado->id,
            'name' => 'Egreso Hospitalario',
            'slug' => 'egreso-hospitalario',
            'description' => 'Proceso de alta hospitalaria, incluyendo plan de cuidados, medicamentos y seguimiento.',
            'objectives' => 'Al finalizar este módulo, el estudiante será capaz de: 1) Crear recursos Medication para prescripciones, 2) Estructurar DiagnosticReport para resúmenes de alta, 3) Configurar planes de seguimiento.',
            'icon' => 'fas fa-sign-out-alt',
            'order' => 2,
            'is_active' => true
        ]);

        $moduloMonitoreo = Module::create([
            'area_id' => $hospitalizado->id,
            'name' => 'Monitoreo de Pacientes',
            'slug' => 'monitoreo-pacientes',
            'description' => 'Seguimiento de signos vitales, observaciones clínicas y evolución del paciente hospitalizado.',
            'objectives' => 'Al finalizar este módulo, el estudiante será capaz de: 1) Crear recursos Observation para signos vitales, 2) Estructurar series temporales de observaciones, 3) Interpretar valores de referencia.',
            'icon' => 'fas fa-heartbeat',
            'order' => 3,
            'is_active' => true
        ]);

        // Crear módulos para Urgencia
        $moduloTriage = Module::create([
            'area_id' => $urgencia->id,
            'name' => 'Triage de Urgencia',
            'slug' => 'triage-urgencia',
            'description' => 'Clasificación de pacientes según nivel de prioridad en servicios de urgencia.',
            'objectives' => 'Al finalizar este módulo, el estudiante será capaz de: 1) Crear recursos Encounter para triage, 2) Aplicar códigos de prioridad, 3) Estructurar observaciones de triage.',
            'icon' => 'fas fa-sort-amount-down',
            'order' => 1,
            'is_active' => true
        ]);

        $moduloEmergencias = Module::create([
            'area_id' => $urgencia->id,
            'name' => 'Atención de Emergencias',
            'slug' => 'atencion-emergencias',
            'description' => 'Manejo de casos críticos y emergencias médicas con recursos FHIR.',
            'objectives' => 'Al finalizar este módulo, el estudiante será capaz de: 1) Crear recursos para emergencias, 2) Estructurar observaciones críticas, 3) Manejar referencias entre recursos.',
            'icon' => 'fas fa-exclamation-triangle',
            'order' => 2,
            'is_active' => true
        ]);

        // Crear módulos para Centro Médico
        $moduloConsulta = Module::create([
            'area_id' => $centroMedico->id,
            'name' => 'Consulta Ambulatoria',
            'slug' => 'consulta-ambulatoria',
            'description' => 'Proceso de consulta médica ambulatoria, anamnesis y examen físico.',
            'objectives' => 'Al finalizar este módulo, el estudiante será capaz de: 1) Crear recursos Encounter para consultas, 2) Estructurar anamnesis en Observation, 3) Documentar diagnósticos.',
            'icon' => 'fas fa-stethoscope',
            'order' => 1,
            'is_active' => true
        ]);

        $moduloSeguimiento = Module::create([
            'area_id' => $centroMedico->id,
            'name' => 'Seguimiento Ambulatorio',
            'slug' => 'seguimiento-ambulatorio',
            'description' => 'Control de pacientes crónicos y seguimiento de tratamientos ambulatorios.',
            'objectives' => 'Al finalizar este módulo, el estudiante será capaz de: 1) Crear recursos para seguimiento, 2) Estructurar planes de tratamiento, 3) Documentar evolución.',
            'icon' => 'fas fa-calendar-check',
            'order' => 2,
            'is_active' => true
        ]);

        // Crear lecciones para Ingreso Hospitalario
        Lesson::create([
            'module_id' => $moduloIngreso->id,
            'fhir_resource_id' => $patientResource->id,
            'title' => 'Creación de Recurso Patient',
            'slug' => 'creacion-recurso-patient',
            'content' => 'En esta lección aprenderás a crear y estructurar un recurso Patient según el perfil chileno de FHIR. El recurso Patient es fundamental para identificar de manera única a cada paciente en el sistema.',
            'learning_objectives' => '1) Comprender la estructura del recurso Patient\n2) Aplicar identificadores chilenos (RUT)\n3) Estructurar nombres y direcciones según estándares locales',
            'interactive_examples' => [
                [
                    'title' => 'Ejemplo de Patient con RUT chileno',
                    'description' => 'Crear un recurso Patient con identificador RUT chileno',
                    'fhir_data' => $patientResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Cuál es el sistema de identificación recomendado para pacientes en Chile?',
                    'options' => ['RUT', 'DNI', 'Pasaporte', 'Carnet de identidad'],
                    'correct_answer' => 0,
                    'explanation' => 'El RUT (Rol Único Tributario) es el identificador estándar para personas en Chile.'
                ],
                [
                    'question' => '¿Qué campo es obligatorio en un recurso Patient?',
                    'options' => ['name', 'address', 'telecom', 'identifier'],
                    'correct_answer' => 0,
                    'explanation' => 'El campo name es obligatorio para identificar al paciente.'
                ]
            ],
            'estimated_duration' => 45,
            'order' => 1,
            'is_active' => true
        ]);

        Lesson::create([
            'module_id' => $moduloIngreso->id,
            'fhir_resource_id' => $encounterResource->id,
            'title' => 'Configuración de Encounter Hospitalario',
            'slug' => 'configuracion-encounter-hospitalario',
            'content' => 'Aprende a crear y configurar un recurso Encounter para el ingreso hospitalario, incluyendo clasificación, período y razón del encuentro.',
            'learning_objectives' => '1) Crear recursos Encounter para hospitalización\n2) Aplicar códigos de clasificación correctos\n3) Estructurar referencias a otros recursos',
            'interactive_examples' => [
                [
                    'title' => 'Encounter de ingreso hospitalario',
                    'description' => 'Configurar un encuentro de tipo hospitalario',
                    'fhir_data' => $encounterResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Qué código se usa para un encuentro hospitalario?',
                    'options' => ['IMP', 'AMB', 'EMER', 'VR'],
                    'correct_answer' => 0,
                    'explanation' => 'IMP (inpatient) es el código para encuentros hospitalarios.'
                ]
            ],
            'estimated_duration' => 30,
            'order' => 2,
            'is_active' => true
        ]);

        Lesson::create([
            'module_id' => $moduloIngreso->id,
            'fhir_resource_id' => $practitionerResource->id,
            'title' => 'Registro de Profesionales de la Salud',
            'slug' => 'registro-profesionales-salud',
            'content' => 'Aprende a crear recursos Practitioner para registrar a los profesionales de la salud que participan en la atención del paciente.',
            'learning_objectives' => '1) Crear recursos Practitioner\n2) Aplicar identificadores profesionales chilenos\n3) Estructurar información de contacto',
            'interactive_examples' => [
                [
                    'title' => 'Practitioner con registro chileno',
                    'description' => 'Crear un profesional con registro de Superintendencia de Salud',
                    'fhir_data' => $practitionerResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Qué sistema se usa para identificar médicos en Chile?',
                    'options' => ['Superintendencia de Salud', 'Colegio Médico', 'MINSAL', 'SEREMI'],
                    'correct_answer' => 0,
                    'explanation' => 'La Superintendencia de Salud mantiene el registro oficial de profesionales.'
                ]
            ],
            'estimated_duration' => 35,
            'order' => 3,
            'is_active' => true
        ]);

        // Lecciones para Egreso Hospitalario
        Lesson::create([
            'module_id' => $moduloEgreso->id,
            'fhir_resource_id' => $medicationResource->id,
            'title' => 'Prescripción de Medicamentos',
            'slug' => 'prescripcion-medicamentos',
            'content' => 'Aprende a crear recursos Medication para prescripciones médicas en el egreso hospitalario.',
            'learning_objectives' => '1) Crear recursos Medication\n2) Estructurar ingredientes y concentraciones\n3) Aplicar códigos ATC',
            'interactive_examples' => [
                [
                    'title' => 'Medicamento con código ATC',
                    'description' => 'Crear un medicamento con clasificación ATC',
                    'fhir_data' => $medicationResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Qué sistema de codificación se usa para medicamentos?',
                    'options' => ['ATC', 'SNOMED', 'LOINC', 'ICD-10'],
                    'correct_answer' => 0,
                    'explanation' => 'ATC (Anatomical Therapeutic Chemical) es el sistema estándar para medicamentos.'
                ]
            ],
            'estimated_duration' => 40,
            'order' => 1,
            'is_active' => true
        ]);

        Lesson::create([
            'module_id' => $moduloEgreso->id,
            'fhir_resource_id' => $diagnosticReportResource->id,
            'title' => 'Resumen de Alta Hospitalaria',
            'slug' => 'resumen-alta-hospitalaria',
            'content' => 'Aprende a crear DiagnosticReport para resúmenes de alta hospitalaria con diagnósticos y recomendaciones.',
            'learning_objectives' => '1) Crear DiagnosticReport\n2) Estructurar conclusiones médicas\n3) Referenciar observaciones relacionadas',
            'interactive_examples' => [
                [
                    'title' => 'Reporte de alta con conclusiones',
                    'description' => 'Crear un resumen de alta con diagnósticos',
                    'fhir_data' => $diagnosticReportResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Qué campo contiene las conclusiones del reporte?',
                    'options' => ['conclusion', 'result', 'category', 'code'],
                    'correct_answer' => 0,
                    'explanation' => 'El campo conclusion contiene las conclusiones médicas del reporte.'
                ]
            ],
            'estimated_duration' => 50,
            'order' => 2,
            'is_active' => true
        ]);

        // Lecciones para Monitoreo de Pacientes
        Lesson::create([
            'module_id' => $moduloMonitoreo->id,
            'fhir_resource_id' => $observationResource->id,
            'title' => 'Signos Vitales y Observaciones',
            'slug' => 'signos-vitales-observaciones',
            'content' => 'Aprende a crear recursos Observation para registrar signos vitales y observaciones clínicas del paciente hospitalizado.',
            'learning_objectives' => '1) Crear recursos Observation\n2) Aplicar códigos LOINC\n3) Estructurar valores cuantitativos',
            'interactive_examples' => [
                [
                    'title' => 'Observación de temperatura corporal',
                    'description' => 'Crear una observación de signo vital',
                    'fhir_data' => $observationResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Qué sistema de codificación se usa para observaciones?',
                    'options' => ['LOINC', 'SNOMED', 'ATC', 'ICD-10'],
                    'correct_answer' => 0,
                    'explanation' => 'LOINC (Logical Observation Identifiers Names and Codes) es el estándar para observaciones.'
                ]
            ],
            'estimated_duration' => 35,
            'order' => 1,
            'is_active' => true
        ]);

        // Lecciones para Triage de Urgencia
        Lesson::create([
            'module_id' => $moduloTriage->id,
            'fhir_resource_id' => $encounterResource->id,
            'title' => 'Triage y Clasificación de Prioridad',
            'slug' => 'triage-clasificacion-prioridad',
            'content' => 'Aprende a crear recursos Encounter para el proceso de triage en urgencias, incluyendo clasificación de prioridad.',
            'learning_objectives' => '1) Crear Encounter para triage\n2) Aplicar códigos de prioridad\n3) Estructurar observaciones de triage',
            'interactive_examples' => [
                [
                    'title' => 'Encounter de triage de urgencia',
                    'description' => 'Configurar un encuentro de triage',
                    'fhir_data' => $encounterResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Cuál es el objetivo principal del triage?',
                    'options' => ['Clasificar por prioridad', 'Diagnosticar', 'Tratar', 'Hospitalizar'],
                    'correct_answer' => 0,
                    'explanation' => 'El triage clasifica a los pacientes según su nivel de prioridad de atención.'
                ]
            ],
            'estimated_duration' => 30,
            'order' => 1,
            'is_active' => true
        ]);

        // Lecciones para Consulta Ambulatoria
        Lesson::create([
            'module_id' => $moduloConsulta->id,
            'fhir_resource_id' => $encounterResource->id,
            'title' => 'Consulta Médica Ambulatoria',
            'slug' => 'consulta-medica-ambulatoria',
            'content' => 'Aprende a crear recursos Encounter para consultas médicas ambulatorias, incluyendo anamnesis y examen físico.',
            'learning_objectives' => '1) Crear Encounter ambulatorio\n2) Estructurar anamnesis\n3) Documentar examen físico',
            'interactive_examples' => [
                [
                    'title' => 'Consulta ambulatoria',
                    'description' => 'Configurar una consulta médica ambulatoria',
                    'fhir_data' => $encounterResource->example_data
                ]
            ],
            'quiz_questions' => [
                [
                    'question' => '¿Qué código se usa para consultas ambulatorias?',
                    'options' => ['AMB', 'IMP', 'EMER', 'VR'],
                    'correct_answer' => 0,
                    'explanation' => 'AMB (ambulatory) es el código para consultas ambulatorias.'
                ]
            ],
            'estimated_duration' => 40,
            'order' => 1,
            'is_active' => true
        ]);
    }
}

