<?php

namespace App\Models\Refs;

use App\Models\EcoRefsCompaniesId;
use App\User;
use Illuminate\Database\Eloquent\Model;

class EcoRefsGtm extends Model
{
    protected $fillable = ['company_id', 'name', 'price', 'pi', 'comment', 'author_id'];

    public function company()
    {
        return $this->belongsTo(EcoRefsCompaniesId::class, 'company_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
