<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = "drivers";

    public static function updateLocation($id, $req)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return DB::table('drivers')
            ->where('user_id', $id)
            ->update(['lat' => $req->lat, 'lng' => $req->lng,'updated_at'=>date('Y-m-d H:i:s')]);
    }
    public static function findDriver()
    {

        return DB::table('drivers as d')
            ->join('users as u','u.id','=','d.user_id')
            ->where('d.deleted_at', null)
            ->select('u.id','u.name','d.lng','d.lat', 'd.updated_at')
            ->get();
    }
}
