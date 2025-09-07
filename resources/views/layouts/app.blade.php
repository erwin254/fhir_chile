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
            padding: 2.5rem;
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
            padding: 2rem;
            border-bottom: 1px solid #E5E7EB;
            background: #F9FAFB;
            border-radius: 16px 16px 0 0;
        }

        .card-body-modern {
            padding: 2rem;
        }

        /* Spacing utilities */
        .mb-6 { margin-bottom: 3rem !important; }
        .mb-7 { margin-bottom: 4rem !important; }
        .mb-8 { margin-bottom: 5rem !important; }
        .mt-6 { margin-top: 3rem !important; }
        .mt-7 { margin-top: 4rem !important; }
        .mt-8 { margin-top: 5rem !important; }
        .py-6 { padding-top: 3rem !important; padding-bottom: 3rem !important; }
        .py-7 { padding-top: 4rem !important; padding-bottom: 4rem !important; }
        .py-8 { padding-top: 5rem !important; padding-bottom: 5rem !important; }

        /* Grid layouts */
        .grid {
            display: grid;
            gap: 2rem;
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        /* Card improvements */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-body {
            padding: 2rem;
        }

        .card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #E5E7EB;
            background: #F9FAFB;
        }

        /* Hero section */
        .hero {
            margin-bottom: 3rem;
        }

        /* Button improvements */
        .btn {
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

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary:hover {
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: #6B7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4B5563;
            color: white;
        }

        .btn-success {
            background: var(--gradient-secondary);
            color: white;
        }

        .btn-success:hover {
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        /* Progress bar improvements */
        .progress {
            height: 12px;
            background: #E5E7EB;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }

        /* Typography improvements */
        h1, h2, h3, h4, h5, h6 {
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        p {
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        /* List improvements */
        ul, ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        li {
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }

        /* Form improvements */
        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #D1D5DB;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Alert improvements */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .content-area {
                padding: 1.5rem;
            }

            .grid-2, .grid-3 {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-header {
                padding: 1rem 1.5rem;
            }

            .hero {
                margin-bottom: 2rem;
            }
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
                        <a href="{{ route('fhir.artifacts.browser') }}" class="nav-link ps-5">
                            <i class="fas fa-search text-primary"></i>
                            Buscador de Artefactos
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link ps-5" onclick="showFhirSearch()">
                            <i class="fas fa-database text-warning"></i>
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
    @include('layouts.notification-modals')

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
                    <div class="alert alert-light border-0" style="background: rgba(59, 130, 246, 0.1);">
                        <i class="fas fa-lightbulb text-primary me-2"></i>
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
                    <div class="alert alert-light border-0 mb-3" style="background: rgba(59, 130, 246, 0.1);">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <strong>Búsqueda simulada:</strong> ${resourceType} con query "${searchQuery}"
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-file-medical text-primary me-2"></i>
                                Resultado de ejemplo
                            </h6>
                            <p class="card-text">Aquí se mostrarían los resultados de la búsqueda FHIR.</p>
                            <div class="mt-3">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i> Ver Detalles
                                </button>
                                <button class="btn btn-sm btn-outline-secondary ms-2">
                                    <i class="fas fa-download me-1"></i> Descargar
                                </button>
                            </div>
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
                resultsDiv.innerHTML = `
                    <div class="alert alert-light border-0" style="background: rgba(245, 158, 11, 0.1);">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Por favor, ingresa un JSON válido para validar.
                    </div>
                `;
                return;
            }
            
            resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Validando...</p></div>';
            
            // Simular validación (en una implementación real, harías una petición AJAX)
            setTimeout(() => {
                resultsDiv.innerHTML = `
                    <div class="alert alert-light border-0 mb-3" style="background: rgba(16, 185, 129, 0.1);">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Validación exitosa:</strong> El recurso ${resourceType} es válido según el Core Chileno.
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-clipboard-check text-success me-2"></i>
                                Detalles de validación
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i> 
                                    Estructura JSON válida
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i> 
                                    Campos requeridos presentes
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i> 
                                    Cumple con el Core Chileno
                                </li>
                            </ul>
                            <div class="mt-3">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-download me-1"></i> Descargar Validación
                                </button>
                            </div>
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

        // Funciones para mostrar modales de notificación
        function showSuccessModal(title, message) {
            document.getElementById('successModalTitle').textContent = title || '¡Éxito!';
            document.getElementById('successModalMessage').textContent = message || 'Operación completada exitosamente.';
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        }

        function showErrorModal(title, message) {
            document.getElementById('errorModalTitle').textContent = title || 'Error';
            document.getElementById('errorModalMessage').textContent = message || 'Ha ocurrido un error inesperado.';
            var modal = new bootstrap.Modal(document.getElementById('errorModal'));
            modal.show();
        }

        function showWarningModal(title, message) {
            document.getElementById('warningModalTitle').textContent = title || 'Advertencia';
            document.getElementById('warningModalMessage').textContent = message || 'Por favor, revisa la información.';
            var modal = new bootstrap.Modal(document.getElementById('warningModal'));
            modal.show();
        }

        function showInfoModal(title, message) {
            document.getElementById('infoModalTitle').textContent = title || 'Información';
            document.getElementById('infoModalMessage').textContent = message || 'Información importante para ti.';
            var modal = new bootstrap.Modal(document.getElementById('infoModal'));
            modal.show();
        }

        function showConfirmModal(title, message, onConfirm) {
            document.getElementById('confirmModalTitle').textContent = title || 'Confirmar Acción';
            document.getElementById('confirmModalMessage').textContent = message || '¿Estás seguro de que deseas continuar?';
            
            // Remover event listeners anteriores
            const confirmButton = document.getElementById('confirmModalButton');
            const newConfirmButton = confirmButton.cloneNode(true);
            confirmButton.parentNode.replaceChild(newConfirmButton, confirmButton);
            
            // Agregar nuevo event listener
            newConfirmButton.addEventListener('click', function() {
                if (onConfirm && typeof onConfirm === 'function') {
                    onConfirm();
                }
                bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
            });
            
            var modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        }

        function showLessonCompletedModal() {
            var modal = new bootstrap.Modal(document.getElementById('lessonCompletedModal'));
            modal.show();
        }

        function showCorrectAnswerModal(message) {
            document.getElementById('correctAnswerMessage').textContent = message || 'Tu respuesta es correcta.';
            var modal = new bootstrap.Modal(document.getElementById('correctAnswerModal'));
            modal.show();
        }

        function showIncorrectAnswerModal(message) {
            document.getElementById('incorrectAnswerMessage').textContent = message || 'Tu respuesta no es correcta. Revisa la explicación.';
            var modal = new bootstrap.Modal(document.getElementById('incorrectAnswerModal'));
            modal.show();
        }

        // Función para mostrar notificaciones de sesión
        @if (session('status'))
            showSuccessModal('Éxito', '{{ session('status') }}');
        @endif

        @if (session('error'))
            showErrorModal('Error', '{{ session('error') }}');
        @endif

        @if (session('warning'))
            showWarningModal('Advertencia', '{{ session('warning') }}');
        @endif

        @if (session('info'))
            showInfoModal('Información', '{{ session('info') }}');
        @endif
    </script>
    
    <!-- Stack para scripts adicionales de las vistas -->
    @stack('scripts')
</body>
</html>