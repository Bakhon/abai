@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('ecorefsannualprodvolume.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ecorefsannualprodvolume.update',$EcoRefsAnnualProdVolume->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Объем годовой добычи, от:</strong>
                                        <input type="integer" name="annual_prod_volume_beg" class="form-control" placeholder="" value="{{$EcoRefsAnnualProdVolume->annual_prod_volume_beg}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Объем годовой добычи, до:</strong>
                                        <input type="integer" name="annual_prod_volume_end" class="form-control" placeholder="" value="{{$EcoRefsAnnualProdVolume->annual_prod_volume_end}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ставка НДПИ, в %:</strong>
                                        <input type="float" name="ndpi" class="form-control" placeholder="" value="{{$EcoRefsAnnualProdVolume->ndpi}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">{{__('app.submit')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
