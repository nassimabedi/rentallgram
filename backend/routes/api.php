<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\ItemController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function(Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->post('/categories', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::middleware(['auth:sanctum', 'owner'])->group(function () {
    Route::post('/items', [ItemController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'owner'])->group(function () {
    Route::put('/items/{id}', [ItemController::class, 'update']);
});

Route::middleware(['auth:sanctum', 'owner'])->group(function () {
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
});

// Public endpoint (no owner restriction)
Route::get('/items/{id}', [ItemController::class, 'show']);

// Public endpoint (no owner restriction)
Route::get('/items', [ItemController::class, 'index']);