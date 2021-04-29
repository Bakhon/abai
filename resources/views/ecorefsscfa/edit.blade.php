@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('ecorefsscfa.index') }}"
                           class="btn btn-primary">
                            {{__('app.back')}}
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('ecorefsscfa.update', $scFa->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{__('economic_reference.source_data')}}:</strong>

                                        <input type="text"
                                               name="name"
                                               value="{{$scFa->name}}"
                                               class="form-control">
                                    </div>

                                    <div class="form-check">
                                        <input id="is_forecast"
                                               name="is_forecast"
                                               type="checkbox"
                                               {{$scFa->is_forecast ? 'checked' : ''}}
                                               class="form-check-input">

                                        <label for="is_forecast"
                                               class="form-check-label text-black-50">
                                            {{__('economic_reference.scenario')}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit"
                                            class="btn btn-primary">
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