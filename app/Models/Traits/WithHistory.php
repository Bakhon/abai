<?php
namespace App\Models\Traits;

use App\EditHistory;

trait WithHistory
{
    public function history()
    {
        return $this->morphMany(EditHistory::class, 'entity')->orderBy('created_at', 'desc');
    }
}
