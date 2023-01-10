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
    Route::get('customer/getcustomerid/{id}/change', 'CustomerController@getcustomerid')->name('customer.getcustomerid');
    Route::patch('customer/updatepassword/{id}', 'CustomerController@updatePassword')->name('customer.updatepassword');
    Route::post('customer/updatecustomer/{id}', 'CustomerController@updateCustomer')->name('customer.updatecustomer');
    Route::get('customer/{id}/create', 'CustomerController@viewCreateById')->name('customer.viewcreatebyid');
    Route::post('customer/createbyid', 'CustomerController@createById')->name('customer.createbyid');
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
