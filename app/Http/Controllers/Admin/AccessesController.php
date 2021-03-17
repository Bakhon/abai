<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Access;
use App\User;
use App\Module;

class AccessesController extends Controller
{
    public function index()
    {

        $accesses = Access::all()->sortByDesc('created_at');
        return view('admin.accesses.index', compact('accesses'));
    }
    public function edit($id)
    {
            $access = Access::whereId($id)->first();
            return view('admin.accesses.edit', compact('access'));
    }
    public function update(Request $request)
    {
            $status = $request->get('access_status');
            $id = $request->get('access_id');
            $user_id = $request->get('user_id');
            $module_id = $request->get('module_id');
            $user = User::whereId($user_id)->first();

            if($status == 'open'){
                $user->modules()->detach($module_id);
                $user->modules()->attach($module_id);
                $access = Access::whereId($id)->first();
                $access->status = $status;
                $access->save();
                return back()->with(['message' => 'Статус запроса был обновлен! Статус: одобрено!']);
            }elseif($status == 'close'){
                $access = Access::whereId($id)->first();
                $access->status = $status;
                $access->save();
                return back()->with(['message' => 'Статус запроса был обновлен! Статус: отклонено!']);
            }else{
                
            }
        
    }
}
