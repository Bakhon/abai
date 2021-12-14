<?php

namespace App\Http\Controllers\PlastFluids;

use App\Http\Controllers\Controller;


class PlastFluidsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:plastFluids view main')->only('pf', 'pfUploadMonitoring', 'pfDownloadMonitoring', 'pfDataAnalysis');
    }

    public function pf()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        return view('plastfluids.pf', compact('permissionNames'));
    }

    public function pfUploadMonitoring()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        return view('plastfluids.pf_upload_monitoring', compact('permissionNames'));
    }

    public function pfDownloadMonitoring()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        return view('plastfluids.pf_download_monitoring', compact('permissionNames'));
    }

    public function pfDataAnalysis()
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        return view('plastfluids.pf-data-analysis', compact('permissionNames'));
    }
}
