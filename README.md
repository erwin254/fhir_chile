# FHIR E-Learning Chile

Una plataforma de e-learning abierta para aprender a trabajar con recursos FHIR usando ejemplos del Core Chileno de HL7 Chile.

## 🎯 Objetivo

Proporcionar una plataforma de aprendizaje práctica para profesionales de la salud, desarrolladores y estudiantes que deseen implementar estándares FHIR en Chile, utilizando ejemplos reales basados en el Core Chileno de HL7 Chile.

## 🏥 Áreas de Aprendizaje

La plataforma está organizada en tres grandes áreas médicas:

### 1. Hospitalizado
- **Ingreso Hospitalario**: Proceso de admisión, evaluación inicial y asignación de cama
- **Egreso Hospitalario**: Alta médica, plan de cuidados y seguimiento

### 2. Urgencia
- **Triage de Urgencia**: Clasificación de pacientes según nivel de prioridad
- **Atención de Emergencias**: Manejo de casos críticos

### 3. Centro Médico
- **Consulta Ambulatoria**: Anamnesis, examen físico y plan de tratamiento
- **Seguimiento Ambulatorio**: Control de pacientes crónicos

## 🚀 Características

- **Ejemplos Prácticos**: Recursos FHIR reales basados en el Core Chileno
- **Validación**: Herramientas para validar recursos contra perfiles chilenos
- **Progreso**: Sistema de seguimiento del progreso del usuario
- **Interactivo**: Ejemplos interactivos y evaluaciones
- **Gratuito**: Plataforma completamente abierta y gratuita

## 📋 Requisitos del Sistema

- PHP 7.4 o superior
- Composer
- MySQL 5.7 o superior
- Node.js y NPM (para compilar assets)

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/fhir-elearning-chile.git
cd fhir-elearning-chile
```

### 2. Instalar dependencias
```bash
composer install
npm install
```

### 3. Configurar el entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar la base de datos
Editar el archivo `.env` con los datos de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fhir_elearning
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 5. Ejecutar migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

### 6. Compilar assets
```bash
npm run dev
```

### 7. Iniciar el servidor
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

## 📚 Estructura del Proyecto

```
app/
├── Http/Controllers/     # Controladores de la aplicación
├── Models/              # Modelos Eloquent
└── Services/            # Servicios (FhirService)

database/
├── migrations/          # Migraciones de base de datos
└── seeders/            # Seeders con datos iniciales

resources/
├── views/              # Vistas Blade
│   ├── layouts/        # Layouts base
│   ├── areas/          # Vistas de áreas
│   ├── lessons/        # Vistas de lecciones
│   └── auth/           # Vistas de autenticación
└── css/               # Estilos CSS

routes/
└── web.php            # Rutas web
```

## 🔧 Configuración FHIR

### Servidor FHIR
La aplicación está configurada para conectarse con un servidor FHIR. Puedes cambiar la URL en el archivo `.env`:

```env
FHIR_SERVER_URL=https://hapi.fhir.org/baseR4
```

### Core Chileno
La aplicación utiliza el Core Chileno de HL7 Chile como referencia:
- **URL**: https://hl7chile.cl/fhir/ig/clcore/ImplementationGuide/hl7.fhir.cl.clcore
- **Versión**: 1.0.0

## 📖 Uso de la Plataforma

### 1. Registro e Inicio de Sesión
- Los usuarios pueden registrarse gratuitamente
- El sistema mantiene el progreso de cada usuario

### 2. Navegación por Áreas
- Selecciona un área médica (Hospitalizado, Urgencia, Centro Médico)
- Explora los módulos disponibles en cada área

### 3. Aprendizaje por Lecciones
- Cada lección se enfoca en un recurso FHIR específico
- Incluye teoría, ejemplos prácticos y evaluaciones
- El progreso se guarda automáticamente

### 4. Validación de Recursos
- Utiliza las herramientas de validación para verificar recursos FHIR
- Aprende sobre los requisitos del Core Chileno

## 🧪 Recursos FHIR Incluidos

### Recursos Básicos
- **Patient**: Información demográfica con identificadores chilenos (RUT)
- **Encounter**: Encuentros médicos con códigos locales
- **Observation**: Observaciones clínicas con terminologías chilenas
- **Organization**: Organizaciones de salud chilenas
- **Practitioner**: Profesionales de la salud chilenos

### Ejemplos Específicos
- Pacientes con RUT chileno
- Direcciones con códigos postales chilenos
- Códigos de diagnóstico locales
- Terminologías médicas chilenas

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Contacto

- **Proyecto**: FHIR E-Learning Chile
- **Desarrollado por**: [Tu Nombre]
- **Email**: tu-email@ejemplo.com
- **Sitio Web**: https://tu-sitio.com

## 🙏 Agradecimientos

- **HL7 Chile** por el desarrollo del Core Chileno de FHIR
- **HL7 International** por el estándar FHIR
- **Laravel** por el framework PHP
- **Comunidad FHIR** por su apoyo y contribuciones

## 📚 Recursos Adicionales

- [HL7 Chile](https://hl7chile.cl/)
- [Core Chileno de FHIR](https://hl7chile.cl/fhir/ig/clcore/ImplementationGuide/hl7.fhir.cl.clcore)
- [Documentación FHIR](https://www.hl7.org/fhir/)
- [Laravel Documentation](https://laravel.com/docs)

---

**¡Aprende FHIR con ejemplos reales del sistema de salud chileno!** 🇨🇱