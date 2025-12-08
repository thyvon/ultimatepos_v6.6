<?php

use Illuminate\Support\Facades\Route;
Route::middleware(['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'])
    ->prefix('installment')->group(function() {

    // Main Installment Module
    Route::get('/', 'InstallmentController@index')->name('installment.index');
    Route::resource('/installment','InstallmentController');
    Route::get('/installments','InstallmentController@instalments')->name('installment.instalments');
    Route::get('/installments_for_home','InstallmentController@installments_for_home')->name('installment.installments_for_home');
    Route::get('/installmentdelete/{id}','InstallmentController@installmentdelete')->name('installment.installmentdelete');
    Route::get('/paymentdelete/{id}','InstallmentController@paymentdelete')->name('installment.paymentdelete');
    Route::get('/addpayment/{id}','InstallmentController@addpayment')->name('installment.addpayment');
    Route::post('/storepayment','InstallmentController@storepayment')->name('installment.storepayment');
    Route::get('/business','InstallmentController@business')->name('installment.business');
    Route::get('/printinstallment/{id}','InstallmentController@printinstallment')->name('installment.printinstallment');

    // Installment System
    Route::resource('/system','InstallmentSystemController');
    Route::get('/getsystemdata','InstallmentSystemController@getsystemdata')->name('installment.getsystemdata');

    // Customer Module
    Route::resource('/customer','CustomerController');
    Route::get('/getcustomerdata/{id}','CustomerController@getcustomerdata')->name('installment.getcustomerdata');
    Route::get('/createinstallment2/{id}/{total}/{paid?}','CustomerController@createinstallment2')->name('installment.customer.createinstallment2');
    Route::post('/createinstallment','CustomerController@createinstallment')->name('installment.customer.createinstallment');
    Route::get('/getinstallment','CustomerController@getinstallment')->name('installment.customer.getinstallment');
    Route::get('/contacts','CustomerController@contacts')->name('installment.customer.contacts');
    Route::get('/contactwithinstallment','CustomerController@contactwithinstallment')->name('installment.customer.contactwithinstallment');

    // Sell Module
    Route::get('/sells','SellController@index')->name('installment.sells.index');
    Route::get('/sells/{id}','SellController@show')->name('installment.sells.show');
    Route::get('/sells/{id}/edit','SellController@edit')->name('installment.sells.edit');
    Route::post('/sells/duplicate/{id}','SellController@duplicateSell')->name('installment.sells.duplicateSell');

    // SellPos
    Route::get('/sellpos/{id}/edit','SellPosController@edit')->name('installment.sellpos.edit');
    Route::delete('/sellpos/{id}','SellPosController@destroy')->name('installment.sellpos.destroy');
    Route::get('/sellpos/{id}/showInvoiceUrl','SellPosController@showInvoiceUrl')->name('installment.sellpos.showInvoiceUrl');

    // Sell Return
    Route::get('/sellreturn/add/{id}','SellReturnController@add')->name('installment.sellreturn.add');

    // Transaction Payment
    Route::get('/transactionpayment/{id}','TransactionPaymentController@show')->name('installment.transactionpayment.show');

    // Notification
    Route::get('/notification/getTemplate','NotificationController@getTemplate')->name('installment.notification.getTemplate');

    // Shipping
    Route::get('/sells/{id}/editShipping','SellController@editShipping')->name('installment.sells.editShipping');
    Route::get('/sells/viewMedia','SellController@viewMedia')->name('installment.sells.viewMedia');

    // CustomerController Installment Helper
    Route::get('/customer/createinstallment2/{id}/{total}/{paid?}','CustomerController@createinstallment2')->name('installment.customer.createinstallment2');

});
