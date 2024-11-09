<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\PoissonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('categorias', CategoriaController::class);
Route::resource('estudiantes', EstudianteController::class);


Route::get('/poisson', [PoissonController::class, 'index']);
Route::post('/calculate-probability', [PoissonController::class, 'calculateProbability']);
Route::post('/calculate-cumulative', [PoissonController::class, 'calculateCumulative']);
Route::post('/calculate-graph-data', [PoissonController::class, 'calculateGraphData']);
