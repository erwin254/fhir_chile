<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registrarse - FHIR E-Learning Chile</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-y: auto;
            padding: 4rem 2rem;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="300" fill="url(%23a)"/><circle cx="800" cy="300" r="200" fill="url(%23a)"/><circle cx="400" cy="700" r="250" fill="url(%23a)"/></svg>');
            opacity: 0.3;
        }

        .register-container {
            position: relative;
            z-index: 2;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: var(--shadow-hover);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(255,255,255,0.2);
            margin: 2rem auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-logo {
            width: 80px;
            height: 80px;
            background: var(--gradient-secondary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .register-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
            color: #6B7280;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.8);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .btn-register {
            width: 100%;
            padding: 1rem;
            background: var(--gradient-secondary);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #E5E7EB;
        }

        .login-link p {
            color: #6B7280;
            margin-bottom: 1rem;
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #1D4ED8;
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .back-home {
            position: absolute;
            top: 3rem;
            left: 3rem;
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .back-home:hover {
            color: white;
            transform: translateX(-5px);
        }

        .invalid-feedback {
            display: block;
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .is-invalid {
            border-color: var(--danger-color) !important;
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .strength-weak { color: var(--danger-color); }
        .strength-medium { color: var(--accent-color); }
        .strength-strong { color: var(--secondary-color); }

        @media (max-width: 768px) {
            body {
                padding: 3rem 1rem;
            }
            
            .register-container {
                margin: 1rem auto;
                padding: 2rem;
            }
            
            .back-home {
                position: relative;
                top: auto;
                left: auto;
                margin-bottom: 2rem;
                color: var(--dark-color);
            }
        }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="back-home">
        <i class="fas fa-arrow-left"></i>
        Volver al Inicio
    </a>

    <div class="register-container">
        <div class="register-header">
            <div class="register-logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1 class="register-title">Crear Cuenta</h1>
            <p class="register-subtitle">Únete a FHIR E-Learning Chile y comienza tu aprendizaje</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="fas fa-user"></i>
                    Nombre Completo
                </label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                       placeholder="Tu nombre completo">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i>
                    Correo Electrónico
                </label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="email"
                       placeholder="tu@email.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i>
                    Contraseña
                </label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password"
                       placeholder="Mínimo 8 caracteres">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="password-strength" id="password-strength"></div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">
                    <i class="fas fa-lock"></i>
                    Confirmar Contraseña
                </label>
                <input id="password-confirm" type="password" class="form-control" 
                       name="password_confirmation" required autocomplete="new-password"
                       placeholder="Repite tu contraseña">
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i>
                Crear Cuenta
            </button>
        </form>

        <div class="login-link">
            <p>¿Ya tienes una cuenta?</p>
            <a href="{{ route('login') }}" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Iniciar Sesión
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password Strength Checker -->
    <script>
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('password-strength');
            
            if (password.length === 0) {
                strengthDiv.textContent = '';
                return;
            }
            
            let strength = 0;
            let strengthText = '';
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            if (strength < 3) {
                strengthText = 'Contraseña débil';
                strengthDiv.className = 'password-strength strength-weak';
            } else if (strength < 5) {
                strengthText = 'Contraseña media';
                strengthDiv.className = 'password-strength strength-medium';
            } else {
                strengthText = 'Contraseña fuerte';
                strengthDiv.className = 'password-strength strength-strong';
            }
            
            strengthDiv.textContent = strengthText;
        });
    </script>
</body>
</html>
