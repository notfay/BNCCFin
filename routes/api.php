<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\InvoiceApiController;

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

// Public API routes (no authentication required for testing)
Route::prefix('v1')->group(function () {
    // Categories API
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/categories/{id}', [CategoryApiController::class, 'show']);
    Route::post('/categories', [CategoryApiController::class, 'store']);
    Route::put('/categories/{id}', [CategoryApiController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryApiController::class, 'destroy']);
    
    // Products API
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    Route::post('/products', [ProductApiController::class, 'store']);
    Route::put('/products/{id}', [ProductApiController::class, 'update']);
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);
    
    // Invoices API
    Route::get('/invoices', [InvoiceApiController::class, 'index']);
    Route::get('/invoices/{id}', [InvoiceApiController::class, 'show']);
});
