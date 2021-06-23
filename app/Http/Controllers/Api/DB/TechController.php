<?php

namespace App\Http\Controllers\Api\DB;

use App\Models\BigData\Dictionaries\Tech;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TechController
{

    /**
     * @param int $techId
     * @return Tech
     */
    public function getWellsById(Request $request):array {
        if (!$request->get('techId')) {
            return [];
        }
        $tech = Tech::where('id', '=', $request->get('techId'))
            ->with(
                [
                    'wells' =>
                        function ($query) {
                            $query->active(Carbon::now());
                            $query->distinct();
                        }
                ]
            )
            ->first();
        return $tech ? $tech->wells->toArray() : [];
    }

}