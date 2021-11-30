<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class faqController extends Controller
{
    public function index()
    {
        $faqData = json_encode(Faq::all()->toArray());
        return view('faq')->with(compact('faqData'));
    }
}
