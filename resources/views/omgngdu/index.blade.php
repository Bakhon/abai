@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('omgngdu.create') }}">+</a>
            </div>
            <h1 style="color:#fff">Форма ввода данных ОМГ НГДУ</h1>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th colspan="6">Узел отбора</th>
                        <th colspan="10">Фактические данные НГДУ</th>
                        <th rowspan="3">{{__('app.action')}}</th>
                    </tr>
                    <tr>
                        <th rowspan="2">Месторождение</th>
                        <th rowspan="2">НГДУ</th>
                        <th rowspan="2">ЦДНГ</th>
                        <th rowspan="2">ГУ</th>
                        <th rowspan="2">ЗУ</th>
                        <th rowspan="2">Скважина</th>
                        <th rowspan="2">Дата</th>
                        <th rowspan="2">Суточная добыча  жидкости, м3/сут</th>
                        <th rowspan="2">Давление в буферной емкости, кгс/см2</th>
                        <th rowspan="2">Давление на выходе насоса, кгс/см2</th>
                        <th colspan="2">Печь</th>
                        <th colspan="4">Кормасс</th>
                    </tr>
                    <tr>
                        <th>Давление на входе, кгс/см2</th>
                        <th>Давление на выходе, кгс/см2</th>
                        <th>Обозначение Кормасса</th>
                        <th>Давление, кгс/см2</th>
                        <th>Температура</th>
                        <th>Суточная добыча жидкости, м3/сут</th>
                    </tr>
                    @foreach ($omgngdu as $item)
                        <tr>
                            <td>
                                @if ($item->field === 1)
                                    Узень
                                @else
                                    Карамандыбас
                                @endif
                            </td>
                            <td>{{ $item->ngdu->name }}</td>
                            <td>{{ $item->cdng->name }}</td>
                            <td>{{ $item->gu->name }}</td>
                            <td>{{ $item->zu->name }}</td>
                            <td>{{ $item->well->name }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->daily_fluid_production }}</td>
                            <td>{{ $item->surge_tank_pressure }}</td>
                            <td>{{ $item->pump_discharge_pressure }}</td>
                            <td>{{ $item->heater_inlet_pressure }}</td>
                            <td>{{ $item->heater_output_pressure }}</td>
                            <td>{{ $item->kormass_number }}</td>
                            <td>{{ $item->pressure }}</td>
                            <td>{{ $item->temperature }}</td>
                            <td>{{ $item->daily_fluid_production_kormass }}</td>
                            <td>
                                <form action="{{ route('omgngdu.destroy',$item->id) }}" method="POST">
                                    {{-- <a class="btn btn-primary" href="{{ route('omgngdu.edit',$item->id) }}"><i class="fas fa-edit"></i></a> --}}
                                    <a class="btn btn-primary" href="{{ route('omgngdu.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>

                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {!! $omgngdu->links() !!}
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
