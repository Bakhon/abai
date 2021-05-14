@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{url('/')}}/ru/ecorefsscfa"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.source_data')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsbranchid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.branch')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefscompaniesids"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.company_name')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsequipid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.equipment_name')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsrouteid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.route')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsroutetnid"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.route_tn')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsdirection"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.direction')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsannualprodvolume"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_annual_prod_volume')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsavgmarketprice"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_avg_market_price')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsdiscontcoefbar"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_discont_coef_bar')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefselectprsbrigcost"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_select_prs_brig_cost')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsndorates"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_ndo_rates')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsrentequipelectservcost"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_rent_equip_select_serv_cost')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsservicetime"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_service_time')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefstarifytn"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_tarify_tn')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsempper"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_empper')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsmacro"
                       class="list-group-item list-group-item-action text-primary">
                        {{__('economic_reference.eco_refs_macro')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsrenttax"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_rent_tax')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsexc"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_exc')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsprocdob"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_proc_dob')}}
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsavgprs"
                       class="list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_avg_prs')}}
                    </a>
                    <a href="{{ route('eco_refs_cost.index') }}"
                       class="text-primary list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_cost')}}
                    </a>
                    <a href="{{ route('eco_refs_scenario.index') }}"
                       class="text-primary list-group-item list-group-item-action">
                        {{__('economic_reference.eco_refs_scenario')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
