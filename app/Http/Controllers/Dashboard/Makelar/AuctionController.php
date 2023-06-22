<?php

namespace App\Http\Controllers\Dashboard\Makelar;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    public function index()
    {
        return view('dashboard.makelar.auction.index');
    }

    public function show($id)
    {
        $auction = Auction::findOrFail($id);
        return view('dashboard.makelar.auction.show', compact('auction'));
    }

    public function store($id)
    {
        $detail = AuctionDetail::findOrFail($id);
        $auction = Auction::whereHas('details', function ($q) use ($id) {
            $q->where('id', $id);
        })->first();
        try {
            DB::beginTransaction();

            foreach ($auction->details as $item) {
                $item->update([
                    'status' => 2
                ]);
            }

            $detail->update([
                'status' => 1
            ]);


            $auction->order->update([
                'reviewer_price' => $detail->bid,
                'deadline_at' => $detail->deadline_at,
                'start_at' => Carbon::now(),
                'reviewer_id' => $detail->reviewer_id
            ]);

            $auction->order->logs()->create([
                'log' => 'Reviewer Telah Dipilih'
            ]);

            $auction->order->logs()->create([
                'log' => 'Pekerjaan Dimulai'
            ]);

            $auction->update([
                'status' => 1
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan');
        }
    }
}
