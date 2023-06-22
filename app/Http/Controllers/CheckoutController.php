<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

// use Illuminate\Support\Facades\Input;

class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }

    public function getcart(Request $request)
    {
        $this->validate($request, [
            'atas_nama' => 'required',
            // 'no_meja' => 'required',
            'total_harga' => 'required',
        ]);
        $cartdata = $_GET["halah"];
        $jml_org = $request->input('jml_org');
        if ($jml_org != null) {
            if ($jml_org == 2) {

                $mejanya = rand(21, 25);
            } elseif ($jml_org == 4) {

                $mejanya = rand(26, 30);
            } elseif ($jml_org == 6) {

                $mejanya = rand(31, 35);
            } elseif ($jml_org == 8) {

                $mejanya = rand(36, 40);
            } elseif ($jml_org == 10) {

                $mejanya = rand(41, 45);
            } else {

                return 'ewow';
            }
        } else {

            $mejanya = $request->input('no_meja');
        }

        $pesanan = new Pesanan;
        $pesanan->atas_nama = $request->input('atas_nama');
        $pesanan->no_meja = $mejanya;
        $pesanan->total_harga = $request->input('total_harga');
        $pesanan->isdone = 0;
        $pesanan->admin_id = 1;
        $pesanan->save();
        $idpesanan = $pesanan->id_nota;

        for ($i = 0; $i < count($cartdata); $i++) {
            $detailPesanan = new DetailPesanan;
            $detailPesanan->jumlah = $cartdata[$i]['count'];
            if (isset($cartdata[$i]['name'])) {

                $namanya[$i] = $cartdata[$i]['name'];
            }
            $produknya[$i] = DB::table('produks')
                ->where('nama', '=', $namanya[$i])
                ->first();
            $detailPesanan->nota_id = $idpesanan;
            $detailPesanan->produk_id = $produknya[$i]->id_produk;
            $detailPesanan->save();
        }

        return redirect('/checkout/success')
            ->with('success', 'Berhasil melakukan pemesanan!');
    }

    public function success()
    {
        return view('success');
    }
}
