<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    protected $table = "provinces";
    //hiển thị danh sách tỉnh/thành phố
    public static function getList()
    {
        $res = DB::table(config('constants.PROVINCE_TABLE'))->where('publish', 1)->get();
        return $res;
    }

}
