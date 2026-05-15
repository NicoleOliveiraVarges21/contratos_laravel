<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractItemController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');

    Route::apiResource(
        'clients',
        ClientController::class
    );

    Route::apiResource(
        'services',
        ServiceController::class
    );

    Route::apiResource(
        'contracts',
        ContractController::class
    );

    Route::patch(
        'contracts/{contract}/cancel',
        [ContractController::class, 'cancel']
    );

    Route::post(
        'contracts/{contract}/items',
        [ContractItemController::class, 'store']
    );

    Route::put(
        'contract-items/{contractItem}',
        [ContractItemController::class, 'update']
    );

    Route::delete(
        'contract-items/{contractItem}',
        [ContractItemController::class, 'destroy']
    );
});
