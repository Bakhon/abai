<?php

namespace App\Http\Controllers\WaterFloodingManagement;
use App\Http\Controllers\Controller;

class WaterFloodingManagementController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('waterflooding_management.waterflooding_management');
    }

}