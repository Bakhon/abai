<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Org extends Model
{
    /**
     * @return HasMany|Field
     */
    public function fields()
    {
        return $this->hasMany(Field::class, 'org_id');
    }
}
