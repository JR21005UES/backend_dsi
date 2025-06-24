<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;


Route::get('menu/listar', [MenuController::class, 'index']);
