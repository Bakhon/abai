<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogPageView;
use App\Module;
use App\User;
use App\Access;

class UserController extends Controller
{
    public function profile()
    {
        $logs = LogPageView::whereUserId(Auth::id())->orderBy('id', 'desc')->get();
        $modules = Auth::user()->modules;
        $other_modules = Module::doesntHave('users')->orWhereHas('users', function ($query) {
            return $query->where('user_id', '!=', Auth::id());
        })->get();
        $accesses = Access::whereUserId(Auth::id())->orderBy('updated_at', 'desc')->get();
        return view('users.profile', compact('logs','modules','other_modules','accesses'));
    }
}
