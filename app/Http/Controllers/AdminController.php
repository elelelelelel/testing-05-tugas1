<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProdukController;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

class AdminController extends Controller
{
    public function loginpage()
    {
        return view('admin/login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // return Auth::user();
            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function home()
    {
        $allproduk = Produk::all();
        $nproduk = $allproduk->count();

        $allselling = Pesanan::all();
        $nselling = $allselling
            ->where('isdone', '=', 1)
            ->count();

        $totalSelling = $allselling
            ->where('isdone', '=', 1)
            ->sum('total_harga');

        $totalSellingEachMonth = DB::table('pesanans')
            ->selectRaw("sum(total_harga) as total, DATE_FORMAT(created_at, '%Y') AS year, DATE_FORMAT(created_at, '%m') AS month, DATE_FORMAT(created_at, '%M-%Y') AS period")
            ->where('isdone', '=', 1)
            ->groupBy(['year', 'month', 'period'])
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // $nprodsell = 0;
        // for ($i=0; $i < $nselling; $i++) {
        //     # code...
        //     $produkselling[$i] = DB::table('detail_pesanans')
        //         ->join('produks', 'detail_pesanans.produk_id', '=', 'produks.id_produk')
        //         ->select('detail_pesanans.jumlah', 'produks.nama')
        //         ->where('produk_id','=', $allproduk[$i]->id_produk)
        //         ->get();

        // $nprodsell;
        // for ($j=0; $j < count($produkselling); $j++) {
        //     # code...
        //     $nprodsell += $produkselling[$i][$j]->jumlah;
        // }
        // }

        $produkselling = DB::table('produks')
            ->leftJoin('detail_pesanans', 'detail_pesanans.produk_id', '=', 'produks.id_produk')
            ->select('produks.id_produk', DB::raw('SUM(jumlah) AS jmlsold'), 'produks.nama', 'produks.isavail')
            ->groupBy('produks.id_produk')
            ->groupBy('detail_pesanans.produk_id')
            ->groupBy('produks.nama')
            ->groupBy('produks.isavail')
            ->orderBy('jmlsold', 'DESC')
            ->where('produks.isavail', '!=', 2)
            ->get();

        return view('admin/adminhome')
            ->with('allproduk', $allproduk)
            ->with('nproduk', $nproduk)
            ->with('produkselling', $produkselling)
            ->with('nselling', $nselling)
            ->with('totalSelling', $totalSelling)
            ->with('totalSellingEachMonth', $totalSellingEachMonth);
        // ->with('nprodsell', $nprodsell)
        // return $produkselling;
    }

    public function manage()
    {
        $allproduk = Produk::all();
        return view('admin/manage')
            ->with('allproduk', $allproduk);
    }

    public function selling()
    {
        $allselling = Pesanan::all();
        $nselling = $allselling->count();

        $nsucselling = DB::table('pesanans')
            ->where('isdone', '=', 1)
            ->get();

        $sumselling = 0;
        for ($c = 0; $c < $nsucselling->count(); $c++) {
            $sumselling += $nsucselling[$c]->total_harga;
        }

        $produkbought = [];
        for ($i = 0; $i < $nselling; $i++) {
            $produkbought[$i] = DB::table('detail_pesanans')
                ->join('produks', 'detail_pesanans.produk_id', '=', 'produks.id_produk')
                ->select('detail_pesanans.*', 'produks.*')
                ->where('nota_id', '=', $allselling[$i]->id_nota)
                ->get();
        }

        $sellingnow = $allselling
            ->where('isdone', '=', 0);

        $sellinghis = $allselling
            ->where('isdone', '!=', 0);

        return view('admin/selling')
            ->with('allselling', $allselling)
            ->with('produkbought', $produkbought)
            ->with('sellingnow', $sellingnow)
            ->with('sellinghis', $sellinghis)
            ->with('nselling', $nselling)
            ->with('sumselling', $sumselling);
    }

    public function accSelling(Pesanan $accselling)
    {
        $donenow = $accselling->isdone;
        if ($donenow == 0) {
            $accselling->isdone = 1;
            $accselling->save();
        }

        return redirect('/admin/selling')
            ->with('success', 'Pesanan berhasil di-update');
    }

    public function decSelling(Pesanan $decselling)
    {
        $donenow = $decselling->isdone;
        if ($donenow == 0) {
            $decselling->isdone = 2;
            $decselling->save();
        }

        return redirect('/admin/selling')
            ->with('success', 'Pesanan berhasil di-batalkan');
    }
}
