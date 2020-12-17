@extends('layouts.app')

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
                <h1>Просмотр карточки</h1>
                <h2>Дата: {{ \Carbon\Carbon::parse($omguhe->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th><b>Значение</b></th>
                    </tr>
                    <!-- <tr>
                        <td>Месторождение</td>
                        <td>{{$omguhe->field->name}}</td>
                    </tr> -->
                    <!-- <tr>
                        <td>НГДУ</td>
                        <td>{{$omguhe->ngdu->name}}</td>
                    </tr> -->
                    <!-- <tr>
                        <td>ЦДНГ</td>
                        <td>{{$omguhe->cdng->name}}</td>
                    </tr> -->
                    <tr>
                        <td>ГУ</td>
                        <td>{{$omguhe->gu->name}}</td>
                    </tr>
                    <!-- <tr>
                        <td>ЗУ</td>
                        <td>{{$omguhe->zu->name}}</td>
                    </tr> -->
                    <tr>
                        <td>Скважина</td>
                        <td>{{$omguhe->well->name}}</td>
                    </tr>
                    <tr>
                        <td>Фактическая дозировка, г/м3</td>
                        <td>{{$omguhe->current_dosage}}</td>
                    </tr>
                    <!-- <tr>
                        <td>Суточный расход ингибитора, кг/сут</td>
                        <td>{{$omguhe->daily_inhibitor_flowrate}}</td>
                    </tr> -->
                    <tr>
                        <td>Простой дозатора, сутки</td>
                        <td>
                            @if($omguhe->out_of_service_оf_dosing == 1)
                                Был простой
                            @else
                                Простоя не было
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <td>Причина</td>
                        <td>{{$omguhe->reason}}</td>
                    </tr>
                </table>
                {{-- <a class="btn btn-warning" href="{{ route('omguhe.edit',$omguhe->id) }}">{{__('app.edit')}}</a> --}}
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
