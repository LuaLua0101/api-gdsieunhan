<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function getTransactions()
    {
        return Transaction::first();
    }

    public function addTransaction(Request $request)
    {
        $t = new Transaction;
        $t->fee = $request->fee;
        $t->note = $request->note;
        $t->type = $request->type;
        $t->save();

        return 'OK';
    }

    public function removeTransaction()
    {
        return Transaction::first();
    }
}