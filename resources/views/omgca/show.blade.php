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
                <h2>Дата: {{ \Carbon\Carbon::parse($omgca->date)->format('d.m.Y')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th><b>Значение</b></th>
                    </tr>
                    <tr>
                        <td>Месторождение</td>
                        <td>
                            @if ($omgca->field === 1)
                                Узень
                            @else
                                Карамандыбас
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>НГДУ</td>
                        <td>{{$omgca->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЦДНГ</td>
                        <td>{{$omgca->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>ГУ</td>
                        <td>{{$omgca->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЗУ</td>
                        <td>{{$omgca->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>Скважина</td>
                        <td>{{$omgca->well->name}}</td>
                    </tr>
                    <tr>
                        <td>Планируемая дозировка, г/м3</td>
                        <td>{{$omgca->plan_dosage}}</td>
                    </tr>
                </table>
                {{-- <a class="btn btn-warning" href="{{ route('watermeasurement.edit',$wm->id) }}">{{__('app.edit')}}</a> --}}
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
