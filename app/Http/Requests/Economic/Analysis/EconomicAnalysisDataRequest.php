<?php

namespace App\Http\Requests\Economic\Analysis;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EconomicAnalysisDataRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this['date'] = Carbon::parse($this['date'])
            ->setDay(1)
            ->format('Y-m-d');
    }

    public function rules()
    {
        return [
//            'org_id' => 'required|integer|min:1',
            'permanent_stop_coefficient' => 'required|numeric',
            'date' => 'required|date',
        ];
    }
}
