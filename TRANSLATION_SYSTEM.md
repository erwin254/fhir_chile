# Sistema de Traducciones FHIR

## Descripción

Este sistema implementa un mecanismo de traducciones multilingüe para las descripciones de elementos FHIR usando el sistema de traducciones nativo de Laravel. Esto permite una fácil escalabilidad para agregar nuevos idiomas y mantener las traducciones de manera centralizada.

## Características

- ✅ **Sistema nativo de Laravel**: Utiliza `trans()` y archivos de idioma estándar
- ✅ **Multilingüe**: Soporte para español e inglés (fácil agregar más idiomas)
- ✅ **Selector dinámico**: Cambio de idioma en tiempo real
- ✅ **Fallback inteligente**: Si no hay traducción, muestra el texto original
- ✅ **Traducciones completas**: 226+ traducciones para elementos FHIR comunes
- ✅ **Lógica mejorada**: Prioriza traducciones completas sobre parciales

## Estructura de Archivos

```
resources/lang/
├── es/
│   └── fhir.php          # Traducciones en español
└── en/
    └── fhir.php          # Traducciones en inglés
```

## Configuración

### 1. Idioma por Defecto
El idioma por defecto se configura en `config/app.php`:
```php
'locale' => 'es',  // Español por defecto
```

### 2. Middleware de Idioma
El middleware `SetLocale` permite cambiar idiomas dinámicamente:
```php
// En app/Http/Kernel.php
'web' => [
    // ... otros middlewares
    \App\Http\Middleware\SetLocale::class,
],
```

## Uso

### 1. Cambio de Idioma
Los usuarios pueden cambiar idiomas usando los botones en la interfaz:
```html
<a href="{{ request()->fullUrlWithQuery(['lang' => 'es']) }}">Español</a>
<a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}">English</a>
```

### 2. En el Controlador
```php
public function show($id)
{
    $artifact = $this->getArtifactById($id);
    $translations = trans('fhir');  // Obtiene traducciones del idioma actual
    
    return view('fhir.artifact-detail', compact('artifact', 'translations'));
}
```

### 3. En JavaScript
```javascript
function translateElementDescription(definition) {
    if (!definition) return '';
    
    const translations = @json($translations);  // Traducciones desde Laravel
    
    // Lógica de traducción...
    if (translations[definition]) {
        return translations[definition];
    }
    
    // Fallback para traducciones parciales...
    return definition;
}
```

## Agregar Nuevas Traducciones

### 1. Agregar al Archivo de Idioma
```php
// resources/lang/es/fhir.php
return [
    // ... traducciones existentes
    'Nueva descripción en inglés.' => 'Nueva descripción en español.',
];
```

### 2. Agregar al Archivo en Inglés
```php
// resources/lang/en/fhir.php
return [
    // ... traducciones existentes
    'Nueva descripción en inglés.' => 'Nueva descripción en inglés.',
];
```

### 3. Limpiar Caché
```bash
php artisan cache:clear
php artisan view:clear
```

## Agregar Nuevos Idiomas

### 1. Crear Directorio de Idioma
```bash
mkdir resources/lang/fr  # Para francés
```

### 2. Crear Archivo de Traducciones
```php
// resources/lang/fr/fhir.php
<?php
return [
    'A categorization of the resource.' => 'Une catégorisation de la ressource.',
    // ... más traducciones
];
```

### 3. Actualizar Middleware
```php
// En app/Http/Middleware/SetLocale.php
if (in_array($locale, ['en', 'es', 'fr'])) {  // Agregar 'fr'
    App::setLocale($locale);
    Session::put('locale', $locale);
}
```

### 4. Agregar Selector de Idioma
```html
<a href="{{ request()->fullUrlWithQuery(['lang' => 'fr']) }}">Français</a>
```

## Estadísticas Actuales

- **Total de traducciones**: 226
- **Idiomas soportados**: Español, Inglés
- **Cobertura**: Elementos comunes de FHIR, Patient, Organization, Practitioner, Observation, Medication, Condition
- **Tipos de artefactos**: StructureDefinition, CapabilityStatement

## Ventajas del Sistema

1. **Escalabilidad**: Fácil agregar nuevos idiomas
2. **Mantenibilidad**: Traducciones centralizadas
3. **Reutilización**: Se puede usar en otras partes de la aplicación
4. **Estándares**: Sigue las mejores prácticas de Laravel
5. **Performance**: Caché automático de traducciones
6. **Fallback**: Sistema robusto de respaldo

## Pruebas

El sistema incluye pruebas automáticas que verifican:
- ✅ Traducciones en español funcionan
- ✅ Traducciones en inglés funcionan
- ✅ Conteo de traducciones coincide
- ✅ Traducciones largas funcionan
- ✅ Lógica de JavaScript funciona
- ✅ Fallback funciona correctamente

## Comandos Útiles

```bash
# Limpiar caché de traducciones
php artisan cache:clear

# Limpiar caché de vistas
php artisan view:clear

# Verificar configuración de idioma
php artisan tinker
>>> app()->getLocale()
```

## Futuras Mejoras

- [ ] Agregar más idiomas (francés, portugués, etc.)
- [ ] Sistema de traducciones automáticas
- [ ] Interfaz de administración para traducciones
- [ ] Exportar/importar traducciones
- [ ] Validación de traducciones faltantes
