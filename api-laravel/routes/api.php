<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;


Route::middleware('api')->group(function () {

    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('empresas', EmpresaController::class);

    Route::get('clientes/{empresa}/{codigo}', [ClienteController::class, 'show']);
    Route::put('clientes/{empresa}/{codigo}', [ClienteController::class, 'update']);
    Route::delete('clientes/{empresa}/{codigo}', [ClienteController::class, 'destroy']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
