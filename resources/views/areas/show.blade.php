@extends('layouts.app')

@section('title', $area->name . ' - FHIR E-Learning Chile')

@section('content')
<div class="hero mb-6">
    <div class="card">
        <div class="card-body text-center">
            <div class="mb-4" style="font-size: 4rem; color: {{ $area->color }};">
                <i class="{{ $area->icon }}"></i>
            </div>
            <h1 class="mb-3" style="color: {{ $area->color }};">{{ $area->name }}</h1>
            <p class="mb-4" style="font-size: 1.1rem; color: #64748b;">{{ $area->description }}</p>
            
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
        </div>
    </div>
</div>

@if($area->activeModules->count() > 0)
    <div class="grid grid-2">
        @foreach($area->activeModules as $module)
            @php
                $progress = $moduleProgress && isset($moduleProgress[$module->id]) ? $moduleProgress[$module->id] : null;
            @endphp
            <div class="card position-relative">
                <!-- Badge de completado -->
                @if($progress && $progress['is_completed'])
                    <div class="position-absolute top-0 end-0 m-3 bg-success text-white rounded-circle p-2" style="z-index: 10;">
                        <i class="fas fa-check"></i>
                    </div>
                @endif

                <div class="card-body">
                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 position-relative" style="font-size: 2rem; color: {{ $area->color }};">
                            <i class="{{ $module->icon }}"></i>
                            @if($progress && $progress['is_completed'])
                                <div class="position-absolute top-0 end-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 1.5rem; height: 1.5rem; font-size: 0.8rem; transform: translate(50%, -50%);">
                                    <i class="fas fa-check"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h3 class="mb-0" style="color: {{ $area->color }};">{{ $module->name }}</h3>
                                @if($progress)
                                    <div class="d-flex align-items-center gap-2">
                                        @if($progress['status'] === 'completed')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i> Completado
                                            </span>
                                        @elseif($progress['status'] === 'in_progress')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-play me-1"></i> En Progreso
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-clock me-1"></i> No Iniciado
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <p class="text-muted mb-3">{{ $module->description }}</p>
                            
                            @if($progress)
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small">Progreso del Módulo</span>
                                        <span class="text-muted small fw-semibold">
                                            {{ $progress['completed_lessons'] }}/{{ $progress['total_lessons'] }} lecciones
                                        </span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" 
                                             style="width: {{ $progress['progress_percentage'] }}%; 
                                                    background: {{ $progress['is_completed'] ? '#10b981' : '#3b82f6' }}; 
                                                    transition: width 0.3s ease;">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($module->objectives)
                        <div class="mb-4">
                            <h4 class="mb-3" style="color: #1e293b;">
                                <i class="fas fa-bullseye me-2"></i> Objetivos de Aprendizaje
                            </h4>
                            <div class="p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid {{ $area->color }};">
                                <p class="mb-0" style="white-space: pre-line; line-height: 1.6;">{{ $module->objectives }}</p>
                            </div>
                        </div>
                    @endif

                    @if($module->activeLessons->count() > 0)
                        <div class="mb-4">
                            <h4 class="mb-3" style="color: #1e293b;">
                                <i class="fas fa-list me-2"></i> Lecciones ({{ $module->activeLessons->count() }})
                            </h4>
                            
                            <div class="d-flex flex-column gap-3">
                                @foreach($module->activeLessons as $lesson)
                                    <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border" style="background: #f8fafc;">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="me-3" style="font-size: 1.2rem; color: {{ $area->color }};">
                                                    <i class="fas fa-play-circle"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-1" style="color: #1e293b;">{{ $lesson->title }}</h5>
                                                    <p class="mb-0 text-muted small">
                                                        <i class="fas fa-clock me-1"></i> {{ $lesson->estimated_duration }} min
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            @if($lesson->fhirResource)
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-primary">
                                                        {{ $lesson->fhirResource->resource_type }}
                                                    </span>
                                                    <span class="text-muted small">
                                                        {{ $lesson->fhirResource->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="d-flex align-items-center gap-3">
                                            @if($userProgress && isset($userProgress[$lesson->id]))
                                                @php $progress = $userProgress[$lesson->id]; @endphp
                                                <div class="text-end">
                                                    <div class="text-muted small mb-1">
                                                        {{ $progress->progress_percentage }}% completado
                                                    </div>
                                                    <div class="progress" style="width: 100px;">
                                                        <div class="progress-bar" style="width: {{ $progress->progress_percentage }}%"></div>
                                                    </div>
                                                </div>
                                                
                                                @if($progress->status === 'completed')
                                                    <div class="text-success" style="font-size: 1.5rem;">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                @elseif($progress->status === 'in_progress')
                                                    <div class="text-warning" style="font-size: 1.5rem;">
                                                        <i class="fas fa-play-circle"></i>
                                                    </div>
                                                @endif
                                            @endif
                                            
                                            <a href="{{ route('lessons.show', $lesson->slug) }}" class="btn btn-primary btn-sm">
                                                @if($userProgress && isset($userProgress[$lesson->id]) && $userProgress[$lesson->id]->status === 'completed')
                                                    <i class="fas fa-redo me-1"></i> Repasar
                                                @else
                                                    <i class="fas fa-play me-1"></i> Iniciar
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="text-center">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-book-open me-2"></i> Ver Módulo Completo
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card text-center">
        <div class="card-body">
            <h2 class="mb-3">No hay módulos disponibles</h2>
            <p class="text-muted">Los módulos para esta área se están desarrollando. Vuelve pronto.</p>
        </div>
    </div>
@endif

<div class="mt-6">
    <div class="card">
        <div class="card-body text-center">
            <h3 class="mb-3">
                <i class="fas fa-info-circle me-2" style="color: {{ $area->color }};"></i>
                Sobre {{ $area->name }}
            </h3>
            <p class="text-muted mb-0">
                Los módulos en esta área están diseñados para cubrir todo el flujo de atención en {{ strtolower($area->name) }}, 
                desde el ingreso hasta el egreso del paciente, utilizando recursos FHIR del Core Chileno.
            </p>
        </div>
    </div>
</div>
@endsection

