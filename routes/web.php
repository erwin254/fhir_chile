<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\FhirController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Rutas de autenticación
Auth::routes();

// Rutas de áreas
Route::get('/areas/{slug}', [AreaController::class, 'show'])->name('areas.show');

// Rutas de lecciones
Route::get('/lessons/{slug}', [LessonController::class, 'show'])->name('lessons.show');
Route::post('/lessons/{slug}/progress', [LessonController::class, 'updateProgress'])->name('lessons.progress');

// Rutas FHIR
Route::get('/fhir/chile-core', [FhirController::class, 'chileCore'])->name('fhir.chile-core');
Route::post('/fhir/validate', [FhirController::class, 'validateResource'])->name('fhir.validate');
Route::post('/fhir/search', [FhirController::class, 'searchResources'])->name('fhir.search');
Route::get('/fhir/{resourceType}/{id}', [FhirController::class, 'getResource'])->name('fhir.get');
Route::post('/fhir/create', [FhirController::class, 'createResource'])->name('fhir.create');

