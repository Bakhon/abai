@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('abd46.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('abd46.update', $row->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>KPI Абдулгафарова:</strong>
                                        <select class="form-control" name="abdkpi_id">
                                        <option>Select Item</option>
                                        @foreach ($abdkpi as $item)
                                            @if($item->id==$row->abdkpi_id)
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
                                <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Дата:</strong>
                                        <input type="date" name="date_col" class="form-control">
                                    </div>
                                </div> -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Целевые параметры:</strong>
                                        <input type="date" name="aim_params" value={{$row->aim_params}} class="form-control" >
                                    </div>
                                </div>
                                <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Факт:</strong>
                                        <input type="date" name="fact" value={{$row->fact}} class="form-control">
                                    </div>
                                </div> -->
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Остаток дней для исполнения:</strong>
                                        <input type="integer" name="remaining_days" value={{$row->remaining_days}} class="form-control" placeholder="Пример: 5">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ожидаемое исполнение:</strong>
                                        <input type="float" name="expactations_percentage" value={{$row->expactations_percentage}} class="form-control" placeholder="Пример: 0.9">
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
