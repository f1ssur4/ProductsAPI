<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CatalogController;

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

Route::controller(CatalogController::class)->group(function () {
    Route::get('/products', 'getAll');
    Route::get('/products/{id}', 'getByFilters');
});
