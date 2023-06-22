<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.category.index');
    }

    public function create()
    {
        return view('dashboard.admin.category.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]);

            DB::commit();

            return redirect()->route('dashboard.admin.category.index')->with('success', 'Category berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
