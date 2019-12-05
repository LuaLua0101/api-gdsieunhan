<?php
namespace App\Http\Controllers;

use App\Models\SkillGroup;
use App\Models\Student;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;

class SkillGroupController extends Controller
{
    public function get()
    {
        return SkillGroup::orderBy('id', 'desc')->get();
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

            $t = new SkillGroup;
            $t->name = $request->name;
            $t->group_type_id = $request->type;
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
            $t = SkillGroup::findOrFail($request->id);
            $t->delete();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }
}