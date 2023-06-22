<?php

namespace App\Http\Controllers\Dashboard\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class AuctionController extends Controller
{
    public function index()
    {
        return view('dashboard.reviewer.auction.index');
    }

    public function show($id)
    {
        $auction = Auction::findOrFail($id);
        return view('dashboard.reviewer.auction.show', compact('auction'));
    }

    public function store(Request $request)
    {
        $auction = Auction::findOrFail($request->auction_id);
        try {
            DB::beginTransaction();

            $deadline = Carbon::create($request->deadline);
            $auction->details()->create([
                'reviewer_id' => Auth::user()->id,
                'bid' => $request->bid,
                'deadline_at' => $deadline
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Anda berhasil menawar pesanan ini. Silahkan tunggu');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan');
        }
    }

    public function history()
    {
        return view('dashboard.reviewer.auction.history.index');
    }
}
