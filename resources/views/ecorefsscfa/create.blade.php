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
                        <form action="{{ route('ecorefsscfa.store') }}"
                              method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{__('economic_reference.source_data')}}:</strong>

                                        <input type="text"
                                               name="name"
                                               class="form-control">
                                    </div>

                                    <div class="form-check">
                                        <input id="is_fact"
                                               name="is_fact"
                                               type="checkbox"
                                               class="form-check-input">

                                        <label for="is_fact"
                                               class="form-check-label text-black-50">
                                            {{__('economic_reference.factual_data')}}
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
