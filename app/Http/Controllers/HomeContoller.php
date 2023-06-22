<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class HomeContoller extends Controller
{
    public function index()
    {
        return view('homepage.home');
    }

    public function confirmEmail($token)
    {
        $user = User::where('verified_token', $token)->first();
        if ($user) {
            $user->confirmEmail();
            if (Auth::guest()) {
                return redirect()->route('login')->with('success', 'Email anda berhasil di konfirmasi');
            } else {
                return redirect()->route('profile.index')->with('success', 'Email anda berhasil di konfirmasi');
            }
        } else {
            return abort(404);
        }
    }

    public function getSubCategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();
        return api_response(1, '', compact('subcategories'));
    }
}
