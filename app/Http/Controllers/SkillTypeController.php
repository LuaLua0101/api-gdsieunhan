<?php
namespace App\Http\Controllers;

use App\Models\SkillType;
use DB;
use Illuminate\Http\Request;
use Response;

class SkillTypeController extends Controller
{
    public function get()
    {
        return SkillType::select('skill_types.id', 'skill_types.name','groups.name as gname', 'groups.type')
        ->leftjoin('groups', 'skill_types.group_type', '=', 'groups.id')->get();
    }

    public function listBy(Request $request)
    {
        return SkillType::where('group_type', $request->type)->get();
    }

    public function getDetail(Request $request)
    {
        try {
            $data = SkillType::findOrFail($request->id);
            return Response::json(['skill' => $data], 200);
        } catch (\Exception $e) {
            return 404;
        }
    }

    public function add(Request $request)
    {
        try {
            DB::beginTransaction();

            $t = new SkillType;
            $t->name = $request->name;
            $t->group_type = $request->type;
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
                $t = SkillType::findOrFail($request->id);
                $t->name = $request->name;
                $t->group_type = $request->type;
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
            $t = SkillType::findOrFail($request->id);
            $t->delete();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }
}
