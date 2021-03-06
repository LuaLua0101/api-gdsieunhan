<?php
namespace App\Http\Controllers;

use App\Models\Timekeeping;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;

class TeacherController extends Controller
{
    public function get()
    {
        return User::where('type', '!=', 2)->where('active', null)->orderBy('id', 'desc')->get();
    }

    public function getTimeKeepingAll(Request $request)
    {
        $list = User::where('type', '!=', 2)->where('active', null)->orderBy('id', 'desc')->get();
        foreach ($list as $i) {
            $i['checkin'] = Timekeeping::select('id as tid', 'date', 'checkin', 'checkout')->where('user_id', $i->id)->whereDate('date', DB::raw('CURDATE()'))->first();
        }

        return Response::json(['list' => $list], 200);
    }

    public function getTimeKeepingDetail(Request $request)
    {
        $month = date('m');
        $year = date('Y');
        $maxDays = date('t');
        $data = [];
        for ($i = 1; $i <= $maxDays; $i++) {
            $date = $year . '-' . $month . '-' . $i;
            $item = Timekeeping::select('id', 'checkin', 'checkout', 'date')->where('user_id', $request->id)->whereDate('date', '=', $date)->first();
            if ($item) {
                $data[] = $item;
            } else {
                $data[] = ['date' => $date];
            }
        }
        // $data = Timekeeping::select('id', 'checkin', 'checkout', 'date')->where('user_id', $request->id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('id', 'desc')->get()->groupBy('date');
        return Response::json(['list' => array_reverse($data), 'max_day' => $maxDays, 'month' => $month, 'year' => $year], 200);
    }

    public function getDetail(Request $request)
    {
        try {
            return Response::json(['teacher' => User::findOrFail($request->id)], 200);
        } catch (\Exception $e) {
            return 404;
        }
    }

    public function add(Request $request)
    {
        try {
            DB::beginTransaction();

            $t = new User;
            $t->name = $request->name;
            $t->email = $request->email;
            $t->salary = $request->salary;
            $t->facebook = $request->facebook;
            $t->gender = $request->gender;
            $t->dob = $request->dob;
            $t->type = 1;
            $t->phone = $request->phone;
            $t->start_date = $request->start_date;
            $t->address = $request->address;
            $t->password = Hash::make(123456);
            $t->created_at = time();
            $t->save();

            DB::commit();
            return Response::json(['id' => $t->id, 'created_at' => date("Y-m-d H:i:s")], 200);
        } catch (Throwable $e) {
            DB::rollback();
            return Response::json([], 500);
        }

    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->id) {
                $t = User::findOrFail($request->id);
                $t->name = $request->name;
                $t->email = $request->email;
                $t->salary = $request->salary;
                $t->facebook = $request->facebook;
                $t->gender = $request->gender;
                $t->dob = $request->dob;
                $t->phone = $request->phone;
                $t->start_date = $request->start_date;
                $t->address = $request->address;
                $t->save();
            }

            DB::commit();
            return 200;
        } catch (Throwable $e) {
            DB::rollback();
            return Response::json(['status' => 'fail'], 500);
        }
    }

    public function updateTimekeeping(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->id) {
                $t = Timekeeping::findOrFail($request->id);
                $t->checkin = $request->checkin;
                $t->checkout = $request->checkout;
                $t->save();
            }

            DB::commit();
            return 200;
        } catch (Throwable $e) {
            DB::rollback();
            return Response::json(['status' => 'fail'], 500);
        }
    }

    public function addCheckin(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->id) {
                $t = new Timekeeping;
                $t->user_id = $request->id;
                $t->date = $request->date ? $request->date : date("Y-m-d");
                $t->checkin = "8:00";
                $t->checkout = "17:00";
                $t->save();
                DB::commit();
                return Response::json(['checkin' => $t], 200);
            }

            DB::rollback();
            return Response::json(404);
        } catch (Throwable $e) {
            DB::rollback();
            return Response::json(['status' => 'fail'], 500);
        }
    }

    public function removeCheckin(Request $request)
    {
        try {
            DB::beginTransaction();
            $t = Timekeeping::findOrFail($request->id);
            $t->delete();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }

    public function del(Request $request)
    {
        try {
            DB::beginTransaction();
            $t = User::findOrFail($request->id);
            $t->active = 0;
            $t->save();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }
}