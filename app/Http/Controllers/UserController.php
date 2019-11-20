<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function editUser(Request $request)
    {
        try {
            $user = User::editUser($request);
            //nếu biến company_id tồn tài->khách hàng công ty
            if ($request->company_id) {
                $customer = Customer::editCustomer_Company($request);
            } else {
                $customer = Customer::editCustomer_Personal($request);
            }
            if ($user == 200 && $customer == 200) {
                return back()
                    ->with('success', __('messages.change_info_success'));
            } else {
                return back()
                    ->with('error', __('messages.change_info_fail'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function changePassword(Request $request)
    {
        try {
            $res = User::changePassword($request);
            if ($res == 200) {
                return back()
                    ->with('success', __('messages.change_password_success'));
            } else {
                return back()
                    ->with('error', __('messages.change_password_fail'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function checkExistPasswordCurrent($password)
    {
        return User::checkExistPasswordCurrent($password);
    }
}
