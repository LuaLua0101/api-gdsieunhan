<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postLogout()
    {
        Auth::logout();
        Session::flash('success', __('messages.logout_success'));
        return redirect('/');
    }
}
