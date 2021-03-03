@extends('layouts.monitor')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="container">
                <h1>{{ trans('monitoring.show_title') }}</h1>
                <h2>{{ trans('app.year') }}: {{ \Carbon\Carbon::parse($omgca->date)->format('Y')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$omgca->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgca.fields.plan_dosage') }}</td>
                        <td>{{$omgca->plan_dosage}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omgca.fields.tech_mode') }}</td>
                        <td>{{$omgca->q_v}}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('omgca.index') }}">{{__('app.back')}}</a>
            </div>
        </div>
    </div>
@endsection
<style>
    body{color: white !important;}
    .table{
        color: white !important;
    }
</style>
