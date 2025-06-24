<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('login', [AuthController::class, 'login']);




//Valida
Route::middleware('auth:sanctum')->group(function () {

    require __DIR__ . '/routes/users.php';
    require __DIR__ . '/routes/roles.php';
    require __DIR__ . '/routes/profiles.php';
    require __DIR__ . '/routes/menus.php';



    //Tabla entre perfiles y roles
    Route::get('profile_role/listar', [RoleController::class, 'indexProfileRole']);
    Route::post('user_role/crear', [RoleController::class, 'storeProfileRole']);
    Route::delete('user_role/eliminar/{id}', [RoleController::class, 'destroyProfileRole']);

    //Tabla entre usuarios y perfiles
    Route::get('user_profile/listar', [UserController::class, 'indexUserProfile']);
    Route::post('user_profile/crear', [UserController::class, 'storeUserProfile']);
    Route::delete('user_profile/eliminar/{id}', [UserController::class, 'destroyUserProfile']);
});
