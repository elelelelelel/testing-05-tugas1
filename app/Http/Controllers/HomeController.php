<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;

class HomeController extends Controller
{
    public function home() {
    $allproduk = Produk::all()
        ->where('isavail', '=', 1);

    $produkselling = DB::table('produks')
        ->leftJoin('detail_pesanans', 'detail_pesanans.produk_id', '=', 'produks.id_produk')
        ->select('produks.id_produk', DB::raw('SUM(jumlah) AS jmlsold'), 'produks.nama', 'produks.harga', 'produks.img_path', 'produks.isavail')
        ->groupBy('produks.id_produk')
        ->groupBy('detail_pesanans.produk_id')
        ->groupBy('produks.nama')
        ->groupBy('produks.img_path')
        ->groupBy('produks.harga')
        ->groupBy('produks.isavail')
        ->orderBy('jmlsold', 'DESC')
        ->where('produks.isavail', '=', 1)
        ->take(3)
        ->get();

    return view('homepage')
        ->with('allproduk', $allproduk)
        ->with('produkselling', $produkselling);
}
}
