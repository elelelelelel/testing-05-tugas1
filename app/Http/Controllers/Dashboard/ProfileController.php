<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.profile.index', compact('categories'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'phone' => 'required',
            'job' => 'required',
            'university' => 'required',
            'gender' => 'required',
            'sub_category' => 'required'
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            if ($request->has('role')) {
                $roles = $request->role;
//                if (!in_array('reviewer', $request->role) && $user->isAn('reviewer')) {
//                    $user->retract('reviewer');
//                }
//                if (!in_array('editor', $request->role) && $user->isAn('editor')) {
//                    $user->retract('editor');
//                }
                foreach ($roles as $role) {
                    $user->assign($role);
                    if ($role == 'reviewer') {
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
                        $user->update([
                            'orcid_id' => $request->orcid_id ?? null,
                            'scopus_url' => $request->scopus_url ?? null,
                            'sinta_url' => $request->sinta_url ?? null
                        ]);
                    }
                }
            }

            $user->update([
                'email' => $request->email,
                'phone' => $request->phone,
                'university' => $request->university,
                'job' => $request->job,
                'gender' => $request->gender,
            ]);

            $user->subCategories()->sync($request->sub_category);

            if (!is_null($request->password)) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            if ($request->has('sinta_url') && !is_null($request->sinta_url)) {
                $user->update([
                    'sinta_url' => $request->sinta_url
                ]);
            }

            if ($request->has('orcid_id') && !is_null($request->orcid_id)) {
                $user->update([
                    'orcid_id' => $request->orcid_id,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
