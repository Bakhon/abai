@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('watermeasurement.export') }}"><i class="fas fa-file-export"></i></a>
                <a class="btn btn-success" href="{{ route('watermeasurement.create') }}">+</a>
            </div>
            <h1 style="color:#fff">Лабораторные данные по промысловой жидкости</h1>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-responsive table-bordered">
                    <tr>
                        <td>Дата отбора</td>
                        <td>Прочие объекты</td>
                        <td>НГДУ</td>
                        <td>ЦДНГ</td>
                        <td>ГУ</td>
                        <td>ЗУ</td>
                        <td>Скважина</td>
                        <td>НСО3-</td>
                        <td>СО32-</td>
                        <td>SO42-</td>
                        <td>Cl-</td>
                        <td>Ca2+</td>
                        <td>Mg2+</td>
                        <td>Na+K+</td>
                        <td>Плотность при 20°С, г/см3</td>
                        <td>рН</td>
                        <td>Общая минерализация, мг/дм3</td>
                        <td>Общая жесткость, мг-экв/дм3</td>
                        <td>Тип воды по Сулину</td>
                        <td>Содержание нефтепродуктов, мг/дм3</td>
                        <td>Механические примеси, мг/дм3</td>
                        <td>Содержание стронция, мг/дм³</td>
                        <td>Содержание бария, мг/дм³</td>
                        <td>Содержание общего железа мг/дм3</td>
                        <td>Содержание трехвалентного железа мг/дм3</td>
                        <td>Содержание двухвалентного железа мг/дм3</td>
                        <td>H2S, мг/дм3 (после буферной емкости)</td>
                        <td>О2, мг/дм3</td>
                        <td>CO2, мг/дм3 (после буферной емкости)</td>
                        <td>СВБ, кл/см3</td>
                        <td>УОБ, кл/см3</td>
                        <td>ТБ, кл/см3</td>
                        <td>{{__('app.action')}}</td>
                    </tr>
                    @foreach ($wm as $item)
                        <tr>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->other_objects->name }}</td>
                            <td>{{ $item->ngdu->name }}</td>
                            <td>{{ $item->cdng->name }}</td>
                            <td>{{ $item->gu->name }}</td>
                            <td>{{ $item->zu->name }}</td>
                            <td>{{ $item->well->name }}</td>
                            <td>{{ $item->hydrocarbonate_ion }}</td>
                            <td>{{ $item->carbonate_ion }}</td>
                            <td>{{ $item->sulphate_ion }}</td>
                            <td>{{ $item->chlorum_ion }}</td>
                            <td>{{ $item->calcium_ion }}</td>
                            <td>{{ $item->magnesium_ion }}</td>
                            <td>{{ $item->potassium_ion_sodium_ion }}</td>
                            <td>{{ $item->density}}</td>
                            <td>{{ $item->ph}}</td>
                            <td>{{ $item->mineralization}}</td>
                            <td>{{ $item->total_hardness}}</td>
                            <td>{{ $item->waterTypeBySulin->name}}</td>
                            <td>{{ $item->content_of_petrolium_products}}</td>
                            <td>{{ $item->mechanical_impurities}}</td>
                            <td>{{ $item->strontium_content}}</td>
                            <td>{{ $item->barium_content}}</td>
                            <td>{{ $item->total_iron_content}}</td>
                            <td>{{ $item->ferric_iron_content}}</td>
                            <td>{{ $item->ferrous_iron_content}}</td>
                            <td>{{ $item->hydrogen_sulfide}}</td>
                            <td>{{ $item->oxygen}}</td>
                            <td>{{ $item->carbon_dioxide}}</td>
                            <td>{{ $item->sulphateReducingBacteria->name}}</td>
                            <td>{{ $item->hydrocarbonOxidizingBacteria->name}}</td>
                            <td>{{ $item->thionicBacteria->name}}</td>
                            <td>
                                <form action="{{ route('watermeasurement.destroy',$item->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('watermeasurement.edit',$item->id) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-primary" href="{{ route('watermeasurement.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-primary" href="{{ route('watermeasurement.history',$item->id) }}"><i class="fas fa-history"></i></a>
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
                {!! $wm->links() !!}
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
