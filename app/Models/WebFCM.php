<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebFCM extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = "web_fcm";
    protected $fillable = ['user_id', 'fcm_web_token', 'created_at', 'updated_at'];
}
