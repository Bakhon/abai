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
                           href="{{ route('economic.technical.ngdu.index') }}">
                            {{__('app.back')}}
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('economic.technical.ngdu.update', $model->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('forecast.field') }}:</strong>
                                        <select class="form-control" name="field_id">
                                            @foreach ($fields as $field)
                                                @if($field->id === $model->field_id)
                                                    <option value="{{ $field->id }}" selected>
                                                        {{ $field->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $field->id }}">
                                                        {{ $field->name }}
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
                                        <strong>{{ __('forecast.NGDU') }}:</strong>
                                        <input type="text" name="name" class="form-control"
                                               value="{{$model->name}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{__('app.submit')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
