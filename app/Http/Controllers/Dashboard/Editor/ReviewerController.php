<?php

namespace App\Http\Controllers\Dashboard\Editor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{
    public function index()
    {
        return view('dashboard.editor.reviewer.index');
    }

    public function create($slug)
    {
        $user = User::whereSlug($slug)->first();
        return view('dashboard.editor.reviewer.create', compact('user'));
    }

    public function show($slug)
    {
        $user = User::whereSlug($slug)->first();
        return view('dashboard.editor.reviewer.show', compact('user'));
    }
}
