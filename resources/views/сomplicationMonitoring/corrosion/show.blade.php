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
                <h1>Просмотр карточки</h1>
                <h2>Дата: {{ \Carbon\Carbon::parse($corrosion->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th><b>Значение</b></th>
                    </tr>
                    <tr>
                        <td>Месторождение</td>
                        <td>
                            @if ($corrosion->field === 1)
                                Узень
                            @else
                                Карамандыбас
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>НГДУ</td>
                        <td>{{$corrosion->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЦДНГ</td>
                        <td>{{$corrosion->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>ГУ</td>
                        <td>{{$corrosion->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>Дата начала</td>
                        <td>{{$corrosion->start_date_of_background_corrosion}}</td>
                    </tr>
                    <tr>
                        <td>Дата окончания</td>
                        <td>{{$corrosion->final_date_of_background_corrosion}}</td>
                    </tr>
                    <tr>
                        <td>Фоновая скорость</td>
                        <td>{{ $corrosion->background_corrosion_velocity }}</td>
                    </tr>
                    <tr>
                        <td>Дата начало замера скорости коррозии с реагентом</td>
                        <td>{{ $corrosion->start_date_of_corrosion_velocity_with_inhibitor_measure }}</td>
                    </tr>
                    <tr>
                        <td>Дата окончания замера скорости коррозии с реагентом</td>
                        <td>{{ $corrosion->final_date_of_corrosion_velocity_with_inhibitor_measure }}</td>
                    </tr>
                    <tr>
                        <td>Скорость коррозии</td>
                        <td>{{ $corrosion->corrosion_velocity_with_inhibitor }}</td>
                    </tr>
                    <tr>
                        <td>Номер образца-свидетеля</td>
                        <td>{{ $corrosion->sample_number }}</td>
                    </tr>
                    <tr>
                        <td>Масса до установки, гр</td>
                        <td>{{ $corrosion->weight_before }}</td>
                    </tr>
                    <tr>
                        <td>Количество дней экспозиции</td>
                        <td>{{ $corrosion->days }}</td>
                    </tr>
                    <tr>
                        <td>Масса после извлечения, гр</td>
                        <td>{{ $corrosion->weight_after }}</td>
                    </tr>
                    <tr>
                        <td>Средняя скорость коррозии, мм/г</td>
                        <td>{{ $corrosion->avg_speed }}</td>
                    </tr>
                </table>
                <a class="btn btn-primary" href="{{ route('corrosioncrud.index') }}">{{__('app.back')}}</a>
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
