@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{url('/')}}/ru/module_economy/ecorefsscfa"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.source_data')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsbranchid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.branch')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefscompaniesids"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.company_name')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsequipid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.equipment_name')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsrouteid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.route')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsroutetnid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.route_tn')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsdirection"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.direction')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsannualprodvolume"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_annual_prod_volume')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsavgmarketprice"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_avg_market_price')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefselectprsbrigcost"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_select_prs_brig_cost')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsndorates"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_ndo_rates')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsrentequipelectservcost"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_rent_equip_select_serv_cost')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsservicetime"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_service_time')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsrenttax"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_rent_tax')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsexc"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_exc')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsprocdob"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_proc_dob')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsavgprs"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_avg_prs')}}
                    </a>
                    <a href="{{ route('eco_refs_cost.index') }}"
                       class="text-primary list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_cost')}}
                    </a>
                    <a href="{{ route('eco_refs_cost.index',['is_forecast'=> 1]) }}"
                       class="text-primary list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_scenario')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsmacro"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_macro')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsempper"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_empper')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefsdiscontcoefbar"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_discont_coef_bar')}}
                    </a>
                    <a href="{{url('/')}}/ru/module_economy/ecorefstarifytn"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_tarify_tn')}}
                    </a>
                    <a href="{{ route('eco_refs_gtm.index') }}"
                       class="text-primary list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_gtm')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
