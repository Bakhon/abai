@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('antiecoone.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('antiecoone.update', $row->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сценарий/Факт:</strong>
                                        <select class="form-control" name="sc_fa">
                                        <option>Select Item</option>
                                        @foreach ($sc_fa as $item)
                                            @if($item->id==$row->sc_fa)
                                            <option value="{{ $item->id }}" selected>
                                                {{ $item->name }}
                                            </option>
                                            @else
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Компания:</strong>
                                        <select class="form-control" name="company_id">
                                        <option>Select Item</option>
                                        @foreach ($company as $item)
                                            @if($item->id==$row->company_id)
                                            <option value="{{ $item->id }}" selected>
                                                {{ $item->name }}
                                            </option>
                                            @else
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Дата:</strong>
                                        <input type="date" name="date" value={{$row->date}} class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Дата начала:</strong>
                                        <input type="date" name="dbeg" value={{$row->dbeg}} class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Дата конца:</strong>
                                        <input type="date" name="dend" value={{$row->dend}} class="form-control">
                                    </div>
                                </div>
                               <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Коэффициент баррелизации экспорт 1 (к примеру: КТК):</strong>
                                        <input type="float" name="bar_coef_exp_one" value={{$row->bar_coef_exp_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Коэффициент баррелизации экспорт 2 (к примеру: КТО):</strong>
                                        <input type="float" name="bar_coef_exp_two" value={{$row->bar_coef_exp_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Коэффициент барреализации экспорт 3:</strong>
                                        <input type="float" name="bar_coef_exp_three" value={{$row->bar_coef_exp_three}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Коэффициент барреализации местный рынок 1:</strong>
                                        <input type="float" name="bar_coef_ins_one" value={{$row->bar_coef_ins_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Коэффициент барреализации местный рынок 2:</strong>
                                        <input type="float" name="bar_coef_ins_two" value={{$row->bar_coef_ins_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Доля реализации продукции экспорт 1 (к примеру: КТК):</strong>
                                        <input type="float" name="sales_share_exp_one" value={{$row->sales_share_exp_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Доля реализации продукции экспорт 2 (к примеру: КТО):</strong>
                                        <input type="float" name="sales_share_exp_two" value={{$row->sales_share_exp_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Доля реализации по на правления экспорт 3:</strong>
                                        <input type="float" name="sales_share_exp_three" value={{$row->sales_share_exp_three}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Доля реализации продукции местный рынок 1 (к примеру: АНПЗ):</strong>
                                        <input type="float" name="sales_share_ins_one" value={{$row->sales_share_ins_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Доля реализации продукции местный рынок 1 (к примеру: ПНХЗ):</strong>
                                        <input type="float" name="sales_share_ins_two" value={{$row->sales_share_ins_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скидка при реализации продукции по направлению экспорт 1 (к примеру: КТК):</strong>
                                        <input type="float" name="disc_exp_one" value={{$row->disc_exp_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скидка при реализации продукции по направлению экспорт 2 (к примеру: КТО):</strong>
                                        <input type="float" name="disc_exp_two" value={{$row->disc_exp_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скидка при реализации по направлению экспорт 3:</strong>
                                        <input type="float" name="disc_exp_three" value={{$row->disc_exp_three}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скидка при реализации продукции по направлению местный рынок 1 :</strong>
                                        <input type="float" name="disc_ins_one" value={{$row->disc_ins_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скидка при реализации продукции по направлению местный рынок 2:</strong>
                                        <input type="float" name="disc_ins_two" value={{$row->disc_ins_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Транспортные расходы при реализации по направлению экспорт 1 (к примеру: КТК):</strong>
                                        <input type="float" name="trans_exp_cost_one" value={{$row->trans_exp_cost_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Транспортные расходы при реализации по направлению экспорт 2 (к примеру: КТО):</strong>
                                        <input type="float" name="trans_exp_cost_two" value={{$row->trans_exp_cost_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Транспортные расходы экспорт 3:</strong>
                                        <input type="float" name="trans_exp_cost_three" value={{$row->trans_exp_cost_three}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Транспортные расходы при реализации по направлению местный рынок 1 (к примеру: АНПЗ):</strong>
                                        <input type="float" name="trans_ins_cost_one" value={{$row->trans_ins_cost_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Транспортные расходы при реализации по направлению экспорт 2  (к примеру: ПНХЗ):</strong>
                                        <input type="float" name="trans_ins_cost_two" value={{$row->trans_ins_cost_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Условно-переменные расходы, тенге/тонна жидкости:</strong>
                                        <input type="float" name="var_cost_one" value={{$row->var_cost_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Условно-переменные расходы, тенге/тонна жидкости:</strong>
                                        <input type="float" name="var_cost_two" value={{$row->var_cost_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Условно-постоянные расходы (расходы на персонал), тенге/год:</strong>
                                        <input type="float" name="fix_cost_one" value={{$row->fix_cost_one}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Условно-постоянные расходы (расходы на персонал минус ФОТ ПРС), тенге/год:</strong>
                                        <input type="float" name="fix_cost_two" value={{$row->fix_cost_two}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Условно-постоянные расходы (без учета затрат на персонал), тенге/год:</strong>
                                        <input type="float" name="fix_cost_three" value={{$row->fix_cost_three}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Условно-постоянные расходы, тенге/год:</strong>
                                        <input type="float" name="fix_cost_four" value={{$row->fix_cost_four}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Административные расходы (ОАР), тенге/год:</strong>
                                        <input type="float" name="adm_exp" value={{$row->adm_exp}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Средняя стоимость 1 ПРС без ФОТ, тенге:</strong>
                                        <input type="float" name="avg_prs_cost" value={{$row->avg_prs_cost}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ФОТ на 1 ПРС:</strong>
                                        <input type="float" name="fot_prs" value={{$row->fot_prs}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Средняя стоимость 1 ПРС, тенге:</strong>
                                        <input type="float" name="avg_prs_cost_fot" value={{$row->avg_prs_cost_fot}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Средняя стоимость КРС:</strong>
                                        <input type="float" name="avg_krs_cost" value={{$row->avg_krs_cost}} class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Амортизация (тенге на тонну нефти):</strong>
                                        <input type="float" name="amort" value={{$row->amort}} class="form-control" placeholder="Пример: 0.4">
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
