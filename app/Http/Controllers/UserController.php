<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogPageView;

class UserController extends Controller
{
    public function profile()
    {
        $logs = LogPageView::whereUserId(Auth::id())->orderBy('id', 'desc')->get();
        return view('users.profile', compact('logs'));
    }
}
