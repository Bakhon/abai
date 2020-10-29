@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('antiecotwo.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('antiecotwo.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сценарий/Факт:</strong>
                                        <select class="form-control" name="sc_fa">
                                        <option>Select Item</option>
                                        @foreach ($sc_fa as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
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
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ценовой сценарий, $/баррель:</strong>
                                        <input type="float" name="oil_cost" class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Стоимость продажи нефти на внешний рынок 1 (к примеру: КТК) доллар/баррель:</strong>
                                        <input type="float" name="oil_cost_exp_one" class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Стоимость продажи нефти на внешний рынок 2 (к примеру: КТО) доллар/баррель:</strong>
                                        <input type="float" name="oil_cost_exp_two" class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Стоимость продажи нефти на внешний рынок 3 (к примеру: КТО) доллар/баррель:</strong>
                                        <input type="float" name="oil_cost_exp_three" class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Стоимость продажи нефти на местный рынок 1 (к примеру: АНПЗ) тенге/тонна:</strong>
                                        <input type="float" name="oil_cost_ins_one" class="form-control" placeholder="Пример: 0.4">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Стоимость продажи нефти на местный рынок 2 (к примеру: ПНХЗ) тенге/тонна:</strong>
                                        <input type="float" name="oil_cost_ins_two" class="form-control" placeholder="Пример: 0.4">
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
