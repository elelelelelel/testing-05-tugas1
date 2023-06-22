<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionDetail;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Auth;

class ReviewerController extends Controller
{
    public function getReviews()
    {
        $orders = Order::where('reviewer_id', Auth::user()->id)
            ->whereNotNull('paid_at')->orderByDesc('created_at');
        return DataTables::of($orders)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('editor', function ($q) {
                return $q->editor->name;
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
                return '<a href="' . route('dashboard.reviewer.review.show', $q->invoice) . '" class="btn btn-primary">Detail</a>';
            })
            ->rawColumns(['avatar', 'action', 'answer'])
            ->make(true);
    }

    public function getAuctions()
    {
        $reviewer_categories = Auth::user()->subCategories->pluck('id');
        $min_rate = Setting::where('slug', 'minimal-rating')->first()->value;
        $auction = Auction::with('order')->whereHas('order', function ($q) use ($reviewer_categories) {
            $q->whereIn('sub_category_id', $reviewer_categories);
        })->orderByDesc('created_at');
        if (Auth::user()->rate < $min_rate) {
            $auction = $auction->whereNull('created_at');
        }
        return DataTables::of($auction)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('category', function ($q) {
                return $q->order->subCategory->name;
            })
            ->addColumn('title', function ($q) {
                return $q->order->title;
            })
            ->addColumn('word_count', function ($q) {
                return number_format($q->order->total_words) . ' Kata';
            })
            ->addColumn('total_price', function ($q) {
                return 'Rp. ' . number_format($q->order->total_price);
            })
            ->addColumn('_auction_due_at', function ($q) {
                return $q->auction_due_at->format('d M Y H:i');
            })
            ->addColumn('action', function ($q) {
                $action = '<a href="' . route('dashboard.reviewer.auction.show', $q->id) . '" class="btn btn-primary">Detail</a>';
                return $action;
            })
            ->addColumn('request_bid', function ($q) {
                return $q->details->where('reviewer_id', Auth::user()->id)->count() > 0 ? 1 : 0;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getAuctionHistories()
    {
        $auction = AuctionDetail::where('reviewer_id', Auth::user()->id);
        return DataTables::of($auction)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('title', function ($q) {
                return $q->auction->order->title;
            })
            ->addColumn('bid', function ($q) {
                return 'Rp. ' . number_format($q->bid);
            })
            ->addColumn('price', function ($q) {
                return 'Rp. ' . number_format($q->auction->order->total_price);
            })
            ->addColumn('_deadline_at', function ($q) {
                return $q->deadline_at->format('d M Y');
            })
            ->addColumn('bid_status', function ($q) {
                return $q->bid_status;
            })
            ->make(true);
    }
}
