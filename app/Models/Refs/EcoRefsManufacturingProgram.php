<?php

namespace App\Models\Refs;

use App\Models\EcoRefsCompaniesId;
use App\User;
use Illuminate\Database\Eloquent\Model;

class EcoRefsManufacturingProgram extends Model
{
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(EcoRefsCompaniesId::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
