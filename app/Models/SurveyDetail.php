<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyDetail extends Model
{
    protected $fillable = ['survey_id', 'skill_id'];
    protected $table = "survey_details";
}
