<?php
namespace App\Http\Controllers;

use App\Models\Notify;
use App\Models\NotifyDetail;
use DB;
use Illuminate\Http\Request;
use Response;

class NotifyController extends Controller
{
    public function get()
    {
        return Notify::orderBy('id', 'desc')->get();
    }

    public function getDetail(Request $request)
    {
        $notify = Notify::find($request->id)->first();
        $detail = NotifyDetail::where('notify_id', $request->id)->orderBy('seq', 'asc')->get();
        return Response::json(['notify' => $notify, 'detail' => $detail], 200);
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