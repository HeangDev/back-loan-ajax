<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;

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

Route::group(['as' => 'api.','namespace' => 'App\Http\Controllers\Api'], function() {
    Route::apiResource('duration', DurationController::class)->only([
        'index'
    ]);

    Route::apiResource('agreement', AgreementController::class)->only([
        'index'
    ]);

    Route::apiResource('loan', LoanController::class)->only([
        'show', 'store'
    ]);

    Route::apiResource('user', UserController::class)->only([
        'show', 'update'
    ]);

    Route::apiResource('signature', SignatureController::class)->only([
        'show', 'update'
    ]);

    Route::apiResource('deposit', DepositController::class)->only([
        'show'
    ]);

    Route::apiResource('withdraw', WithdrawController::class)->only([
        'store'
    ]);

    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/changepassword', [LoginController::class, 'changePassword']);
    Route::get('/getinfo/{id}', [LoginController::class, 'getInfo']);
});
