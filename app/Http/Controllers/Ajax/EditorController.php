<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Auth;

class EditorController extends Controller
{
    public function getReviewers()
    {
        $user = User::where('id', '<>', Auth::user()->id)->where('status', 1)->whereHas('roles', function ($q) {
            $q->where('name', 'reviewer');
        });
        return DataTables::of($user)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('name', function ($q) {
                return '<a href="' . route('dashboard.editor.reviewer.show', ['slug' => $q->slug]) . '">' . $q->name . '</a>';
            })
            ->addColumn('gender', function ($q) {
                return $q->gender;
            })
            ->addColumn('university', function ($q) {
                return $q->university;
            })
            ->addColumn('category', function ($q) {
                return implode(', ', $q->subCategories->pluck('name')->toArray());
            })
            ->rawColumns(['avatar', 'action', 'answer','name'])
            ->make(true);
    }

    public function getOrders()
    {
        $orders = Order::where('editor_id', Auth::user()->id)->orderByDesc('created_at');
        return DataTables::of($orders)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('reviewer', function ($q) {
                return !is_null($q->reviewer_id) ? '<a href="' . route('dashboard.editor.reviewer.show', ['slug' => $q->reviewer->slug]) . '">' . $q->reviewer->name . '</a>' : '-';
            })
            ->addColumn('total', function ($q) {
                return 'Rp. ' . number_format($q->total_price);
            })
            ->addColumn('status', function ($q) {
                return $q->status;
            })
            ->addColumn('_created_at', function ($q) {
                return $q->created_at->format('d M Y');
            })
            ->addColumn('action', function ($q) {
                return '<a href="' . route('dashboard.editor.order.show', $q->invoice) . '" class="btn btn-primary">Detail</a>';
            })
            ->rawColumns(['avatar', 'action', 'answer','reviewer'])
            ->make(true);
    }
}
