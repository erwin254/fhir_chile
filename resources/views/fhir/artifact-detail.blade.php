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
                                <strong>Ver:</strong><br>
                                <a href="{{ config('fhir.artifacts_url') }}/{{ $artifact['id'] }}" target="_blank" class="text-break small">
                                    {{ config('fhir.artifacts_url') }}/{{ $artifact['id'] }}
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
                            <button class="nav-link" id="json-tab" data-bs-toggle="tab" data-bs-target="#json" type="button" role="tab">
                                <i class="fas fa-code me-2"></i>JSON
                            </button>
                        </li>
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

                        <!-- JSON Tab -->
                        <div class="tab-pane fade" id="json" role="tabpanel">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0">Contenido JSON del Artefacto</h6>
                                    <button class="btn btn-sm btn-outline-primary" onclick="copyJsonToClipboard()">
                                        <i class="fas fa-copy me-1"></i>Copiar JSON
                                    </button>
                                </div>
                                <pre id="jsonContent" class="bg-light p-3 rounded" style="max-height: 500px; overflow-y: auto; font-size: 12px;"><code><!-- JSON content will be loaded by JavaScript --></code></pre>
                            </div>
                        </div>

                        <!-- URLs Tab -->
                        <div class="tab-pane fade" id="urls" role="tabpanel">
                            <div class="mb-3">
                                <strong>Ver:</strong><br>
                                <a href="{{ config('fhir.artifacts_url') }}/{{ $artifact['id'] }}" target="_blank" class="text-break small">
                                    {{ config('fhir.artifacts_url') }}/{{ $artifact['id'] }}
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
    let overview = '<div class="row">';
    
    // Basic Information
    overview += '<div class="col-md-6">';
    overview += '<h6>Información Básica</h6>';
    overview += '<ul class="list-unstyled">';
    
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
        overview += `<li><strong>Tipo:</strong> <span class="badge bg-primary">${artifact.type}</span></li>`;
    }
    
    if (artifact.id) {
        overview += `<li><strong>ID:</strong> <code>${artifact.id}</code></li>`;
    }
    
    overview += '</ul>';
    overview += '</div>';
    
    // Version and Status
    overview += '<div class="col-md-6">';
    overview += '<h6>Versión y Estado</h6>';
    overview += '<ul class="list-unstyled">';
    
    if (artifact.version) {
        overview += `<li><strong>Versión:</strong> ${artifact.version}</li>`;
    }
    
    if (artifact.status) {
        const statusClass = artifact.status === 'active' ? 'bg-success' : 
                           artifact.status === 'draft' ? 'bg-warning' : 'bg-secondary';
        overview += `<li><strong>Estado:</strong> <span class="badge ${statusClass}">${artifact.status}</span></li>`;
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
    
    overview += '</ul>';
    overview += '</div>';
    
    overview += '</div>';
    
    // Additional Information
    if (artifact.content) {
        overview += '<div class="mt-4">';
        overview += '<h6>Información Adicional</h6>';
        
        if (artifact.content.profile) {
            overview += '<div class="mb-2">';
            overview += '<strong>Perfiles:</strong><br>';
            artifact.content.profile.forEach(profile => {
                overview += `<span class="badge bg-info me-1">${profile}</span>`;
            });
            overview += '</div>';
        }
        
        if (artifact.content.fhirVersion) {
            overview += `<div class="mb-2"><strong>Versión FHIR:</strong> ${artifact.content.fhirVersion}</div>`;
        }
        
        if (artifact.content.kind) {
            overview += `<div class="mb-2"><strong>Tipo de Definición:</strong> ${artifact.content.kind}</div>`;
        }
        
        if (artifact.content.abstract !== undefined) {
            overview += `<div class="mb-2"><strong>Abstracto:</strong> ${artifact.content.abstract ? 'Sí' : 'No'}</div>`;
        }
        
        overview += '</div>';
    }
    
    // Links
    overview += '<div class="mt-4">';
    overview += '<h6>Enlaces</h6>';
    overview += '<ul class="list-unstyled">';
    overview += `<li><strong>Ver:</strong> <a href="{{ config('fhir.artifacts_url') }}/${artifact.id}" target="_blank">{{ config('fhir.artifacts_url') }}/${artifact.id}</a></li>`;
    overview += '</ul>';
    overview += '</div>';
    
    document.getElementById('overviewContent').innerHTML = overview;
}

// Load JSON content
function loadJson() {
    const jsonContent = JSON.stringify(artifact.content || artifact, null, 2);
    // Use textContent instead of innerHTML to avoid HTML parsing issues
    const codeElement = document.querySelector('#jsonContent code');
    codeElement.textContent = jsonContent;
}

// Copy JSON to clipboard
function copyJsonToClipboard() {
    const jsonContent = JSON.stringify(artifact.content || artifact, null, 2);
    navigator.clipboard.writeText(jsonContent).then(() => {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check me-1"></i>Copiado!';
        button.classList.remove('btn-outline-primary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-primary');
        }, 2000);
    }).catch(err => {
        console.error('Error copying to clipboard:', err);
        alert('Error al copiar al portapapeles');
    });
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
    loadJson();
    
    @if($artifact['type'] === 'StructureDefinition')
    loadElements();
    @endif
    
    @if($artifact['type'] === 'CapabilityStatement')
    loadCapabilities();
    @endif
});
</script>
@endsection
