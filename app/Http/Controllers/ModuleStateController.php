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
            ->select(
                [
                    'id',
                    'name',
                    'date',
                    'current_execution_percent',
                    'current_ready_percent',
                    'planning_execution_percent',
                    'planning_ready_percent',
                    'result',
                    'is_header',
                    'is_sub_section'
                ]
            )
            ->where('is_header', false)
            ->get()
            ->toArray();
    }
    public function getHeader()
    {
        return ModuleState::query()
            ->select(['date','is_header'])
            ->where('is_header', true)
            ->first();
    }
    public function storeStates(Request $request)
    {
        $params = $request->request->all();
        foreach($params['params']['states'] as $module) {
            ModuleState::find($module['id'])->update($module);
        }
        $this->storeDate($params['params']['date']);
    }
    private function storeDate($updatedDate)
    {
        return ModuleState::query()
            ->select()
            ->where('is_header', true)
            ->first()
            ->update(['date' => $updatedDate]);
    }
}