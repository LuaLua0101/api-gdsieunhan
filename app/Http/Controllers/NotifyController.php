<?php
namespace App\Http\Controllers;

use App\Models\Notify;
use App\Models\NotifyDetail;
use App\Models\NotifyPinned;
use DB;
use Illuminate\Http\Request;
use Response;

class NotifyController extends Controller
{
    public function get()
    {
        return Notify::orderBy('id', 'desc')->get();
    }

    public function getTeacherNotifies()
    {
        $data = DB::table('notifies')
            ->join('notify_pinned', 'notifies.id', '=',
                DB::raw('notify_pinned.notify_id AND notifies.type = 0'))
            ->get();
        return Response::json(['data' => $data], 200);
    }

    public function getParentNotifies()
    {
        $data = DB::table('notifies')
            ->join('notify_pinned', 'notifies.id', '=',
                DB::raw('notify_pinned.notify_id AND notifies.type = 1'))
            ->get();
        return Response::json(['data' => $data], 200);
    }

    public function getPinnedList()
    {
        return NotifyPinned::get();
    }

    public function pinNotify(Request $request)
    {
        $d = new NotifyPinned;
        $d->notify_id = $request->id;
        $d->created_at = time();
        $d->save();
        return Response::json(['notify' => $d], 200);
    }

    public function unpinNotify(Request $request)
    {
        try {
            DB::beginTransaction();
            $t = NotifyPinned::findOrFail($request->id);
            $t->delete();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }

    public function getDetail(Request $request)
    {
        $detail = NotifyDetail::where('notify_id', $request->id)->orderBy('seq', 'asc')->get();
        return Response::json(['detail' => $detail], 200);
    }

    public function add(Request $request)
    {
        try {
            DB::beginTransaction();

            $t = new Notify;
            $t->title = $request->title;
            $t->type = $request->type;
            $t->pin = 0;
            $t->active_date = $request->date;
            $t->created_at = time();
            $t->save();

            $seq = 1;
            foreach ($request->details as $i) {
                $d = new NotifyDetail;
                $d->notify_id = $t->id;
                $d->content = $i;
                $d->seq = $seq;
                $d->created_at = time();
                $d->save();
                $seq++;
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
            $t = Notify::findOrFail($request->id);
            $t->delete();
            //clear all notify detail
            $deletedRows = NotifyDetail::where('notify_id', $request->id)->delete();
            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;}
    }

}
