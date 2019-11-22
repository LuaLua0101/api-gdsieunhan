<?php
Route::post('login', 'ApiController@login');
Route::get('logout', 'ApiController@logout');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('list', 'FinanceController@get')->middleware(['can:get-transactions']);
        Route::post('add', 'FinanceController@add')->middleware(['can:add-transaction']);
        Route::post('delete', 'FinanceController@del')->middleware(['can:del-transaction']);
    });

    Route::group(['prefix' => 'notify'], function () {
        Route::get('list', 'NotifyController@get')->middleware(['can:get-notifies']);
        Route::post('add', 'NotifyController@add')->middleware(['can:add-notify']);
        Route::post('delete', 'NotifyController@del')->middleware(['can:del-notify']);
    });
});