<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanDetail extends Model
{
    protected $fillable = ['plan_id', 'skill_id'];
    protected $table = "plan_details";
}
