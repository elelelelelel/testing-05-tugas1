<?php

namespace App\Http\Controllers\Dashboard\Editor;

use App\Http\Controllers\Controller;
use App\Models\AdminBank;
use App\Models\Category;
use App\Models\PriceList;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Exception;

class OrderController extends Controller
{
    public function index()
    {
        return view('dashboard.editor.order.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'total_words' => 'required',
            'title' => 'required',
            'keyword' => 'required',
            'abstract' => 'required',
            'doc' => 'required',
            'price' => 'required',
            'bank' => 'required',
            'sub_category' => 'required'
        ]);

        $price = PriceList::find($request->price);
        $bank = AdminBank::find($request->bank);
        if (!$price || !$bank) {
            return redirect()->back()->with('failed', 'Reload halaman anda');
        }

        $total_price = $price->price * ceil($request->total_words / 1000);
        try {
            DB::beginTransaction();

            $invoice = $this->generateInvoiceId();
            $path = Storage::disk('s3')->put('doc/' . Auth::user()->slug . '/' . $request->title . '/' . $request->file('doc')->getClientOriginalName(), $request->file('doc'));

            $order = Order::create([
                'editor_id' => Auth::user()->id,
                'price_id' => $request->price,
                'sub_category_id' => $request->sub_category,
                'invoice' => $invoice,
                'title' => $request->title,
                'abstract' => $request->abstract,
                'keyword' => $request->keyword,
                'file_path' => $path,
                'file_name' => $request->doc->getClientOriginalName(),
                'file_size' => bytesForHuman($request->doc->getSize()),
                'account_name' => $bank->bank_name,
                'account_number' => $bank->bank_number,
                'account_holder' => $bank->bank_holder,
                'price' => $price->price,
                'tax_price' => 0,
                'total_price' => $total_price,
                'payment_due' => Carbon::now()->addDays(1),
                'total_words' => $request->total_words
            ]);

            if ($request->has('form_review')){
                $review_path = Storage::disk('s3')->put('form-review/' . Auth::user()->slug . '/' . $request->title . '/' . $request->file('form_review')->getClientOriginalName(), $request->file('form_review'));
                $order->update([
                    'form_review_path' => $review_path,
                    'form_review_name' => $request->form_review->getClientOriginalName(),
                    'form_review_size' => bytesForHuman($request->form_review->getSize()),
                ]);
            }

            $order->logs()->create([
                'log' => 'Editor Membuat Pesanan'
            ]);

            DB::commit();

            return redirect()->route('dashboard.editor.order.checkout', $invoice);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.editor.order.create', compact('categories'));
    }

    public function show($invoice)
    {
        $order = Order::where('invoice', $invoice)->where('editor_id', Auth::user()->id)->firstOrFail();
        return view('dashboard.editor.order.show', compact('order'));
    }

    public function checkout($invoice)
    {
        $order = Order::where('invoice', $invoice)->first();
        return view('dashboard.editor.order.checkout', compact('order'));
    }

    public function confirm(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('failed', 'Ada suatu kesalahan');
        }

        try {
            DB::beginTransaction();

            $path = Storage::disk('s3')->put('doc/' . Auth::user()->slug . '/' . $order->title . '/' . $request->file('doc')->getClientOriginalName(), $request->file('doc'));

            $order->update([
                'paid_at' => Carbon::now(),
                'payment_proof' => $path
            ]);

            $order->logs()->create([
                'log' => 'Editor Mengunggah Bukti Pembayaran'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Bukti pembayaran anda telah diupload, mohon tunggu konfirmasi dari Makelar');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function finish(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('failed', 'Ada suatu kesalahan');
        }

        try {
            DB::beginTransaction();

            $order->update([
                'done_at' => Carbon::now(),
                'rate' => $request->rate,
                'testimonial' => $request->testimonial
            ]);

            $order->logs()->create([
                'log' => 'Pesanan Selesai'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan Selesai. Terima Kasih');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    private function generateInvoiceId()
    {
        do {
            $invoice = 'INV' . strtoupper(Str::random(8));
        } while (Order::where('invoice', $invoice)->count() > 0);
        return $invoice;
    }
}
