<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class WithdrawController extends Controller
{
    public function index()
    {
        return view('dashboard.withdraw.index');
    }

    public function getWithdraw()
    {
        $withdraw = Withdraw::where('user_id', Auth::user()->id);
        return DataTables::of($withdraw)
            ->addColumn('behalf', function ($q) {
                return $q->behalf;
            })
            ->addColumn('amount', function ($q) {
                return 'Rp. ' . number_format($q->amount);
            })
            ->addColumn('behalf', function ($q) {
                return $q->behalf;
            })
            ->addColumn('behalf', function ($q) {
                return $q->behalf;
            })
            ->addColumn('status', function ($q) {
                return !is_null($q->confirmed_at) ? 'Sudah dikonfirmasi' : "Belum dikonfirmasi";
            })
            ->rawColumns(['avatar', 'action', 'answer'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|integer|min:1|max:' . Auth::user()->balance,
            'bank_name' => 'required',
            'behalf' => 'required',
            'bank_number'
        ]);

        try {
            DB::beginTransaction();

            Withdraw::create([
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'behalf' => $request->behalf,
                'bank_name' => $request->bank_name,
                'bank_number' => $request->bank_number,
            ]);

            $user = User::find(Auth::user()->id);
            $balance = $user->balance - $request->amount;

            $user->update([
                'balance' => $balance
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Penarikan berhasil, Tunggu konfirmasi dari admin');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan');
        }
    }
}
