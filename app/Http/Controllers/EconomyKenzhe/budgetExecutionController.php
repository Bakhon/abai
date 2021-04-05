<?php

namespace App\Http\Controllers\EconomyKenzhe;

use App\Imports\HandbookRepTtValueImport;
use App\Models\EconomyKenzhe\HandbookRepTt;
use App\Models\EconomyKenzhe\SubholdingCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class budgetExecutionController extends Controller
{

    public function budgetExecution()
    {
        return view('economy_kenzhe.budgetExecution');
    }

}