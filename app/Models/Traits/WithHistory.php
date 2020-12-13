<?php
namespace App\Models\Traits;

trait WithHistory
{
    public function history()
    {
        return $this->morphMany(\App\EditHistory::class, 'entity')->orderBy('created_at', 'desc');
    }
}
