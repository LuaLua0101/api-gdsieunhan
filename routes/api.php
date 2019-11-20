<?php
Route::post('login', 'ApiController@login');
Route::get('logout', 'ApiController@logout');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('order-detail/{id?}', 'Api\CustomerController@orderDetail');
});