<?php

namespace App\Http\Controllers;
use App\Models\District;

class DistrictController extends Controller
{
    public function districtOfProvince($id)
    {
        try {
            $res = District::districtOfProvince($id);
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
