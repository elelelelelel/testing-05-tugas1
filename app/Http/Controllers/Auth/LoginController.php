<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmMail;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $check = User::where('email', $email)->first();
        if (!$check) {
            return redirect()->back()->with('failed', 'Akun tidak dapat ditemukan')->withInput();
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('profile.index');
        } else {
            return redirect()
                ->back()
                ->with('failed', 'Your password is incorrect')
                ->withInput();
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
