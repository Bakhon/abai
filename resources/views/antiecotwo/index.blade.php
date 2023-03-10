@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('antiecotwo.create') }}">+</a>
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
                                <th>Компания:</th>
                                <th>Ценовой сценарий, $/баррель:</th>
                                <th>Стоимость продажи нефти на внешний рынок 1 (к примеру: КТК) доллар/баррель:</th>
                                <th>Стоимость продажи нефти на внешний рынок 2 (к примеру: КТО) доллар/баррель:</th>
                                <th>Стоимость продажи нефти на внешний рынок 3 (к примеру: КТО) доллар/баррель:</th>
                                <th>Стоимость продажи нефти на местный рынок 1 (к примеру: АНПЗ) тенге/тонна:</th>
                                <th>Стоимость продажи нефти на местный рынок 2 (к примеру: ПНХЗ) тенге/тонна:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($antiecotwo as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->oil_cost }}</td>
                                    <td>{{ $item->oil_cost_exp_one }}</td>
                                    <td>{{ $item->oil_cost_exp_two }}</td>
                                    <td>{{ $item->oil_cost_exp_three }}</td>
                                    <td>{{ $item->oil_cost_ins_one }}</td>
                                    <td>{{ $item->oil_cost_ins_two }}</td>
                                    <td>
                                        <form action="{{ route('antiecotwo.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('antiecotwo.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $antiecotwo->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
