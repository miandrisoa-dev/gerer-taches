<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Laravel\Fortify\Features;
use App\Models\Task;
use Illuminate\Http\Request; // Nécessaire pour le formulaire

Route::inertia('/', 'Welcome', [ 'canRegister' => Features::enabled(Features::registration()),])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';


// 1. Route pour AFFICHER la liste
Route::get( '/exercices', [TaskController::class,'index']);

// 2. Route pour ENREGISTRER une nouvelle tâche
Route::post( '/exercices', [TaskController::class,'store']);

// 3. Route pour DELETE 
Route::delete( '/exercices/{task}', [TaskController::class, 'destroy']);

// 4. Route pour tache complete
Route::patch('/exercices/{task}/toggle', [TaskController::class, 'toggle']);