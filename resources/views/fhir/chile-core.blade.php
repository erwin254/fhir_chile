@extends('layouts.app')

@section('title', 'HL7 Chile Core - FHIR')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="card-title mb-0">
                        <i class="fas fa-heartbeat me-2"></i>
                        {{ $chileCoreInfo['name'] }}
                    </h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Descripción</h2>
                            <p class="lead">{{ $chileCoreInfo['description'] }}</p>
                            
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle me-2"></i>Información del Perfil</h5>
                                <ul class="mb-0">
                                    <li><strong>Versión:</strong> {{ $chileCoreInfo['version'] }}</li>
                                    <li><strong>URL del Perfil:</strong> 
                                        <a href="{{ $chileCoreInfo['url'] }}" target="_blank" class="text-decoration-none">
                                            {{ $chileCoreInfo['url'] }}
                                            <i class="fas fa-external-link-alt ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <h3>Recursos FHIR Disponibles</h3>
                            <div class="row">
                                @foreach($chileCoreInfo['resources'] as $resourceType => $description)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">
                                                <i class="fas fa-file-medical me-2"></i>
                                                {{ $resourceType }}
                                            </h5>
                                            <p class="card-text">{{ $description }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-cogs me-2"></i>
                                        Configuración Chilena
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($chileCoreInfo['chile_config']))
                                        <h6>Código de País</h6>
                                        <p><span class="badge bg-primary">{{ $chileCoreInfo['chile_config']['country_code'] }}</span></p>
                                        
                                        <h6>Sistema RUT</h6>
                                        <p><small class="text-muted">{{ $chileCoreInfo['chile_config']['rut_system'] }}</small></p>
                                        
                                        <h6>Regiones de Chile</h6>
                                        <div class="max-height-200 overflow-auto">
                                            <ul class="list-unstyled small">
                                                @foreach($chileCoreInfo['chile_config']['regions'] as $region)
                                                <li class="mb-1">
                                                    <i class="fas fa-map-marker-alt text-success me-1"></i>
                                                    {{ $region }}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card border-warning mt-3">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">
                                        <i class="fas fa-tools me-2"></i>
                                        Herramientas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-primary btn-sm" onclick="showValidationTool()">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Validador FHIR
                                        </button>
                                        <button class="btn btn-outline-success btn-sm" onclick="showSearchTool()">
                                            <i class="fas fa-search me-2"></i>
                                            Buscar Recursos
                                        </button>
                                        <button class="btn btn-outline-info btn-sm" onclick="showCreateTool()">
                                            <i class="fas fa-plus-circle me-2"></i>
                                            Crear Recurso
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Validador FHIR -->
<div class="modal fade" id="validationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>
                    Validador de Recursos FHIR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="validationForm">
                    <div class="mb-3">
                        <label for="resourceType" class="form-label">Tipo de Recurso</label>
                        <select class="form-select" id="resourceType" name="resource_type" required>
                            <option value="">Seleccionar tipo...</option>
                            @foreach($chileCoreInfo['resources'] as $resourceType => $description)
                            <option value="{{ $resourceType }}">{{ $resourceType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="resourceData" class="form-label">Datos del Recurso (JSON)</label>
                        <textarea class="form-control" id="resourceData" name="resource_data" rows="10" 
                                  placeholder='{"resourceType": "Patient", "identifier": [{"system": "http://www.registrocivil.cl/run", "value": "12345678-9"}]}'></textarea>
                    </div>
                </form>
                <div id="validationResult" class="mt-3" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="validateResource()">
                    <i class="fas fa-check me-2"></i>
                    Validar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Buscar Recursos -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-search me-2"></i>
                    Buscar Recursos FHIR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="searchForm">
                    <div class="mb-3">
                        <label for="searchResourceType" class="form-label">Tipo de Recurso</label>
                        <select class="form-select" id="searchResourceType" name="resource_type" required>
                            <option value="">Seleccionar tipo...</option>
                            @foreach($chileCoreInfo['resources'] as $resourceType => $description)
                            <option value="{{ $resourceType }}">{{ $resourceType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="searchParams" class="form-label">Parámetros de Búsqueda</label>
                        <input type="text" class="form-control" id="searchParams" name="search_params" 
                               placeholder="name=Juan&birthdate=1990-01-01">
                    </div>
                </form>
                <div id="searchResult" class="mt-3" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="searchResources()">
                    <i class="fas fa-search me-2"></i>
                    Buscar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear Recurso -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>
                    Crear Recurso FHIR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="mb-3">
                        <label for="createResourceType" class="form-label">Tipo de Recurso</label>
                        <select class="form-select" id="createResourceType" name="resource_type" required>
                            <option value="">Seleccionar tipo...</option>
                            @foreach($chileCoreInfo['resources'] as $resourceType => $description)
                            <option value="{{ $resourceType }}">{{ $resourceType }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="createResourceData" class="form-label">Datos del Recurso (JSON)</label>
                        <textarea class="form-control" id="createResourceData" name="resource_data" rows="10" 
                                  placeholder='{"resourceType": "Patient", "identifier": [{"system": "http://www.registrocivil.cl/run", "value": "12345678-9"}]}'></textarea>
                    </div>
                </form>
                <div id="createResult" class="mt-3" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="createResource()">
                    <i class="fas fa-plus me-2"></i>
                    Crear
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}
.max-height-200 {
    max-height: 200px;
}
</style>

<script>
function showValidationTool() {
    const modal = new bootstrap.Modal(document.getElementById('validationModal'));
    modal.show();
}

function showSearchTool() {
    const modal = new bootstrap.Modal(document.getElementById('searchModal'));
    modal.show();
}

function showCreateTool() {
    const modal = new bootstrap.Modal(document.getElementById('createModal'));
    modal.show();
}

function validateResource() {
    const form = document.getElementById('validationForm');
    const formData = new FormData(form);
    
    fetch('{{ route("fhir.validate") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById('validationResult');
        resultDiv.style.display = 'block';
        
        if (data.success) {
            if (data.validation.valid) {
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <h6><i class="fas fa-check-circle me-2"></i>Recurso Válido</h6>
                        ${data.validation.warnings.length > 0 ? '<p><strong>Advertencias:</strong></p><ul>' + data.validation.warnings.map(w => '<li>' + w + '</li>').join('') + '</ul>' : ''}
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-times-circle me-2"></i>Recurso Inválido</h6>
                        <p><strong>Errores:</strong></p>
                        <ul>${data.validation.errors.map(e => '<li>' + e + '</li>').join('')}</ul>
                        ${data.validation.warnings.length > 0 ? '<p><strong>Advertencias:</strong></p><ul>' + data.validation.warnings.map(w => '<li>' + w + '</li>').join('') + '</ul>' : ''}
                    </div>
                `;
            }
        } else {
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Error</h6>
                    <p>${data.error}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const resultDiv = document.getElementById('validationResult');
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Error de Conexión</h6>
                <p>No se pudo conectar con el servidor.</p>
            </div>
        `;
    });
}

function searchResources() {
    const form = document.getElementById('searchForm');
    const formData = new FormData(form);
    
    // Parse search parameters
    const searchParams = document.getElementById('searchParams').value;
    const params = {};
    if (searchParams) {
        searchParams.split('&').forEach(param => {
            const [key, value] = param.split('=');
            if (key && value) {
                params[key] = decodeURIComponent(value);
            }
        });
    }
    formData.append('search_params', JSON.stringify(params));
    
    fetch('{{ route("fhir.search") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById('searchResult');
        resultDiv.style.display = 'block';
        
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="alert alert-success">
                    <h6><i class="fas fa-search me-2"></i>Resultados de Búsqueda</h6>
                    <pre class="mt-2">${JSON.stringify(data.data, null, 2)}</pre>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Error</h6>
                    <p>${data.error}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const resultDiv = document.getElementById('searchResult');
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Error de Conexión</h6>
                <p>No se pudo conectar con el servidor.</p>
            </div>
        `;
    });
}

function createResource() {
    const form = document.getElementById('createForm');
    const formData = new FormData(form);
    
    // Parse JSON data
    const resourceData = document.getElementById('createResourceData').value;
    try {
        const parsedData = JSON.parse(resourceData);
        formData.set('resource_data', JSON.stringify(parsedData));
    } catch (e) {
        alert('Error: Los datos del recurso deben ser JSON válido');
        return;
    }
    
    fetch('{{ route("fhir.create") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById('createResult');
        resultDiv.style.display = 'block';
        
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="alert alert-success">
                    <h6><i class="fas fa-check-circle me-2"></i>Recurso Creado</h6>
                    <pre class="mt-2">${JSON.stringify(data.data, null, 2)}</pre>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Error</h6>
                    <p>${data.error}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const resultDiv = document.getElementById('createResult');
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Error de Conexión</h6>
                <p>No se pudo conectar con el servidor.</p>
            </div>
        `;
    });
}
</script>
@endsection
