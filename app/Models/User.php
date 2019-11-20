<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Request;

class User
{
    public static function editUser($data)
    {
        try {
            $user_id = Auth::user()->id;
            DB::table(config('constants.USER_TABLE'))
                ->where('id', $user_id)
                ->update([
                    'name' => isset($data->name) && $data->name !== "undefined"
                        && $data->name !== null ? $data->name : '',
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
            return 200;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    //change password user
    public static function changePassword($data)
    {
        try {
            $password = Auth::user()->password;
            if (Hash::check($data->current_password, $password)) {
                $user_id = Auth::User()->id;
                DB::table(config('constants.USER_TABLE'))
                    ->where('id', $user_id)
                    ->update([
                        'password' => Hash::make($data->new_password),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
                return 200;
            }
            return 201;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public static function checkExistPasswordCurrent($password)
    {
        if (Request::ajax()) {
            $password_current = Auth::user()->password;
            if (Hash::check($password, $password_current)) {
                return 200;
            }
            return 201;
        }
    }

    //check exist validate email & phone
    public static function checkExistEmail($email)
    {
        if (Request::ajax()) {
            $res = DB::table(config('constants.USER_TABLE'))->where('email', '=', $email)->first();
            if ($res == null) {
                return 200;
            }
            return 201;
        }
    }
    public static function checkExistPhone($phone)
    {
        if (Request::ajax()) {
            $res = DB::table(config('constants.USER_TABLE'))->where('phone', '=', $phone)->first();
            if ($res == null) {
                return 200;
            }
            return 201;
        }
    }
}
