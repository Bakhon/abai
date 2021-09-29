@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (count($errors) > 0)
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('gtm-decline-rates.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('gtm-decline-rates.update', 1) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ДЗО:</strong>
                                        <select class="form-control" name="org_id" required="required">
                                            @foreach($orgs as $org)
                                                <option value="{{ $org->id }}" @php $gtmDeclineRate->org->id == $org->id ? 'selected="selected"' : '' @endphp>{{ $org->name_ru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Месторождение:</strong>
                                        <select class="form-control" name="geo_id" required="required">
                                            @foreach($geos as $geo)
                                                <option value="{{ $org->id }}" @php $gtmDeclineRate->geo->id == $geo->id ? 'selected="selected"' : '' @endphp>{{ $geo->name_ru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Год:</strong>
                                        <select class="form-control" name="date" required="required">
                                            @foreach(range(date('Y', strtotime('+2 year')), date('Y', strtotime('-2 year'))) as $year)
                                                <option value="{{ $year }}" @php $gtmDeclineRate->date->format('Y') == $year ? 'selected="selected"' : '' @endphp>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Базового фонда:</strong>
                                        <input value="{{ $gtmDeclineRate->base_fund }}" type="text" name="base_fund" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ВНС:</strong>
                                        <input value="{{ $gtmDeclineRate->vns }}" type="text" name="vns" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ВНС ГРП:</strong>
                                        <input value="{{ $gtmDeclineRate->vns_grp  }}" type="text" name="vns_grp" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ГС:</strong>
                                        <input value="{{ $gtmDeclineRate->gs }}" type="text" name="gs" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ГС ГРП:</strong>
                                        <input value="{{ $gtmDeclineRate->gs_grp }}" type="text" name="gs_grp" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ЗБС:</strong>
                                        <input value="{{ $gtmDeclineRate->zbs }}" type="text" name="zbs" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ЗБГС:</strong>
                                        <input value="{{ $gtmDeclineRate->zbgs }}" type="text" name="zbgs" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>УГЛ:</strong>
                                        <input value="{{ $gtmDeclineRate->ugl }}" type="text" name="ugl" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ГРП:</strong>
                                        <input value="{{ $gtmDeclineRate->grp }}" type="text" name="grp" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ВБД:</strong>
                                        <input value="{{ $gtmDeclineRate->vbd }}" type="text" name="vbd" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ПВЛГ:</strong>
                                        <input value="{{ $gtmDeclineRate->pvlg }}" type="text" name="pvlg" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>РИР:</strong>
                                        <input value="{{ $gtmDeclineRate->rir }}" type="text" name="rir" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ПВР:</strong>
                                        <input value="{{ $gtmDeclineRate->pvr }}" type="text" name="pvr" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ОПЗ:</strong>
                                        <input value="{{ $gtmDeclineRate->opz }}" type="text" name="opz" class="form-control" required="required">
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
