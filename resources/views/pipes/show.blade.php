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
                <table class="table table-bordered">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th><b>Значение</b></th>
                    </tr>
                    <tr>
                        <td>ГУ</td>
                        <td>{{$pipe->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>Длина</td>
                        <td>{{ $pipe->length }}</td>
                    </tr>
                    <tr>
                        <td>Внешний диаметр</td>
                        <td>{{ $pipe->outside_diameter }}</td>
                    </tr>
                    <tr>
                        <td>Внутренний диаметр</td>
                        <td>{{ $pipe->inner_diameter }}</td>
                    </tr>
                    <tr>
                        <td>Толщина стенок</td>
                        <td>{{ $pipe->thickness }}</td>
                    </tr>
                    <tr>
                        <td>Жесткость</td>
                        <td>{{ $pipe->roughness }}</td>
                    </tr>
                    <tr>
                        <td>Материал</td>
                        <td>{{ $pipe->material_id }}</td>
                    </tr>
                    <tr>
                        <td>Участок</td>
                        <td>{{ $pipe->plot }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('pipes.index') }}">{{__('app.back')}}</a>
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
