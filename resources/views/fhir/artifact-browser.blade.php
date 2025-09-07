@extends('layouts.app')

@section('title', 'Buscador de Artefactos FHIR - Core Chileno')

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

<div class="hero mb-6">
    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4" style="font-size: 4rem; color: #3B82F6;">
                <i class="fas fa-search"></i>
            </div>
            <h1 class="mb-3" style="color: #3B82F6;">Buscador de Artefactos FHIR</h1>
            <p class="mb-4" style="font-size: 1.1rem; color: #64748b;">
                Explora todos los artefactos del Core Chileno de FHIR
            </p>
        </div>
    </div>
</div>

<!-- Filtros de búsqueda -->
<div class="card mb-6">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="searchInput" class="form-label">
                    <i class="fas fa-search me-2"></i>Buscar artefactos
                </label>
                <input type="text" class="form-control" id="searchInput" 
                       placeholder="Buscar por nombre, título o descripción...">
            </div>
            <div class="col-md-3">
                <label for="typeFilter" class="form-label">
                    <i class="fas fa-filter me-2"></i>Tipo de artefacto
                </label>
                <select class="form-select" id="typeFilter">
                    <option value="">Todos los tipos</option>
                    <option value="StructureDefinition">Structure Definition</option>
                    <option value="CodeSystem">Code System</option>
                    <option value="ValueSet">Value Set</option>
                    <option value="CapabilityStatement">Capability Statement</option>
                    <option value="ImplementationGuide">Implementation Guide</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="categoryFilter" class="form-label">
                    <i class="fas fa-tags me-2"></i>Categoría
                </label>
                <select class="form-select" id="categoryFilter">
                    <option value="">Todas las categorías</option>
                    <option value="Core Profiles">Core Profiles</option>
                    <option value="Chilean Extensions">Chilean Extensions</option>
                    <option value="Structure Definitions">Structure Definitions</option>
                    <option value="Chilean Code Systems">Chilean Code Systems</option>
                    <option value="Code Systems">Code Systems</option>
                    <option value="Chilean Value Sets">Chilean Value Sets</option>
                    <option value="Value Sets">Value Sets</option>
                    <option value="Capability Statements">Capability Statements</option>
                    <option value="Implementation Guide">Implementation Guide</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button class="btn btn-primary" onclick="searchArtifacts()">
                    <i class="fas fa-search me-2"></i>Buscar
                </button>
                <button class="btn btn-outline-secondary ms-2" onclick="clearFilters()">
                    <i class="fas fa-times me-2"></i>Limpiar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-6" id="statsContainer">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-primary mb-2" style="font-size: 2rem;">
                    <i class="fas fa-file-code"></i>
                </div>
                <h3 class="mb-1" id="totalArtifacts">-</h3>
                <p class="text-muted mb-0">Total Artefactos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-success mb-2" style="font-size: 2rem;">
                    <i class="fas fa-sitemap"></i>
                </div>
                <h3 class="mb-1" id="structureDefinitions">-</h3>
                <p class="text-muted mb-0">Structure Definitions</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-warning mb-2" style="font-size: 2rem;">
                    <i class="fas fa-list-ul"></i>
                </div>
                <h3 class="mb-1" id="codeSystems">-</h3>
                <p class="text-muted mb-0">Code Systems</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div class="text-info mb-2" style="font-size: 2rem;">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="mb-1" id="valueSets">-</h3>
                <p class="text-muted mb-0">Value Sets</p>
            </div>
        </div>
    </div>
</div>

<!-- Resultados -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">
            <i class="fas fa-list me-2"></i>Resultados
        </h3>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" id="resultsCount">Cargando...</span>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setViewMode('grid')" id="gridViewBtn">
                    <i class="fas fa-th"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setViewMode('list')" id="listViewBtn">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Loading -->
        <div id="loadingIndicator" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando artefactos...</p>
        </div>

        <!-- Grid View -->
        <div id="gridView" class="d-none">
            <div class="row" id="artifactsGrid">
                <!-- Los artefactos se cargarán aquí -->
            </div>
        </div>

        <!-- List View -->
        <div id="listView" class="d-none">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Versión</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="artifactsTable">
                        <!-- Los artefactos se cargarán aquí -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No results -->
        <div id="noResults" class="text-center py-5 d-none">
            <div class="text-muted mb-3" style="font-size: 3rem;">
                <i class="fas fa-search"></i>
            </div>
            <h4 class="text-muted">No se encontraron artefactos</h4>
            <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
        </div>
    </div>
</div>

