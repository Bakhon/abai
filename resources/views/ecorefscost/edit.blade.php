@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('ecorefscost.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ecorefscost.update', $ecoRefsCost->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.source_data') }}:</strong>
                                        <select class="form-control" name="sc_fa">
                                            <option>{{ __('economic_reference.select_item') }}</option>
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
                                        <strong>{{ __('economic_reference.company') }}:</strong>
                                        <select class="form-control" name="company_id">
                                            <option>{{ __('economic_reference.select_item') }}</option>
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
                                        <strong>{{ __('economic_reference.month-year') }}:</strong>
                                        <input type="date" name="date" value="{{$ecoRefsCost->date}}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.variable') }}:</strong>
                                        <input type="float" name="variable" class="form-control"
                                               value="{{$ecoRefsCost->variable}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.fix_noWRpayroll') }}:</strong>
                                        <input type="float" name="fix_noWRpayroll" class="form-control"
                                               value="{{$ecoRefsCost->fix_noWRpayroll}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.fix_payroll') }}:</strong>
                                        <input type="float" name="fix_payroll" class="form-control"
                                               value="{{$ecoRefsCost->fix_payroll}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.fix_nopayroll') }}:</strong>
                                        <input type="float" name="fix_nopayroll" class="form-control"
                                               value="{{$ecoRefsCost->fix_nopayroll}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.fix') }}:</strong>
                                        <input type="float" name="fix" class="form-control"
                                               value="{{$ecoRefsCost->fix}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.gaoverheads') }}:</strong>
                                        <input type="float" name="gaoverheads" class="form-control"
                                               value="{{$ecoRefsCost->gaoverheads}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.wr_nopayroll') }}:</strong>
                                        <input type="float" name="wr_nopayroll" class="form-control"
                                               value="{{$ecoRefsCost->wr_nopayroll}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.wr_payroll') }}:</strong>
                                        <input type="float" name="wr_payroll" class="form-control"
                                               value="{{$ecoRefsCost->wr_payroll}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.wo') }}:</strong>
                                        <input type="float" name="wo" class="form-control"
                                               value="{{$ecoRefsCost->wo}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.net_back') }}:</strong>
                                        <input type="float" name="net_back" class="form-control"
                                               value="{{$ecoRefsCost->net_back}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.amort') }}:</strong>
                                        <input type="float" name="net_back" class="form-control"
                                               value="{{$ecoRefsCost->amort}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{ __('economic_reference.comment') }}:</strong>
                                        <input type="float" name="comment" class="form-control"
                                               value="{{$ecoRefsCost->comment}}">
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
