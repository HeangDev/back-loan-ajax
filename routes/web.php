<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'App\Http\Controllers\admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('customer/{id}/changepassword', 'CustomerController@viewChangePassword')->name('customer.viewchangepassword');
    Route::post('cheagePassword', 'CustomerController@cheagePassword')->name('customer.cheagepassword');
    Route::resources([
        'duration' => DurationController::class,
        'customer' => CustomerController::class,
        'deposit' => DepositController::class,
        'withdraw' => WithdrawController::class,
        'loan' => LoanController::class,
        'agreement' => AgreementController::class,
        'user' => UserController::class,
    ]);
});
