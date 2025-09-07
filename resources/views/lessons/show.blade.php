@extends('layouts.app')

@section('title', $lesson->title . ' - FHIR E-Learning Chile')

@section('content')
<div class="hero mb-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('areas.show', $lesson->module->area->slug) }}" class="btn btn-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <div class="flex-grow-1">
                    <h1 class="mb-3" style="color: {{ $lesson->module->area->color }};">{{ $lesson->title }}</h1>
                    <p class="mb-0" style="color: #64748b; font-size: 1.1rem;">
                        <i class="{{ $lesson->module->area->icon }} me-2" style="color: {{ $lesson->module->area->color }};"></i>
                        {{ $lesson->module->area->name }} - {{ $lesson->module->name }}
                    </p>
                </div>
            </div>
        
            @if($userProgress)
                <div class="d-flex align-items-center p-4" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div class="flex-grow-1 me-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Progreso:</span>
                            <span class="fw-bold" style="color: #10b981;">{{ $userProgress->progress_percentage }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $userProgress->progress_percentage }}%"></div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="mb-1" style="font-size: 0.875rem; color: #64748b;">
                            <i class="fas fa-clock me-1"></i> {{ $userProgress->time_spent }} min
                        </div>
                        <div style="font-size: 0.875rem; color: #64748b;">
                            Estado: 
                            @if($userProgress->status === 'completed')
                                <span class="badge bg-success">Completado</span>
                            @elseif($userProgress->status === 'in_progress')
                                <span class="badge bg-warning">En progreso</span>
                            @else
                                <span class="badge bg-secondary">No iniciado</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-2">
    <!-- Contenido de la lección -->
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">
                <i class="fas fa-book me-2" style="color: {{ $lesson->module->area->color }};"></i>
                Contenido de la Lección
            </h2>
            
            <div class="mb-4" style="white-space: pre-line; line-height: 1.8; color: #374151; font-size: 1.05rem;">
                {{ $lesson->content }}
            </div>

            @if($lesson->learning_objectives)
                <div class="p-4" style="background: #f0f9ff; border-radius: 12px; border-left: 4px solid {{ $lesson->module->area->color }};">
                    <h3 class="mb-3" style="color: {{ $lesson->module->area->color }};">
                        <i class="fas fa-bullseye me-2"></i> Objetivos de Aprendizaje
                    </h3>
                    <div style="white-space: pre-line; color: #374151; line-height: 1.6;">
                        {{ $lesson->learning_objectives }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Recurso FHIR -->
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">
                <i class="fas fa-code me-2" style="color: {{ $lesson->module->area->color }};"></i>
                Recurso FHIR: {{ $lesson->fhirResource->name }}
            </h2>
            
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        {{ $lesson->fhirResource->resource_type }}
                    </span>
                    <span class="text-muted">{{ $lesson->fhirResource->name }}</span>
                </div>
                
                <p class="text-muted mb-3">{{ $lesson->fhirResource->description }}</p>
                
                @if($lesson->fhirResource->explanation)
                    <div class="p-3 mb-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <h5 class="mb-2" style="color: #1e293b;">Explicación:</h5>
                        <p class="mb-0" style="color: #374151;">{{ $lesson->fhirResource->explanation }}</p>
                    </div>
                @endif
            </div>

            <!-- Ejemplo JSON -->
            <div class="mb-4">
                <h4 class="mb-3" style="color: #1e293b;">
                    <i class="fas fa-file-code me-2"></i> Ejemplo JSON
                </h4>
                <div class="p-3" style="background: #1e293b; color: #e2e8f0; border-radius: 8px; overflow-x: auto;">
                    <pre class="mb-0" style="font-size: 0.875rem; line-height: 1.5;"><code>{{ json_encode($lesson->fhirResource->example_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                </div>
            </div>

            @if($lesson->fhirResource->chile_core_profile)
                <div class="text-center">
                    <a href="{{ $lesson->fhirResource->chile_core_profile }}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt me-2"></i> Ver Perfil Chileno
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@if($lesson->interactive_examples && count($lesson->interactive_examples) > 0)
    <div class="mt-6">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4">
                    <i class="fas fa-play-circle me-2" style="color: {{ $lesson->module->area->color }};"></i>
                    Ejemplos Interactivos
                </h2>
                
                @foreach($lesson->interactive_examples as $index => $example)
                    <div class="mb-4 border rounded-3 overflow-hidden">
                        <div class="p-3" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <h4 class="mb-2" style="color: #1e293b;">{{ $example['title'] }}</h4>
                            <p class="mb-0 text-muted">{{ $example['description'] }}</p>
                        </div>
                        <div class="p-3">
                            <div class="p-3 rounded" style="background: #1e293b; color: #e2e8f0; overflow-x: auto;">
                                <pre class="mb-0" style="font-size: 0.875rem; line-height: 1.5;"><code>{{ json_encode($example['fhir_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@if($lesson->quiz_questions && count($lesson->quiz_questions) > 0)
    <div class="mt-6">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4">
                    <i class="fas fa-question-circle me-2" style="color: {{ $lesson->module->area->color }};"></i>
                    Evaluación
                </h2>
                
                @foreach($lesson->quiz_questions as $index => $question)
                    <div class="mb-5 p-4 border rounded-3">
                        <h4 class="mb-3" style="color: #1e293b;">{{ $index + 1 }}. {{ $question['question'] }}</h4>
                        
                        <div class="mb-3">
                            @foreach($question['options'] as $optionIndex => $option)
                                <label class="d-flex align-items-center p-3 mb-2 rounded-3 border" style="background: #f8fafc; cursor: pointer; transition: all 0.3s ease;">
                                    <input type="radio" name="question_{{ $index }}" value="{{ $optionIndex }}" class="me-3">
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        
                        <div class="quiz-explanation d-none p-3 rounded-3 mb-3" style="background: #f0f9ff; border-left: 4px solid {{ $lesson->module->area->color }};">
                            <p class="mb-0" style="color: #374151;"><strong>Explicación:</strong> {{ $question['explanation'] }}</p>
                        </div>
                        
                        <button onclick="checkAnswer({{ $index }}, {{ $question['correct_answer'] }})" class="btn btn-primary">
                            <i class="fas fa-check me-2"></i> Verificar Respuesta
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<div class="mt-6 text-center">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">¿Has completado esta lección?</h3>
            <p class="mb-4 text-muted">Marca como completada para actualizar tu progreso</p>
            <button onclick="markAsCompleted()" class="btn btn-success btn-lg">
                <i class="fas fa-check-circle me-2"></i> Marcar como Completada
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function checkAnswer(questionIndex, correctAnswer) {
    const selectedAnswer = document.querySelector(`input[name="question_${questionIndex}"]:checked`);
    const explanation = document.querySelector(`.quiz-explanation`);
    
    if (!selectedAnswer) {
        showWarningModal('Selecciona una respuesta', 'Por favor selecciona una respuesta antes de continuar.');
        return;
    }
    
    if (parseInt(selectedAnswer.value) === correctAnswer) {
        showCorrectAnswerModal('¡Excelente! Tu respuesta es correcta.');
    } else {
        showIncorrectAnswerModal('Tu respuesta no es correcta. Revisa la explicación para entender mejor.');
    }
    
    explanation.classList.remove('d-none');
}

function markAsCompleted() {
    showConfirmModal(
        'Completar Lección', 
        '¿Estás seguro de que has completado esta lección? Tu progreso será actualizado.',
        function() {
            // Mostrar loading
            const button = document.querySelector('[onclick="markAsCompleted()"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
            button.disabled = true;
            
            axios.post('{{ route("lessons.progress", $lesson->slug) }}', {
                progress_percentage: 100,
                time_spent: {{ $userProgress ? $userProgress->time_spent + 1 : 1 }}
            })
            .then(response => {
                showLessonCompletedModal();
                setTimeout(() => {
                    location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorModal('Error al actualizar', 'Error al actualizar el progreso. Inténtalo de nuevo.');
                // Restaurar botón
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    );
}
</script>
@endpush

