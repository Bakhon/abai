@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('economic.technical.list') }}" class="btn btn-info">
                {{ __('forecast.return_menu') }}
            </a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary"
                           href="{{ route('economic.technical.forecast.index') }}">
                            {{__('app.back')}}
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('economic.technical.forecast.update', $model->id) }}"
                              method="POST"> @csrf @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('forecast.source_data') }}:</strong>
                                        <select class="form-control" name="source_id">
                                            <option>Select Item</option>
                                            @foreach ($source as $item)
                                                @if($item->id==$model->source_id)
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
                                        <strong>{{ __('forecast.gu') }}:</strong>
                                        <select class="form-control" name="gu_id">
                                            <option>Select Item</option>
                                            @foreach ($gu as $item)
                                                @if($item->id==$model->gu_id)
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
                                        <strong>{{ __('forecast.well') }}:</strong>
                                        <input type="text" name="well_id" class="form-control" placeholder=""
                                               value="{{$model->well_id}}">
                                        <strong>{{ __('forecast.date') }}:</strong>
                                        <input type="date" name="date" class="form-control" placeholder=""
                                               value="{{$model->date}}">
                                        <strong>{{ __('forecast.oil-production') }}:</strong>
                                        <input type="text" name="oil" class="form-control" placeholder=""
                                               value="{{$model->oil}}">
                                        <strong>{{ __('forecast.extraction-liquid') }}:</strong>
                                        <input type="text" name="liquid" class="form-control" placeholder=""
                                               value="{{$model->liquid}}">
                                        <strong>{{ __('forecast.days-worked') }}:</strong>
                                        <input type="text" name="days_worked" class="form-control" placeholder=""
                                               value="{{$model->days_worked}}">
                                        <strong>{{ __('forecast.prs') }}:</strong>
                                        <input type="text" name="prs" class="form-control" placeholder=""
                                               value="{{$model->prs}}">
                                        <strong>{{ __('forecast.comment') }}:</strong>
                                        <input type="text" name="comment" class="form-control" placeholder=""
                                               value="{{$model->comment }}">
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