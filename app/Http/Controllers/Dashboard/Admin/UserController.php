<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Exception;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.user.index');
    }

    public function create()
    {
        return view('dashboard.admin.user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'job' => 'required',
            'university' => 'required',
            'role' => 'required',
            'gender' => 'required',
        ]);

        $role = strtolower($request->role);

        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'university' => $request->university,
                'job' => $request->job,
                'gender' => $request->gender,
                'email_verified_at' => Carbon::now()
            ]);

            $user->assign($role);

            DB::commit();
            return redirect()->route('dashboard.admin.user.index')->with('success', "Data berhasil ditambahkan");
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
