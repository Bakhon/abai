<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\faqPage;

class faqController extends Controller
{
    public function index()
    {
        return view('faq');
    }

    public function getQuestionsAndAnswers()
    {
        return faqPage::all();
    }
}
