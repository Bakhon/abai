@extends('layouts.pf')
@section('content')
<div class="pf-upload-monitoring-wrapper">
    <div class="pf-upload-monitoring">
        <pf-upload_monitoring></pf-upload_monitoring>
    </div>
</div>
@endsection


<style>
    .pf-upload-monitoring-wrapper {
        margin: 0;
        padding: 0;
        display: grid;
        grid-template-rows: 1fr 975fr 1fr;
        grid-template-columns: 5fr 1852fr 5fr;
        background: #0f1430;
        width: 100%;
        height: 100%;
    }


    .pf-upload-monitoring {
        grid-column: 2;
        grid-row: 2;
        background: #0f1430;
    }
</style>