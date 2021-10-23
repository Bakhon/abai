<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ModuleState;

class ModuleStateController extends Controller
{
    public function ceoModuleState()
    {
        return view('moduleState.ceo_module_state');
    }
    public function ceoModuleStateInput()
    {
        return view('moduleState.ceo_module_state_input');
    }
    public function getStates()
    {
        return ModuleState::query()
            ->select()
            ->where('is_header', false)
            ->get()
            ->toArray();
    }
    public function getHeader()
    {
        return ModuleState::query()
            ->select()
            ->where('is_header', true)
            ->first();
    }
}