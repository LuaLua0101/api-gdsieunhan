<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Skill;
use App\Models\SkillGroup;
use App\Models\Survey;
use App\Models\SurveyDetail;
use App\Models\PlanDetail;
use Auth;
use DB;
use Illuminate\Http\Request;
use Response;

class PlanController extends Controller
{
    public function get(Request $request)
    {
        try {
            $p = Plan::firstOrCreate(['student_id' => $request->student_id]);
            $p->teacher_id = Auth::user()->id;
            $p->save();

            $skillGroups = SkillGroup::where('type', 1)->orderBy('id', 'desc')->get();

            foreach ($skillGroups as $group) {
                $data = DB::table('skills')
                    ->select('skills.id', 'content')
                    ->where('skills.group_id', $group->id)
                    ->get();
                if ($p) {
                    foreach ($data as $item) {
                        $survey = PlanDetail::where('plan_id', $p->id)->where('skill_id', $item->id)->first();
                        if ($survey) {
                            $item->rate = $survey->rate;
                            $item->note = $survey->note;
                        }
                    }
                }

                $group->skills = $data;
            }
            return Response::json(['data' => $skillGroups, 'plan_id' => $p->id], 200);
        } catch (\Exception $e) {
            return $e;
        }
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

    public function checkSurveyIsExist()
    {
        try {
            $t = Survey::firstOrCreate(['student_id' => Auth::user()->id]);
            return Response::json(['data' => $t], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getPlanSkillList(Request $request)
    {
        try {
            $t = Survey::firstOrCreate(['student_id' => $request->student_id]);
            $p = Plan::firstOrCreate(['student_id' => $request->student_id]);
            $p->teacher_id = Auth::user()->id;
            $p->save();

            $skillGroups = SkillGroup::orderBy('id', 'desc')->get();

            foreach ($skillGroups as $group) {
                $data = DB::table('skills')
                    ->select('skills.id', 'content')
                    ->where('skills.group_id', $group->id)
                    ->get();
                if ($t) {
                    foreach ($data as $item) {
                        $survey = SurveyDetail::where('survey_id', $t->id)->where('skill_id', $item->id)->first();
                        if ($survey) {
                            $item->rate = $survey->rate;
                            $item->note = $survey->note;
                        }
                    }
                }

                $group->skills = $data;
            }
            return Response::json(['data' => $skillGroups, 'survey_id' => $t->id, 'plan_id' => $p->id], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function updatePlan(Request $request)
    {
        try {
            $p = PlanDetail::firstOrCreate(
                ['plan_id' => $request->plan_id, 'skill_id' => $request->skill_id]
            );
            $p->rate = $request->rate;
            $p->note = $request->note;
            $p->save();

            return Response::json(['p' => $p], 200);
        } catch (\Exception $e) {
            return $e;
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
