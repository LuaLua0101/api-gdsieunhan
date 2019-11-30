<?php
Route::post('login', 'ApiController@login');
Route::get('logout', 'ApiController@logout');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::group(['prefix' => 'transaction'], function () {
        Route::get('list', 'FinanceController@get')->middleware(['can:get-transactions']);
        Route::post('histories', 'FinanceController@getHistories')->middleware(['can:get-transactions']);
        Route::post('add', 'FinanceController@add')->middleware(['can:add-transaction']);
        Route::post('delete', 'FinanceController@del')->middleware(['can:del-transaction']);
    });

    Route::group(['prefix' => 'notify'], function () {
        Route::get('list', 'NotifyController@get')->middleware(['can:get-notifies']);
        Route::post('detail', 'NotifyController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add', 'NotifyController@add')->middleware(['can:add-notify']);
        Route::post('delete', 'NotifyController@del')->middleware(['can:del-notify']);
    });

    Route::group(['prefix' => 'student'], function () {
        Route::get('list', 'StudentController@get')->middleware(['can:get-notifies']);
        Route::post('detail', 'StudentController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add', 'StudentController@add')->middleware(['can:add-notify']);
        Route::post('update', 'StudentController@update')->middleware(['can:add-notify']);
        Route::post('delete', 'StudentController@del')->middleware(['can:del-notify']);
    });

    Route::group(['prefix' => 'teacher'], function () {
        Route::get('list', 'TeacherController@get')->middleware(['can:get-notifies']);
        Route::post('time-keeping-all', 'TeacherController@getTimeKeepingAll')->middleware(['can:get-notifies']);
        Route::post('time-keeping', 'TeacherController@getTimeKeepingDetail')->middleware(['can:get-notifies']);
        Route::post('detail', 'TeacherController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add-checkin', 'TeacherController@addCheckin')->middleware(['can:get-notifies']);
        Route::post('remove-checkin', 'TeacherController@removeCheckin')->middleware(['can:get-notifies']);
        Route::post('add', 'TeacherController@add')->middleware(['can:add-notify']);
        Route::post('update', 'TeacherController@update')->middleware(['can:add-notify']);
        Route::post('update-checkin', 'TeacherController@updateTimekeeping')->middleware(['can:add-notify']);
        Route::post('delete', 'TeacherController@del')->middleware(['can:del-notify']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('list', 'UserController@get')->middleware(['can:get-notifies']);
        Route::post('detail', 'UserController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add', 'UserController@add')->middleware(['can:add-notify']);
        Route::post('update', 'UserController@update')->middleware(['can:add-notify']);
        Route::post('delete', 'UserController@del')->middleware(['can:del-notify']);
    });

});