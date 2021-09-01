@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('eco_refs_cost.index') }}"
                           class="btn btn-primary">
                            {{__('app.back')}}
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('eco_refs_cost.update', $ecoRefsCost->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
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
                                                @if($item->id==$ecoRefsCost->sc_fa)
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
                                        <strong>
                                            {{ __('economic_reference.company') }}
                                        </strong>

                                        <select name="company_id" class="form-control">
                                            <option>
                                                {{ __('economic_reference.select_item') }}
                                            </option>

                                            @foreach ($companies as $item)
                                                @if($item->id==$ecoRefsCost->company_id)
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
                                        <strong>
                                            {{ __('economic_reference.month-year') }}
                                        </strong>

                                        <input type="date"
                                               name="date"
                                               value="{{$ecoRefsCost->date}}"
                                               class="form-control">
                                    </div>
                                </div>

                                @foreach(\App\Models\EcoRefsCost::FILLABLE_FLOAT_KEYS as $key)
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>
                                                {{ __("economic_reference.$key") }}
                                            </strong>

                                            <input type="float"
                                                   name="{{$key}}"
                                                   value="{{$ecoRefsCost->$key}}"
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
                                               value="{{$ecoRefsCost->comment}}">
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
