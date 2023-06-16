<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/login', [LoginController::class, 'showFormLogin'])->name("login");
Route::get('/login/{id}', [LoginController::class, 'loginWithId'])->name("loginWithId");
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [AuthenticationController::class, 'logout']);



