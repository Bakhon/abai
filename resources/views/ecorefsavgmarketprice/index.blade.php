@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('eco_refs_list') }}"
               class="btn btn-info">
                {{ __('economic_reference.return_menu') }}
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ecorefs-header">
                        <a class="btn btn-success" href="{{ route('ecorefsavgmarketprice.create') }}">+</a>
                        <div class="ecorefs-title"> {{__('economic_reference.eco_refs_avg_market_price')}}</div>
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
                                <th>Сценарий/Факт:</th>
                                <th>Среднемесячная рыночная цена ($/баррель), от:</th>
                                <th>Среднемесячная рыночная цена ($/баррель), до:</th>
                                <th>Ставка ЭТП, $ за 1 тонну:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefsavgmarketprice as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->avg_market_price_beg }}</td>
                                    <td>{{ $item->avg_market_price_end }}</td>
                                    <td>{{ $item->exp_cust_duty_rate }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsavgmarketprice.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsavgmarketprice.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2">{{__('app.delete')}}</button>
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
