<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FromJSONLD;
use App\Http\Controllers\ToRdf4jController;
use App\Http\Controllers\FromRdf4jController;
use App\Http\Controllers\ToGraphQlController;
use App\Http\Controllers\FromGraphQlController;
use App\Http\Controllers\ToAiController;
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



Route::get('/jsonLdScraping', [FromJSONLD::class, 'index']);
Route::post('/sendToRdf4j', [ToRdf4jController::class, 'index'] );
Route::get('/getRdf4j', [FromRdf4jController::class, 'index'] );
Route::post( '/sendToGraphQl', [ToGraphQlController::class, 'index'] );
Route::post( '/getGraphQl', [FromGraphQlController::class, 'index'] );
Route::post( '/sendToAi', [ToAiController::class, 'index'] );
