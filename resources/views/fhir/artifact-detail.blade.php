@extends('layouts.app')

@section('title', 'Detalle del Artefacto FHIR')

@section('content')
<!-- Language Selector -->
<div class="d-flex justify-content-end mb-3">
    <div class="btn-group" role="group">
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'es']) }}" 
           class="btn btn-sm {{ app()->getLocale() === 'es' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-flag me-1"></i>Español
        </a>
        <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" 
           class="btn btn-sm {{ app()->getLocale() === 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-flag me-1"></i>English
        </a>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-file-medical me-2"></i>
                    {{ $artifact['name'] ?? $artifact['id'] }}
                </h1>
                <div>
                    <a href="{{ route('fhir.artifacts.browser') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Buscador
                    </a>
                </div>
            </div>

            <!-- Overview Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Resumen
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled" id="overviewContent">
                                <!-- Content will be loaded by JavaScript -->
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Ver en fhir.mk:</strong><br>
                                <a href="http://fhir.mk/public/fhir/artifacts/{{ $artifact['id'] }}" target="_blank" class="text-break small">
                                    http://fhir.mk/public/fhir/artifacts/{{ $artifact['id'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="artifactTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Resumen
                            </button>
                        </li>
                        @if($artifact['type'] === 'StructureDefinition')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="elements-tab" data-bs-toggle="tab" data-bs-target="#elements" type="button" role="tab">
                                <i class="fas fa-list me-2"></i>Elementos
                            </button>
                        </li>
                        @endif
                        @if($artifact['type'] === 'CapabilityStatement')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="capabilities-tab" data-bs-toggle="tab" data-bs-target="#capabilities" type="button" role="tab">
                                <i class="fas fa-server me-2"></i>Capacidades
                            </button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="urls-tab" data-bs-toggle="tab" data-bs-target="#urls" type="button" role="tab">
                                <i class="fas fa-link me-2"></i>URLs
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="artifactTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div id="overviewContent">
                                <!-- Content will be loaded by JavaScript -->
                            </div>
                        </div>

                        @if($artifact['type'] === 'StructureDefinition')
                        <!-- Elements Tab -->
                        <div class="tab-pane fade" id="elements" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Path</th>
                                            <th>Cardinalidad</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="elementsContent">
                                        <!-- Content will be loaded by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        @if($artifact['type'] === 'CapabilityStatement')
                        <!-- Capabilities Tab -->
                        <div class="tab-pane fade" id="capabilities" role="tabpanel">
                            <div id="capabilitiesContent">
                                <!-- Content will be loaded by JavaScript -->
                            </div>
                        </div>
                        @endif

                        <!-- URLs Tab -->
                        <div class="tab-pane fade" id="urls" role="tabpanel">
                            <div class="mb-3">
                                <strong>Ver en fhir.mk:</strong><br>
                                <a href="http://fhir.mk/public/fhir/artifacts/{{ $artifact['id'] }}" target="_blank" class="text-break small">
                                    http://fhir.mk/public/fhir/artifacts/{{ $artifact['id'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Store artifact data globally
const artifact = @json($artifact);
const translations = @json($translations);

// Translation function using Laravel translations
function translateElementDescription(definition) {
    if (!definition) return '';
    
    // Try exact match first
    if (translations[definition]) {
        return translations[definition];
    }
    
    // Try partial matches for common patterns, prioritizing longer matches
    const sortedTranslations = Object.entries(translations).sort((a, b) => b[0].length - a[0].length);
    
    for (const [english, spanish] of sortedTranslations) {
        if (definition.includes(english)) {
            // Check if this is a complete sentence match or just a partial match
            const beforeMatch = definition.substring(0, definition.indexOf(english));
            const afterMatch = definition.substring(definition.indexOf(english) + english.length);
            
            // If the match is at the beginning or end, or surrounded by sentence boundaries, it's likely a complete match
            const isCompleteMatch = (
                beforeMatch === '' || 
                beforeMatch.endsWith('. ') || 
                beforeMatch.endsWith(' ') ||
                afterMatch === '' || 
                afterMatch.startsWith('. ') || 
                afterMatch.startsWith(' ')
            );
            
            if (isCompleteMatch) {
                return definition.replace(english, spanish);
            }
        }
    }
    
    // If no translation found, return original
    return definition;
}

