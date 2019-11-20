<?php
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

// Sửa đường dẫn trang chủ mặc định
Route::get('/', 'HomeController@index');
// Đăng ký, đăng nhập, đăng xuất thành viên
Route::post('register', 'Auth\RegisterController@postRegister');
Route::get('checkExistEmail/{email?}', 'Auth\RegisterController@checkExistEmail');
Route::get('checkExistPhone/{phone?}', 'Auth\RegisterController@checkExistPhone');

Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@postLogin']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LogoutController@postLogout']);

// chỉnh sửa,thay đổi password thành viên
Route::post('edit-user', 'UserController@editUser');
Route::post('change-password', 'UserController@changePassword');
Route::get('checkExistPasswordCurrent/{password?}', 'UserController@checkExistPasswordCurrent');

//trang hiển thị
Route::get('contact', 'HomeController@contact');
Route::post('contact-us', 'HomeController@contactUs');
Route::get('price-list', 'HomeController@price_list');
Route::get('news', 'HomeController@news');
Route::get('new-detail', 'HomeController@new_detail');
Route::get('order', 'HomeController@order');
Route::post('loadOrder', 'HomeController@loadOrder');
Route::get('order/status={id?}', 'HomeController@orderStatus');
Route::post('loadOrder_Status', 'HomeController@loadOrder_Status');
Route::get('order-detail/{id?}', 'HomeController@order_detail');
Route::get('order-search', 'HomeController@order_search');
Route::get('user-manual', 'HomeController@user_manual');

//hiển thị danh sách  (AJAX)
Route::get('districtOfProvince/{province_id?}', 'DistrictController@districtOfProvince');
Route::get('loadInfoSender', 'OrderController@loadInfoSender');
Route::get('loadInfoReceive', 'OrderController@loadInfoReceive');
//đơn hàng
Route::get('total-price-order-all', 'OrderController@totalPriceAll'); //ajax
Route::get('total-price-order', 'OrderController@totalPrice'); //ajax
Route::get('total-price-order-all-search', 'OrderController@totalPriceAllSearch'); //ajax
Route::get('total-price-order-search', 'OrderController@totalPriceSearch'); //ajax
Route::post('create-order', 'OrderController@create');
//print
Route::get('print-order/id={order_id?}','OrderController@printOrder');

//xóa cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
