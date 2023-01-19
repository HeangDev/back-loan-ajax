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


Route::group(['as' => 'admin.', 'namespace' => 'App\Http\Controllers\admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('customer/getcustomerid/{id}/change', 'CustomerController@getcustomerid')->name('customer.getcustomerid');
    Route::patch('customer/updatepassword/{id}', 'CustomerController@updatePassword')->name('customer.updatepassword');
    Route::post('customer/updatecustomer/{id}', 'CustomerController@updateCustomer')->name('customer.updatecustomer');
    Route::get('customer/{id}/create', 'CustomerController@viewCreateById')->name('customer.viewcreatebyid');
    Route::post('customer/createbyid', 'CustomerController@createById')->name('customer.createbyid');
    
    // Notifications 
    Route::get('notification/reload-notification', 'LoanController@reload_Notifications')->name('reload-notifiactions');
    Route::get('notification/reload-badge-icon-notification', 'LoanController@reload_Badge_Notifications')->name('reload-badge-icon-notifiactions');
    Route::get('notification/reload-badge-icon-notification-sidebar', 'LoanController@reload_Badge_Sidebar_Notifications')->name('reload-badge-icon-sidebar-notifiactions');
    Route::post('notification/readed-notification/{id}', 'LoanController@readed_Notifications')->name('readed.notification');

    Route::post('ajax-user-update', 'UserController@userUpdate')->name('ajax.user.update');
    Route::resources([
        'duration' => DurationController::class,
        'customer' => CustomerController::class,
        'deposit' => DepositController::class,
        'withdraw' => WithdrawController::class,
        'loan' => LoanController::class,
        'agreement' => AgreementController::class,
        'message' => MessageController::class,
        'user' => UserController::class,
    ]);
});
