<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Models\BigData\Well;

class WellsController extends Controller
{
    public function get(Well $well): array
    {
        return ['well' => $well];
    }
}
