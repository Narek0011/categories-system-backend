<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [UserController::class, 'signup']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::apiResources([
        'category' => CategoryController::class,
        'brands' => BrandController::class,
        'cars' => CarController::class,
    ]);
});

Route::get('/getAllCategories', [CategoryController::class, 'getAllCategories']);
Route::get('/get-brands-by-category/{id}', [BrandController::class, 'getBrandsByCategory']);

