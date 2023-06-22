<?php

namespace App\Http\Controllers\Dashboard\Makelar;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class OrderController extends Controller
{
    public function index()
    {
        return view('dashboard.makelar.order.index');
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->first();
        return view('dashboard.makelar.order.show', compact('order'));
    }

    public function confirm(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('failed', 'Ada suatu kesalahan');
        }

        try {
            DB::beginTransaction();

            $order->update([
                'confirmed_at' => Carbon::now()
            ]);

            $order->logs()->create([
                'log' => 'Makelar Mengkonfirmasi Pesanan'
            ]);

            $order->auctions()->create([
                'auction_due_at' => Carbon::now()->addDays(1)
            ]);

            $order->logs()->create([
                'log' => 'Makelar Membuat Lelang'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan Berhasil Dikonfirmasi');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function decline(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('failed', 'Ada suatu kesalahan');
        }

        try {
            DB::beginTransaction();

            $order->update([
                'declined_at' => Carbon::now(),
                'cancellation_reason' => 'Pesanan ditolak'
            ]);

            $order->logs()->create([
                'log' => 'Makelar Menolak Pesanan'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan Berhasil Ditolak');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function refund(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('failed', 'Ada suatu kesalahan');
        }
        try {
            DB::beginTransaction();

            foreach ($order->auctions as $auction) {
                $auction->update([
                    'status' => 1
                ]);
            }

            $order->editor()->update([
                'balance' => $order->editor->balance += $order->total_price
            ]);


            $order->update([
                'declined_at' => Carbon::now(),
                'cancellation_reason' => 'Pesanan dikembalikan'
            ]);

            $order->logs()->create([
                'log' => 'Makelar Melakukan Refund'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan Berhasil Ditolak');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
