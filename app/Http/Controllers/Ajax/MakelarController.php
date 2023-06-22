<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionDetail;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MakelarController extends Controller
{
    public function getOrders()
    {
        $orders = Order::orderByDesc('created_at');
        return DataTables::of($orders)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('reviewer', function ($q) {
                return !is_null($q->reviewer_id) ? $q->reviewer->name : '-';
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
                return '<a href="' . route('dashboard.makelar.order.show', $q->invoice) . '" class="btn btn-primary">Detail</a>';
            })
            ->rawColumns(['avatar', 'action', 'answer'])
            ->make(true);
    }

    public function getAuctions()
    {
        $auction = Auction::orderByDesc('created_at');
        return DataTables::of($auction)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('status', function ($q) {
                return $q->status == 0 ? 'Buka' : 'Tutup';
            })
            ->addColumn('bid_count', function ($q) {
                return $q->details->count();
            })
            ->addColumn('invoice', function ($q) {
                return '<a href="' . route('dashboard.makelar.order.show', $q->order->invoice) . '">' . $q->order->invoice . '</a>';
            })
            ->addColumn('action', function ($q) {
                $action = '<a href="' . route('dashboard.makelar.auction.show', $q->id) . '" class="btn btn-primary">Detail</a>';
                if ($q->status == 0) {
                    $action .= ' <a href="#" class="btn btn-danger">Tutup Lelang</a>';
                }
                return $action;
            })
            ->rawColumns(['invoice', 'action'])
            ->make(true);
    }

    public function getAuctionDetails($id)
    {
        $auction = AuctionDetail::where('auction_id', $id);
        return DataTables::of($auction)
            ->addColumn('id', function ($q) {
                return $q->id;
            })
            ->addColumn('editor', function ($q) {
                return $q->reviewer->name;
            })
            ->addColumn('bid', function ($q) {
                return 'Rp. ' . number_format($q->bid);
            })
            ->addColumn('_deadline_at', function ($q) {
                return $q->deadline_at->format('d M Y');
            })
            ->addColumn('action', function ($q) {
                return '<button class="btn btn-primary" data-id="' . $q->id . '">Terima</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getWithdraw()
    {
        $withdraw = Withdraw::whereNotNull('id');
        return DataTables::of($withdraw)
            ->addColumn('user', function ($q) {
                return $q->user->name;
            })
            ->addColumn('behalf', function ($q) {
                return $q->behalf;
            })
            ->addColumn('amount', function ($q) {
                return 'Rp. ' . number_format($q->amount);
            })
            ->addColumn('behalf', function ($q) {
                return $q->behalf;
            })
            ->addColumn('behalf', function ($q) {
                return $q->behalf;
            })
            ->addColumn('status', function ($q) {
                return !is_null($q->confirmed_at) ? 'Sudah dikonfirmasi' : "Belum dikonfirmasi";
            })
            ->addColumn('action', function ($q) {
                return !is_null($q->confirmed_at) ? '-' : '<button class="btn btn-primary" data-id="' . $q->id . '">Konfirmasi</button>';
            })
            ->rawColumns(['avatar', 'action', 'answer'])
            ->make(true);
    }

    public function getUsers(Request $request)
    {
        $user = User::where('status', 1);
        $role = $request->get('role', 'all');

        if ($role == 'editor') {
            $user = $user->whereHas('roles', function ($q) {
                $q->whereIn('name', ['editor']);
            });
        } else if ($role == 'reviewer') {
            $user = $user->whereHas('roles', function ($q) {
                $q->whereIn('name', ['reviewer']);
            });
        } else {
            $user = $user->whereHas('roles', function ($q) {
                $q->whereIn('name', ['reviewer', 'editor']);
            });
        }

        $user = $user->orderByDesc('created_at');
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
            ->addColumn('status', function ($q) {
                if ($q->isAn('reviewer')) {
                    if ($q->reviewer_approved_at) {
                        return '<span data-toggle="tooltip" title="Similarity : ' . $q->similarity . '">Approved</span>';
                    } else {
                        return '<span data-toggle="tooltip" title="Similarity : ' . $q->similarity . '">Declined</span>';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('action', function ($q) {
                $threshold_minimal = Setting::whereSlug('threshold-minimal')->first()->value;
                $threshold_maximal = Setting::whereSlug('threshold-maximal')->first()->value;
                if ($q->isAn('reviewer') && $q->similarity >= $threshold_minimal && $q->similarity <= $threshold_maximal) {
                    if (!is_null($q->reviewer_declined_at)) {
                        return '<a href="#" class="btn btn-primary" data-id="' . $q->id . '">Approve</a>';
                    } else {
                        return '<a href="#" class="btn btn-danger" data-id="' . $q->id . '">Decline</a>';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('similarity', function ($q) {
                return $q->similarity;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
