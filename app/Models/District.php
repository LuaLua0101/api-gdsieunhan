<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Request;

class District extends Model
{
    protected $table = "districts";
    //hiển thị danh sách quận/huyện theo id của tỉnh/thành phố
    public static function districtOfProvince($id)
    {
        if (Request::ajax()) { //còn thiếu điều kiện public
            $res = DB::table(config('constants.DISTRICT_TABLE'))->select('id', 'name as text')->where(['province_id' => $id])->get();
            return $res;
        }
    }

    //tìm quận huyện theo id
    public static function findDistrict($id)
    {
        $res = DB::table(config('constants.DISTRICT_TABLE'))->where(['id' => $id])->first();
        return $res;
    }
    public static function getList()
    {
        $res = DB::table(config('constants.DISTRICT_TABLE'))->where('publish', 1)->get();
        return $res;
    }
}
