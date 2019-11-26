<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;

class StudentController extends Controller
{
    public function get()
    {
        return Student::where('active', null)->orderBy('id', 'desc')->get();
    }

    public function getDetail(Request $request)
    {
        // $student = Student::where('id', $request->id)->where('active', null)->first();
        // $m = User::find('student_id', $request->id)->first();
        // $f = User::find('student_id', $request->id)->first();
        try {
            return Response::json(['student' => Student::findOrFail($request->id),
                'mom' => User::where('student_id', $request->id)->where('gender', 0)->first(),
                'dad' => User::where('student_id', $request->id)->where('gender', 1)->first()], 200);
        } catch (\Exception $e) {
            return 404;
        }
    }

    public function add(Request $request)
    {
        try {
            DB::beginTransaction();

            $t = new Student;
            $t->name = $request->name;
            $t->alias = $request->alias;
            $t->fee = $request->fee;
            $t->note = $request->note;
            $t->gender = $request->gender;
            $t->dob = $request->dob;
            $t->sub_id = $request->sub_id;
            $t->created_at = time();
            $t->save();

            $student_id = $t->id;

            //add parent users
            if ($request->mName) {
                $m = new User;
                $m->name = $request->mName ? $request->mName : "";
                $m->phone = $request->mPhone ? $request->mPhone : "";
                $m->facebook = $request->mFB ? $request->mFB : "";
                $m->type = 2;
                $m->password = Hash::make(123456);
                $m->gender = 0;
                $m->student_id = $student_id;
                $m->save();
            }

            if ($request->fName) {
                $f = new User;
                $f->name = $request->fName ? $request->fName : "";
                $f->phone = $request->fPhone ? $request->fPhone : "";
                $f->facebook = $request->fFB ? $request->fFB : "";
                $f->type = 2;
                $f->gender = 1;
                $m->password = Hash::make(123456);
                $f->student_id = $student_id;
                $f->save();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
        }
        return Response::json(['id' => $t->id, 'created_at' => date("Y-m-d H:i:s")], 200);
    }

    public function del(Request $request)
    {
        try {
            DB::beginTransaction();
            $t = Student::findOrFail($request->id);
            $t->active = 0;
            $t->save();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }
}
