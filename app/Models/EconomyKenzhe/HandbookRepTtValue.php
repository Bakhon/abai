<?php

namespace App\Models\EconomyKenzhe;

use App\Models\EcoRefsCompaniesId;
use Illuminate\Database\Eloquent\Model;

class HandbookRepTtValue extends Model
{
    protected $table = 'rep_tt_values';

    protected $fillable = ['rep_id', 'company_id', 'date', 'value', 'company', 'rep_tt', 'type'];

    public function company()
    {
        return $this->belongsTo(EcoRefsCompaniesId::class, 'company_id', 'id');
    }

    public function rept()
    {
        return $this->belongsTo(HandbookRepTt::class, 'rep_id', 'id');
    }

}