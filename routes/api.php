<?php
Route::post('login', 'ApiController@login');
Route::get('logout', 'ApiController@logout');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('get-transactions', 'FinanceController@getTransactions')->middleware(['can:get-transactions']);
    Route::post('add-transaction', 'FinanceController@addTransaction')->middleware(['can:add-transaction']);
});