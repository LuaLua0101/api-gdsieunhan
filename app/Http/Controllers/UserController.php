<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;

class UserController extends Controller
{
    public function get()
    {
        return User::where('type', 2)->where('active', null)->orderBy('id', 'desc')->get();
    }

    public function getDetail(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            return Response::json(['user' => $user, 'student' => Student::findOrFail($user->student_id)], 200);
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
            $t->email = $request->alias;
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
                $t->facebook = $request->facebook;
                $t->gender = $request->gender;
                $t->phone = $request->phone;
                $t->save();
            }

            DB::commit();
            return Response::json(['status' => 'ok'], 200);
        } catch (Throwable $e) {
            DB::rollback();
            return Response::json(['status' => 'fail'], 500);
        }
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