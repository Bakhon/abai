<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;


class ZusCLeaning extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public $table = 'zu_cleanings';

    public function zu()
    {
        return $this->hasOne(Zu::class, 'id', 'zu_id')->withDefault();
    }   
}
