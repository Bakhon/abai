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
                        <form action="{{ route('economic.technical.ngdu.store') }}"
                              method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('forecast.field') }}:</strong>
                                        <select class="form-control" name="field_id">
                                            @foreach ($fields as $field)
                                                <option value="{{ $field->id }}">
                                                    {{ $field->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <strong>{{ __('forecast.NGDU') }}:</strong>
                                        <input type="text" name="name" class="form-control">
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
