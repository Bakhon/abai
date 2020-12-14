@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('oilgas.create') }}">+</a>
            </div>
            <h1 style="color:#fff">База данных по нефти и газу</h1>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <td>Прочие объекты</td>
                        <td>НГДУ</td>
                        <td>ЦДНГ</td>
                        <td>ГУ</td>
                        <td>ЗУ</td>
                        <td>Скважина</td>
                        <td>Дата</td>
                        <td>Плотность нефти при 20°С, кг/м3</td>
                        <td>Вязкость нефти при 20С, мм2/с</td>
                        <td>Вязкость нефти при 40С, мм2/с</td>
                        <td>Вязкость нефти при 50С, мм2/с</td>
                        <td>Вязкость нефти при 60С, мм2/с</td>
                        <td>H2S в газе, ppm</td>
                        <td>О2 в газе, %</td>
                        <td>CO2 в газе, %</td>
                        <td>Плотность газа при 20°С, кг/м3</td>
                        <td>Вязкость газа при 20С, сП</td>
                        <td>{{__('app.action')}}</td>
                    </tr>
                    @foreach ($oilgas as $item)
                        <tr>
                            <td>{{ $item->other_objects->name }}</td>
                            <td>{{ $item->ngdu->name }}</td>
                            <td>{{ $item->cdng->name }}</td>
                            <td>{{ $item->gu->name }}</td>
                            <td>{{ $item->zu->name }}</td>
                            <td>{{ $item->well->name }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->water_density_at_20 }}</td>
                            <td>{{ $item->oil_viscosity_at_20 }}</td>
                            <td>{{ $item->oil_viscosity_at_40 }}</td>
                            <td>{{ $item->oil_viscosity_at_50 }}</td>
                            <td>{{ $item->oil_viscosity_at_60 }}</td>
                            <td>{{ $item->hydrogen_sulfide_in_gas }}</td>
                            <td>{{ $item->oxygen_in_gas }}</td>
                            <td>{{ $item->carbon_dioxide_in_gas }}</td>
                            <td>{{ $item->gas_density_at_20 }}</td>
                            <td>{{ $item->gas_viscosity_at_20 }}</td>
                            <td>
                                <form action="{{ route('oilgas.destroy',$item->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('oilgas.edit',['oilgas' => $item->id]) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-primary" href="{{ route('oilgas.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-primary" href="{{ route('oilgas.history',$item->id) }}"><i class="fas fa-history"></i></a>
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
                {!! $oilgas->links() !!}
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
