<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.setting.index');
    }

    public function edit($slug)
    {
        $setting = Setting::whereSlug($slug)->firstOrFail();
        return view('dashboard.admin.setting.edit', compact('setting'));
    }

    public function update($slug, Request $request)
    {
        $setting = Setting::whereSlug($slug)->firstOrFail();
        try {
            DB::beginTransaction();

            $setting->update([
                'value' => $request->value
            ]);

            DB::commit();
            return redirect()->route('dashboard.admin.setting.index')->with('success', 'Data berhasil dirubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Terjadi kesalahan');
        }

    }
}
