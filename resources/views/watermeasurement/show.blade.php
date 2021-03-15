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
                <h2>{{ trans('app.date') }}: {{ \Carbon\Carbon::parse($wm->date)->format('d.m.Y H:i:s')}}</h2>
                <table class="table table-bordered">
                    <tr>
                        <th><b>{{ trans('app.param_name') }}</b></th>
                        <th><b>{{ trans('app.param_value') }}</b></th>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.other_objects') }}</td>
                        <td>{{$wm->other_objects->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.ngdu') }}</td>
                        <td>{{$wm->ngdu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.cdng') }}</td>
                        <td>{{$wm->cdng->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.gu.gu') }}</td>
                        <td>{{$wm->gu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.zu.zu') }}</td>
                        <td>{{$wm->zu->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.well.well') }}</td>
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
                        <td>{{ trans('monitoring.wm.fields.density') }}</td>
                        <td>{{$wm->density}}</td>
                    </tr>
                    <tr>
                        <td>pH</td>
                        <td>{{$wm->ph}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.mineralization') }}</td>
                        <td>{{$wm->mineralization}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.total_hardness') }}</td>
                        <td>{{$wm->total_hardness}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.water_type_by_sulin') }}</td>
                        <td>{{$wm->waterTypeBySulin->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.content_of_petrolium_products') }}</td>
                        <td>{{$wm->content_of_petrolium_products}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.mechanical_impurities') }}</td>
                        <td>{{$wm->mechanical_impurities}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.strontium_content') }}</td>
                        <td>{{$wm->strontium_content}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.barium_content') }}</td>
                        <td>{{$wm->barium_content}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.total_iron_content') }}</td>
                        <td>{{$wm->total_iron_content}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.ferric_iron_content') }}</td>
                        <td>{{$wm->ferric_iron_content}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.ferrous_iron_content') }}</td>
                        <td>{{$wm->ferrous_iron_content}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.hydrogen_sulfide') }}</td>
                        <td>{{$wm->hydrogen_sulfide}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.oxygen') }}</td>
                        <td>{{$wm->oxygen}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.carbon_dioxide') }}</td>
                        <td>{{$wm->carbon_dioxide}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.sulphate_reducing_bacteria') }}</td>
                        <td>{{$wm->sulphateReducingBacteria->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.hydrocarbon_oxidizing_bacteria') }}</td>
                        <td>{{$wm->hydrocarbonOxidizingBacteria->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('monitoring.wm.fields.thionic_bacteria') }}</td>
                        <td>{{$wm->thionicBacteria->name}}</td>
                    </tr>
                </table>
                <a class="btn btn-warning" href="{{ route('watermeasurement.edit',$wm->id) }}">{{__('app.edit')}}</a>
                <a class="btn btn-primary" href="{{ route('watermeasurement.index') }}">{{__('app.back')}}</a>
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
