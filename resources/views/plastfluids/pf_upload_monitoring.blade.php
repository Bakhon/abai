@extends('layouts.pf')
@section('content')
<div class="pf-upload-monitoring-wrapper">
    <div class="pf-upload-monitoring">
        <pf-upload_monitoring :user="{{json_encode(auth()->user())}}"></pf-upload_monitoring>
    </div>
</div>
@endsection


<style>
    .pf-upload-monitoring-wrapper {
        margin: 0;
        padding: 0;
        background: #0f1430;
        width: 100%;
    }

    .pf-upload-monitoring {
        background: #0f1430;
    }
</style>