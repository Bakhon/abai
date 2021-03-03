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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($omguhe->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.well.well') }}</td>
                        <td>{{$omguhe->well->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omguhe.fields.fact_dosage') }}</td>
                        <td>{{$omguhe->current_dosage}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omguhe.fields.dosator_idle') }}</td>
                        <td>
                            @if($omguhe->out_of_service_оf_dosing == 1)
                                {{ trans('monitoring.omguhe.fields.dosator.idle') }}
                            @else
                                {{ trans('monitoring.omguhe.fields.dosator.no_idle') }}
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.omguhe.fields.reason') }}</td>
                        <td>{{$omguhe->reason}}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('omguhe.index') }}">{{__('app.back')}}</a>
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
