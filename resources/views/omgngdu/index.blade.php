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
                <table class="table table-responsive table-bordered">
                    <tr>
                        <td colspan="6">Узел отбора</td>
                        <td colspan="10">Фактические данные НГДУ</td>
                        <td rowspan="2">{{__('app.action')}}</td>
                    </tr>
                    <tr>
                        <td>Месторождение</td>
                        <td>НГДУ</td>
                        <td>ЦДНГ</td>
                        <td>ГУ</td>
                        <td>ЗУ</td>
                        <td>Скважина</td>
                        <td>Дата</td>
                        <td>Суточная добыча  жидкости, м3/сут</td>
                        <td>Суточная добыча  воды, м3/сут</td>
                        <td>Суточная добыча нефти, т/сут</td>
                        <td>Количество газа в СИБ, ст.м3/сут</td>
                        <td>Обводненность, %</td>
                        <td>Давление в буферной емкости, бар</td>
                        <td>Давление на выходе насоса, бар</td>
                        <td>Температура на входе в печь, С</td>
                        <td>Температура на выходе из печи, С</td>
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
                            <td>{{ $item->daily_water_production }}</td>
                            <td>{{ $item->daily_oil_production }}</td>
                            <td>{{ $item->daily_gas_production_in_sib }}</td>
                            <td>{{ $item->bsw }}</td>
                            <td>{{ $item->surge_tank_pressure }}</td>
                            <td>{{ $item->pump_discharge_pressure }}</td>
                            <td>{{ $item->heater_inlet_pressure }}</td>
                            <td>{{ $item->heater_output_pressure }}</td>
                            <td>
                                <form action="{{ route('omgngdu.destroy',$item->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('omgngdu.edit',$item->id) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-primary" href="{{ route('omgngdu.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-primary" href="{{ route('omgngdu.history',$item->id) }}"><i class="fas fa-history"></i></a>
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