<!-- Modal para detalles del artefacto -->
<div class="modal fade" id="artifactModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="artifactModalTitle">
                    <i class="fas fa-file-code me-2"></i>Detalles del Artefacto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="artifactModalBody">
                <!-- Contenido del modal se cargará aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="viewFullArtifact()">
                    <i class="fas fa-external-link-alt me-2"></i>Ver Completo
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentArtifacts = [];
let currentViewMode = 'grid';
let currentArtifact = null;

// Cargar estadísticas al inicio
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
    loadAllArtifacts();
    setupEventListeners();
});

function setupEventListeners() {
    // Búsqueda en tiempo real
    document.getElementById('searchInput').addEventListener('input', debounce(searchArtifacts, 300));
    
    // Filtros
    document.getElementById('typeFilter').addEventListener('change', searchArtifacts);
    document.getElementById('categoryFilter').addEventListener('change', searchArtifacts);
    
    // Enter en búsqueda
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchArtifacts();
        }
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function loadStats() {
    fetch('{{ route("fhir.artifacts.stats") }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data && typeof data === 'object') {
                document.getElementById('totalArtifacts').textContent = data.total || 0;
                document.getElementById('structureDefinitions').textContent = (data.by_type && data.by_type.StructureDefinition) || 0;
                document.getElementById('codeSystems').textContent = (data.by_type && data.by_type.CodeSystem) || 0;
                document.getElementById('valueSets').textContent = (data.by_type && data.by_type.ValueSet) || 0;
            } else {
                throw new Error('Invalid data format');
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
            document.getElementById('totalArtifacts').textContent = '0';
            document.getElementById('structureDefinitions').textContent = '0';
            document.getElementById('codeSystems').textContent = '0';
            document.getElementById('valueSets').textContent = '0';
        });
}

function loadAllArtifacts() {
    showLoading();
    
    fetch('{{ route("fhir.artifacts.search") }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data && Array.isArray(data.artifacts)) {
                currentArtifacts = data.artifacts;
                displayArtifacts(currentArtifacts);
            } else {
                currentArtifacts = [];
                displayArtifacts(currentArtifacts);
            }
            hideLoading();
        })
        .catch(error => {
            console.error('Error loading artifacts:', error);
            currentArtifacts = [];
            displayArtifacts(currentArtifacts);
            hideLoading();
            showError('Error al cargar los artefactos');
        });
}

