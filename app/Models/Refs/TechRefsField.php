<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Refs\TechRefsCompany;

class TechRefsField extends Model
{
    protected $fillable = [
        'name', 'company_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Refs\TechRefsCompany', 'company_id');
    }
}
