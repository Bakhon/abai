@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('ecorefsrentequipelectservcost.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ecorefsrentequipelectservcost.update', $row->id) }}" method="POST">
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
                                        <strong>Оборудование:</strong>
                                        <select class="form-control" name="equip_id">
                                        <option>Select Item</option>
                                        @foreach ($equip as $item)
                                            @if($item->id==$row->equip_id)
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
                                        <strong>Стоимость аренды, тенге:</strong>
                                        <input type="number" name="rent_cost" value={{$row->rent_cost}} class="form-control" placeholder="Пример: 55000">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Стоимость оборудования, тенге:</strong>
                                        <input type="number" name="equip_cost" value={{$row->equip_cost}} class="form-control" placeholder="Пример: 8500000">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Расход электроэнергии, кВт*ч:</strong>
                                        <input type="number" name="elect_cons" value={{$row->elect_cons}} class="form-control" placeholder="Пример: 50">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Стоимость суточного обслуживания, тенге:</strong>
                                        <input type="number" name="dayli_serv_cost" value={{$row->dayli_serv_cost}} class="form-control" placeholder="Пример: 10000">
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