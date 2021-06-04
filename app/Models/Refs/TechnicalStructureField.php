<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TechnicalStructureField extends Model
{
    protected $fillable = [
        'name', 'company_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(TechnicalStructureCompany::class, 'company_id');
    }
}
