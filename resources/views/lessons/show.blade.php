@extends('layouts.app')

@section('title', $lesson->title . ' - FHIR E-Learning Chile')

@section('content')
<div class="hero mb-6">
    <div class="card">
        <div style="display: flex; align-items: center; margin-bottom: 1rem;">
            <a href="{{ route('areas.show', $lesson->module->area->slug) }}" class="btn btn-secondary" style="margin-right: 1rem;">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <div>
                <h1 style="color: {{ $lesson->module->area->color }}; margin-bottom: 0.5rem;">{{ $lesson->title }}</h1>
                <p style="color: #64748b;">
                    <i class="{{ $lesson->module->area->icon }}" style="color: {{ $lesson->module->area->color }};"></i>
                    {{ $lesson->module->area->name }} - {{ $lesson->module->name }}
                </p>
            </div>
        </div>
        
        @if($userProgress)
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem;">
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-weight: 500;">Progreso:</span>
                        <span style="font-weight: 600; color: #10b981;">{{ $userProgress->progress_percentage }}%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $userProgress->progress_percentage }}%"></div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.875rem; color: #64748b;">
                        <i class="fas fa-clock"></i> {{ $userProgress->time_spent }} min
                    </div>
                    <div style="font-size: 0.875rem; color: #64748b;">
                        Estado: 
                        @if($userProgress->status === 'completed')
                            <span style="color: #10b981;">Completado</span>
                        @elseif($userProgress->status === 'in_progress')
                            <span style="color: #f59e0b;">En progreso</span>
                        @else
                            <span style="color: #64748b;">No iniciado</span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="grid grid-2">
    <!-- Contenido de la lección -->
    <div class="card">
        <h2 class="mb-4">
            <i class="fas fa-book" style="color: {{ $lesson->module->area->color }};"></i>
            Contenido de la Lección
        </h2>
        
        <div style="white-space: pre-line; line-height: 1.8; color: #374151;">
            {{ $lesson->content }}
        </div>

        @if($lesson->learning_objectives)
            <div class="mt-4" style="background: #f0f9ff; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid {{ $lesson->module->area->color }};">
                <h3 style="color: {{ $lesson->module->area->color }}; margin-bottom: 1rem;">
                    <i class="fas fa-bullseye"></i> Objetivos de Aprendizaje
                </h3>
                <div style="white-space: pre-line; color: #374151;">
                    {{ $lesson->learning_objectives }}
                </div>
            </div>
        @endif
    </div>

    <!-- Recurso FHIR -->
    <div class="card">
        <h2 class="mb-4">
            <i class="fas fa-code" style="color: {{ $lesson->module->area->color }};"></i>
            Recurso FHIR: {{ $lesson->fhirResource->name }}
        </h2>
        
        <div class="mb-4">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <span style="background: #e0e7ff; color: #3730a3; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 500;">
                    {{ $lesson->fhirResource->resource_type }}
                </span>
                <span style="color: #64748b;">{{ $lesson->fhirResource->name }}</span>
            </div>
            
            <p style="color: #64748b; margin-bottom: 1rem;">{{ $lesson->fhirResource->description }}</p>
            
            @if($lesson->fhirResource->explanation)
                <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    <h4 style="color: #1e293b; margin-bottom: 0.5rem;">Explicación:</h4>
                    <p style="color: #374151; margin: 0;">{{ $lesson->fhirResource->explanation }}</p>
                </div>
            @endif
        </div>

        <!-- Ejemplo JSON -->
        <div class="mb-4">
            <h4 style="color: #1e293b; margin-bottom: 1rem;">
                <i class="fas fa-file-code"></i> Ejemplo JSON
            </h4>
            <div style="background: #1e293b; color: #e2e8f0; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;">
                <pre style="margin: 0; font-size: 0.875rem;"><code>{{ json_encode($lesson->fhirResource->example_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
            </div>
        </div>

        @if($lesson->fhirResource->chile_core_profile)
            <div class="text-center">
                <a href="{{ $lesson->fhirResource->chile_core_profile }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-external-link-alt"></i> Ver Perfil Chileno
                </a>
            </div>
        @endif
    </div>
</div>

@if($lesson->interactive_examples && count($lesson->interactive_examples) > 0)
    <div class="mt-6">
        <div class="card">
            <h2 class="mb-4">
                <i class="fas fa-play-circle" style="color: {{ $lesson->module->area->color }};"></i>
                Ejemplos Interactivos
            </h2>
            
            @foreach($lesson->interactive_examples as $index => $example)
                <div class="mb-4" style="border: 1px solid #e2e8f0; border-radius: 0.5rem; overflow: hidden;">
                    <div style="background: #f8fafc; padding: 1rem; border-bottom: 1px solid #e2e8f0;">
                        <h4 style="color: #1e293b; margin-bottom: 0.5rem;">{{ $example['title'] }}</h4>
                        <p style="color: #64748b; margin: 0;">{{ $example['description'] }}</p>
                    </div>
                    <div style="padding: 1rem;">
                        <div style="background: #1e293b; color: #e2e8f0; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;">
                            <pre style="margin: 0; font-size: 0.875rem;"><code>{{ json_encode($example['fhir_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if($lesson->quiz_questions && count($lesson->quiz_questions) > 0)
    <div class="mt-6">
        <div class="card">
            <h2 class="mb-4">
                <i class="fas fa-question-circle" style="color: {{ $lesson->module->area->color }};"></i>
                Evaluación
            </h2>
            
            @foreach($lesson->quiz_questions as $index => $question)
                <div class="mb-4" style="border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem;">
                    <h4 style="color: #1e293b; margin-bottom: 1rem;">{{ $index + 1 }}. {{ $question['question'] }}</h4>
                    
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem;">
                        @foreach($question['options'] as $optionIndex => $option)
                            <label style="display: flex; align-items: center; padding: 0.75rem; background: #f8fafc; border-radius: 0.5rem; cursor: pointer; transition: background-color 0.3s;">
                                <input type="radio" name="question_{{ $index }}" value="{{ $optionIndex }}" style="margin-right: 0.75rem;">
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                    
                    <div class="quiz-explanation" style="display: none; background: #f0f9ff; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid {{ $lesson->module->area->color }};">
                        <p style="margin: 0; color: #374151;"><strong>Explicación:</strong> {{ $question['explanation'] }}</p>
                    </div>
                    
                    <button onclick="checkAnswer({{ $index }}, {{ $question['correct_answer'] }})" class="btn btn-primary">
                        <i class="fas fa-check"></i> Verificar Respuesta
                    </button>
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="mt-6 text-center">
    <div class="card">
        <h3 class="mb-4">¿Has completado esta lección?</h3>
        <p class="mb-4" style="color: #64748b;">Marca como completada para actualizar tu progreso</p>
        <button onclick="markAsCompleted()" class="btn btn-success">
            <i class="fas fa-check-circle"></i> Marcar como Completada
        </button>
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
    
    explanation.style.display = 'block';
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

