<?php

use App\Http\Controllers\ApiController;
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

Route::get('/clients', [ApiController::class, 'getClients']);
Route::get('/clients/{client}', [ApiController::class, 'getClient']);
Route::post('/clients/{client}/use-keywords', [ApiController::class, 'updateKeywords']);
Route::post('/extract-invoice', [ApiController::class, 'extractInvoice']);
