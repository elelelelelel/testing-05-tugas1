<?php

namespace App\Http\Controllers\Dashboard\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class ReviewController extends Controller
{
    public function index()
    {
        return view('dashboard.reviewer.review.index');
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->first();
        return view('dashboard.reviewer.review.show', compact('order'));
    }

    public function uploadDoc(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('failed', 'Ada suatu kesalahan');
        }
        $punishment_precentage = 0;
        $punishment = 0;
        if ($order->deadline_at->isBefore(Carbon::now())) {
            $punishment_precentage = Setting::where('slug', 'punishment')->first()->value;
            $punishment = $order->reviewer_price * ($punishment_precentage / 100);
        }

        $balance = $order->reviewer_price - $punishment;

        try {
            DB::beginTransaction();

            $path = Storage::disk('s3')->put('doc/' . $order->editor->slug . '/' . $order->title . '/' . $request->file('doc')->getClientOriginalName(), $request->file('doc'));

            $order->update([
                'upload_review_at' => Carbon::now(),
                'punishment' => $punishment,
                'punishment_percentage' => $punishment_precentage
            ]);

            $order->reviews()->create([
                'attachment_path' => $path,
                'attachment_name' => $request->doc->getClientOriginalName(),
                'attachment_size' => bytesForHuman($request->doc->getSize())
            ]);

            $order->logs()->create([
                'log' => 'Reviewer Mengunggah Document'
            ]);

            $order->reviewer()->update([
                'balance' => $order->reviewer->balance += $balance
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Dokumen berhasil diunggah, mohon menunggu ulasan dari editor');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
