<?php

namespace App\Http\Controllers;
use App\Models\Company;

class CompanyController extends Controller
{
    public function listCompany()
    {
        try {
            $res = Company::listCompany();
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
