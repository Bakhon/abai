<?php

namespace App\Http\Requests\Paegtm\EcoRefs;

use Illuminate\Foundation\Http\FormRequest;

class GtmDeclineRateCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'org_id' => 'required',
            'geo_id' => 'required',
            'date' => 'required',
            'base_fund' => 'required',
            'vns' => 'required',
            'vns_grp' => 'required',
            'gs' => 'required',
            'gs_grp' => 'required',
            'zbs' => 'required',
            'zbgs' => 'required',
            'ugl' => 'required',
            'grp' => 'required',
            'vbd' => 'required',
            'pvlg' => 'required',
            'rir' => 'required',
            'pvr' => 'required',
            'opz' => 'required',
        ];
    }
}
