@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('antiecoone.create') }}">+</a>
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
                                <th>Дата начала:</th>
                                <th>Дата конца:</th>
                                <th>Коэффициент баррелизации экспорт 1 (к примеру: КТК):</th>
                                <th>Коэффициент баррелизации экспорт 2 (к примеру: КТО):</th>
                                <th>Коэффициент барреализации экспорт 3:</th>
                                <th>Коэффициент барреализации местный рынок 1:</th>
                                <th>Коэффициент барреализации местный рынок 2:</th>
                                <th>Доля реализации продукции экспорт 1 (к примеру: КТК):</th>
                                <th>Доля реализации продукции экспорт 2 (к примеру: КТО):</th>
                                <th>Доля реализации по на правления экспорт 3:</th>
                                <th>Доля реализации продукции местный рынок 1 (к примеру: АНПЗ):</th>
                                <th>Доля реализации продукции местный рынок 1 (к примеру: ПНХЗ):</th>
                                <th>Скидка при реализации продукции по направлению экспорт 1 (к примеру: КТК):</th>
                                <th>Скидка при реализации продукции по направлению экспорт 2 (к примеру: КТО):</th>
                                <th>Скидка при реализации по направлению экспорт 3:</th>
                                <th>Скидка при реализации продукции по направлению местный рынок 1 :</th>
                                <th>Скидка при реализации продукции по направлению местный рынок 2:</th>
                                <th>Транспортные расходы при реализации по направлению экспорт 1 (к примеру: КТК):</th>
                                <th>Транспортные расходы при реализации по направлению экспорт 2 (к примеру: КТО):</th>
                                <th>Транспортные расходы экспорт 3:</th>
                                <th>Транспортные расходы при реализации по направлению местный рынок 1 (к примеру: АНПЗ):</th>
                                <th>Транспортные расходы при реализации по направлению экспорт 2  (к примеру: ПНХЗ):</th>
                                <th>Условно-переменные расходы, тенге/тонна жидкости:</th>
                                <th>Условно-переменные расходы, тенге/тонна жидкости:</th>
                                <th>Условно-постоянные расходы (расходы на персонал), тенге/год:</th>
                                <th>Условно-постоянные расходы (расходы на персонал минус ФОТ ПРС), тенге/год:</th>
                                <th>Условно-постоянные расходы (без учета затрат на персонал), тенге/год:</th>
                                <th>Условно-постоянные расходы, тенге/год:</th>
                                <th>Административные расходы (ОАР), тенге/год:</th>
                                <th>Средняя стоимость 1 ПРС без ФОТ, тенге:</th>
                                <th>ФОТ на 1 ПРС:</th>
                                <th>Сердняя стоимость 1 ПРС, тенге:</th>
                                <th>Средняя стоимость КРС:</th>
                                <th>Амортизация (тенге на тонну нефти):</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($antiecoone as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->dbeg }}</td>
                                    <td>{{ $item->dend }}</td>
                                    <td>{{ $item->bar_coef_exp_one }}</td>
                                    <td>{{ $item->bar_coef_exp_two }}</td>
                                    <td>{{ $item->bar_coef_exp_three }}</td>
                                    <td>{{ $item->bar_coef_ins_one }}</td>
                                    <td>{{ $item->bar_coef_ins_two }}</td>
                                    <td>{{ $item->sales_share_exp_one }}</td>
                                    <td>{{ $item->sales_share_exp_two }}</td>
                                    <td>{{ $item->sales_share_exp_three }}</td>
                                    <td>{{ $item->sales_share_ins_one }}</td>
                                    <td>{{ $item->sales_share_ins_two }}</td>
                                    <td>{{ $item->disc_exp_one }}</td>
                                    <td>{{ $item->disc_exp_two }}</td>
                                    <td>{{ $item->disc_exp_three }}</td>
                                    <td>{{ $item->disc_ins_one }}</td>
                                    <td>{{ $item->disc_ins_two }}</td>
                                    <td>{{ $item->trans_exp_cost_one }}</td>
                                    <td>{{ $item->trans_exp_cost_two }}</td>
                                    <td>{{ $item->trans_exp_cost_three }}</td>
                                    <td>{{ $item->trans_ins_cost_one }}</td>
                                    <td>{{ $item->trans_ins_cost_two }}</td>
                                    <td>{{ $item->var_cost_one }}</td>
                                    <td>{{ $item->var_cost_two }}</td>
                                    <td>{{ $item->fix_cost_one }}</td>
                                    <td>{{ $item->fix_cost_two }}</td>
                                    <td>{{ $item->fix_cost_three }}</td>
                                    <td>{{ $item->fix_cost_four }}</td>
                                    <td>{{ $item->adm_exp }}</td>
                                    <td>{{ $item->avg_prs_cost }}</td>
                                    <td>{{ $item->fot_prs }}</td>
                                    <td>{{ $item->avg_prs_cost_fot }}</td>
                                    <td>{{ $item->avg_krs_cost }}</td>
                                    <td>{{ $item->amort }}</td>
                                    <td>
                                        <form action="{{ route('antiecoone.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('antiecoone.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $antiecoone->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
