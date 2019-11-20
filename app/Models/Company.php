<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Request;

class Company
{
    //hiển thị danh sách các công ty AJAX
    public static function listCompany()
    {
        if (Request::ajax()) {
            $res = DB::table(config('constants.COMPANY_TABLE'))->select('id', 'name as text')->get();
            return $res;
        }
    }
    //hiển thị danh sách các công ty
    public static function listCompanyAll()
    {
        $res = DB::table(config('constants.COMPANY_TABLE'))->where('publish', 1)->get();
        return $res;
    }
}
