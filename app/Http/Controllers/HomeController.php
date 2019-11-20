<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Company;
use App\Models\Order;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        return view('index', [
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
        ]);
    }
    public function contact()
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        return view('contact', [
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
        ]);
    }
    public function contactUs(Request $request)
    {
        try {
            $res = DB::table(config('constants.CONTACTUS_TABLE'))->insert(
                [
                    'name' => $request->name,
                    'company' => $request->company,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'created_at' => date('Y-m-d h:i:s'),
                ]
            );
            return back()
                ->with('success', __('messages.contact_us_success'));
        } catch (\Throwable $th) {
            return back()
                ->with('error', __('messages.contact_us_fail'));
        }
    }
    public function price_list()
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        return view('price-list', [
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
        ]);
    }
    public function news()
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        return view('news', [
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
        ]);
    }
    public function new_detail()
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        return view('new-detail', [
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
        ]);
    }
    public function user_manual()
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        return view('user-manual', [
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
        ]);
    }
    public function order()
    {
        $province = Province::getList();
        $district = District::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        $order = Order::getList();
        $count_order_all = Order::countList();
        $count_order_watting = Order::countList_Status(1);
        $count_order_no_delivery = Order::countList_Status(2);
        $count_order_beging_delivery = Order::countList_Status(3);
        $count_order_done_delivery = Order::countList_Status(4);
        $count_order_customer_cancel = Order::countList_Status(5);
        $count_order_iht_cancel = Order::countList_Status(6);
        $count_order_fail = Order::countList_Status(7);
        $sum_order = Order::sumList();
        return view('order', [
            'order' => $order,
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
            'district' => $district,
            'sum_order' => $sum_order,
            'count_order_all' => $count_order_all,
            'count_order_watting' => $count_order_watting,
            'count_order_no_delivery' => $count_order_no_delivery,
            'count_order_beging_delivery' => $count_order_beging_delivery,
            'count_order_done_delivery' => $count_order_done_delivery,
            'count_order_customer_cancel' => $count_order_customer_cancel,
            'count_order_iht_cancel' => $count_order_iht_cancel,
            'count_order_fail' => $count_order_fail,
        ]);
    }
    public function orderStatus($status_id)
    {
        $province = Province::getList();
        $district = District::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        $order = Order::getList_Status($status_id);
        $count_order_all = Order::countList();
        $count_order_watting = Order::countList_Status(1);
        $count_order_no_delivery = Order::countList_Status(2);
        $count_order_beging_delivery = Order::countList_Status(3);
        $count_order_done_delivery = Order::countList_Status(4);
        $count_order_customer_cancel = Order::countList_Status(5);
        $count_order_iht_cancel = Order::countList_Status(6);
        $count_order_fail = Order::countList_Status(7);
        $sum_order = Order::sumList_Status($status_id);
        return view('order-status', [
            'order' => $order,
            'customer' => $customer,
            'company' => $company,
            'province' => $province,
            'district' => $district,
            'sum_order' => $sum_order,
            'count_order_all' => $count_order_all,
            'count_order_watting' => $count_order_watting,
            'count_order_no_delivery' => $count_order_no_delivery,
            'count_order_beging_delivery' => $count_order_beging_delivery,
            'count_order_done_delivery' => $count_order_done_delivery,
            'count_order_customer_cancel' => $count_order_customer_cancel,
            'count_order_iht_cancel' => $count_order_iht_cancel,
            'count_order_fail' => $count_order_fail,
        ]);
    }
    public function loadOrder(Request $request)
    {
        $res = Order::loadOrder($request);
        return $res;
    }
    public function loadOrder_Status(Request $request)
    {
        try {
            $res = Order::loadOrder_Status($request);
            if ($res != null) {
                return $res;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function order_search(Request $request)
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        $order = Order::getListSearch($request);
        $order_watting = Order::getList_StatusSearch($request, 1);
        $order_no_delivery = Order::getList_StatusSearch($request, 2);
        $order_beging_delivery = Order::getList_StatusSearch($request, 3);
        $order_done_delivery = Order::getList_StatusSearch($request, 4);
        $order_customer_cancel = Order::getList_StatusSearch($request, 5);
        $order_iht_cancel = Order::getList_StatusSearch($request, 6);
        $order_fail = Order::getList_StatusSearch($request, 7);
        $sum_order = 0;
        foreach ($order as $item) {
            $sum_order += $item->total_price;
        }
        return view('order-search', [
            'customer' => $customer,
            'company' => $company,
            'order' => $order,
            'order_watting' => $order_watting,
            'order_no_delivery' => $order_no_delivery,
            'order_beging_delivery' => $order_beging_delivery,
            'order_done_delivery' => $order_done_delivery,
            'order_customer_cancel' => $order_customer_cancel,
            'order_iht_cancel' => $order_iht_cancel,
            'order_fail' => $order_fail,
            'sum_order' => $sum_order,
            'province' => $province,
        ]);
    }
    public function order_detail($id)
    {
        $province = Province::getList();
        $customer = Customer::getUserOfCustomer();
        $company = Company::listCompanyAll();
        $order = Order::detail($id);
        return view('order-detail', [
            'customer' => $customer,
            'company' => $company,
            'order' => $order,
            'province' => $province,
        ]);
    }

    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

}
