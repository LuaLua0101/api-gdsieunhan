<?php

Route::post('login', 'ApiController@login');
Route::post('customer-login', 'ApiController@customerLogin');
Route::get('logout', 'ApiController@logout');

Route::post('customer-register', 'ApiController@customerRegister');

Route::post('customer/update-fcm', 'ApiController@updateCustomerFCM');
Route::get('driver/find', 'ApiController@findDriver');

Route::group(['middleware' => 'auth.jwt', 'prefix' => 'driver'], function () {
    // Route::get('verify', 'ApiController@verify')->middleware(['can:delete-company2']);
    Route::get('verify', 'ApiController@verify');
    Route::get('logout', 'ApiController@logout');
    Route::post('update', 'ApiController@changeInfo');
    Route::post('change-passwd', 'ApiController@changePassword');
    Route::post('tracking', 'ApiController@tracking');

    Route::post('list-order', 'ApiController@loadOrders');
    Route::get('order-detail/{id?}', 'ApiController@detail');
    Route::get('order-start/{id?}', 'ApiController@startShipping');
    Route::get('order-finish/{id?}', 'ApiController@finishShipping');
    Route::post('update-fcm', 'ApiController@updateFCM');
    Route::post('get-order', 'ApiController@getOrder');
    Route::post('update-code', 'ApiController@updateCode');
    Route::post('upload-image', 'ApiController@uploadImage');
    Route::post('upload-image-base64', 'ApiController@saveImgBase64');

    Route::post('list-receive', 'ApiController@listReceive');
    Route::post('qrcode-receive', 'ApiController@qrcodeReceive');
    Route::post('qrcode-sender', 'ApiController@qrcodeSender');
    Route::post('order-detail-receive/{id?}', 'ApiController@detail');
});

//raymond

Route::group(['middleware' => 'auth.jwt', 'prefix' => 'customer'], function () {
    Route::post('update-webfcm', 'ApiController@updateWebFCM');
    Route::post('search-all', 'ApiController@searchAll');
    Route::post('search-waiting', 'ApiController@searchWaiting');
    Route::post('search-finished', 'ApiController@searchFinished');
    Route::post('search-cancelled', 'ApiController@searchCancelled');

    Route::post('check-coupon-code', 'ApiController@checkCouponCode');
    Route::post('create-order', 'ApiController@createOrder');

    Route::post('load-histories', 'ApiController@loadInfoHistories');
    Route::post('load-info-receive', 'ApiController@loadInfoReceive');

    Route::post('order-detail/{id?}', 'Api\CustomerController@orderDetail');
    Route::post('order-all', 'Api\CustomerController@orderAll');
    Route::post('order-waiting', 'Api\CustomerController@orderWaiting');
    Route::post('order-finish', 'Api\CustomerController@orderFinish');
    Route::post('order-cancelled', 'Api\CustomerController@orderCancel');

    Route::post('change-info', 'Api\CustomerController@changeInfo');
});