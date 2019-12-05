<?php
namespace App\Http\Controllers;

use App\Models\Skill;
use DB;
use Illuminate\Http\Request;
use Response;

class SkillController extends Controller
{
    public function get()
    {
        return DB::table('skills')
            ->select('skills.id', 'content', 'group_id', 'groups.name')
            ->leftjoin('groups', 'skills.group_id', '=', 'groups.id')
            ->get();
    }

    public function getDetail(Request $request)
    {
        try {
            $data = Skill::findOrFail($request->id);
            return Response::json(['skill' => $data], 200);
        } catch (\Exception $e) {
            return 404;
        }
    }

    public function add(Request $request)
    {
        try {
            DB::beginTransaction();

            $t = new Skill;
            $t->content = $request->content;
            $t->group_id = $request->group;
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
                $t = Skill::findOrFail($request->id);
                $t->content = $request->content;
                $t->group_id = $request->group;
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
            $t = Skill::findOrFail($request->id);
            $t->delete();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }
}
