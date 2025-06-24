<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

//Roles
    Route::get('rol/listar', [RoleController::class, 'index']);
    Route::post('rol/crear', [RoleController::class, 'store']);
    Route::put('rol/actualizar/{id}', [RoleController::class, 'update']);
    Route::delete('rol/eliminar/{id}', [RoleController::class, 'destroy']);
    Route::get('rol/listar/{id}', [RoleController::class, 'show']);
    Route::put('rol/recuperar/{id}', [RoleController::class, 'restore']);
