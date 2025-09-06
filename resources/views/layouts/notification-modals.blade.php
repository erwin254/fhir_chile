<!-- Modal de Notificación de Éxito -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-check-circle" style="font-size: 4rem; color: var(--secondary-color);"></i>
                </div>
                <h5 class="modal-title mb-3" id="successModalTitle">¡Éxito!</h5>
                <p class="text-muted mb-4" id="successModalMessage">Operación completada exitosamente.</p>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>Entendido
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Notificación de Error -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: var(--danger-color);"></i>
                </div>
                <h5 class="modal-title mb-3" id="errorModalTitle">Error</h5>
                <p class="text-muted mb-4" id="errorModalMessage">Ha ocurrido un error inesperado.</p>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Notificación de Advertencia -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-exclamation-circle" style="font-size: 4rem; color: var(--accent-color);"></i>
                </div>
                <h5 class="modal-title mb-3" id="warningModalTitle">Advertencia</h5>
                <p class="text-muted mb-4" id="warningModalMessage">Por favor, revisa la información.</p>
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                    <i class="fas fa-exclamation me-2"></i>Entendido
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Notificación de Información -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-info-circle" style="font-size: 4rem; color: var(--primary-color);"></i>
                </div>
                <h5 class="modal-title mb-3" id="infoModalTitle">Información</h5>
                <p class="text-muted mb-4" id="infoModalMessage">Información importante para ti.</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="fas fa-info me-2"></i>Entendido
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-question-circle" style="font-size: 4rem; color: var(--primary-color);"></i>
                </div>
                <h5 class="modal-title mb-3" id="confirmModalTitle">Confirmar Acción</h5>
                <p class="text-muted mb-4" id="confirmModalMessage">¿Estás seguro de que deseas continuar?</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmModalButton">
                        <i class="fas fa-check me-2"></i>Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Lección Completada -->
<div class="modal fade" id="lessonCompletedModal" tabindex="-1" aria-labelledby="lessonCompletedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-trophy" style="font-size: 4rem; color: var(--accent-color);"></i>
                </div>
                <h5 class="modal-title mb-3" style="color: var(--accent-color);">¡Lección Completada!</h5>
                <p class="text-muted mb-4">Tu progreso ha sido actualizado exitosamente.</p>
                <div class="alert alert-light border-0 mb-4" style="background: rgba(245, 158, 11, 0.1);">
                    <i class="fas fa-star text-warning me-2"></i>
                    <strong>¡Excelente trabajo!</strong> Continúa con la siguiente lección.
                </div>
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-right me-2"></i>Continuar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Respuesta Correcta -->
<div class="modal fade" id="correctAnswerModal" tabindex="-1" aria-labelledby="correctAnswerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-check-circle" style="font-size: 4rem; color: var(--secondary-color);"></i>
                </div>
                <h5 class="modal-title mb-3" style="color: var(--secondary-color);">¡Correcto!</h5>
                <p class="text-muted mb-4" id="correctAnswerMessage">Tu respuesta es correcta.</p>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>Continuar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Respuesta Incorrecta -->
<div class="modal fade" id="incorrectAnswerModal" tabindex="-1" aria-labelledby="incorrectAnswerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-times-circle" style="font-size: 4rem; color: var(--danger-color);"></i>
                </div>
                <h5 class="modal-title mb-3" style="color: var(--danger-color);">Incorrecto</h5>
                <p class="text-muted mb-4" id="incorrectAnswerMessage">Tu respuesta no es correcta. Revisa la explicación.</p>
                <div class="alert alert-light border-0 mb-4" style="background: rgba(239, 68, 68, 0.1);">
                    <i class="fas fa-lightbulb text-danger me-2"></i>
                    <strong>Tip:</strong> Revisa el contenido de la lección para entender mejor.
                </div>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-redo me-2"></i>Intentar de Nuevo
                </button>
            </div>
        </div>
    </div>
</div>
