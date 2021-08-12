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

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="list-group text-center">
                    <a href="{{ route('tarifytn_data_upload') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('economic_reference.upload_excel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row justify-content-center" style="margin-top: 75px;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('ecorefstarifytn.create') }}">+</a>
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
                                <th>Сценарий/Факт:</th>
                                <th>Филиал:</th>
                                <th>Компания:</th>
                                <th>Направление:</th>
                                <th>Маршрут:</th>
                                <th>Маршрут ТН:</th>
                                <th>Валюта:</th>
                                <th>Дата:</th>
                                <th>Тариф за тонну:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefstarifytn as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->branch->name}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->direction->name }}</td>
                                    <td>{{ $item->route->name }}</td>
                                    <td>{{ $item->routetn->name }}</td>
                                    <td>{{ $item->exc->name }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->tn_rate }}</td>
                                    <td>
                                        <form action="{{ route('ecorefstarifytn.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefstarifytn.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="margin-top: 7px;">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefstarifytn->links() !!}
                    </div>
                </div>
            </div>
    </div>
@endsection
