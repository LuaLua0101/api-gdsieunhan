<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use DB;
use Illuminate\Http\Request;
use Response;

class FinanceController extends Controller
{
    public function get()
    {
        return Transaction::whereDate('created_at', DB::raw('CURDATE()'))->orderBy('id', 'desc')->get();
    }

    public function add(Request $request)
    {
        $t = new Transaction;
        $t->fee = $request->fee;
        $t->note = $request->note;
        $t->type = $request->type;
        $t->created_at = time();
        $t->save();

        return Response::json(['id' => $t->id, 'created_at' => date("Y-m-d H:i:s")], 200);
    }

    public function del(Request $request)
    {
        try {
            $t = Transaction::findOrFail($request->id);
            $t->delete();
            return 200;
        } catch (\Exception $e) {return 500;}
    }
}