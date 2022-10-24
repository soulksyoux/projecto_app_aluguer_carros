<?php

use App\Http\Controllers\ClienteController;
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

Route::apiResource("cliente", ClienteController::class);
Route::apiResource("carro", ClienteController::class);
Route::apiResource("marca", ClienteController::class);
Route::apiResource("modelo", ClienteController::class);
Route::apiResource("locacao", ClienteController::class);