function searchArtifacts() {
    const query = document.getElementById('searchInput').value;
    const type = document.getElementById('typeFilter').value;
    const category = document.getElementById('categoryFilter').value;
    
    showLoading();
    
    const params = new URLSearchParams();
    if (query) params.append('q', query);
    if (type) params.append('type', type);
    if (category) params.append('category', category);
    
    fetch(`{{ route("fhir.artifacts.search") }}?${params}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data && Array.isArray(data.artifacts)) {
                currentArtifacts = data.artifacts;
            } else {
                currentArtifacts = [];
            }
            displayArtifacts(currentArtifacts);
            hideLoading();
        })
        .catch(error => {
            console.error('Error searching artifacts:', error);
            currentArtifacts = [];
            displayArtifacts(currentArtifacts);
            hideLoading();
            showError('Error al buscar artefactos');
        });
}

function displayArtifacts(artifacts) {
    if (!Array.isArray(artifacts)) {
        artifacts = [];
    }
    
    document.getElementById('resultsCount').textContent = `${artifacts.length} artefactos encontrados`;
    
    if (artifacts.length === 0) {
        showNoResults();
        return;
    }
    
    hideNoResults();
    
    if (currentViewMode === 'grid') {
        displayGridView(artifacts);
    } else {
        displayListView(artifacts);
    }
}

function displayGridView(artifacts) {
    const container = document.getElementById('artifactsGrid');
    container.innerHTML = '';
    
    artifacts.forEach(artifact => {
        const card = createArtifactCard(artifact);
        container.appendChild(card);
    });
    
    document.getElementById('gridView').classList.remove('d-none');
    document.getElementById('listView').classList.add('d-none');
}

function displayListView(artifacts) {
    const tbody = document.getElementById('artifactsTable');
    tbody.innerHTML = '';
    
    artifacts.forEach(artifact => {
        const row = createArtifactRow(artifact);
        tbody.appendChild(row);
    });
    
    document.getElementById('listView').classList.remove('d-none');
    document.getElementById('gridView').classList.add('d-none');
}

function createArtifactCard(artifact) {
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-4 mb-4';
    
    col.innerHTML = `
        <div class="card h-100 artifact-card" onclick="showArtifactDetails('${artifact.id}')">
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <div class="me-3" style="color: ${artifact.color}; font-size: 1.5rem;">
                        <i class="${artifact.icon}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1">${artifact.name}</h6>
                        <span class="badge" style="background-color: ${artifact.color}; color: white; font-size: 0.7rem;">
                            ${artifact.type}
                        </span>
                    </div>
                </div>
                <h5 class="card-title mb-2">${artifact.title}</h5>
                <p class="card-text text-muted small">${truncateText(artifact.description, 100)}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">v${artifact.version}</small>
                    <span class="badge bg-${getStatusColor(artifact.status)}">${artifact.status}</span>
                </div>
            </div>
        </div>
    `;
    
    return col;
}

function createArtifactRow(artifact) {
    const row = document.createElement('tr');
    row.onclick = () => showArtifactDetails(artifact.id);
    row.style.cursor = 'pointer';
    
    row.innerHTML = `
        <td>
            <div class="d-flex align-items-center">
                <i class="${artifact.icon} me-2" style="color: ${artifact.color};"></i>
                <span class="badge" style="background-color: ${artifact.color}; color: white;">
                    ${artifact.type}
                </span>
            </div>
        </td>
        <td>
            <div>
                <strong>${artifact.name}</strong>
                <br>
                <small class="text-muted">${artifact.title}</small>
            </div>
        </td>
        <td>${truncateText(artifact.description, 150)}</td>
        <td>v${artifact.version}</td>
        <td><span class="badge bg-${getStatusColor(artifact.status)}">${artifact.status}</span></td>
        <td>
            <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); showArtifactDetails('${artifact.id}')">
                <i class="fas fa-eye"></i>
            </button>
        </td>
    `;
    
    return row;
}

function showArtifactDetails(artifactId) {
    const artifact = currentArtifacts.find(a => a.id === artifactId);
    if (!artifact) return;
    
    currentArtifact = artifact;
    
    document.getElementById('artifactModalTitle').innerHTML = `
        <i class="${artifact.icon} me-2" style="color: ${artifact.color};"></i>
        ${artifact.name}
    `;
    
    document.getElementById('artifactModalBody').innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6>Información General</h6>
                <table class="table table-sm">
                    <tr><td><strong>Tipo:</strong></td><td>${artifact.type}</td></tr>
                    <tr><td><strong>Nombre:</strong></td><td>${artifact.name}</td></tr>
                    <tr><td><strong>Título:</strong></td><td>${artifact.title}</td></tr>
                    <tr><td><strong>Versión:</strong></td><td>v${artifact.version}</td></tr>
                    <tr><td><strong>Estado:</strong></td><td><span class="badge bg-${getStatusColor(artifact.status)}">${artifact.status}</span></td></tr>
                    <tr><td><strong>Editor:</strong></td><td>${artifact.publisher}</td></tr>
                    ${artifact.date ? `<tr><td><strong>Fecha:</strong></td><td>${new Date(artifact.date).toLocaleDateString()}</td></tr>` : ''}
                </table>
            </div>
            <div class="col-md-6">
                <h6>URLs</h6>
                <div class="mb-2">
                    <strong>URL:</strong><br>
                    <a href="${artifact.url}" target="_blank" class="text-break">${artifact.url}</a>
                </div>
                <div class="mb-2">
                    <strong>Ver en fhir.mk:</strong><br>
                    <a href="http://fhir.mk/public/fhir/artifacts/${artifact.id}" target="_blank" class="text-break">http://fhir.mk/public/fhir/artifacts/${artifact.id}</a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h6>Descripción</h6>
                <p>${artifact.description || 'Sin descripción disponible'}</p>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('artifactModal'));
    modal.show();
}

function viewFullArtifact() {
    if (currentArtifact) {
        window.open(`{{ route('fhir.artifacts.show', '') }}/${currentArtifact.id}`, '_blank');
    }
}

function setViewMode(mode) {
    currentViewMode = mode;
    
    // Actualizar botones
    document.getElementById('gridViewBtn').classList.toggle('active', mode === 'grid');
    document.getElementById('listViewBtn').classList.toggle('active', mode === 'list');
    
    // Mostrar vista correspondiente
    displayArtifacts(currentArtifacts);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('typeFilter').value = '';
    document.getElementById('categoryFilter').value = '';
    loadAllArtifacts();
}

function showLoading() {
    document.getElementById('loadingIndicator').classList.remove('d-none');
    document.getElementById('gridView').classList.add('d-none');
    document.getElementById('listView').classList.add('d-none');
    document.getElementById('noResults').classList.add('d-none');
}

function hideLoading() {
    document.getElementById('loadingIndicator').classList.add('d-none');
}

function showNoResults() {
    document.getElementById('noResults').classList.remove('d-none');
    document.getElementById('gridView').classList.add('d-none');
    document.getElementById('listView').classList.add('d-none');
}

function hideNoResults() {
    document.getElementById('noResults').classList.add('d-none');
}

function showError(message) {
    // Implementar notificación de error
    console.error(message);
}

function truncateText(text, maxLength) {
    if (!text) return '';
    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
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
