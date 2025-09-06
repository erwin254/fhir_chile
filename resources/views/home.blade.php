@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 mb-3">
                    <i class="fas fa-graduation-cap text-primary"></i>
                    FHIR E-Learning Chile
                </h1>
                <p class="lead text-muted">
                    Aprende a trabajar con recursos FHIR usando ejemplos del Core Chileno de HL7 Chile
                </p>
                <p class="text-muted">
                    ¡Bienvenido, {{ Auth::user()->name }}! Selecciona un área de aprendizaje para comenzar.
                </p>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Progreso -->
    @if($progressStats)
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">
                        <i class="fas fa-chart-line text-primary"></i> Tu Progreso
                    </h5>
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <h3 class="text-primary mb-1">{{ $progressStats['completed_modules'] }}/{{ $progressStats['total_modules'] }}</h3>
                                <p class="text-muted mb-0">Módulos Completados</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <h3 class="text-success mb-1">{{ $progressStats['completed_lessons'] }}/{{ $progressStats['total_lessons'] }}</h3>
                                <p class="text-muted mb-0">Lecciones Completadas</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <h3 class="text-info mb-1">{{ $progressStats['overall_progress'] }}%</h3>
                                <p class="text-muted mb-0">Progreso General</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <div class="progress mb-2" style="height: 20px;">
                                    <div class="progress-bar bg-gradient" 
                                         style="width: {{ $progressStats['overall_progress'] }}%; background: linear-gradient(45deg, #3b82f6, #10b981);">
                                    </div>
                                </div>
                                <p class="text-muted mb-0 small">Progreso Visual</p>
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
                <div class="card h-100 shadow-sm" style="position: relative;">
                    @if($areaStats['completed_modules'] === $areaStats['total_modules'] && $areaStats['total_modules'] > 0)
                        <div style="position: absolute; top: 1rem; right: 1rem; background: #10b981; color: white; padding: 0.5rem; border-radius: 50%; font-size: 1.2rem; z-index: 10;">
                            <i class="fas fa-check"></i>
                        </div>
                    @endif
                    
                    <div class="card-body text-center">
                        <div class="mb-3" style="position: relative;">
                            <i class="{{ $area->icon }} fa-3x" style="color: {{ $area->color }};"></i>
                            @if($areaStats['completed_modules'] === $areaStats['total_modules'] && $areaStats['total_modules'] > 0)
                                <div style="position: absolute; top: -0.5rem; right: -0.5rem; background: #10b981; color: white; border-radius: 50%; width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                    <i class="fas fa-check"></i>
                                </div>
                            @endif
                        </div>
                        <h5 class="card-title" style="color: {{ $area->color }};">{{ $area->name }}</h5>
                        <p class="card-text text-muted">
                            {{ $area->description }}
                        </p>
                        
                        @if($progressStats)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Progreso del Área</small>
                                    <small class="text-muted">{{ $areaProgress }}%</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar" 
                                         style="width: {{ $areaProgress }}%; background: {{ $area->color }};">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        {{ $areaStats['completed_modules'] }}/{{ $areaStats['total_modules'] }} módulos completados
                                    </small>
                                </div>
                            </div>
                        @endif
                        
                        <a href="{{ route('areas.show', $area->slug) }}" class="btn" style="background: {{ $area->color }}; color: white; border: none;">
                            @if($areaStats['completed_modules'] === $areaStats['total_modules'] && $areaStats['total_modules'] > 0)
                                <i class="fas fa-redo"></i> Repasar
                            @else
                                <i class="fas fa-arrow-right"></i> Comenzar
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
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tools"></i> Herramientas FHIR
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <a href="{{ route('fhir.chile-core') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-flag"></i> Core Chileno
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-outline-info" onclick="showFhirSearch()">
                                    <i class="fas fa-search"></i> Buscar Recursos
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-outline-success" onclick="showFhirValidator()">
                                    <i class="fas fa-check-circle"></i> Validar Recursos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success mt-4" role="alert">
            {{ session('status') }}
        </div>
    @endif
</div>
@endsection

