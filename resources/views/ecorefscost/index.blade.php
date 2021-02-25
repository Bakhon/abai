@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('eco_refs_list') }}" class="btn btn-info">
                Вернуться в справочник</a>
        </div>
    </div>
{{--    <div class="container">--}}
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('ecorefscost.create') }}">+</a>
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
                                <th>Дата:</th>
                                <th>Условно-переменные расходы:</th>
                                <th>Условно-постоянные расходы (расходы на персонал минус ФОТ ПРС):</th>
                                <th>Условно-постоянные расходы (расходы на персонал):</th>
                                <th>Условно-постоянные расходы (без учета затрат на персонал):</th>
                                <th>Условно-постоянные расходы :</th>
                                <th>Административные расходы (ОАР):</th>
                                <th>Средняя стоимость 1 ПРС без ФОТ:</th>
                                <th>ФОТ на 1 ПРС:</th>
                                <th>Средняя стоимость КРС:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefscost as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->variable }}</td>
                                    <td>{{ $item->fix_noWRpayroll }}</td>
                                    <td>{{ $item->fix_payroll }}</td>
                                    <td>{{ $item->fix_nopayroll }}</td>
                                    <td>{{ $item->fix }}</td>
                                    <td>{{ $item->gaoverheads }}</td>
                                    <td>{{ $item->wr_nopayroll }}</td>
                                    <td>{{ $item->wr_payroll }}</td>
                                    <td>{{ $item->wo }}</td>
                                    <td>
                                        <form action="{{ route('ecorefscost.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefscost.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefscost->links() !!}
                    </div>
                </div>
            </div>
        </div>
{{--    </div>--}}
@endsection
