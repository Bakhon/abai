@extends('layouts.monitor')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">
                <a class="btn btn-success" href="{{ route('watermeasurement.create') }}">+</a>
            </div>
            <div class="card-body">
                {{ $table }}
            </div>
        </div>
    </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
