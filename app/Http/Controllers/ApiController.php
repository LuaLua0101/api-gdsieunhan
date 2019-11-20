<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\District;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Province;
use App\Models\WebFCM;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends Controller
{
    public $loginAfterSignUp = true;

    public function updateWebFCM(Request $req)
    {
        $id = Auth::user()->id;
        $o = WebFCM::firstOrNew(array('user_id' => $id));
        $o->fcm_web_token = $req->fcm;
        $o->save();
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function login(Request $request)
    {
        dd(24);
        $this->validate($request, [
            'phone' => 'required|max:255',
            'password' => 'required',
        ]);
        $input = $request->only('phone', 'password');
        $jwt_token = null;

        try {
            if (!$jwt_token = JWTAuth::attempt($input)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Phone or Password',
                ], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], 500);
        }

        $user_level = Auth::user()->level;
        $user = Auth::user();

        return response()->json([
            'token' => 'Bearer ' . $jwt_token,
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);

    }
    public function customerRegister(Request $request)
    {
        try {
            //check phone & email
            $phone = Customer::checkExistPhone($request->phone);
            $email = Customer::checkExistEmail($request->email);
            if ($phone == 200 && $email == 200) {
                $user = Customer::customerRegister($request);
                return response()->json([
                    'success' => true,
                    'data' => $user,
                ], 200);
            } else {
                if ($phone == 201 && $email == 201) {
                    return response()->json([
                        'fail' => 'Your phone number & email already exists',
                    ], 201);
                }
                if ($phone == 201) {
                    return response()->json([
                        'fail' => 'Your phone number already exists',
                    ], 201);
                }
                if ($email == 201) {
                    return response()->json([
                        'fail' => 'Your email already exists',
                    ], 201);
                }
            }
        } catch (Exception $e) {
            return response()->json('fail', 500);
        }
    }
    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|max:255',
            'password' => 'required',
        ]);
        $input = $request->only('phone', 'password');
        $jwt_token = null;
        $username = 'phone';
        if (filter_var($input['phone'], FILTER_VALIDATE_EMAIL)) {
            $username = 'email';
        }
        try {
            if (!$jwt_token = JWTAuth::attempt([
                $username => $input['phone'],
                'password' => $input['password'],
            ])) {

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Phone or Password',
                ], 200);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], 500);
        }

        $user_level = Auth::user()->level;
        $user = Auth::user();

        if ($user_level == 3) {
            $customer = DB::table('users as u')->rightJoin('customers as c', 'c.user_id', '=', 'u.id')->where('u.id', $user->id)->select('u.*', 'c.address')->first();
            return response()->json([
                'token' => 'Bearer ' . $jwt_token,
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'address' => $customer->address,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User has no permission',
            ], 200);
        }
    }
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully',
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out',
            ], 500);
        }
    }

    public function verify()
    {
        $user = Auth::user();

        return response()->json([
            'code' => Response::HTTP_OK,
            'token' => 'Bearer ' . JWTAuth::getToken(),
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);
    }
    public function searchAll(Request $req)
    {
        $res = Order::searchAll($req->search, $req->skip);

        return response()->json($res);
    }
    public function searchWaiting(Request $req)
    {
        $res = Order::searchWaiting($req->search);

        return response()->json($res);
    }
    public function searchFinished(Request $req)
    {
        $res = Order::searchFinished($req->search);

        return response()->json($res);
    }
    public function searchCancelled(Request $req)
    {
        $res = Order::searchCancelled($req->search);

        return response()->json($res);
    }

    public function changeInfo(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            $req->name ? $user->name = $req->name : null;
            $req->phone ? $user->phone = $req->phone : null;
            $req->email ? $user->email = $req->email : null;
            $user->save();
            return response()->json(['code' => 200]);
        } catch (\Exception $e) {
            //
        }
    }
    public function changePassword(Request $req)
    {
        try {
            if (JWTAuth::attempt(['phone' => Auth::user()->phone, 'password' => $req->old_pwd])) {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($req->new_pwd);
                $user->save();
                return response()->json(['code' => 200]);
            } else {
                return response()->json(['code' => 500]);
            }
        } catch (\Exception $e) {
            //
        }
    }

    public function tracking(Request $req)
    {
        try {
            Driver::updateLocation(Auth::user()->id, $req);
            return response()->json(['code' => 200]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500]);
        }
    }

    public function findAll()
    {
        try {
            $driver = Driver::whereNotNull('lat')->whereNotNull('lng')->get(['user_id', 'lat', 'lng']);
            return response()->json($driver);
        } catch (\Exception $e) {
            return response()->json(['code' => 500]);
        }
    }

    public function loadOrders(Request $req)
    {
        $page = $req->page ? $req->page : 0;
        $type = $req->type ? $req->type : 0;
        $driver = Driver::where('user_id', Auth::user()->id)->firstOrFail();
        if ($type == 0) {
            $orders = Order::getAllOrderByDriver($driver->id, $page);
        } else if ($type == 4) {
            $orders = Order::getFinishOrderByDriver($driver->id, $page);
        } else {
            $orders = Order::getPendingOrderByDriver($driver->id, $page);
        }
        foreach ($orders as $order) {
            $order->created_at = date("d-m-Y", strtotime($order->created_at));
        }
        return response()->json($orders);
    }

    public function getOrder(Request $req)
    {
        $order = Order::getOrderById($req->order_id);
        return response()->json($order);
    }
    public function updateCode(Request $req)
    {
        $order = Order::updateCode($req);
        return response()->json($order);
    }

    public function detail($id)
    {

        $order = Order::orderDetail($id);
        $sender_province = Province::where('province_id', $order->sender_province_id)->first();
        $sender_dist = District::find($order->sender_district_id);
        $receive_province = Province::where('province_id', $order->receive_province_id)->first();
        $receive_dist = District::find($order->receive_district_id);

        $order->sender_province_id = $sender_province ? $sender_province->name : '';
        $order->sender_district_id = $sender_dist ? $sender_dist->name : '';
        $order->receive_province_id = $receive_province ? $receive_province->name : '';
        $order->receive_district_id = $receive_dist ? $receive_dist->name : '';
        $order->created_at = date("d-m-Y", strtotime($order->created_at));
        return response()->json($order);
    }

    public function startShipping($id)
    {
        try {
            $order = Order::find($id);
            $order->status = 3;
            $order->save();
            //send notify to customer
            $fcm = Device::getToken($order->user_id);
            if ($fcm) {
                Device::sendMsgToDevice($fcm, 'Thông báo từ IHTGO', 'Đơn hàng ' . $order->code . ' đang trên đường giao', []);
            }

            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json(e);
        }
    }
    public function uploadImage(Request $request)
    {
        try {
            dd($request->image);

            if ($request->hasFile('image')) {
                //filename to store
                $filenametostore = $request->id . '_orders.png';
                //Upload File
                $request->file('image')->storeAs('public/orders', $filenametostore);
                $request->file('image')->storeAs('public/orders/thumbnail', $filenametostore);

                //Resize image here
                $thumbnailpath = public_path('storage/orders/thumbnail/' . $filenametostore);
                $img = Image::make($thumbnailpath)->resize(400, 150, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath);
                DB::table('orders')
                    ->where('id', $request->id)
                    ->update([
                        'image_link' => 'public/storage/orders/' . $filenametostore,
                    ]);
            }
            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json(e);
        }
    }
    protected function saveImgBase64(Request $request)
    {
        list($extension, $content) = explode(';', $request->image);
        $fileName = $request->id . '_orders.png';
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');

        $checkDirectory = $storage->exists('orders/');

        if (!$checkDirectory) {
            $storage->makeDirectory('orders/');
        }

        $storage->put('orders/' . '/' . $fileName, base64_decode($content), 'public');
        DB::table('orders')
            ->where('id', $request->id)
            ->update([
                'image_link' => 'public/storage/orders/' . $fileName,
            ]);

        return $fileName;
    }
    public function finishShipping($id)
    {
        try {
            $order = Order::find($id);
            $order->status = 4;
            $order->save();

            //send notify to customer
            $fcm = Device::getToken($order->user_id);
            if ($fcm) {
                Device::sendMsgToDevice($fcm, 'Thông báo từ IHTGO', 'Đơn hàng ' . $order->code . ' đã được giao thành công', []);
            }

            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json(e);
        }
    }

    public function updateFCM(Request $req)
    {
        try {
            Device::updateFcm(Auth::user()->id, $req->fcm);
            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json(e);
        }
    }

    public function updateCustomerFCM(Request $req)
    {
        try {
            Device::updateFcm($req->id, $req->fcm);
            return response()->json(200);
        } catch (\Exception $e) {
            return response()->json(e);
        }
    }
    //raymond
    public function loadInfoHistories(Request $req)
    {
        try {
            $data1 = Order::loadSenderAddress($req);
            $data2 = Order::loadReceiveAddress($req);
            $data3 = Order::loadSenderName($req);
            $data4 = Order::loadSenderPhone($req);
            $data5 = Order::loadReceiveName($req);
            $data6 = Order::loadReceivePhone($req);
            return response()->json(['send_add' => $data1, 'rec_add' => $data2, 'send_names' => $data3, 'send_phones' => $data4, 'rec_names' => $data5, 'rec_phones' => $data6, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'msg' => $e]);
        }
    }

    public function loadInfoReceive(Request $req)
    {
        try {
            $data = Order::loadInfoReceive($req);
            return response()->json(['data' => $data, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500]);
        }
    }
    public function findDriver()
    {
        try {
            $data = Driver::findDriver();
            return response()->json(['data' => $data, 'code' => 200]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['code' => 500]);
        }
    }
    public function checkCouponCode(Request $req)
    {
        $res = Order::checkCouponCode($req);
        if ($res == 200) {
            return response()->json('ok');
        } else {
            return response()->json('fail');
        }
    }
    public function createOrder(Request $req)
    {
        try {
            $user = Auth::user();
            $data = Order::createOrder($req);
            //send notify to customer
            $fcm = Device::getToken($user->id);
            if ($fcm) {
                Device::sendMsgToDevice($fcm, 'Thông báo từ IHTGO', 'Đơn hàng ' . $data->code . ' đã được tạo thành công', []);
            }

            //send notify to web
            $webfcm = WebFCM::find($user->id);
            if ($webfcm) {
                Device::sendMsgToDevice($webfcm->fcm_web_token, 'Thông báo từ IHTGO', 'Đơn hàng ' . $data->code . ' đã được tạo thành công', []);
            }

            return response()->json(['data' => $data, 'code' => 200]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function listReceive(Request $req)
    {
        $page = $req->page ? $req->page : 0;
        $driver = Driver::where('user_id', Auth::user()->id)->firstOrFail();
        $orders = Order::listReceive($driver->id, $page);
        foreach ($orders as $order) {
            $order->created_at = date("d-m-Y", strtotime($order->created_at));
        }
        return response()->json($orders);
    }
    public function qrcodeReceive(Request $req)
    {
        $res = Order::qrcodeReceive($req);
        if ($res == 200) {
            return response()->json('ok');
        } else {
            return response()->json('fail');
        }
    }
    public function qrcodeSender(Request $req)
    {
        $order = Order::getOrderByCode($req->code);
        $res = Order::qrcodeSender($req);
        if ($res == 200) {
            //send notify to customer
            $fcm = Device::getToken($order->user_id);
            if ($fcm) {
                Device::sendMsgToDevice($fcm, 'Thông báo từ IHTGO', 'Đơn hàng ' . $order->code . ' đang được giao', []);
            }

            //send notify to web
            $webfcm = WebFCM::find($order->user_id);
            if ($webfcm) {
                Device::sendMsgToDevice($webfcm->fcm_web_token, 'Thông báo từ IHTGO', 'Đơn hàng ' . $order->code . ' đang được giao', []);
            }

            return response()->json('ok');
        } else if ($res == 404) {
            return response()->json('Vui lòng nhập ghi chú');
        } else if ($res == 201) {
            return response()->json('Có lỗi xảy ra vui lòng liên hệ admin');
        }
    }
}