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
        Route::get('teacher-list', 'NotifyController@getTeacherNotifies')->middleware(['can:get-notifies']);
        Route::get('parent-list', 'NotifyController@getParentNotifies')->middleware(['can:get-notifies']);
        Route::post('detail', 'NotifyController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add', 'NotifyController@add')->middleware(['can:add-notify']);
        Route::post('delete', 'NotifyController@del')->middleware(['can:del-notify']);

        Route::get('pinned-list', 'NotifyController@getPinnedList')->middleware(['can:del-notify']);
        Route::post('unpin', 'NotifyController@unpinNotify')->middleware(['can:del-notify']);
        Route::post('pin', 'NotifyController@pinNotify')->middleware(['can:del-notify']);
    });

    Route::group(['prefix' => 'student'], function () {
        Route::get('list', 'StudentController@get')->middleware(['can:get-notifies']);
        Route::post('detail', 'StudentController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add', 'StudentController@add')->middleware(['can:add-notify']);
        Route::post('update', 'StudentController@update')->middleware(['can:add-notify']);
        Route::post('delete', 'StudentController@del')->middleware(['can:del-notify']);

        Route::post('time-keeping-all', 'StudentController@getTimeKeepingAll')->middleware(['can:get-notifies']);
        Route::post('time-keeping', 'StudentController@getTimeKeepingDetail')->middleware(['can:get-notifies']);
        Route::post('add-checkin', 'StudentController@addCheckin')->middleware(['can:get-notifies']);
        Route::post('remove-checkin', 'StudentController@removeCheckin')->middleware(['can:get-notifies']);
        Route::post('update-checkin', 'StudentController@updateTimekeeping')->middleware(['can:add-notify']);
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

    Route::group(['prefix' => 'skill-group'], function () {
        Route::get('list', 'SkillGroupController@get')->middleware(['can:get-notifies']);
        Route::post('detail', 'SkillGroupController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add', 'SkillGroupController@add')->middleware(['can:add-notify']);
        Route::post('update', 'SkillGroupController@update')->middleware(['can:add-notify']);
        Route::post('delete', 'SkillGroupController@del')->middleware(['can:del-notify']);
    });

    Route::group(['prefix' => 'skill'], function () {
        Route::get('list', 'SkillController@get')->middleware(['can:get-notifies']);
        Route::get('check-survey', 'SkillController@checkSurveyIsExist')->middleware(['can:get-notifies']);
        Route::post('list-survey', 'SkillController@getSurveySkillList')->middleware(['can:get-notifies']);
        Route::post('detail', 'SkillController@getDetail')->middleware(['can:get-notifies']);
        Route::post('add', 'SkillController@add')->middleware(['can:add-notify']);
        Route::post('update-survey', 'SkillController@updateSurvey')->middleware(['can:add-notify']);
        Route::post('update', 'SkillController@update')->middleware(['can:add-notify']);
        Route::post('delete', 'SkillController@del')->middleware(['can:del-notify']);
    });

    Route::group(['prefix' => 'plan'], function () {
        Route::post('list', 'PlanController@get')->middleware(['can:get-notifies']);
    });
});
