<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix(\App\Providers\RouteServiceProvider::CURRENT_API_VERSION)
    ->name(\App\Providers\RouteServiceProvider::CURRENT_API_VERSION . '.')
    ->group(function () {
        Route::apiResource('urls', \App\Http\Controllers\Api\UrlsController::class)->except('index', 'show', 'update', 'destroy');
    });
