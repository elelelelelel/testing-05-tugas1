<?php

namespace App\Http\Controllers\Dashboard\Makelar;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $threshold_minimal = Setting::whereSlug('threshold-minimal')->first()->value;
        $threshold_maximal = Setting::whereSlug('threshold-maximal')->first()->value;
        return view('dashboard.makelar.user.index', compact('threshold_minimal', 'threshold_maximal'));
    }

    public function approveUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'reviewer_approved_at' => Carbon::now(),
            'reviewer_declined_at' => null
        ]);
        return redirect()->back();
    }

    public function declineUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'reviewer_declined_at' => Carbon::now(),
            'reviewer_approved_at' => null
        ]);
        return redirect()->back();
    }


}
