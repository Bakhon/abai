@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('marab2.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('marab2.update', $row->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
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
                                        <strong>Тип:</strong>
                                        <select class="form-control" name="type_id">
                                        <option>Select Item</option>
                                        @foreach ($type as $item)
                                            @if($item->id==$row->type_id)
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
                                        <strong>Дивиденды:</strong>
                                        <input type="integer" name="dividends" value={{$row->dividends}} class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Вклад в уставной капитал:</strong>
                                        <input type="integer" name="vklad_v_ustavnoy_kapital" value={{$row->vklad_v_ustavnoy_kapital}} class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Выдача займов/финансовая помощь с КМГ:</strong>
                                        <input type="integer" name="vydacha_zaimov" value={{$row->vydacha_zaimov}} class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Возврат займов и фин. помощи:</strong>
                                        <input type="integer" name="vozvrat_zaimov" value={{$row->vozvrat_zaimov}} class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Возврат уставного капитала:</strong>
                                        <input type="integer" name="vozvrat_ustavnogo_kapitala" value={{$row->vozvrat_ustavnogo_kapitala}} class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Прочие:</strong>
                                        <input type="integer" name="others" value={{$row->others}} class="form-control">
                                    </div>
                                </div>
                                
                                <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Итого,  тыс. тенге:</strong>
                                        <input type="integer" name="total" value={{$row->total}} class="form-control">
                                    </div>
                                </div> -->
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
