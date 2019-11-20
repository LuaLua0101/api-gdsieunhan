<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        try {
            $res = Order::create($request);
            if ($res == 200) {
                return back()
                    ->with('success', __('messages.create_order_success'));
            } else {
                return back()
                    ->with('error', __('messages.create_order_fail'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function totalPriceAll()
    {
        try {
            $res = Order::totalPriceAll();
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function totalPrice(Request $request)
    {
        try {
            $res = Order::totalPrice($request->id);
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    //trang search order date
    public function totalPriceAllSearch(Request $request)
    {
        try {
            $res = Order::totalPriceAllSearch($request);
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function totalPriceSearch(Request $request)
    {
        try {
            $res = Order::totalPriceSearch($request, $request->id);
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function loadInfoSender(Request $request)
    {
        try {
            $res = Order::loadInfoSender($request);
            return $res;
            
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function loadInfoReceive(Request $request)
    {
        try {
            $res = Order::loadInfoReceive($request);
            return $res;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function printOrder($id)
    {
        $order = Order::detail($id);

        return view('print-order')->with('order', $order);
    }
}
