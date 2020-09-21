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
                <h2>Дата: {{ \Carbon\Carbon::parse($wm->date)->format('d.m.Y H:i:s')}}</h2>

                <a class="btn btn-warning float-right" href="{{ route('watermeasurement.edit',$wm->id) }}">{{__('app.edit')}}</a>
                <a class="btn btn-primary float-right" href="{{ route('watermeasurement.index') }}">{{__('app.back')}}</a>

                <table class="table table-bordered">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th><b>Значение</b></th>
                    </tr>
                    <tr>
                        <td>Прочие объекты</td>
                        <td>{{$wm->other_objects->name}}</td>
                    </tr>
                    <tr>
                        <td>НГДУ</td>
                        <td>{{$wm->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЦДНГ</td>
                        <td>{{$wm->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>ГУ</td>
                        <td>{{$wm->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>ЗУ</td>
                        <td>{{$wm->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>Скважина</td>
                        <td>{{$wm->well->name}}</td>
                    </tr>
                    <tr>
                        <td>НСО3-</td>
                        <td>{{$wm->hydrocarbonate_ion}}</td>
                    </tr>
                    <tr>
                        <td>СО32-</td>
                        <td>{{$wm->carbonate_ion}}</td>
                    </tr>
                    <tr>
                        <td>SO42-</td>
                        <td>{{$wm->sulphate_ion}}</td>
                    </tr>
                    <tr>
                        <td>Cl-</td>
                        <td>{{$wm->chlorum_ion}}</td>
                    </tr>
                    <tr>
                        <td>Ca2+</td>
                        <td>{{$wm->calcium_ion}}</td>
                    </tr>
                    <tr>
                        <td>Mg2+</td>
                        <td>{{$wm->magnesium_ion}}</td>
                    </tr>
                    <tr>
                        <td>Na+K+</td>
                        <td>{{$wm->potassium_ion_sodium_ion}}</td>
                    </tr>
                    <tr>
                        <td>Плотность при 20°С, г/см3</td>
                        <td>{{$wm->density}}</td>
                    </tr>
                    <tr>
                        <td>рН</td>
                        <td>{{$wm->ph}}</td>
                    </tr>
                    <tr>
                        <td>Общая минерализация, мг/дм3</td>
                        <td>{{$wm->mineralization}}</td>
                    </tr>
                    <tr>
                        <td>Общая жесткость, мг-экв/дм3</td>
                        <td>{{$wm->total_hardness}}</td>
                    </tr>
                    <tr>
                        <td>Тип воды по Сулину</td>
                        <td>{{$wm->waterTypeBySulin->name}}</td>
                    </tr>
                    <tr>
                        <td>Содержание нефтепродуктов, мг/дм3</td>
                        <td>{{$wm->content_of_petrolium_products}}</td>
                    </tr>
                    <tr>
                        <td>Механические примеси, мг/дм3</td>
                        <td>{{$wm->mechanical_impurities}}</td>
                    </tr>
                    <tr>
                        <td>Содержание стронция, мг/дм³</td>
                        <td>{{$wm->strontium_content}}</td>
                    </tr>
                    <tr>
                        <td>Содержание бария, мг/дм³</td>
                        <td>{{$wm->barium_content}}</td>
                    </tr>
                    <tr>
                        <td>Содержание общего железа мг/дм3</td>
                        <td>{{$wm->total_iron_content}}</td>
                    </tr>
                    <tr>
                        <td>Содержание трехвалентного железа мг/дм3</td>
                        <td>{{$wm->ferric_iron_content}}</td>
                    </tr>
                    <tr>
                        <td>Содержание двухвалентного железа мг/дм3</td>
                        <td>{{$wm->ferrous_iron_content}}</td>
                    </tr>
                    <tr>
                        <td>H2S, мг/дм3</td>
                        <td>{{$wm->hydrogen_sulfide}}</td>
                    </tr>
                    <tr>
                        <td>О2, мг/дм3</td>
                        <td>{{$wm->oxygen}}</td>
                    </tr>
                    <tr>
                        <td>CO2, мг/дм3</td>
                        <td>{{$wm->carbon_dioxide}}</td>
                    </tr>
                    <tr>
                        <td>СВБ, кл/см3</td>
                        <td>{{$wm->sulphateReducingBacteria->name}}</td>
                    </tr>
                    <tr>
                        <td>УОБ, кл/см3</td>
                        <td>{{$wm->hydrocarbonOxidizingBacteria->name}}</td>
                    </tr>
                    <tr>
                        <td>ТБ, кл/см3</td>
                        <td>{{$wm->thionicBacteria->name}}</td>
                    </tr>
                </table>
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
