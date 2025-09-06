<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>FHIR E-Learning Chile - Plataforma de Aprendizaje</title>

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
                line-height: 1.6;
                color: var(--dark-color);
                background: var(--light-color);
                overflow-x: hidden;
            }

            .hero-section {
                background: var(--gradient-primary);
                min-height: 100vh;
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
            }

            .hero-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="300" fill="url(%23a)"/><circle cx="800" cy="300" r="200" fill="url(%23a)"/><circle cx="400" cy="700" r="250" fill="url(%23a)"/></svg>');
                opacity: 0.3;
            }

            .hero-content {
                position: relative;
                z-index: 2;
                color: white;
                text-align: center;
            }

            .hero-title {
                font-size: 3.5rem;
                font-weight: 800;
                margin-bottom: 1.5rem;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                animation: fadeInUp 1s ease-out;
            }

            .hero-subtitle {
                font-size: 1.25rem;
                margin-bottom: 2rem;
                opacity: 0.9;
                animation: fadeInUp 1s ease-out 0.2s both;
            }

            .hero-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
                animation: fadeInUp 1s ease-out 0.4s both;
            }

            .btn-hero {
                padding: 1rem 2rem;
                border-radius: 50px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.3s ease;
                border: 2px solid transparent;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 1.1rem;
            }

            .btn-hero-primary {
                background: rgba(255,255,255,0.2);
                color: white;
                border-color: rgba(255,255,255,0.3);
                backdrop-filter: blur(10px);
            }

            .btn-hero-primary:hover {
                background: rgba(255,255,255,0.3);
                transform: translateY(-2px);
                box-shadow: var(--shadow-hover);
                color: white;
            }

            .btn-hero-secondary {
                background: var(--secondary-color);
                color: white;
                border-color: var(--secondary-color);
            }

            .btn-hero-secondary:hover {
                background: #059669;
                transform: translateY(-2px);
                box-shadow: var(--shadow-hover);
                color: white;
            }

            .features-section {
                padding: 5rem 0;
                background: white;
            }

            .feature-card {
                background: white;
                border-radius: 20px;
                padding: 2.5rem;
                text-align: center;
                box-shadow: var(--shadow-soft);
                transition: all 0.3s ease;
                border: 1px solid rgba(0,0,0,0.05);
                height: 100%;
            }

            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: var(--shadow-hover);
            }

            .feature-icon {
                width: 80px;
                height: 80px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                font-size: 2rem;
                color: white;
            }

            .feature-icon.hospital {
                background: var(--gradient-primary);
            }

            .feature-icon.emergency {
                background: var(--gradient-secondary);
            }

            .feature-icon.medical {
                background: var(--gradient-accent);
            }

            .feature-title {
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                color: var(--dark-color);
            }

            .feature-description {
                color: #6B7280;
                line-height: 1.6;
            }

            .stats-section {
                background: var(--gradient-primary);
                padding: 4rem 0;
                color: white;
            }

            .stat-item {
                text-align: center;
            }

            .stat-number {
                font-size: 3rem;
                font-weight: 800;
                margin-bottom: 0.5rem;
            }

            .stat-label {
                font-size: 1.1rem;
                opacity: 0.9;
            }

            .cta-section {
                background: var(--dark-color);
                color: white;
                padding: 5rem 0;
                text-align: center;
            }

            .cta-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .cta-description {
                font-size: 1.2rem;
                margin-bottom: 2rem;
                opacity: 0.8;
            }

            .navbar-custom {
                background: rgba(255,255,255,0.95);
                backdrop-filter: blur(10px);
                box-shadow: 0 2px 20px rgba(0,0,0,0.1);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
            }

            .navbar-brand {
                font-weight: 800;
                font-size: 1.5rem;
                color: var(--primary-color) !important;
            }

            .nav-link {
                font-weight: 500;
                color: var(--dark-color) !important;
                transition: color 0.3s ease;
            }

            .nav-link:hover {
                color: var(--primary-color) !important;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem;
                }
                
                .hero-buttons {
                    flex-direction: column;
                    align-items: center;
                }
                
                .btn-hero {
                    width: 100%;
                    max-width: 300px;
                }
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-graduation-cap me-2"></i>
                    FHIR E-Learning Chile
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
            @if (Route::has('login'))
                    @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/home') }}">
                                        <i class="fas fa-home me-1"></i> Dashboard
                                    </a>
                                </li>
                    @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                                    </a>
                                </li>
                        @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">
                                            <i class="fas fa-user-plus me-1"></i> Registrarse
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <i class="fas fa-heartbeat me-3"></i>
                        FHIR E-Learning Chile
                    </h1>
                    <p class="hero-subtitle">
                        Aprende a trabajar con recursos FHIR usando ejemplos del Core Chileno de HL7 Chile.<br>
                        Plataforma de aprendizaje interactiva para profesionales de la salud.
                    </p>
                    <div class="hero-buttons">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="btn-hero btn-hero-primary">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Ir al Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-hero btn-hero-primary">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Iniciar Sesión
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-hero btn-hero-secondary">
                                        <i class="fas fa-user-plus"></i>
                                        Registrarse Gratis
                                    </a>
                        @endif
                    @endauth
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="display-4 fw-bold mb-3">Áreas de Aprendizaje</h2>
                        <p class="lead text-muted">Módulos especializados para diferentes contextos de atención médica</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon hospital">
                                <i class="fas fa-hospital"></i>
                            </div>
                            <h3 class="feature-title">Hospitalizado</h3>
                            <p class="feature-description">
                                Módulos enfocados en el flujo de atención hospitalaria, desde el ingreso hasta el egreso del paciente. 
                                Incluye recursos para admisión, monitoreo y alta hospitalaria.
                            </p>
                        </div>
                            </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon emergency">
                                <i class="fas fa-ambulance"></i>
                            </div>
                            <h3 class="feature-title">Urgencia</h3>
                            <p class="feature-description">
                                Módulos para el manejo de pacientes en servicios de urgencia y emergencias médicas. 
                                Incluye triage, atención de emergencias y manejo de casos críticos.
                            </p>
                        </div>
                            </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon medical">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <h3 class="feature-title">Centro Médico</h3>
                            <p class="feature-description">
                                Módulos para atención ambulatoria y consultas médicas en centros de salud. 
                                Incluye consultas, seguimiento ambulatorio y manejo de pacientes crónicos.
                            </p>
                        </div>
                    </div>
                </div>
                            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <div class="stat-number">7</div>
                            <div class="stat-label">Módulos Disponibles</div>
                                </div>
                            </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <div class="stat-number">9</div>
                            <div class="stat-label">Lecciones Interactivas</div>
                        </div>
                            </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <div class="stat-number">6</div>
                            <div class="stat-label">Recursos FHIR</div>
                                </div>
                            </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Gratuito</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <h2 class="cta-title">¿Listo para comenzar?</h2>
                <p class="cta-description">
                    Únete a la plataforma de aprendizaje FHIR más completa de Chile y mejora tus habilidades en interoperabilidad de datos de salud.
                </p>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn-hero btn-hero-secondary">
                            <i class="fas fa-rocket"></i>
                            Continuar Aprendiendo
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-hero btn-hero-secondary">
                            <i class="fas fa-user-plus"></i>
                            Comenzar Ahora
                        </a>
                    @endauth
                @endif
                        </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-light py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; 2025 FHIR E-Learning Chile. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Desarrollado con <i class="fas fa-heart text-danger"></i> para la comunidad médica chilena</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Custom JS -->
        <script>
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Add scroll effect to navbar
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar-custom');
                if (window.scrollY > 50) {
                    navbar.style.background = 'rgba(255,255,255,0.98)';
                } else {
                    navbar.style.background = 'rgba(255,255,255,0.95)';
                }
            });
        </script>
    </body>
</html>
