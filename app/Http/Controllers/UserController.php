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
            return Response::json(['user' => User::findOrFail($request->id)], 200);
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
                $t = Student::findOrFail($request->id);
                $t->name = $request->name;
                $t->alias = $request->alias;
                $t->fee = $request->fee;
                $t->note = $request->note;
                $t->gender = $request->gender;
                $t->dob = $request->dob;
                $t->sub_id = $request->sub_id;
                $t->address = $request->address;
                $t->save();

                $student_id = $t->id;

                //update parent users
                if ($request->mName) {
                    $m = User::where('student_id', $request->id)->where('gender', 0)->first();
                    if ($m === null) {
                        $m = new User;
                        $m->type = 2;
                        $m->gender = 0;
                        $m->password = Hash::make(123456);
                        $m->student_id = $request->id;
                    }
                    $m->name = $request->mName ? $request->mName : "";
                    $m->phone = $request->mPhone ? $request->mPhone : "";
                    $m->facebook = $request->mFB ? $request->mFB : "";
                    $m->save();
                }

                if ($request->fName) {
                    $f = User::where('student_id', $request->id)->where('gender', 1)->first();
                    if ($f === null) {
                        $f = new User;
                        $f->type = 2;
                        $f->gender = 1;
                        $f->password = Hash::make(123456);
                        $f->student_id = $request->id;
                    }
                    $f->name = $request->fName ? $request->fName : "";
                    $f->phone = $request->fPhone ? $request->fPhone : "";
                    $f->facebook = $request->fFB ? $request->fFB : "";
                    $f->save();
                }
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