<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidRole;
//Usuarios

//ocupa el middleware ValidRole para validar los roles de los usuarios y enviale un string que diga admin

Route::get('user/listar', [UserController::class, 'index'])->middleware(ValidRole::class . ':ROLE_USER_LIST');
Route::post('user/crear', [UserController::class, 'store'])->middleware(ValidRole::class . ':ROLE_USER_CREATE');
Route::put('user/actualizar/{id}', [UserController::class, 'update'])->middleware(ValidRole::class . ':ROLE_USER_UPDATE');
Route::delete('user/eliminar/{id}', [UserController::class, 'destroy']);
Route::get('user/listar/{id}', [UserController::class, 'show'])->middleware(ValidRole::class . ':ROLE_USER_LIST');
