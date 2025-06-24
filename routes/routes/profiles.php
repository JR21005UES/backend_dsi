<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
//Perfiles 
    Route::get('perfil/listar', [ProfileController::class, 'index']);
    Route::post('perfil/crear', [ProfileController::class, 'store']);
    Route::put('perfil/actualizar/{id}', [ProfileController::class, 'update']);
    Route::delete('perfil/eliminar/{id}', [ProfileController::class, 'destroy']);
    Route::get('perfil/listar/{id}', [ProfileController::class, 'show']);
    Route::put('perfil/recuperar/{id}', [ProfileController::class, 'restore']);
