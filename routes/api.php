<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;

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


Route::middleware('api.key')->group(function () {
    Route::resource('category', CategoryController::class)->except([
        'create', 'edit'
    ]);
    Route::resource('product', ProductController::class)->except([
        'create', 'edit'
    ]);
});

Route::get('search', [ProductController::class, 'search']);
