<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/test2', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/test2/db', [\App\Http\Controllers\HomeController::class, 'db']);
