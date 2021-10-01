<?php

namespace App\Http\Controllers\Economic\Technical;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TechnicalListController extends Controller
{
    public function __invoke(): View
    {
        return view('economic.technical.list');
    }
}
