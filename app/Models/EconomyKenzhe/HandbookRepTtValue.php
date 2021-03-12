<?php

namespace App\Models\EconomyKenzhe;

use Illuminate\Database\Eloquent\Model;

class HandbookRepTtValue extends Model
{
    protected $table = 'rep_tt_values';

    protected $fillable = ['rep_id', 'company_id', 'date', 'value', 'company', 'rep_tt'];

    public function company()
    {
        return $this->belongsTo(SubholdingCompany::class, 'company_id', 'id');
    }

    public function rept()
    {
        return $this->belongsTo(HandbookRepTt::class, 'rep_id', 'id');
    }

}
