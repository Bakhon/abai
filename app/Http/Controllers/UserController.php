<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogPageView;
use App\Module;
use App\Profile;
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
     
    public function update_avatar(Request $request){

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ]);

        $profile = Profile::whereUserId(Auth::id())->first();

        $avatarName = '/images/avatars/'.$profile->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->file('avatar')->move('images/avatars', $avatarName);

        $profile->thumb = $avatarName;
        $profile->save();

        return response()->json(['message' => 'Аватар обновлен!','status' => 1,'thumb'=> $avatarName]);

    }

    public function delete_avatar(){
        $profile = Profile::whereUserId(Auth::id())->first();
        if($profile->thumb == null){
            return response()->json(['message' => 'У Вас нет аватара!','status' => 0]); 
        }
        $profile->thumb = null;
        $profile->save();
        return response()->json(['message' => 'Аватар успешно удален!','status' => 1]); 
    }
}
