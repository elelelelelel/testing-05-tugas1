<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.price-list.index');
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'package' => 'required',
            'price' => 'required|integer',
            'description' => 'required',
        ]);

        $price = PriceList::findOrFail($id);

        $price->update([
            'price' => $request->price,
            'package' => $request->package,
            'tooltip' => $request->description,
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Data berhasil dirubah');
    }
}