// Load overview content
function loadOverview() {
    let overview = '<ul class="list-unstyled">';
    
    if (artifact.name) {
        overview += `<li><strong>Nombre:</strong> ${artifact.name}</li>`;
    }
    
    if (artifact.title) {
        overview += `<li><strong>Título:</strong> ${artifact.title}</li>`;
    }
    
    if (artifact.description) {
        overview += `<li><strong>Descripción:</strong> ${artifact.description}</li>`;
    }
    
    if (artifact.type) {
        overview += `<li><strong>Tipo:</strong> ${artifact.type}</li>`;
    }
    
    if (artifact.version) {
        overview += `<li><strong>Versión:</strong> ${artifact.version}</li>`;
    }
    
    if (artifact.status) {
        overview += `<li><strong>Estado:</strong> ${artifact.status}</li>`;
    }
    
    if (artifact.publisher) {
        overview += `<li><strong>Editor:</strong> ${artifact.publisher}</li>`;
    }
    
    if (artifact.date) {
        overview += `<li><strong>Fecha:</strong> ${artifact.date}</li>`;
    }
    
    if (artifact.url) {
        overview += `<li><strong>URL:</strong> <a href="${artifact.url}" target="_blank" class="text-break small">${artifact.url}</a></li>`;
    }
    
    overview += `<li><strong>Ver en fhir.mk:</strong> <a href="http://fhir.mk/public/fhir/artifacts/${artifact.id}" target="_blank">http://fhir.mk/public/fhir/artifacts/${artifact.id}</a></li>`;
    
    overview += '</ul>';
    
    document.getElementById('overviewContent').innerHTML = overview;
}

@if($artifact['type'] === 'StructureDefinition')
// Load elements content
function loadElements() {
    const content = artifact.content;
    let elements = '';
    
    if (content && content.snapshot && content.snapshot.element) {
        content.snapshot.element.forEach(element => {
            const cardinality = element.min !== undefined && element.max !== undefined 
                ? `${element.min}..${element.max}` 
                : '';
            
            const type = element.type ? element.type.map(t => t.code).join(', ') : '';
            
            elements += `
                <tr>
                    <td><code>${element.path || ''}</code></td>
                    <td>${cardinality}</td>
                    <td>${type}</td>
                    <td>${translateElementDescription(element.definition || '')}</td>
                </tr>
            `;
        });
    }
    
    document.getElementById('elementsContent').innerHTML = elements;
}
@endif

@if($artifact['type'] === 'CapabilityStatement')
// Load capabilities content
function loadCapabilities() {
    const content = artifact.content;
    let capabilities = '<div class="row">';
    
    // General info
    capabilities += '<div class="col-md-6">';
    capabilities += '<h6>Información General</h6>';
    capabilities += '<ul class="list-unstyled">';
    
    if (content.publisher) {
        capabilities += `<li><strong>Editor:</strong> ${content.publisher}</li>`;
    }
    
    if (content.description) {
        capabilities += `<li><strong>Descripción:</strong> ${content.description}</li>`;
    }
    
    if (content.status) {
        capabilities += `<li><strong>Estado:</strong> ${content.status}</li>`;
    }
    
    if (content.version) {
        capabilities += `<li><strong>Versión:</strong> ${content.version}</li>`;
    }
    
    capabilities += '</ul>';
    capabilities += '</div>';
    
    // Supported formats
    capabilities += '<div class="col-md-6">';
    capabilities += '<h6>Formatos Soportados</h6>';
    capabilities += '<ul class="list-unstyled">';
    
    if (content.format) {
        content.format.forEach(format => {
            capabilities += `<li><span class="badge bg-primary">${format}</span></li>`;
        });
    }
    
    capabilities += '</ul>';
    capabilities += '</div>';
    
    capabilities += '</div>';
    
    // REST capabilities
    if (content.rest && content.rest.length > 0) {
        capabilities += '<div class="mt-4">';
        capabilities += '<h6>Capacidades REST</h6>';
        
        content.rest.forEach(rest => {
            if (rest.resource) {
                capabilities += '<div class="table-responsive">';
                capabilities += '<table class="table table-sm">';
                capabilities += '<thead><tr><th>Recurso</th><th>Operaciones</th><th>Versiones</th></tr></thead>';
                capabilities += '<tbody>';
                
                rest.resource.forEach(resource => {
                    const operations = resource.interaction ? 
                        resource.interaction.map(i => i.code).join(', ') : '';
                    const versions = resource.versioning || '';
                    
                    capabilities += `
                        <tr>
                            <td><code>${resource.type}</code></td>
                            <td>${operations}</td>
                            <td>${versions}</td>
                        </tr>
                    `;
                });
                
                capabilities += '</tbody>';
                capabilities += '</table>';
                capabilities += '</div>';
            }
        });
        
        capabilities += '</div>';
    }
    
    // Messaging capabilities
    if (content.messaging && content.messaging.length > 0) {
        capabilities += '<div class="mt-4">';
        capabilities += '<h6>Capacidades de Mensajería</h6>';
        capabilities += '<ul class="list-unstyled">';
        
        content.messaging.forEach(messaging => {
            if (messaging.endpoint) {
                messaging.endpoint.forEach(endpoint => {
                    capabilities += `<li><strong>Endpoint:</strong> <code>${endpoint.address}</code></li>`;
                });
            }
        });
        
        capabilities += '</ul>';
        capabilities += '</div>';
    }
    
    document.getElementById('capabilitiesContent').innerHTML = capabilities;
}
@endif

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadOverview();
    
    @if($artifact['type'] === 'StructureDefinition')
    loadElements();
    @endif
    
    @if($artifact['type'] === 'CapabilityStatement')
    loadCapabilities();
    @endif
});
</script>
@endsection
