<!-- Modal para búsqueda FHIR -->
<div class="modal fade" id="fhirSearchModal" tabindex="-1" aria-labelledby="fhirSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fhirSearchModalLabel">
                    <i class="fas fa-search"></i> Buscar Recursos FHIR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fhirSearchForm">
                    <div class="mb-3">
                        <label for="resourceType" class="form-label">Tipo de Recurso</label>
                        <select class="form-select" id="resourceType" name="resourceType">
                            <option value="Patient">Patient</option>
                            <option value="Observation">Observation</option>
                            <option value="Practitioner">Practitioner</option>
                            <option value="Medication">Medication</option>
                            <option value="DiagnosticReport">DiagnosticReport</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="searchQuery" class="form-label">Consulta de Búsqueda</label>
                        <input type="text" class="form-control" id="searchQuery" name="searchQuery" placeholder="Ej: name=Juan">
                    </div>
                </form>
                <div id="searchResults" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="performFhirSearch()">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para validación FHIR -->
<div class="modal fade" id="fhirValidatorModal" tabindex="-1" aria-labelledby="fhirValidatorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fhirValidatorModalLabel">
                    <i class="fas fa-check-circle"></i> Validar Recurso FHIR
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fhirValidatorForm">
                    <div class="mb-3">
                        <label for="resourceTypeValidator" class="form-label">Tipo de Recurso</label>
                        <select class="form-select" id="resourceTypeValidator" name="resourceType">
                            <option value="Patient">Patient</option>
                            <option value="Observation">Observation</option>
                            <option value="Practitioner">Practitioner</option>
                            <option value="Medication">Medication</option>
                            <option value="DiagnosticReport">DiagnosticReport</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="resourceJson" class="form-label">JSON del Recurso</label>
                        <textarea class="form-control" id="resourceJson" name="resourceJson" rows="10" placeholder="Pega aquí el JSON del recurso FHIR..."></textarea>
                    </div>
                </form>
                <div id="validationResults" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" onclick="validateFhirResource()">
                    <i class="fas fa-check-circle"></i> Validar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Progreso -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progressModalLabel">
                    <i class="fas fa-chart-line"></i> Mi Progreso de Aprendizaje
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="progressContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando tu progreso...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
