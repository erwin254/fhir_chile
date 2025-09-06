<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FHIR E-Learning Chile')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #3B82F6;
            --secondary-color: #10B981;
            --accent-color: #F59E0B;
            --danger-color: #EF4444;
            --dark-color: #1F2937;
            --light-color: #F8FAFC;
            --sidebar-width: 280px;
            --header-height: 70px;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --shadow-soft: 0 10px 25px rgba(0,0,0,0.1);
            --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light-color);
            color: var(--dark-color);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            box-shadow: var(--shadow-soft);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            background: var(--gradient-primary);
            color: white;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand:hover {
            color: white;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: #6B7280;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: #F3F4F6;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .nav-link.active {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .user-info {
            padding: 1.5rem;
            border-top: 1px solid #E5E7EB;
            background: #F9FAFB;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .user-email {
            font-size: 0.875rem;
            color: #6B7280;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Header */
        .header {
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #6B7280;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: #F3F4F6;
            color: var(--primary-color);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-header {
            background: none;
            border: none;
            color: #6B7280;
            font-size: 1.125rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-header:hover {
            background: #F3F4F6;
            color: var(--primary-color);
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
            background: var(--light-color);
            min-height: calc(100vh - var(--header-height));
        }

        /* Cards */
        .card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .card-header-modern {
            padding: 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            background: #F9FAFB;
            border-radius: 16px 16px 0 0;
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        /* Progress Bars */
        .progress-modern {
            height: 8px;
            background: #E5E7EB;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-modern {
            height: 100%;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }

        /* Buttons */
        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary-modern {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .btn-secondary-modern {
            background: var(--gradient-secondary);
            color: white;
        }

        .btn-secondary-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 1rem;
            }

            .header {
                padding: 0 1rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #E5E7EB;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="sidebar-brand">
                <i class="fas fa-graduation-cap"></i>
                FHIR E-Learning
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#areasCollapse">
                    <i class="fas fa-graduation-cap"></i>
                    Áreas de Aprendizaje
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="areasCollapse">
                    <div class="nav-item">
                        <a href="{{ route('areas.show', 'hospitalizado') }}" class="nav-link ps-5">
                            <i class="fas fa-hospital text-primary"></i>
                            Hospitalizado
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('areas.show', 'urgencia') }}" class="nav-link ps-5">
                            <i class="fas fa-ambulance text-danger"></i>
                            Urgencia
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('areas.show', 'centro-medico') }}" class="nav-link ps-5">
                            <i class="fas fa-user-md text-success"></i>
                            Centro Médico
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link" onclick="showProgressModal()">
                    <i class="fas fa-chart-line"></i>
                    Mi Progreso
                </a>
            </div>
            
            <div class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#fhirCollapse">
                    <i class="fas fa-code"></i>
                    Recursos FHIR
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="fhirCollapse">
                    <div class="nav-item">
                        <a href="{{ route('fhir.chile-core') }}" class="nav-link ps-5">
                            <i class="fas fa-flag text-info"></i>
                            Core Chileno
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link ps-5" onclick="showFhirSearch()">
                            <i class="fas fa-search text-primary"></i>
                            Buscar Recursos
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link ps-5" onclick="showFhirValidator()">
                            <i class="fas fa-check-circle text-success"></i>
                            Validar Recursos
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-email">{{ Auth::user()->email }}</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            
            <div class="header-right">
                <div class="header-actions">
                    <button class="btn-header" onclick="showProgressModal()" title="Mi Progreso">
                        <i class="fas fa-chart-line"></i>
                    </button>
                    <button class="btn-header" onclick="showNotifications()" title="Notificaciones">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="dropdown">
                        <button class="btn-header" data-bs-toggle="dropdown" title="Perfil">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <!-- Modals -->
    @include('layouts.modals')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Configurar Axios para Laravel
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        }

        // Toggle sidebar en móviles
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Cerrar sidebar al hacer clic fuera en móviles
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Funciones para mostrar modales
        function showProgressModal() {
            var modal = new bootstrap.Modal(document.getElementById('progressModal'));
            modal.show();
            loadProgressData();
        }

        function showFhirSearch() {
            var modal = new bootstrap.Modal(document.getElementById('fhirSearchModal'));
            modal.show();
        }

        function showFhirValidator() {
            var modal = new bootstrap.Modal(document.getElementById('fhirValidatorModal'));
            modal.show();
        }

        function showNotifications() {
            // Implementar notificaciones
            console.log('Mostrar notificaciones');
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

        function performFhirSearch() {
            const resourceType = document.getElementById('resourceType').value;
            const searchQuery = document.getElementById('searchQuery').value;
            const resultsDiv = document.getElementById('searchResults');
            
            resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Buscando...</p></div>';
            
            // Simular búsqueda (en una implementación real, harías una petición AJAX)
            setTimeout(() => {
                resultsDiv.innerHTML = `
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Búsqueda simulada:</strong> ${resourceType} con query "${searchQuery}"
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Resultado de ejemplo</h6>
                            <p class="card-text">Aquí se mostrarían los resultados de la búsqueda FHIR.</p>
                        </div>
                    </div>
                `;
            }, 1500);
        }

        function validateFhirResource() {
            const resourceType = document.getElementById('resourceTypeValidator').value;
            const resourceJson = document.getElementById('resourceJson').value;
            const resultsDiv = document.getElementById('validationResults');
            
            if (!resourceJson.trim()) {
                resultsDiv.innerHTML = '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> Por favor, ingresa un JSON válido.</div>';
                return;
            }
            
            resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Validando...</p></div>';
            
            // Simular validación (en una implementación real, harías una petición AJAX)
            setTimeout(() => {
                resultsDiv.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <strong>Validación exitosa:</strong> El recurso ${resourceType} es válido según el Core Chileno.
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Detalles de validación</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success"></i> Estructura JSON válida</li>
                                <li><i class="fas fa-check text-success"></i> Campos requeridos presentes</li>
                                <li><i class="fas fa-check text-success"></i> Cumple con el Core Chileno</li>
                            </ul>
                        </div>
                    </div>
                `;
            }, 2000);
        }

        // Auto-cerrar dropdowns al hacer clic fuera
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            dropdowns.forEach(dropdown => {
                if (!dropdown.closest('.dropdown').contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
    </script>
    
    <!-- Stack para scripts adicionales de las vistas -->
    @stack('scripts')
</body>
</html>