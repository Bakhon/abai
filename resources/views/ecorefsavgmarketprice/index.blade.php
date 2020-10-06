@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('ecorefsavgmarketprice.create') }}">+</a>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Среднемесячная рыночная цена, от:</th>
                                <th>Среднемесячная рыночная цена, до:</th>
                                <th>Ставка ЭТП, $ за 1 тонну:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefsavgmarketprice as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->avg_market_price_beg }}</td>
                                    <td>{{ $item->avg_market_price_end }}</td>
                                    <td>{{ $item->exp_cust_duty_rate }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsavgmarketprice.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsavgmarketprice.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefsavgmarketprice->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
