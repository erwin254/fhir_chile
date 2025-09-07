<?php

return [
    // Common FHIR element descriptions
    'A categorization of the resource.' => 'Una categorización del recurso.',
    'The status of this resource.' => 'El estado de este recurso.',
    'A code that identifies the status of the resource.' => 'Un código que identifica el estado del recurso.',
    'A list of profiles (references to StructureDefinition resources) that this resource claims to conform to.' => 'Una lista de perfiles (referencias a recursos StructureDefinition) a los que este recurso afirma conformarse.',
    'A list of profiles (references to StructureDefinition resources) that this resource claims to conform to. In addition to this structure, it may conform to additional profiles.' => 'Una lista de perfiles (referencias a recursos StructureDefinition) a los que este recurso afirma conformarse. Además de esta estructura, puede conformarse a perfiles adicionales.',
    'In addition to this structure, it may conform to additional profiles.' => 'Además de esta estructura, puede conformarse a perfiles adicionales.',
    
    // Narrative and text descriptions
    'A human-readable narrative that contains a summary of the resource and can be used to represent the content of the resource to a human.' => 'Una narrativa legible por humanos que contiene un resumen del recurso y puede usarse para representar el contenido del recurso a un humano.',
    'The narrative need not encode all the structured data, but is required to contain sufficient detail to make it "clinically safe" for a human to just read the narrative.' => 'La narrativa no necesita codificar todos los datos estructurados, pero debe contener suficiente detalle para hacerla "clínicamente segura" para que un humano solo lea la narrativa.',
    'Resource definitions may define what content should be represented in the narrative to ensure clinical safety.' => 'Las definiciones de recursos pueden definir qué contenido debe representarse en la narrativa para garantizar la seguridad clínica.',
    'A human-readable narrative that contains a summary of the resource and can be used to represent the content of the resource to a human. The narrative need not encode all the structured data, but is required to contain sufficient detail to make it "clinically safe" for a human to just read the narrative. Resource definitions may define what content should be represented in the narrative to ensure clinical safety.' => 'Una narrativa legible por humanos que contiene un resumen del recurso y puede usarse para representar el contenido del recurso a un humano. La narrativa no necesita codificar todos los datos estructurados, pero debe contener suficiente detalle para hacerla "clínicamente segura" para que un humano solo lea la narrativa. Las definiciones de recursos pueden definir qué contenido debe representarse en la narrativa para garantizar la seguridad clínica.',
    
    // Rules and references
    'A reference to a set of rules that were followed when the resource was constructed, and which must be understood when processing the content.' => 'Una referencia a un conjunto de reglas que se siguieron cuando se construyó el recurso, y que deben entenderse al procesar el contenido.',
    'Often, this is a reference to an implementation guide that defines the special rules along with other profiles etc.' => 'A menudo, esto es una referencia a una guía de implementación que define las reglas especiales junto con otros perfiles, etc.',
    'A reference to a set of rules that were followed when the resource was constructed, and which must be understood when processing the content. Often, this is a reference to an implementation guide that defines the special rules along with other profiles etc.' => 'Una referencia a un conjunto de reglas que se siguieron cuando se construyó el recurso, y que deben entenderse al procesar el contenido. A menudo, esto es una referencia a una guía de implementación que define las reglas especiales junto con otros perfiles, etc.',
    
    // Metadata and infrastructure
    'The metadata about the resource. This is content that is maintained by the infrastructure.' => 'Los metadatos sobre el recurso. Este es contenido que es mantenido por la infraestructura.',
    'This is content that is maintained by the infrastructure.' => 'Este es contenido que es mantenido por la infraestructura.',
    'Changes to the content might not always be associated with version changes to the resource.' => 'Los cambios en el contenido podrían no estar siempre asociados con cambios de versión del recurso.',
    'The metadata about the resource. This is content that is maintained by the infrastructure. Changes to the content might not always be associated with version changes to the resource.' => 'Los metadatos sobre el recurso. Este es contenido que es mantenido por la infraestructura. Los cambios en el contenido podrían no estar siempre asociados con cambios de versión del recurso.',
    
    // Resource identification
    'The logical id of the resource, as used in the URL for the resource.' => 'El identificador lógico del recurso, tal como se usa en la URL del recurso.',
    'Once assigned, this value never changes.' => 'Una vez asignado, este valor nunca cambia.',
    'The logical id of the resource, as used in the URL for the resource. Once assigned, this value never changes.' => 'El identificador lógico del recurso, tal como se usa en la URL del recurso. Una vez asignado, este valor nunca cambia.',
    
    // Language
    'The base language in which the resource is written.' => 'El idioma base en el que está escrito el recurso.',
    
    // Patient information
    'Information about an individual or animal receiving health care services' => 'Información sobre un individuo o animal que recibe servicios de atención médica',
    'Demographics and other administrative information about an individual or animal receiving care or other health-related services.' => 'Información demográfica y administrativa sobre un individuo o animal que recibe atención u otros servicios relacionados con la salud.',
    
    // Contained resources
    'These resources do not have an independent existence apart from the resource that contains them - they cannot be identified independently, and nor can they have their own independent transaction scope.' => 'Estos recursos no tienen una existencia independiente aparte del recurso que los contiene - no pueden identificarse independientemente, ni pueden tener su propio alcance de transacción independiente.',
    'They cannot be identified independently, and nor can they have their own independent transaction scope.' => 'No pueden identificarse independientemente, ni pueden tener su propio alcance de transacción independiente.',
    
    // Extensions
    'May be used to represent additional information that is not part of the basic definition of the resource.' => 'Puede usarse para representar información adicional que no es parte de la definición básica del recurso.',
    'May be used to represent additional information that is not part of the basic definition of the element.' => 'Puede usarse para representar información adicional que no es parte de la definición básica del elemento.',
    'To make the use of extensions safe and manageable, there is a strict set of governance applied to the definition and use of extensions.' => 'Para hacer el uso de extensiones seguro y manejable, hay un conjunto estricto de gobernanza aplicado a la definición y uso de extensiones.',
    'Though any implementer is allowed to define an extension, there is a set of requirements that SHALL be met as part of the definition of the extension.' => 'Aunque cualquier implementador puede definir una extensión, hay un conjunto de requisitos que DEBEN cumplirse como parte de la definición de la extensión.',
    'Applications processing a resource are required to check for modifier extensions.' => 'Las aplicaciones que procesan un recurso deben verificar las extensiones modificadoras.',
    'Modifier extensions SHALL NOT change the meaning of any elements on Resource or DomainResource (including cannot change the meaning of modifierExtension itself).' => 'Las extensiones modificadoras NO DEBEN cambiar el significado de ningún elemento en Resource o DomainResource (incluyendo no poder cambiar el significado de modifierExtension en sí mismo).',
    'Usually modifier elements provide negation or qualification.' => 'Generalmente, los elementos modificadores proporcionan negación o calificación.',
    
    // Modifier extensions (long description)
    'May be used to represent additional information that is not part of the basic definition of the resource and that modifies the understanding of the element that contains it and/or the understanding of the containing element\'s descendants. Usually modifier elements provide negation or qualification. To make the use of extensions safe and manageable, there is a strict set of governance applied to the definition and use of extensions. Though any implementer is allowed to define an extension, there is a set of requirements that SHALL be met as part of the definition of the extension. Applications processing a resource are required to check for modifier extensions. Modifier extensions SHALL NOT change the meaning of any elements on Resource or DomainResource (including cannot change the meaning of modifierExtension itself).' => 'Puede usarse para representar información adicional que no es parte de la definición básica del recurso y que modifica la comprensión del elemento que lo contiene y/o la comprensión de los descendientes del elemento contenedor. Generalmente, los elementos modificadores proporcionan negación o calificación. Para hacer el uso de extensiones seguro y manejable, hay un conjunto estricto de gobernanza aplicado a la definición y uso de extensiones. Aunque cualquier implementador puede definir una extensión, hay un conjunto de requisitos que DEBEN cumplirse como parte de la definición de la extensión. Las aplicaciones que procesan un recurso deben verificar las extensiones modificadoras. Las extensiones modificadoras NO DEBEN cambiar el significado de ningún elemento en Resource o DomainResource (incluyendo no poder cambiar el significado de modifierExtension en sí mismo).',
    
    // Element identification
    'Unique id for the element within a resource (for internal references).' => 'ID único para el elemento dentro de un recurso (para referencias internas).',
    'This may be any string value that does not contain spaces.' => 'Esto puede ser cualquier valor de cadena que no contenga espacios.',
    'Unique id for the element within a resource (for internal references). This may be any string value that does not contain spaces.' => 'ID único para el elemento dentro de un recurso (para referencias internas). Esto puede ser cualquier valor de cadena que no contenga espacios.',
    
    // Code systems and versions
    'The version of the code system which was used when choosing this code.' => 'La versión del sistema de códigos que se usó al elegir este código.',
    'Note that a well-maintained code system does not need the version reported, because the meaning of codes is consistent across versions.' => 'Tenga en cuenta que un sistema de códigos bien mantenido no necesita la versión reportada, porque el significado de los códigos es consistente entre versiones.',
    'The version of the code system which was used when choosing this code. Note that a well-maintained code system does not need the version reported, because the meaning of codes is consistent across versions.' => 'La versión del sistema de códigos que se usó al elegir este código. Tenga en cuenta que un sistema de códigos bien mantenido no necesita la versión reportada, porque el significado de los códigos es consistente entre versiones.',
    
    // Coding and symbols
    'A symbol in syntax defined by the system.' => 'Un símbolo en sintaxis definido por el sistema.',
    'The symbol may be a predefined code or an expression in a syntax defined by the coding system (e.g. post-coordination).' => 'El símbolo puede ser un código predefinido o una expresión en una sintaxis definida por el sistema de codificación (ej. post-coordinación).',
    'A symbol in syntax defined by the system. The symbol may be a predefined code or an expression in a syntax defined by the coding system (e.g. post-coordination).' => 'Un símbolo en sintaxis definido por el sistema. El símbolo puede ser un código predefinido o una expresión en una sintaxis definida por el sistema de codificación (ej. post-coordinación).',
    
    // Display and representation
    'A representation of the meaning of the code in the system, following the rules of the system.' => 'Una representación del significado del código en el sistema, siguiendo las reglas del sistema.',
    'Indicates that this coding was chosen by a user directly - e.g. off a pick list of available items (codes or displays).' => 'Indica que esta codificación fue elegida por un usuario directamente - ej. de una lista de elementos disponibles (códigos o displays).',
    
    // Events and activities
    'The period during which the activity occurred.' => 'El período durante el cual ocurrió la actividad.',
    'Indicates whether the event succeeded or failed.' => 'Indica si el evento tuvo éxito o falló.',
    'A free text description of the outcome of the event.' => 'Una descripción de texto libre del resultado del evento.',
    'The purposeOfUse (reason) that was used during the event being recorded.' => 'El propósito de uso (razón) que se usó durante el evento que se está registrando.',
    'Identifier for the category of event.' => 'Identificador para la categoría del evento.',
    
    // Audit events
    'A record of an event made for purposes of maintaining a security log.' => 'Un registro de un evento hecho con el propósito de mantener un registro de seguridad.',
    'Typical uses include detection of intrusion attempts and monitoring for inappropriate usage.' => 'Los usos típicos incluyen la detección de intentos de intrusión y el monitoreo de uso inapropiado.',
    'A record of an event made for purposes of maintaining a security log. Typical uses include detection of intrusion attempts and monitoring for inappropriate usage.' => 'Un registro de un evento hecho con el propósito de mantener un registro de seguridad. Los usos típicos incluyen la detección de intentos de intrusión y el monitoreo de uso inapropiado.',
    
    // Common patterns found in analysis
    'The identification of the code system that defines the meaning of the symbol in the code.' => 'La identificación del sistema de códigos que define el significado del símbolo en el código.',
    'A coded type for the identifier that can be used to determine which identifier to use for a specific purpose.' => 'Un tipo codificado para el identificador que puede usarse para determinar qué identificador usar para un propósito específico.',
    'The portion of the identifier typically relevant to the user and which is unique within the context of the system.' => 'La porción del identificador típicamente relevante para el usuario y que es única dentro del contexto del sistema.',
    'A code that classifies the general type of observation being made.' => 'Un código que clasifica el tipo general de observación que se está realizando.',
    'The identification of the system that provides the coded form of the unit.' => 'La identificación del sistema que proporciona la forma codificada de la unidad.',
    
    // Technical terms
    'The type of the object that was involved in this audit event.' => 'El tipo del objeto que estuvo involucrado en este evento de auditoría.',
    'The assigned lot number of a batch of the specified product.' => 'El número de lote asignado de un lote del producto especificado.',
    'A mime type that indicates the technical format of the target resource signed by the signature.' => 'Un tipo mime que indica el formato técnico del recurso objetivo firmado por la firma.',
    'The code specifying the level of confidentiality of the Composition.' => 'El código que especifica el nivel de confidencialidad de la Composición.',
    'The nature of the relationship between the patient and the contact person.' => 'La naturaleza de la relación entre el paciente y la persona de contacto.',
    
    // Values and calculations
    'The value of the numerator.' => 'El valor del numerador.',
    'The value of the denominator.' => 'El valor del denominador.',
    'The value of the extra detail.' => 'El valor del detalle extra.',
    
    // Medical conditions
    'A manifestation or symptom that led to the recording of this condition.' => 'Una manifestación o síntoma que llevó al registro de esta condición.',
    'The source of the information about the allergy that is recorded.' => 'La fuente de la información sobre la alergia que se registra.',
    'The clinical status of the allergy or intolerance.' => 'El estado clínico de la alergia o intolerancia.',
    'The status of the result value.' => 'El estado del valor del resultado.',
    
    // Security and roles
    'Specification of the participation type the user plays when performing the event.' => 'Especificación del tipo de participación que el usuario desempeña al realizar el evento.',
    'The security role that the user was acting under, that come from local codes defined by the access control security system (e.g. RBAC, ABAC) used in the local context.' => 'El rol de seguridad bajo el cual actuaba el usuario, que proviene de códigos locales definidos por el sistema de seguridad de control de acceso (ej. RBAC, ABAC) usado en el contexto local.',
    
    // Common resource elements
    'A reference to a code defined by a terminology system.' => 'Una referencia a un código definido por un sistema terminológico.',
    'A set of codes drawn from one or more code systems.' => 'Un conjunto de códigos extraídos de uno o más sistemas de códigos.',
    'A human-readable summary of the resource.' => 'Un resumen legible por humanos del recurso.',
    'The date and time when the resource was created.' => 'La fecha y hora cuando se creó el recurso.',
    'The date and time when the resource was last updated.' => 'La fecha y hora cuando se actualizó por última vez el recurso.',
    'The version of the resource.' => 'La versión del recurso.',
    'The identifier of the resource.' => 'El identificador del recurso.',
    'The name of the resource.' => 'El nombre del recurso.',
    'The title of the resource.' => 'El título del recurso.',
    'The description of the resource.' => 'La descripción del recurso.',
    'The publisher of the resource.' => 'El editor del recurso.',
    'The contact information for the resource.' => 'La información de contacto para el recurso.',
    'The copyright information for the resource.' => 'La información de derechos de autor para el recurso.',
    'The language of the resource.' => 'El idioma del recurso.',
    'The jurisdiction of the resource.' => 'La jurisdicción del recurso.',
    'The purpose of the resource.' => 'El propósito del recurso.',
    'The usage of the resource.' => 'El uso del recurso.',
    'The copyright statement for the resource.' => 'La declaración de derechos de autor para el recurso.',
    'The approval date of the resource.' => 'La fecha de aprobación del recurso.',
    'The last review date of the resource.' => 'La fecha de última revisión del recurso.',
    'The effective period of the resource.' => 'El período efectivo del recurso.',
    'The topic of the resource.' => 'El tema del recurso.',
    'The author of the resource.' => 'El autor del recurso.',
    'The editor of the resource.' => 'El editor del recurso.',
    'The reviewer of the resource.' => 'El revisor del recurso.',
    'The endorser of the resource.' => 'El avalador del recurso.',
    'The related artifact.' => 'El artefacto relacionado.',
    'The library referenced by the resource.' => 'La biblioteca referenciada por el recurso.',
    'The profile referenced by the resource.' => 'El perfil referenciado por el recurso.',
    'The extension element.' => 'El elemento de extensión.',
    'The modifier extension element.' => 'El elemento de extensión modificador.',
    'The base definition of the resource.' => 'La definición base del recurso.',
    'The derived type of the resource.' => 'El tipo derivado del recurso.',
    'The abstract flag of the resource.' => 'La bandera abstracta del recurso.',
    
    // Context elements
    'The context of the resource.' => 'El contexto del recurso.',
    'The context type of the resource.' => 'El tipo de contexto del recurso.',
    'The context quantity of the resource.' => 'La cantidad de contexto del recurso.',
    'The context range of the resource.' => 'El rango de contexto del recurso.',
    'The context expression of the resource.' => 'La expresión de contexto del recurso.',
    'The context description of the resource.' => 'La descripción de contexto del recurso.',
    'The context usage of the resource.' => 'El uso de contexto del recurso.',
    'The context group of the resource.' => 'El grupo de contexto del recurso.',
    'The context plan of the resource.' => 'El plan de contexto del recurso.',
    'The context definition of the resource.' => 'La definición de contexto del recurso.',
    'The context condition of the resource.' => 'La condición de contexto del recurso.',
    'The context action of the resource.' => 'La acción de contexto del recurso.',
    'The context transformation of the resource.' => 'La transformación de contexto del recurso.',
    'The context dynamic value of the resource.' => 'El valor dinámico de contexto del recurso.',
    'The context dynamic value set of the resource.' => 'El conjunto de valores dinámicos de contexto del recurso.',
    'The context dynamic value expression of the resource.' => 'La expresión de valor dinámico de contexto del recurso.',
    'The context dynamic value description of the resource.' => 'La descripción de valor dinámico de contexto del recurso.',
    'The context dynamic value usage of the resource.' => 'El uso de valor dinámico de contexto del recurso.',
    'The context dynamic value group of the resource.' => 'El grupo de valor dinámico de contexto del recurso.',
    'The context dynamic value plan of the resource.' => 'El plan de valor dinámico de contexto del recurso.',
    'The context dynamic value definition of the resource.' => 'La definición de valor dinámico de contexto del recurso.',
    'The context dynamic value condition of the resource.' => 'La condición de valor dinámico de contexto del recurso.',
    'The context dynamic value action of the resource.' => 'La acción de valor dinámico de contexto del recurso.',
    'The context dynamic value transformation of the resource.' => 'La transformación de valor dinámico de contexto del recurso.',
    
    // Patient specific descriptions
    'The patient identifier.' => 'El identificador del paciente.',
    'The patient name.' => 'El nombre del paciente.',
    'The patient gender.' => 'El género del paciente.',
    'The patient birth date.' => 'La fecha de nacimiento del paciente.',
    'The patient address.' => 'La dirección del paciente.',
    'The patient contact information.' => 'La información de contacto del paciente.',
    'The patient marital status.' => 'El estado civil del paciente.',
    'The patient photo.' => 'La foto del paciente.',
    'The patient language.' => 'El idioma del paciente.',
    'The patient communication.' => 'La comunicación del paciente.',
    'The patient general practitioner.' => 'El médico general del paciente.',
    'The patient managing organization.' => 'La organización gestora del paciente.',
    'The patient link.' => 'El enlace del paciente.',
    'The patient active flag.' => 'La bandera activa del paciente.',
    'The patient deceased flag.' => 'La bandera de fallecido del paciente.',
    'The patient deceased date time.' => 'La fecha y hora de fallecimiento del paciente.',
    'The patient multiple birth flag.' => 'La bandera de nacimiento múltiple del paciente.',
    'The patient multiple birth integer.' => 'El entero de nacimiento múltiple del paciente.',
    
    // Organization specific descriptions
    'The organization identifier.' => 'El identificador de la organización.',
    'The organization name.' => 'El nombre de la organización.',
    'The organization type.' => 'El tipo de organización.',
    'The organization address.' => 'La dirección de la organización.',
    'The organization contact information.' => 'La información de contacto de la organización.',
    'The organization active flag.' => 'La bandera activa de la organización.',
    'The organization part of.' => 'La organización es parte de.',
    'The organization endpoint.' => 'El punto final de la organización.',
    
    // Practitioner specific descriptions
    'The practitioner identifier.' => 'El identificador del practicante.',
    'The practitioner name.' => 'El nombre del practicante.',
    'The practitioner gender.' => 'El género del practicante.',
    'The practitioner birth date.' => 'La fecha de nacimiento del practicante.',
    'The practitioner address.' => 'La dirección del practicante.',
    'The practitioner contact information.' => 'La información de contacto del practicante.',
    'The practitioner photo.' => 'La foto del practicante.',
    'The practitioner language.' => 'El idioma del practicante.',
    'The practitioner communication.' => 'La comunicación del practicante.',
    'The practitioner active flag.' => 'La bandera activa del practicante.',
    'The practitioner qualification.' => 'La calificación del practicante.',
    'The practitioner role.' => 'El rol del practicante.',
    
    // Observation specific descriptions
    'The observation identifier.' => 'El identificador de la observación.',
    'The observation status.' => 'El estado de la observación.',
    'The observation category.' => 'La categoría de la observación.',
    'The observation code.' => 'El código de la observación.',
    'The observation subject.' => 'El sujeto de la observación.',
    'The observation focus.' => 'El foco de la observación.',
    'The observation encounter.' => 'El encuentro de la observación.',
    'The observation effective date time.' => 'La fecha y hora efectiva de la observación.',
    'The observation effective period.' => 'El período efectivo de la observación.',
    'The observation effective timing.' => 'El tiempo efectivo de la observación.',
    'The observation effective instant.' => 'El instante efectivo de la observación.',
    'The observation issued.' => 'La observación emitida.',
    'The observation performer.' => 'El ejecutor de la observación.',
    'The observation value.' => 'El valor de la observación.',
    'The observation data absent reason.' => 'La razón de ausencia de datos de la observación.',
    'The observation interpretation.' => 'La interpretación de la observación.',
    'The observation note.' => 'La nota de la observación.',
    'The observation body site.' => 'El sitio corporal de la observación.',
    'The observation method.' => 'El método de la observación.',
    'The observation specimen.' => 'La muestra de la observación.',
    'The observation device.' => 'El dispositivo de la observación.',
    'The observation reference range.' => 'El rango de referencia de la observación.',
    'The observation has member.' => 'La observación tiene miembro.',
    'The observation derived from.' => 'La observación derivada de.',
    'The observation component.' => 'El componente de la observación.',
    
    // Medication specific descriptions
    'The medication identifier.' => 'El identificador del medicamento.',
    'The medication code.' => 'El código del medicamento.',
    'The medication status.' => 'El estado del medicamento.',
    'The medication manufacturer.' => 'El fabricante del medicamento.',
    'The medication form.' => 'La forma del medicamento.',
    'The medication amount.' => 'La cantidad del medicamento.',
    'The medication ingredient.' => 'El ingrediente del medicamento.',
    'The medication batch.' => 'El lote del medicamento.',
    'The medication definition.' => 'La definición del medicamento.',
    
    // Condition specific descriptions
    'The condition identifier.' => 'El identificador de la condición.',
    'The condition clinical status.' => 'El estado clínico de la condición.',
    'The condition verification status.' => 'El estado de verificación de la condición.',
    'The condition category.' => 'La categoría de la condición.',
    'The condition severity.' => 'La severidad de la condición.',
    'The condition code.' => 'El código de la condición.',
    'The condition body site.' => 'El sitio corporal de la condición.',
    'The condition subject.' => 'El sujeto de la condición.',
    'The condition encounter.' => 'El encuentro de la condición.',
    'The condition onset date time.' => 'La fecha y hora de inicio de la condición.',
    'The condition onset age.' => 'La edad de inicio de la condición.',
    'The condition onset period.' => 'El período de inicio de la condición.',
    'The condition onset range.' => 'El rango de inicio de la condición.',
    'The condition onset string.' => 'La cadena de inicio de la condición.',
    'The condition abatement date time.' => 'La fecha y hora de abatimiento de la condición.',
    'The condition abatement age.' => 'La edad de abatimiento de la condición.',
    'The condition abatement period.' => 'El período de abatimiento de la condición.',
    'The condition abatement range.' => 'El rango de abatimiento de la condición.',
    'The condition abatement string.' => 'La cadena de abatimiento de la condición.',
    'The condition recorded date.' => 'La fecha registrada de la condición.',
    'The condition recorder.' => 'El registrador de la condición.',
    'The condition asserter.' => 'El asertor de la condición.',
    'The condition stage.' => 'La etapa de la condición.',
    'The condition evidence.' => 'La evidencia de la condición.',
    'The condition note.' => 'La nota de la condición.',
];
