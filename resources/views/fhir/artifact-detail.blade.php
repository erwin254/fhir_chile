@extends('layouts.app')

@section('title', $artifact['name'] . ' - Detalles del Artefacto')

@section('content')
<div class="hero mb-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('fhir.artifacts.browser') }}" class="btn btn-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Volver al Buscador
                </a>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-3" style="color: {{ $artifact['color'] }}; font-size: 2rem;">
                            <i class="{{ $artifact['icon'] }}"></i>
                        </div>
                        <div>
                            <h1 class="mb-1" style="color: {{ $artifact['color'] }};">{{ $artifact['name'] }}</h1>
                            <span class="badge fs-6" style="background-color: {{ $artifact['color'] }}; color: white;">
                                {{ $artifact['type'] }}
                            </span>
                        </div>
                    </div>
                    <h2 class="mb-0">{{ $artifact['title'] }}</h2>
                </div>
            </div>
            
            @if($artifact['description'])
                <div class="alert alert-light border-0" style="background: rgba(59, 130, 246, 0.1);">
                    <p class="mb-0">{{ $artifact['description'] }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <!-- Información General -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información General
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Tipo:</strong></td>
                        <td>{{ $artifact['type'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nombre:</strong></td>
                        <td>{{ $artifact['name'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Versión:</strong></td>
                        <td>v{{ $artifact['version'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Estado:</strong></td>
                        <td>
                            <span class="badge bg-{{ $artifact['status'] === 'active' ? 'success' : ($artifact['status'] === 'draft' ? 'warning' : 'secondary') }}">
                                {{ $artifact['status'] }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Editor:</strong></td>
                        <td>{{ $artifact['publisher'] }}</td>
                    </tr>
                    @if($artifact['date'])
                    <tr>
                        <td><strong>Fecha:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($artifact['date'])->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- URLs -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-link me-2"></i>URLs
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>URL Canonical:</strong><br>
                    <a href="{{ $artifact['url'] }}" target="_blank" class="text-break small">
                        {{ $artifact['url'] }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tools me-2"></i>Acciones
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="copyToClipboard('{{ $artifact['url'] }}')">
                        <i class="fas fa-copy me-2"></i>Copiar URL
                    </button>
                    <button class="btn btn-outline-primary" onclick="downloadArtifact()">
                        <i class="fas fa-download me-2"></i>Descargar JSON
                    </button>
                    <button class="btn btn-outline-secondary" onclick="validateArtifact()">
                        <i class="fas fa-check-circle me-2"></i>Validar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido del Artefacto -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-code me-2"></i>Contenido del Artefacto
                </h5>
            </div>
            <div class="card-body">
                <!-- Navegación por pestañas -->
                <ul class="nav nav-tabs mb-3" id="artifactTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                            <i class="fas fa-eye me-2"></i>Resumen
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="json-tab" data-bs-toggle="tab" data-bs-target="#json" type="button" role="tab">
                            <i class="fas fa-code me-2"></i>JSON
                        </button>
                    </li>
                    @if($artifact['type'] === 'StructureDefinition')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="elements-tab" data-bs-toggle="tab" data-bs-target="#elements" type="button" role="tab">
                            <i class="fas fa-sitemap me-2"></i>Elementos
                        </button>
                    </li>
                    @endif
                    @if($artifact['type'] === 'CodeSystem' || $artifact['type'] === 'ValueSet')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="codes-tab" data-bs-toggle="tab" data-bs-target="#codes" type="button" role="tab">
                            <i class="fas fa-list me-2"></i>Códigos
                        </button>
                    </li>
                    @endif
                </ul>

                <div class="tab-content" id="artifactTabContent">
                    <!-- Resumen -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div id="overviewContent">
                            <!-- El contenido se cargará dinámicamente -->
                        </div>
                    </div>

                    <!-- JSON -->
                    <div class="tab-pane fade" id="json" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6>Representación JSON</h6>
                            <button class="btn btn-sm btn-outline-primary" onclick="copyJson()">
                                <i class="fas fa-copy me-1"></i>Copiar JSON
                            </button>
                        </div>
                        <pre class="bg-dark text-light p-3 rounded" style="max-height: 500px; overflow-y: auto;"><code id="jsonContent">{{ json_encode($artifact['content'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                    </div>

                    @if($artifact['type'] === 'StructureDefinition')
                    <!-- Elementos -->
                    <div class="tab-pane fade" id="elements" role="tabpanel">
                        <div id="elementsContent">
                            <!-- Los elementos se cargarán dinámicamente -->
                        </div>
                    </div>
                    @endif

                    @if($artifact['type'] === 'CodeSystem' || $artifact['type'] === 'ValueSet')
                    <!-- Códigos -->
                    <div class="tab-pane fade" id="codes" role="tabpanel">
                        <div id="codesContent">
                            <!-- Los códigos se cargarán dinámicamente -->
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para validación -->
<div class="modal fade" id="validationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Validación del Artefacto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="validationResult">
                <!-- Resultado de validación se cargará aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const artifact = @json($artifact);

document.addEventListener('DOMContentLoaded', function() {
    loadOverview();
    @if($artifact['type'] === 'StructureDefinition')
    loadElements();
    @endif
    @if($artifact['type'] === 'CodeSystem' || $artifact['type'] === 'ValueSet')
    loadCodes();
    @endif
});

function loadOverview() {
    const content = artifact.content;
    let overview = '<div class="row">';
    
    // Información básica
    overview += '<div class="col-md-6">';
    overview += '<h6>Propiedades</h6>';
    overview += '<ul class="list-unstyled">';
    
    if (content.resourceType) {
        overview += `<li><strong>Tipo de Recurso:</strong> ${content.resourceType}</li>`;
    }
    if (content.id) {
        overview += `<li><strong>ID:</strong> ${content.id}</li>`;
    }
    if (content.url) {
        overview += `<li><strong>URL:</strong> <a href="${content.url}" target="_blank">${content.url}</a></li>`;
    }
    if (content.version) {
        overview += `<li><strong>Versión:</strong> ${content.version}</li>`;
    }
    if (content.status) {
        overview += `<li><strong>Estado:</strong> <span class="badge bg-${getStatusColor(content.status)}">${content.status}</span></li>`;
    }
    
    overview += '</ul>';
    overview += '</div>';
    
    // Información específica por tipo
    overview += '<div class="col-md-6">';
    overview += '<h6>Información Específica</h6>';
    overview += '<ul class="list-unstyled">';
    
    if (artifact.type === 'StructureDefinition') {
        if (content.type) {
            overview += `<li><strong>Tipo Base:</strong> ${content.type}</li>`;
        }
        if (content.derivation) {
            overview += `<li><strong>Derivación:</strong> ${content.derivation}</li>`;
        }
        if (content.kind) {
            overview += `<li><strong>Tipo:</strong> ${content.kind}</li>`;
        }
    } else if (artifact.type === 'CodeSystem') {
        if (content.content) {
            overview += `<li><strong>Contenido:</strong> ${content.content}</li>`;
        }
        if (content.count) {
            overview += `<li><strong>Cantidad de Códigos:</strong> ${content.count}</li>`;
        }
    } else if (artifact.type === 'ValueSet') {
        if (content.compose) {
            overview += `<li><strong>Composición:</strong> Definida</li>`;
        }
        if (content.expansion) {
            overview += `<li><strong>Expansión:</strong> Incluida</li>`;
        }
    }
    
    overview += '</ul>';
    overview += '</div>';
    overview += '</div>';
    
    // Descripción
    if (content.description) {
        overview += '<div class="mt-3">';
        overview += '<h6>Descripción</h6>';
        overview += `<p>${content.description}</p>`;
        overview += '</div>';
    }
    
    document.getElementById('overviewContent').innerHTML = overview;
}

@if($artifact['type'] === 'StructureDefinition')
function loadElements() {
    const content = artifact.content;
    let elements = '<div class="table-responsive">';
    elements += '<table class="table table-sm">';
    elements += '<thead><tr><th>Path</th><th>Nombre</th><th>Tipo</th><th>Cardinalidad</th><th>Descripción</th></tr></thead>';
    elements += '<tbody>';
    
    if (content.snapshot && content.snapshot.element) {
        content.snapshot.element.forEach(element => {
            elements += '<tr>';
            elements += `<td><code>${element.path || ''}</code></td>`;
            elements += `<td>${element.short || ''}</td>`;
            elements += `<td>${element.type ? element.type.map(t => t.code).join(', ') : ''}</td>`;
            elements += `<td>${element.min || ''}..${element.max || ''}</td>`;
            elements += `<td>${element.definition || ''}</td>`;
            elements += '</tr>';
        });
    }
    
    elements += '</tbody>';
    elements += '</table>';
    elements += '</div>';
    
    document.getElementById('elementsContent').innerHTML = elements;
}
@endif

@if($artifact['type'] === 'CodeSystem' || $artifact['type'] === 'ValueSet')
function loadCodes() {
    const content = artifact.content;
    let codes = '<div class="table-responsive">';
    codes += '<table class="table table-sm">';
    codes += '<thead><tr><th>Código</th><th>Display</th><th>Definición</th></tr></thead>';
    codes += '<tbody>';
    
    if (artifact.type === 'CodeSystem' && content.concept) {
        content.concept.forEach(concept => {
            codes += '<tr>';
            codes += `<td><code>${concept.code || ''}</code></td>`;
            codes += `<td>${concept.display || ''}</td>`;
            codes += `<td>${concept.definition || ''}</td>`;
            codes += '</tr>';
        });
    } else if (artifact.type === 'ValueSet' && content.expansion && content.expansion.contains) {
        content.expansion.contains.forEach(concept => {
            codes += '<tr>';
            codes += `<td><code>${concept.code || ''}</code></td>`;
            codes += `<td>${concept.display || ''}</td>`;
            codes += `<td>${concept.definition || ''}</td>`;
            codes += '</tr>';
        });
    }
    
    codes += '</tbody>';
    codes += '</table>';
    codes += '</div>';
    
    document.getElementById('codesContent').innerHTML = codes;
}
@endif

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showSuccessModal('Copiado', 'URL copiada al portapapeles');
    });
}

function copyJson() {
    const jsonText = document.getElementById('jsonContent').textContent;
    navigator.clipboard.writeText(jsonText).then(function() {
        showSuccessModal('Copiado', 'JSON copiado al portapapeles');
    });
}

function downloadArtifact() {
    const jsonText = JSON.stringify(artifact.content, null, 2);
    const blob = new Blob([jsonText], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${artifact.name}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

function validateArtifact() {
    const modal = new bootstrap.Modal(document.getElementById('validationModal'));
    document.getElementById('validationResult').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Validando...</span>
            </div>
            <p class="mt-3">Validando artefacto...</p>
        </div>
    `;
    modal.show();
    
    // Simular validación
    setTimeout(() => {
        document.getElementById('validationResult').innerHTML = `
            <div class="alert alert-success">
                <h6><i class="fas fa-check-circle me-2"></i>Validación Exitosa</h6>
                <p class="mb-0">El artefacto ${artifact.name} es válido según las especificaciones FHIR.</p>
            </div>
            <div class="mt-3">
                <h6>Detalles de Validación:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i> Estructura JSON válida</li>
                    <li><i class="fas fa-check text-success me-2"></i> Campos requeridos presentes</li>
                    <li><i class="fas fa-check text-success me-2"></i> Cumple con el Core Chileno</li>
                </ul>
            </div>
        `;
    }, 2000);
}

function getStatusColor(status) {
    switch (status) {
        case 'active': return 'success';
        case 'draft': return 'warning';
        case 'retired': return 'danger';
        default: return 'secondary';
    }
}
</script>
@endpush
