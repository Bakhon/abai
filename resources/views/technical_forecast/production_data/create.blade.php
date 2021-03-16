@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_data_list') }}" class="btn btn-info">
                {{ __('forecast.return_menu') }}</a>
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
                        <form action="{{ route('tech_data_forecast.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('forecast.source_data') }}:</strong>
                                        <select class="form-control" name="source_id">
                                            <option>Select Item</option>
                                            @foreach ($source as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <strong>{{ __('forecast.gu') }}:</strong>
                                        <select class="form-control" name="gu_id">
                                            <option>Select Item</option>
                                            @foreach ($gu as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <strong>{{ __('forecast.well') }}:</strong>
                                        <input type="text" name="well_id" class="form-control"
                                               placeholder="Пример: JET_0023">
                                        <strong>{{ __('forecast.date') }}:</strong>
                                        <input type="date" name="date" class="form-control"
                                               placeholder="2020-20-02">
                                        <strong>{{ __('forecast.oil-production') }}:</strong>
                                        <input type="text" name="oil" class="form-control"
                                               placeholder="Пример: 65,50">
                                        <strong>{{ __('forecast.extraction-liquid') }}:</strong>
                                        <input type="text" name="liquid" class="form-control"
                                               placeholder="Пример: 403,31">
                                        <strong>{{ __('forecast.days-worked') }}:</strong>
                                        <input type="text" name="days_worked" class="form-control"
                                               placeholder="Пример: 29,58">
                                        <strong>{{ __('forecast.prs') }}:</strong>
                                        <input type="text" name="prs" class="form-control"
                                               placeholder="Пример: 1">
                                        <strong>{{ __('forecast.comment') }}:</strong>
                                        <input type="text" name="comment" class="form-control"
                                               placeholder="Пример: Исправление некорректного значения">
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
