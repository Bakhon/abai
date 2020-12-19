<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imtigger\LaravelJobStatus\JobStatus;

class JobsController extends Controller
{
    public function getStatus(Request $request)
    {
        $job = JobStatus::find($request->id);
        return response()->json(
            [
                'job' => $job
            ]
        );
    }
}
