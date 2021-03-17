<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Module extends Model
{
    protected $table = 'modules';
    protected $fillable = ['name', 'ico', 'url'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
