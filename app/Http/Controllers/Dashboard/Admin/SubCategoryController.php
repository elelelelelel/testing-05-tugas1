<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index($category_id)
    {
        $category = Category::findOrFail($category_id);
        return view('dashboard.admin.sub-category.index', compact('category'));
    }

    public function create($category_id)
    {
        $category = Category::findOrFail($category_id);
        return view('dashboard.admin.sub-category.create', compact('category'));
    }

    public function store($category_id, Request $request)
    {
        try {
            DB::beginTransaction();

            SubCategory::create([
                'category_id' => $category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]);

            DB::commit();

            return redirect()->route('dashboard.admin.sub-category.index', $category_id)->with('success', 'Sub Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
