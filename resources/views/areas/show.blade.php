@extends('layouts.app')

@section('title', $area->name . ' - FHIR E-Learning Chile')

@section('content')
<div class="hero mb-6">
    <div class="card">
        <div class="text-center mb-4">
            <div style="font-size: 4rem; color: {{ $area->color }}; margin-bottom: 1rem;">
                <i class="{{ $area->icon }}"></i>
            </div>
            <h1 style="color: {{ $area->color }}; margin-bottom: 1rem;">{{ $area->name }}</h1>
            <p style="font-size: 1.1rem; color: #64748b;">{{ $area->description }}</p>
        </div>
        
        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Inicio
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
            <div class="card" style="position: relative;">
                <!-- Badge de completado -->
                @if($progress && $progress['is_completed'])
                    <div style="position: absolute; top: 1rem; right: 1rem; background: #10b981; color: white; padding: 0.5rem; border-radius: 50%; font-size: 1.2rem; z-index: 10;">
                        <i class="fas fa-check"></i>
                    </div>
                @endif

                <div class="mb-4">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <div style="font-size: 2rem; color: {{ $area->color }}; margin-right: 1rem; position: relative;">
                            <i class="{{ $module->icon }}"></i>
                            @if($progress && $progress['is_completed'])
                                <div style="position: absolute; top: -0.5rem; right: -0.5rem; background: #10b981; color: white; border-radius: 50%; width: 1.5rem; height: 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                    <i class="fas fa-check"></i>
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                                <h3 style="color: {{ $area->color }}; margin: 0;">{{ $module->name }}</h3>
                                @if($progress)
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        @if($progress['status'] === 'completed')
                                            <span style="background: #10b981; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">
                                                <i class="fas fa-check"></i> Completado
                                            </span>
                                        @elseif($progress['status'] === 'in_progress')
                                            <span style="background: #f59e0b; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">
                                                <i class="fas fa-play"></i> En Progreso
                                            </span>
                                        @else
                                            <span style="background: #6b7280; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">
                                                <i class="fas fa-clock"></i> No Iniciado
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <p style="color: #64748b; font-size: 0.9rem; margin: 0;">{{ $module->description }}</p>
                            
                            @if($progress)
                                <div style="margin-top: 0.75rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <span style="font-size: 0.875rem; color: #64748b;">
                                            Progreso del Módulo
                                        </span>
                                        <span style="font-size: 0.875rem; color: #64748b; font-weight: 500;">
                                            {{ $progress['completed_lessons'] }}/{{ $progress['total_lessons'] }} lecciones
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
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
                </div>

                @if($module->objectives)
                    <div class="mb-4">
                        <h4 style="color: #1e293b; margin-bottom: 0.5rem;">
                            <i class="fas fa-bullseye"></i> Objetivos de Aprendizaje
                        </h4>
                        <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid {{ $area->color }};">
                            <p style="white-space: pre-line; margin: 0;">{{ $module->objectives }}</p>
                        </div>
                    </div>
                @endif

                @if($module->activeLessons->count() > 0)
                    <div class="mb-4">
                        <h4 style="color: #1e293b; margin-bottom: 1rem;">
                            <i class="fas fa-list"></i> Lecciones ({{ $module->activeLessons->count() }})
                        </h4>
                        
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($module->activeLessons as $lesson)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                                    <div style="flex: 1;">
                                        <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                            <div style="font-size: 1.2rem; color: {{ $area->color }}; margin-right: 0.75rem;">
                                                <i class="fas fa-play-circle"></i>
                                            </div>
                                            <div>
                                                <h5 style="margin: 0; color: #1e293b;">{{ $lesson->title }}</h5>
                                                <p style="margin: 0; color: #64748b; font-size: 0.875rem;">
                                                    <i class="fas fa-clock"></i> {{ $lesson->estimated_duration }} min
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @if($lesson->fhirResource)
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span style="background: #e0e7ff; color: #3730a3; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">
                                                    {{ $lesson->fhirResource->resource_type }}
                                                </span>
                                                <span style="color: #64748b; font-size: 0.875rem;">
                                                    {{ $lesson->fhirResource->name }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        @if($userProgress && isset($userProgress[$lesson->id]))
                                            @php $progress = $userProgress[$lesson->id]; @endphp
                                            <div style="text-align: right;">
                                                <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.25rem;">
                                                    {{ $progress->progress_percentage }}% completado
                                                </div>
                                                <div class="progress" style="width: 100px;">
                                                    <div class="progress-bar" style="width: {{ $progress->progress_percentage }}%"></div>
                                                </div>
                                            </div>
                                            
                                            @if($progress->status === 'completed')
                                                <div style="color: #10b981; font-size: 1.5rem;">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            @elseif($progress->status === 'in_progress')
                                                <div style="color: #f59e0b; font-size: 1.5rem;">
                                                    <i class="fas fa-play-circle"></i>
                                                </div>
                                            @endif
                                        @endif
                                        
                                        <a href="{{ route('lessons.show', $lesson->slug) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                            @if($userProgress && isset($userProgress[$lesson->id]) && $userProgress[$lesson->id]->status === 'completed')
                                                <i class="fas fa-redo"></i> Repasar
                                            @else
                                                <i class="fas fa-play"></i> Iniciar
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
                        <i class="fas fa-book-open"></i> Ver Módulo Completo
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card text-center">
        <h2 class="mb-4">No hay módulos disponibles</h2>
        <p>Los módulos para esta área se están desarrollando. Vuelve pronto.</p>
    </div>
@endif

<div class="mt-6">
    <div class="card">
        <h3 class="mb-4 text-center">
            <i class="fas fa-info-circle" style="color: {{ $area->color }};"></i>
            Sobre {{ $area->name }}
        </h3>
        <p class="text-center" style="color: #64748b;">
            Los módulos en esta área están diseñados para cubrir todo el flujo de atención en {{ strtolower($area->name) }}, 
            desde el ingreso hasta el egreso del paciente, utilizando recursos FHIR del Core Chileno.
        </p>
    </div>
</div>
@endsection

