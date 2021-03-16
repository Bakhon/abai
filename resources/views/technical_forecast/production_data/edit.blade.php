@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_data_list') }}" class="btn btn-info">
                Вернуться в справочник</a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('tech_data_forecast.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tech_data_forecast.update', $technicalDataForecast->id) }}"
                              method="POST"> @csrf @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Источник:</strong>
                                        <select class="form-control" name="source_id">
                                            <option>Select Item</option>
                                            @foreach ($source as $item)
                                                @if($item->id==$technicalDataForecast->source_id)
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
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ГУ:</strong>
                                        <select class="form-control" name="gu_id">
                                            <option>Select Item</option>
                                            @foreach ($gu as $item)
                                                @if($item->id==$technicalDataForecast->gu_id)
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
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скважина:</strong>
                                        <input type="text" name="well_id" class="form-control" placeholder=""
                                               value="{{$technicalDataForecast->well_id}}">
                                        <strong>Дата:</strong>
                                        <input type="date" name="date" class="form-control" placeholder=""
                                               value="{{$technicalDataForecast->date}}">
                                        <strong>Добыча нефти, тыс.т:</strong>
                                        <input type="text" name="oil" class="form-control" placeholder=""
                                               value="{{$technicalDataForecast->oil}}">
                                        <strong>Добыча жидкости тыс.т:</strong>
                                        <input type="text" name="liquid" class="form-control" placeholder=""
                                               value="{{$technicalDataForecast->liquid}}">
                                        <strong>Отработанные дни:</strong>
                                        <input type="text" name="days_worked" class="form-control" placeholder=""
                                               value="{{$technicalDataForecast->days_worked}}">
                                        <strong>ПРС:</strong>
                                        <input type="text" name="prs" class="form-control" placeholder=""
                                               value="{{$technicalDataForecast->prs}}">
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