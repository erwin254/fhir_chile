<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="fas fa-home"></i> Inicio
                                </a>
                            </li>
                                   <li class="nav-item dropdown">
                                       <a class="nav-link dropdown-toggle" href="#" id="areasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                           <i class="fas fa-graduation-cap"></i> Áreas de Aprendizaje
                                       </a>
                                       <ul class="dropdown-menu" aria-labelledby="areasDropdown">
                                           <li><a class="dropdown-item" href="{{ route('areas.show', 'hospitalizado') }}">
                                               <i class="fas fa-hospital" style="color: #3B82F6;"></i> Hospitalizado
                                           </a></li>
                                           <li><a class="dropdown-item" href="{{ route('areas.show', 'urgencia') }}">
                                               <i class="fas fa-ambulance" style="color: #EF4444;"></i> Urgencia
                                           </a></li>
                                           <li><a class="dropdown-item" href="{{ route('areas.show', 'centro-medico') }}">
                                               <i class="fas fa-user-md" style="color: #10B981;"></i> Centro Médico
                                           </a></li>
                                       </ul>
                                   </li>
                                   <li class="nav-item">
                                       <a class="nav-link" href="#" onclick="showProgressModal()">
                                           <i class="fas fa-chart-line"></i> Mi Progreso
                                       </a>
                                   </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="fhirDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-code"></i> Recursos FHIR
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="fhirDropdown">
                                    <li><a class="dropdown-item" href="{{ route('fhir.chile-core') }}">
                                        <i class="fas fa-flag"></i> Core Chileno
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="showFhirSearch()">
                                        <i class="fas fa-search"></i> Buscar Recursos
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="showFhirValidator()">
                                        <i class="fas fa-check-circle"></i> Validar Recursos
                                    </a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

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
                            <select class="form-control" id="resourceType" name="resourceType">
                                <option value="Patient">Patient</option>
                                <option value="Encounter">Encounter</option>
                                <option value="Observation">Observation</option>
                                <option value="DiagnosticReport">DiagnosticReport</option>
                                <option value="Medication">Medication</option>
                                <option value="Practitioner">Practitioner</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="searchQuery" class="form-label">Consulta de Búsqueda</label>
                            <input type="text" class="form-control" id="searchQuery" name="searchQuery" placeholder="Ej: name=Juan">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </form>
                    <div id="searchResults" class="mt-3" style="display: none;">
                        <h6>Resultados:</h6>
                        <pre id="searchResultsContent" class="bg-light p-3 rounded"></pre>
                    </div>
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
                            <label for="resourceJson" class="form-label">Recurso FHIR (JSON)</label>
                            <textarea class="form-control" id="resourceJson" name="resourceJson" rows="10" placeholder='{"resourceType": "Patient", "name": [{"family": "García", "given": ["Juan"]}]}'></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Validar
                        </button>
                    </form>
                    <div id="validationResults" class="mt-3" style="display: none;">
                        <h6>Resultados de Validación:</h6>
                        <div id="validationResultsContent"></div>
                    </div>
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

    <script>
        // Configurar Axios para Laravel
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }

        function showFhirSearch() {
            var modal = new bootstrap.Modal(document.getElementById('fhirSearchModal'));
            modal.show();
        }

        function showFhirValidator() {
            var modal = new bootstrap.Modal(document.getElementById('fhirValidatorModal'));
            modal.show();
        }

        function showProgressModal() {
            var modal = new bootstrap.Modal(document.getElementById('progressModal'));
            modal.show();
            
            // Cargar progreso desde la página de inicio
            loadProgressData();
        }

        function loadProgressData() {
            // Simular carga de datos (en una implementación real, harías una petición AJAX)
            setTimeout(() => {
                const progressContent = document.getElementById('progressContent');
                progressContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-hospital"></i> Hospitalizado
                                    </h5>
                                    <div class="progress mb-2" style="height: 20px;">
                                        <div class="progress-bar bg-primary" style="width: 60%;">60%</div>
                                    </div>
                                    <p class="card-text">2/3 módulos completados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-danger">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-danger">
                                        <i class="fas fa-ambulance"></i> Urgencia
                                    </h5>
                                    <div class="progress mb-2" style="height: 20px;">
                                        <div class="progress-bar bg-danger" style="width: 25%;">25%</div>
                                    </div>
                                    <p class="card-text">0/2 módulos completados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-success">
                                        <i class="fas fa-user-md"></i> Centro Médico
                                    </h5>
                                    <div class="progress mb-2" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: 0%;">0%</div>
                                    </div>
                                    <p class="card-text">0/2 módulos completados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-info">
                                        <i class="fas fa-chart-line"></i> Progreso General
                                    </h5>
                                    <div class="progress mb-2" style="height: 20px;">
                                        <div class="progress-bar bg-info" style="width: 35%;">35%</div>
                                    </div>
                                    <p class="card-text">2/7 módulos completados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Tip:</strong> Completa todas las lecciones de un módulo para marcarlo como completado.
                    </div>
                `;
            }, 1000);
        }

        // Manejar búsqueda FHIR
        document.getElementById('fhirSearchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const resourceType = document.getElementById('resourceType').value;
            const searchQuery = document.getElementById('searchQuery').value;
            
            // Simular búsqueda (aquí conectarías con tu API FHIR)
            document.getElementById('searchResults').style.display = 'block';
            document.getElementById('searchResultsContent').textContent = 
                `Buscando ${resourceType} con: ${searchQuery}\n\n` +
                `Resultado simulado: Recurso encontrado con ID: 12345`;
        });

        // Manejar validación FHIR
        document.getElementById('fhirValidatorForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const resourceJson = document.getElementById('resourceJson').value;
            
            try {
                JSON.parse(resourceJson);
                document.getElementById('validationResults').style.display = 'block';
                document.getElementById('validationResultsContent').innerHTML = 
                    '<div class="alert alert-success"><i class="fas fa-check"></i> Recurso FHIR válido</div>';
            } catch (error) {
                document.getElementById('validationResults').style.display = 'block';
                document.getElementById('validationResultsContent').innerHTML = 
                    '<div class="alert alert-danger"><i class="fas fa-times"></i> Error de sintaxis JSON: ' + error.message + '</div>';
            }
        });
    </script>

    <!-- Stack para scripts adicionales de las vistas -->
    @stack('scripts')
</body>
</html>

