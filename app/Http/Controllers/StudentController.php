<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TimekeepingStudent;
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

    public function getBirthday()
    {
        return Student::where('active', null)->whereMonth('dob', date('m'))->orderBy('id', 'desc')->get();
    }

    public function getDetail(Request $request)
    {
        try {
            return Response::json(['student' => Student::findOrFail($request->id),
                'mom' => User::where('student_id', $request->id)->where('type', 2)->where('gender', 0)->first(),
                'dad' => User::where('student_id', $request->id)->where('type', 2)->where('gender', 1)->first(),
                'tutor' => User::where('student_id', $request->id)->where('type', 3)->first()], 200);
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
            $t->address = $request->address;
            $t->allergic = $request->allergic;
            $t->hobby = $request->hobby;
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
                $f->password = Hash::make(123456);
                $f->student_id = $student_id;
                $f->save();
            }

            if ($request->tName) {
                $t = new User;
                $t->name = $request->tName ? $request->tName : "";
                $t->phone = $request->tPhone ? $request->tPhone : "";
                $t->type = 3;
                $t->password = Hash::make(123456);
                $t->student_id = $student_id;
                $t->save();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
        }
        return Response::json(['id' => $t->id, 'created_at' => date("Y-m-d H:i:s")], 200);
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
                $t->allergic = $request->allergic;
                $t->hobby = $request->hobby;
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

                if ($request->tName) {
                    $t = User::where('student_id', $request->id)->where('type', 3)->first();
                    if ($t === null) {
                        $t = new User;
                        $t->type = 3;
                        $t->student_id = $request->id;
                    }
                    $t->name = $request->tName ? $request->tName : "";
                    $t->phone = $request->tPhone ? $request->tPhone : "";
                    $t->save();
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
            $t = Student::findOrFail($request->id);
            $t->active = 0;
            $t->save();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }

    public function getTimekeepingAll(Request $request)
    {
        $list = Student::where('active', null)->orderBy('id', 'desc')->get();
        foreach ($list as $i) {
            $i['checkin'] = TimekeepingStudent::select('id as tid', 'date', 'checkin', 'checkout')->where('student_id', $i->id)->whereDate('date', DB::raw('CURDATE()'))->first();
        }
        return Response::json(['list' => $list], 200);
    }

    public function getTimekeepingDetail(Request $request)
    {
        $month = date('m');
        $year = date('Y');
        $maxDays = date('t');
        $data = [];
        for ($i = 1; $i <= $maxDays; $i++) {
            $date = $year . '-' . $month . '-' . $i;
            $item = TimekeepingStudent::select('id', 'checkin', 'checkout', 'date')->where('student_id', $request->id)->whereDate('date', '=', $date)->first();
            if ($item) {
                $data[] = $item;
            } else {
                $data[] = ['date' => $date];
            }
        }
        // $data = TimekeepingStudent::select('id', 'checkin', 'checkout', 'date')->where('user_id', $request->id)->whereDate('date', '>=', $from)->whereDate('date', '<=', $to)->orderBy('id', 'desc')->get()->groupBy('date');
        return Response::json(['list' => array_reverse($data), 'max_day' => $maxDays, 'month' => $month, 'year' => $year], 200);
    }

    public function updateTimekeeping(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->id) {
                $t = TimekeepingStudent::findOrFail($request->id);
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
                $t = new TimekeepingStudent;
                $t->student_id = $request->id;
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
            $t = TimekeepingStudent::findOrFail($request->id);
            $t->delete();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }
}
