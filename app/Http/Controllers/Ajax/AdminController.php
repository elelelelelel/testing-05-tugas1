<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PriceList;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function getUsers()
    {
        $user = User::where('status', 1)->whereHas('roles', function ($q) {
            $q->where('name', '<>', 'admin');
        });
        return DataTables::of($user)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('name', function ($q) {
                return $q->name;
            })
            ->addColumn('email', function ($q) {
                return $q->email;
            })
            ->addColumn('phone', function ($q) {
                return $q->phone;
            })
            ->addColumn('role', function ($q) {
                return str_replace(array("[", '"', "]"), "", $q->roles->pluck('title'));
            })
            ->addColumn('gender', function ($q) {
                return $q->gender;
            })
            ->addColumn('university', function ($q) {
                return $q->university;
            })
//            ->rawColumns(['avatar', 'action', 'answer'])
            ->make(true);
    }

    public function getCategories()
    {
        $categories = Category::whereNotNull('id');
        return DataTables::of($categories)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('name', function ($q) {
                return $q->name;
            })
            ->addColumn('action', function ($q) {
                return '<a href="' . route('dashboard.admin.sub-category.index', $q->id) . '" class="btn btn-primary">Detail</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getPriceList()
    {
        $prices = PriceList::whereNotNull('id');
        return DataTables::of($prices)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('price', function ($q) {
                return 'Rp. ' . number_format($q->price);
            })
            ->addColumn('description', function ($q) {
                return $q->description;
            })
            ->addColumn('package', function ($q) {
                return $q->package;
            })
            ->addColumn('action', function ($q) {
                return '<button data-id="' . $q->id . '" class="btn btn-primary">Edit</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getSubCategories($category_id)
    {
        $subs = SubCategory::where('category_id', $category_id);
        return DataTables::of($subs)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('name', function ($q) {
                return $q->name;
            })
            ->addColumn('action', function ($q) {
                return '<a href="#" class="btn btn-primary">Edit</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getModalPriceList($id)
    {
        $price = PriceList::find($id);
        return View::make('dashboard.admin.partials.modal-price-list-edit', compact('price'));
    }

    public function getSettings()
    {
        $setting = Setting::whereNotNull('id');
        return DataTables::of($setting)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('name', function ($q) {
                return $q->name;
            })
            ->addColumn('action', function ($q) {
                return '<a href="' . route('dashboard.admin.setting.edit', $q->slug) . '" class="btn btn-primary">Edit</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
