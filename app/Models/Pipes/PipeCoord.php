<?php

namespace App\Models\Pipes;


use Illuminate\Database\Eloquent\Model;
use App\Models\Pipes\OilPipe;

class PipeCoord extends Model
{
    protected $guarded = ['id'];
    protected $table = 'pipe_coords';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function oilPipe()
    {
        return $this->belongsTo(OilPipe::class);
    }
}
