@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('eco_refs_list') }}"
               class="btn btn-info">
                {{ __('economic_reference.return_menu') }}
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ecorefs-header">
                        <a class="btn btn-success" href="{{ route('gtm-decline-rates.create') }}">+</a>
                        <div class="ecorefs-title">{{__('paegtm.gtm_decline_rate')}}</div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>ДЗО:</th>
                                <th>Месторождение:</th>
                                <th>Год:</th>
                                <th>Базового фонда:</th>
                                <th>ВНС:</th>
                                <th>ВНС ГРП:</th>
                                <th>ГС:</th>
                                <th>ГС ГРП:</th>
                                <th>ЗБС:</th>
                                <th>ЗБГС:</th>
                                <th>УГЛ:</th>
                                <th>ГРП:</th>
                                <th>ВБД:</th>
                                <th>ПВЛГ:</th>
                                <th>РИР:</th>
                                <th>ПВР:</th>
                                <th>ОПЗ:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($declineRates as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->org->name_ru }}</td>
                                    <td>{{ $item->geo->name_ru }}</td>
                                    <td>{{ $item->date->format('Y') }}</td>
                                    <td>{{ $item->base_fund }}</td>
                                    <td>{{ $item->vns }}</td>
                                    <td>{{ $item->vns_grp }}</td>
                                    <td>{{ $item->gs }}</td>
                                    <td>{{ $item->gs_grp }}</td>
                                    <td>{{ $item->zbs }}</td>
                                    <td>{{ $item->zbgs }}</td>
                                    <td>{{ $item->ugl }}</td>
                                    <td>{{ $item->grp }}</td>
                                    <td>{{ $item->vbd }}</td>
                                    <td>{{ $item->pvlg }}</td>
                                    <td>{{ $item->rir }}</td>
                                    <td>{{ $item->pvr }}</td>
                                    <td>{{ $item->opz }}</td>
                                    <td>
                                        <form action="{{ route('gtm-decline-rates.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('gtm-decline-rates.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="mt-2">
                    {{ $declineRates->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    @import "/css/ecorefs.css";
</style>