@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('economic.cost.index') }}"
                           class="btn btn-primary">
                            {{__('app.back')}}
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('economic.cost.update', $model->id) }}"
                              method="POST"
                              class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>
                                        {{ __('economic_reference.source_data') }}
                                    </strong>

                                    <select name="sc_fa" class="form-control">
                                        <option>
                                            {{ __('economic_reference.select_item') }}
                                        </option>

                                        @foreach ($scFas as $item)
                                            <option value="{{ $item->id }}"
                                                    {{$item->id === $model->sc_fa ? 'selected' : ''}}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>
                                        {{ __('economic_reference.company') }}
                                    </strong>

                                    <select name="company_id" class="form-control">
                                        <option>
                                            {{ __('economic_reference.select_item') }}
                                        </option>

                                        @foreach ($companies as $item)
                                            <option value="{{ $item->id }}"
                                                    {{$item->id === $model->company_id ? 'selected' : ''}}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>
                                        {{ __('economic_reference.pes') }}
                                    </strong>

                                    <select name="pes_id" class="form-control">
                                        <option :value="null">
                                            {{ __('economic_reference.select_item') }}
                                        </option>

                                        @foreach ($pes as $item)
                                            <option value="{{ $item->id }}"
                                                    {{$item->id === $model->pes_id ? 'selected' : ''}}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>
                                        {{ __('economic_reference.month-year') }}
                                    </strong>

                                    <input type="date"
                                           name="date"
                                           value="{{$model->date}}"
                                           class="form-control">
                                </div>
                            </div>

                            @foreach($fillableFloatKeys as $key)
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>
                                            {{ __("economic_reference.$key") }}
                                        </strong>

                                        <input type="float"
                                               name="{{$key}}"
                                               value="{{$model->$key}}"
                                               class="form-control">
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>
                                        {{ __('economic_reference.comment') }}
                                    </strong>

                                    <input type="float"
                                           name="comment"
                                           class="form-control"
                                           value="{{$model->comment}}">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit"
                                        class="btn btn-primary">
                                    {{__('app.submit')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
