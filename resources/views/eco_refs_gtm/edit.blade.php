@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('eco_refs_gtm.index') }}"
                           class="btn btn-primary">
                            {{__('app.back')}}
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('eco_refs_gtm.update', $gtm->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>
                                            {{ __('economic_reference.name') }}
                                        </strong>

                                        <input name="name"
                                               class="form-control"
                                               value="{{$gtm->name}}">
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
                                                        {{$item->id==$gtm->company_id ? 'selected' : ''}}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>
                                            {{ __("economic_reference.price") }}
                                        </strong>

                                        <input type="float"
                                               name="price"
                                               value="{{$gtm->price}}"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>
                                            {{ __("economic_reference.pi") }}
                                        </strong>

                                        <input type="float"
                                               name="price"
                                               value="{{$gtm->pi}}"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>
                                            {{ __('economic_reference.comment') }}
                                        </strong>

                                        <input name="comment"
                                               class="form-control"
                                               value="{{$gtm->comment}}">
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
