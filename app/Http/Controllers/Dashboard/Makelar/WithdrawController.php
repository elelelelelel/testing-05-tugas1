<?php

namespace App\Http\Controllers\Dashboard\Makelar;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        return view('dashboard.makelar.withdraw.index');
    }

    public function confirm(Request $request)
    {
        $withdraw = Withdraw::findOrFail($request->withdraw_id);
        $withdraw->update([
            'confirmed_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Penarikan berhasil dikonfirmasi');
    }
}
