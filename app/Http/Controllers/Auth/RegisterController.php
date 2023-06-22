<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmMail;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPUnit\Exception;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $categories = Category::all();
        return view('auth.register', compact('categories'));
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'job' => 'required',
            'university' => 'required',
            'gender' => 'required',
            'sub_category' => 'required'
        ]);

        if (!$request->has('role')) {
            return redirect()->back()->with('failed', 'Role harus di isi');
        }

        $roles = $request->role;
        if (in_array('reviewer', $roles)) {
            $this->validate($request, [
                'orcid_id' => 'nullable',
                'scopus_url' => 'required',
                'sinta_url' => 'nullable',
            ]);

//            if (!is_null($request->orcid_id)) {
//                $name = $request->first_name . ' ' . $request->last_name;
//                if (check_orcid_id($request->orcid_id, $name) < 75) {
//                    return redirect()->back()->withInput()->with('failed', 'Mohon cek lagi Orcid ID');
//                }
//            }
//
//            if (!is_null($request->sinta_url)) {
//                $name = $request->first_name . ' ' . $request->last_name;
//                if (check_sinta_url($request->sinta_url, $name) < 75) {
//                    return redirect()->back()->withInput()->with('failed', 'Mohon cek lagi Sinta URL');
//                }
//            }
        }
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
            ]);

            if (!is_null($request->scopus_url)) {
                $name = $request->first_name . ' ' . $request->last_name;
                $threshold = Setting::whereSlug('threshold')->first();
                $similarity = check_scopus_url($request->scopus_url, $name);
                $user->update([
                    'similarity' => $similarity
                ]);
                if ($similarity >= $threshold->value) {
                    $user->update([
                        'reviewer_approved_at' => Carbon::now()
                    ]);
                } else {
                    $user->update([
                        'reviewer_declined_at' => Carbon::now()
                    ]);
                }
            }

            $user->subCategories()->syncWithoutDetaching($request->sub_category);

            $user->slug = Str::slug($user->name) . '-' . Str::random(8);

            foreach ($roles as $role) {
                $user->assign($role);
                if ($role == 'reviewer') {
                    $user->update([
                        'orcid_id' => $request->orcid_id ?? null,
                        'scopus_url' => $request->scopus_url ?? null,
                        'sinta_url' => $request->sinta_url ?? null
                    ]);
                }
            }

            Mail::to($user->email)->send(new ConfirmMail($user));

            DB::commit();
            return redirect()->route('login')->with('success', "Silahkan login menggunakan email $request->email dan password yang telah anda masukkan pada saat registrasi");
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
