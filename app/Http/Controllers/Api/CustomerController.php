<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;


class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    public function orderAll(Request $req)
    {
        try {
            $skip = $req->skip ? $req->skip : 0;
            $data =  Customer::orderAll($skip);
            return response()->json(['data' => $data, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Have not order',
            ], 401);
        }
    }
    public function orderWaiting(Request $req)
    {
        try {
            $skip = $req->skip ? $req->skip : 0;
            $data =  Customer::orderWaiting($skip);
            return response()->json(['data' => $data, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Have not order',
            ], 401);
        }
    }
    public function orderFinish(Request $req)
    {
        try {
            $skip = $req->skip ? $req->skip : 0;
            $data =  Customer::orderFinish($skip);
            return response()->json(['data' => $data, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Have not order',
            ], 401);
        }
    }
    public function orderCancel(Request $req)
    {
        try {
            $skip = $req->skip ? $req->skip : 0;
            $data =  Customer::orderCancel($skip);
            return response()->json(['data' => $data, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Have not order',
            ], 401);
        }
    }
    public function orderDetail($id)
    {
        try {
            $data =  Customer::orderDetail($id);
            $order_deliveries =  Customer::orderDeliveries($id);
            return response()->json(['data' => $data,'order_deliveries'=>$order_deliveries, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Have not order',
            ], 401);
        }
    }
    public function changeInfo(Request $req)
    {
        try {
            if($req->name ==null || $req->address ==null||$req->phone ==null||$req->email ==null){
                return response()->json([
                    'success' => false,
                    'message' => 'Name, email, phone number, address must not be empty',
                ], 401);
            }else{
                $data =  Customer::changeInfo($req);
            }
            return response()->json(['data' => 'success', 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'fail',
            ], 401);
        }
    }
}
