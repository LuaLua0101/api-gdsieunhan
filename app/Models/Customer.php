<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Customer
{
    //đăng ký khách hàng
    public static function customerRegister($request)
    {
        try {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            //thêm thông tin khách hàng vào bảng user
            $user = DB::table(config('constants.USER_TABLE'))->insertGetId(
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'password' => Hash::make($request['password']),
                    'activated' => 1,
                    'level' => 3,
                    'created_at' => date('Y-m-d h:i:s'),
                ]
            );
            //kh cá nhân
            DB::table(config('constants.CUSTOMER_TABLE'))->insert(
                [
                    'user_id' => $user,
                    'type' => 1,
                    'address' => $request->address,
                    'created_at' => date('Y-m-d h:i:s'),
                ]
            );
            return $user;
        } catch (Exception $e) {
            return response()->json('fail', 500);
        }
    }
    //check exist validate email & phone
    public static function checkExistEmail($email)
    {
        $res = DB::table(config('constants.USER_TABLE'))->where('email', '=', $email)->first();
        if ($res == null) {
            return 200;
        }
        return 201;
    }
    public static function checkExistPhone($phone)
    {
        $res = DB::table(config('constants.USER_TABLE'))->where('phone', '=', $phone)->first();
        if ($res == null) {
            return 200;
        }
        return 201;
    }
    //hiển thị địa chỉ,loại khách hàng cá nhân or công ty của khách hàng(form thông tin cá nhân)
    public static function getUserOfCustomer()
    {
        if (Auth::user()) {
            $id = Auth::user()->id;

            $res = DB::select("select c.address, c.type, c.company_id
        FROM users u,customers c
        WHERE u.id=c.user_id AND u.id=$id");
            if (count($res) == '0') {
                $res = null;
            } else {
                $res = $res[0];
            }
            return $res;
        }
    }
    //chỉnh sửa địa chỉ khách hàng cá nhân
    public static function editCustomer_Personal($data)
    {
        try {
            $user_id = Auth::user()->id;
            DB::table(config('constants.CUSTOMER_TABLE'))
                ->where('user_id', $user_id)
                ->update([
                    'company_id' => null,
                    'type' => 1,
                    'address' => $data->address,
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            return 200;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    //chỉnh sửa địa chỉ khách hàng công ty
    public static function editCustomer_Company($data)
    {
        try {
            $user_id = Auth::user()->id;
            //khách hàng chưa có code
            $code_check = DB::table(config('constants.CUSTOMER_TABLE'))->where('user_id', $user_id)->where('code', '!=', '')->first();
            if ($code_check) {
                DB::table(config('constants.CUSTOMER_TABLE'))
                    ->where('user_id', $user_id)
                    ->update([
                        'company_id' => $data->company_id,
                        'type' => 2,
                        'code' => self::codeCustomer(),
                        'address' => $data->address,
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
            } else {
                DB::table(config('constants.CUSTOMER_TABLE'))
                    ->where('user_id', $user_id)
                    ->update([
                        'company_id' => $data->company_id,
                        'type' => 2,
                        'address' => $data->address,
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
            }
            return 200;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    //tạo giá trị code của khách hàng công ty
    public static function codeCustomer()
    {
        $code = DB::select(DB::raw("select c.code
        FROM customers c
        WHERE c.code !=''
        ORDER BY c.id DESC
        LIMIT 1"))[0];
        $code = (int) substr($code->code, 14);
        $code = ++$code;
        $res = 'IHT-KH' . date('Ymd') . $code;
        return $res;
    }

    //list order
    public static function orderAll($skip = 0)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('orders as o')
                ->join('order_details as od', 'od.order_id', '=', 'o.id')
                ->where('o.user_id', $user_id)
                ->select('o.id', 'o.car_option', 'o.status', 'o.coupon_code', 'o.name', 'o.total_price', 'od.sender_address', 'receive_address', 'o.created_at')
                ->orderByDesc('o.id')
                ->skip($skip)
                ->take(10)
                ->get();
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function orderWaiting($skip = 0)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('orders as o')
                ->join('order_details as od', 'od.order_id', '=', 'o.id')
                ->where('o.user_id', $user_id)
                ->where(function ($query) use ($skip) {
                    $query->where('o.status', 1);
                    $query->orWhere('o.status', 2);
                    $query->orWhere('o.status', 3);
                })
                ->select('o.id', 'o.car_option', 'o.status', 'o.coupon_code', 'o.name', 'o.total_price', 'od.sender_address', 'receive_address', 'o.created_at')
                ->orderByDesc('o.id')
                ->skip($skip)
                ->take(10)
                ->get();
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function orderFinish($skip = 0)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('orders as o')
                ->join('order_details as od', 'od.order_id', '=', 'o.id')
                ->where('o.user_id', $user_id)
                ->where('o.status', 4)
                ->select('o.id', 'o.car_option', 'o.status', 'o.coupon_code', 'o.name', 'o.total_price', 'od.sender_address', 'receive_address', 'o.created_at')
                ->orderByDesc('o.id')
                ->skip($skip)
                ->take(10)
                ->get();
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function orderCancel($skip = 0)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('orders as o')
                ->join('order_details as od', 'od.order_id', '=', 'o.id')
                ->where('o.user_id', $user_id)
                ->where(function ($query) use ($skip) {
                    $query->where('o.status', 5);
                    $query->orWhere('o.status', 6);
                    $query->orWhere('o.status', 7);
                })
                ->select('o.id', 'o.car_option', 'o.status', 'o.coupon_code', 'o.name', 'o.total_price', 'od.sender_address', 'receive_address', 'o.created_at')
                ->orderByDesc('o.id')
                ->skip($skip)
                ->take(10)
                ->get();
            return $data;
        } catch (\Exception $ex) {
            dd($ex);
            return $ex;
        }
    }
    public static function orderDetail($id)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('orders as o')
                ->where('o.id', $id)
                ->where('o.user_id', $user_id)
                ->join('order_details as od', 'od.order_id', '=', 'o.id')
                ->leftJoin('order_detail_ext as ode', 'ode.order_id', '=', 'o.id')
                ->select('o.id', 'o.car_option', 'o.code', 'o.coupon_code', 'o.name', 'o.car_option', 'o.is_speed', 'o.payer', 'o.total_price', 'o.status', 'o.created_at', 'od.length as len', 'od.width', 'od.height', 'od.weight', 'od.take_money', 'od.sender_name', 'od.sender_phone', 'od.sender_address', 'od.receive_name', 'od.receive_phone', 'od.receive_address', 'od.note', 'ode.distance', 'ode.hand_on', 'ode.discharge', 'ode.start_time_inventory', 'ode.finish_time_inventory')
                ->first();
            $data->hand_on = (int) $data->hand_on;
            $data->discharge = (int) $data->discharge;
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function orderDeliveries($id)
    {
        try {
            $user_id = Auth::user()->id;
            $data = DB::table('order_deliveries as o')
                ->where('o.order_id', $id)
                ->select('o.status', 'o.date')
                ->get();
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function changeInfo($data)
    {
        try {
            $user_id = Auth::user()->id;
            if($data->password){
                DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'name'=>$data->name,
                    'address'=>$data->address,
                    'password'=> $data->Hash::make($data->password),
                ]);
            }else{
                DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'name'=>$data->name,
                    'address'=>$data->address,
                ]);
            }
            return 200;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function checkPhone($phone)
    {
        try {
            $data = DB::table('users')->where('phone', $phone)->first();
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function checkEmail($email)
    {
        try {
            $data = DB::table('users')->where('email', $email)->first();
            return $data;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
