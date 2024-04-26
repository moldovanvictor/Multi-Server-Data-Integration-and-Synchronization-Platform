<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ToRdf4jController;
use App\Http\Controllers\FromRdf4jController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/jsonLdScraping', [WelcomeController::class, 'index']);
Route::post('/sendToRdf4j', [ToRdf4jController::class, 'index'] );
Route::get('/getRdf4j', [FromRdf4jController::class, 'index'] );