<?php

use App\Http\Controllers\API\EstudianteController;
use Illuminate\Routing\Route;


Route::get('estudiantes', [EstudianteController::class, 'index']);
Route::post('estudiantes', [EstudianteController::class, 'store']);
Route::put('estudiantes/{estudiante}', [EstudianteController::class, 'update']);
Route::get('estudiantes/{estudiante}', [EstudianteController::class, 'show']);
Route::delete('estudiantes/{estudiante}', [EstudianteController::class, 'destroy']);
