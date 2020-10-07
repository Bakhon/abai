@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('ecorefsavgmarketprice.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ecorefsavgmarketprice.update',$EcoRefsAvgMarketPrice->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Среднемесячная рыночная цена, от:</strong>
                                        <input type="integer" name="avg_market_price_beg" class="form-control" placeholder="" value="{{$EcoRefsAvgMarketPrice->avg_market_price_beg}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Среднемесячная рыночная цена, до:</strong>
                                        <input type="integer" name="avg_market_price_end" class="form-control" placeholder="" value="{{$EcoRefsAvgMarketPrice->avg_market_price_end}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ставка ЭТП, $ за 1 тонну:</strong>
                                        <input type="float" name="exp_cust_duty_rate" class="form-control" placeholder="" value="{{$EcoRefsAvgMarketPrice->exp_cust_duty_rate}}">
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
