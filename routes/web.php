<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AffordabilityController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ChatbotController;

Route::post('/chatbot', [ChatbotController::class, 'ask'])->name('chatbot.ask');

// ============================================================
// COMPARE
// ============================================================
Route::get('/compare', [CompareController::class, 'index'])->name('compare');
Route::post('/compare/add/{id}', [CompareController::class, 'add'])->name('compare.add');
Route::get('/compare/remove/{id}', [CompareController::class, 'remove'])->name('compare.remove');

// ============================================================
// FAVORITE
// ============================================================
Route::get('/favorites', [FavoriteController::class, 'index']);
Route::post('/favorites/{id}', [FavoriteController::class, 'store']);
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
Route::post('/favorites/toggle/{id}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// ============================================================
// HOME
// ============================================================
Route::get('/', [PropertyController::class, 'home']);

// ============================================================
// PROPERTY
// ============================================================
Route::resource('properties', PropertyController::class);
Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');

// ============================================================
// SIMULATION - PERBAIKI INI
// ============================================================
Route::get('/simulation', [SimulationController::class, 'general'])->name('simulation.general');
Route::get('/simulation/{id}', [SimulationController::class, 'index'])->name('simulation.property');
Route::post('/simulation/calculate', [SimulationController::class, 'calculate'])->name('simulation.calculate'); // ← PASTIKAN ADA NAMA
Route::get('/simulation/pdf', [SimulationController::class, 'downloadPdf'])->name('simulation.pdf');

// ============================================================
// AFFORDABILITY
// ============================================================
Route::get('/affordability', [AffordabilityController::class, 'index'])->name('affordability.index');
Route::post('/affordability/calculate', [AffordabilityController::class, 'calculate'])->name('affordability.calculate');

// ============================================================
// DASHBOARD
// ============================================================
Route::get('/dashboard', [DashboardController::class, 'index']);

// ============================================================
// RECOMMENDATION
// ============================================================
Route::get('/recommendation', [RecommendationController::class, 'index'])->name('recommendation');