<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DictionariesController extends Controller
{
    const DICTIONARIES = [
        'well_categories' => \App\Models\BigData\Dictionaries\WellCategory::class,
        'orgs' => \App\Models\BigData\Dictionaries\Org::class,
        'geos' => \App\Models\BigData\Dictionaries\Geo::class,
        'well_types' => \App\Models\BigData\Dictionaries\WellType::class,
        'companies' => \App\Models\BigData\Dictionaries\Company::class
    ];

    public function get(string $dict)
    {

        if(!key_exists($dict, self::DICTIONARIES)) {
            return response()->json([], \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }

        return (self::DICTIONARIES[$dict])::all();

    }
}
