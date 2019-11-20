<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Http\Request;
use App\Models\Customer;

class RegisterController extends Controller
{

    protected function create(Request $data)
    {
        //thêm thông tin khách hàng vào bảng user
        $res =   DB::table(config('constants.USER_TABLE'))->insertGetId(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'activated' => '1',
                'created_at' => date('Y-m-d h:i:s'),
            ]
        );
        //kiểm tra khách hàng thuộc cá nhân or công ty
        if ($data['type']==2) {
            //kh công ty
            $code = Customer::codeCustomer();
            DB::table(config('constants.CUSTOMER_TABLE'))->insert(
                [
                    'user_id' => $res,
                    'type' => 2,
                    'code' => $code,
                    'address' => $data->address,
                    'company_id' => $data['company_id'],
                    'province_id'=>$data['province_id'],
                    'district_id'=>$data['district_id'],
                    'created_at' => date('Y-m-d h:i:s'),
                ]
            );
        } else {
            //kh cá nhân
            DB::table(config('constants.CUSTOMER_TABLE'))->insert(
                [
                    'user_id' => $res,
                    'type' => 1,
                    'address' => $data->address,
                    'created_at' => date('Y-m-d h:i:s'),
                ]
            );
        }
        return 200;
    }
    public function postRegister(Request $request)
    {
        // Dữ liệu vào hợp lệ sẽ thực hiện tạo người dùng dưới csdl
        if (self::create($request)==200) {
            // Insert thành công sẽ hiển thị thông báo
            Session::flash('success', __('messages.register_success'));
            return redirect('/');
        } else {
            // Insert thất bại sẽ hiển thị thông báo lỗi
            Session::flash('error', __('messages.register_fail'));
            return redirect('/');
        }
    }

    //check exist validate email & phone
    public function checkExistEmail($email)
    {
        return User::checkExistEmail($email);
    }
    public function checkExistPhone($phone)
    {
        return User::checkExistPhone($phone);
    }
}
