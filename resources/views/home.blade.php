@extends('layouts.app')

@section('title', 'Dashboard - FHIR E-Learning Chile')
@section('page-title', 'Dashboard')

@section('content')
<div class="fade-in-up">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card-modern">
                <div class="card-body-modern text-center">
                    <div class="mb-4">
                        <i class="fas fa-graduation-cap" style="font-size: 4rem; color: var(--primary-color);"></i>
                    </div>
                    <h1 class="display-4 mb-3" style="color: var(--dark-color);">
                        FHIR E-Learning Chile
                    </h1>
                    <p class="lead text-muted mb-3">
                        Aprende a trabajar con recursos FHIR usando ejemplos del Core Chileno de HL7 Chile
                    </p>
                    <div class="alert alert-light border-0" style="background: rgba(59, 130, 246, 0.1);">
                        <i class="fas fa-user-circle text-primary me-2"></i>
                        <strong>¡Bienvenido, {{ Auth::user()->name }}!</strong> Selecciona un área de aprendizaje para comenzar.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Progreso -->
    @if($progressStats)
    <div class="row mb-5">
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="card-title text-center mb-0">
                        <i class="fas fa-chart-line text-primary"></i> Tu Progreso de Aprendizaje
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="row text-center">
                        <div class="col-md-3 mb-4">
                            <div class="card-modern h-100">
                                <div class="card-body-modern text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-layer-group" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                                    </div>
                                    <h3 class="text-primary mb-2">{{ $progressStats['completed_modules'] }}/{{ $progressStats['total_modules'] }}</h3>
                                    <p class="text-muted mb-0">Módulos Completados</p>
                                    <div class="progress-modern mt-3">
                                        <div class="progress-bar-modern" style="width: {{ $progressStats['total_modules'] > 0 ? ($progressStats['completed_modules'] / $progressStats['total_modules']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card-modern h-100">
                                <div class="card-body-modern text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-book-open" style="font-size: 2.5rem; color: var(--secondary-color);"></i>
                                    </div>
                                    <h3 class="text-success mb-2">{{ $progressStats['completed_lessons'] }}/{{ $progressStats['total_lessons'] }}</h3>
                                    <p class="text-muted mb-0">Lecciones Completadas</p>
                                    <div class="progress-modern mt-3">
                                        <div class="progress-bar-modern" style="width: {{ $progressStats['total_lessons'] > 0 ? ($progressStats['completed_lessons'] / $progressStats['total_lessons']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card-modern h-100">
                                <div class="card-body-modern text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-trophy" style="font-size: 2.5rem; color: var(--accent-color);"></i>
                                    </div>
                                    <h3 class="text-info mb-2">{{ $progressStats['overall_progress'] }}%</h3>
                                    <p class="text-muted mb-0">Progreso General</p>
                                    <div class="progress-modern mt-3">
                                        <div class="progress-bar-modern" style="width: {{ $progressStats['overall_progress'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card-modern h-100">
                                <div class="card-body-modern text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-clock" style="font-size: 2.5rem; color: var(--danger-color);"></i>
                                    </div>
                                    <h3 class="text-warning mb-2">{{ $progressStats['total_lessons'] - $progressStats['completed_lessons'] }}</h3>
                                    <p class="text-muted mb-0">Lecciones Pendientes</p>
                                    <div class="progress-modern mt-3">
                                        <div class="progress-bar-modern" style="width: {{ $progressStats['total_lessons'] > 0 ? (($progressStats['total_lessons'] - $progressStats['completed_lessons']) / $progressStats['total_lessons']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Áreas de Aprendizaje -->
    <div class="row">
        @foreach($areas as $area)
            @php
                $areaStats = [
                    'total_modules' => $area->activeModules->count(),
                    'completed_modules' => 0,
                    'total_lessons' => 0,
                    'completed_lessons' => 0
                ];
                
                if ($progressStats) {
                    foreach ($area->activeModules as $module) {
                        $moduleProgress = $module->getProgressForUser(auth()->id());
                        if ($moduleProgress['is_completed']) {
                            $areaStats['completed_modules']++;
                        }
                        $areaStats['total_lessons'] += $moduleProgress['total_lessons'];
                        $areaStats['completed_lessons'] += $moduleProgress['completed_lessons'];
                    }
                }
                
                $areaProgress = $areaStats['total_lessons'] > 0 ? 
                    round(($areaStats['completed_lessons'] / $areaStats['total_lessons']) * 100) : 0;
            @endphp
            
            <div class="col-md-4 mb-4">
                <div class="card-modern h-100" style="position: relative;">
                    @if($areaStats['completed_modules'] === $areaStats['total_modules'] && $areaStats['total_modules'] > 0)
                        <div style="position: absolute; top: 1rem; right: 1rem; background: var(--secondary-color); color: white; padding: 0.5rem; border-radius: 50%; font-size: 1.2rem; z-index: 10; box-shadow: var(--shadow-soft);">
                            <i class="fas fa-check"></i>
                        </div>
                    @endif
                    
                    <div class="card-body-modern text-center">
                        <div class="mb-4" style="position: relative;">
                            <div style="background: linear-gradient(135deg, {{ $area->color }}20, {{ $area->color }}40); padding: 2rem; border-radius: 50%; display: inline-block; margin-bottom: 1rem;">
                                <i class="{{ $area->icon }}" style="font-size: 3rem; color: {{ $area->color }};"></i>
                            </div>
                            @if($areaStats['completed_modules'] === $areaStats['total_modules'] && $areaStats['total_modules'] > 0)
                                <div style="position: absolute; top: 0.5rem; right: 0.5rem; background: var(--secondary-color); color: white; border-radius: 50%; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: var(--shadow-soft);">
                                    <i class="fas fa-check"></i>
                                </div>
                            @endif
                        </div>
                        <h4 class="card-title mb-3" style="color: {{ $area->color }}; font-weight: 700;">{{ $area->name }}</h4>
                        <p class="card-text text-muted">
                            {{ $area->description }}
                        </p>
                        
                        @if($progressStats)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted fw-semibold">Progreso del Área</small>
                                    <small class="text-muted fw-bold">{{ $areaProgress }}%</small>
                                </div>
                                <div class="progress-modern">
                                    <div class="progress-bar-modern" 
                                         style="width: {{ $areaProgress }}%; background: linear-gradient(135deg, {{ $area->color }}, {{ $area->color }}CC);">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border-end">
                                                <h6 class="mb-1" style="color: {{ $area->color }};">{{ $areaStats['completed_modules'] }}</h6>
                                                <small class="text-muted">Módulos</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="mb-1" style="color: {{ $area->color }};">{{ $areaStats['total_modules'] }}</h6>
                                            <small class="text-muted">Total</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <a href="{{ route('areas.show', $area->slug) }}" class="btn-modern btn-primary-modern w-100" style="background: linear-gradient(135deg, {{ $area->color }}, {{ $area->color }}CC);">
                            @if($areaStats['completed_modules'] === $areaStats['total_modules'] && $areaStats['total_modules'] > 0)
                                <i class="fas fa-redo"></i> Repasar Contenido
                            @else
                                <i class="fas fa-arrow-right"></i> Comenzar Aprendizaje
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Herramientas FHIR -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h5 class="mb-0">
                        <i class="fas fa-tools text-primary"></i> Herramientas FHIR
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('fhir.chile-core') }}" class="btn-modern btn-primary-modern w-100">
                                <i class="fas fa-flag"></i> Core Chileno
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button class="btn-modern btn-secondary-modern w-100" onclick="showFhirSearch()">
                                <i class="fas fa-search"></i> Buscar Recursos
                            </button>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button class="btn-modern w-100" style="background: var(--gradient-accent); color: white;" onclick="showFhirValidator()">
                                <i class="fas fa-check-circle"></i> Validar Recursos
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Las notificaciones de sesión se muestran automáticamente como modales -->
</div>
@endsection

