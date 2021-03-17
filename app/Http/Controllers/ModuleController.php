<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Module;
use App\User;
use App\Access;

class ModuleController extends Controller
{
    public function moduleRequest(Request $request)
    {
        $user = Auth::user();
        $module = Module::whereId($request->get('id'))->first();
        $accessActive = Access::where('user_id',$user->id)->where('module_id',$module->id)->where('status','process')->first();
        if(!$accessActive){
            $access = new Access();
            $access->module_id = $module->id;
            $access->module_icon = $module->ico;
            $access->user_id = $user->id;
            $access->user_name = $user->name;
            $access->module_name = $module->name;
            $access->status = 'process';
            $access->save();
            return response()->json(['message' => 'Заявка на запрос модуля успешно отправлена!','status' => 1]);
        }elseif($accessActive){
            return response()->json(['message' => 'Заявка на данный модуль уже существует. Ожидайте ответа','status' => 0]); 
        }else{
            return response()->json(['message' => 'Ошибка! Попробуйте отправить позднее']);  
        }
    }
}

