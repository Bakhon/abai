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
                        <a class="btn btn-success" href="{{ route('ecorefsrentequipelectservcost.create') }}">+</a>
                        <div class="ecorefs-title">{{__('economic_reference.eco_refs_rent_equip_select_serv_cost')}}</div>
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
                                <th style="width: 200px;">Сценарий/Факт:</th>
                                <th style="width: 220px;">Компания:</th>
                                <th>Оборудование:</th>
                                <th style="width: 150px;">Дата:</th>
                                <th>Стоимость аренды, тенге:</th>
                                <th>Стоимость оборудования, тенге:</th>
                                <th>Расход электроэнергии, кВт*ч:</th>
                                <th>Стоимость суточного обслуживания, тенге:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefsrentequipelectservcost as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->equip->name }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->rent_cost }}</td>
                                    <td>{{ $item->equip_cost }}</td>
                                    <td>{{ $item->elect_cons }}</td>
                                    <td>{{ $item->dayli_serv_cost }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsrentequipelectservcost.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsrentequipelectservcost.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefsrentequipelectservcost->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
