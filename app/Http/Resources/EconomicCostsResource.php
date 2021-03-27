<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EconomicCostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sc_fa' => $this -> sc_fa,
            'company_id' => $this -> company_id,
            'date' => $this -> date,
            'variable' => $this -> variable,
            'fix_noWRpayroll' => $this -> fix_noWRpayroll,
            'fix_payroll' => $this -> fix_payroll,
            'fix_nopayroll' => $this -> fix_nopayroll,
            'fix' => $this -> fix,
            'gaoverheads' => $this -> gaoverheads,
            'wr_nopayroll' => $this -> wr_nopayroll,
            'wr_payroll' => $this -> wr_payroll,
            'wo' => $this -> wo,
        ];
    }
}
