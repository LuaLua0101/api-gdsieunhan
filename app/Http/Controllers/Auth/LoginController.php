<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function postLogin(Request $request)
    {
        try {
            // Nếu dữ liệu hợp lệ sẽ kiểm tra trong csdl
            $phone = trim($request->input('phone'));
            $password = trim($request->input('password'));
            if (Auth::attempt(['phone' => $phone, 'password' => $password])) {
                // Kiểm tra đúng email và mật khẩu sẽ chuyển trang
                if (Auth::user()->level == 3) {
                    return back()
                    ->with('success', __('messages.login_success'));
                }else{
                    Auth::logout();
                    return back()
                    ->with('error', __('messages.login_not_authorized'));
                }
            } else {
                // Kiểm tra không đúng sẽ hiển thị thông báo lỗi
                return back()
                ->with('error', __('messages.login_fail'));
            }
            
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
