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
                    <a href="{{ route('discontcoefbar_data_upload') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('economic_reference.upload_excel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ecorefs-header">
                    <a class="btn btn-success" href="{{ route('ecorefsdiscontcoefbar.create') }}">+</a>
                    <div class="ecorefs-title">{{__('economic_reference.eco_refs_discont_coef_bar')}}</div>
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
                            <th style="width: 220px;">Компания:</th>
                            <th style="width: 180px;">Направление:</th>
                            <th style="width: 200px;">Маршрут:</th>
                            <th style="width: 150px;">Дата:</th>
                            <th>Коэффициент баррелизации:</th>
                            <th>Дисконт ($/баррель):</th>
                            <th>Стоимость нефти (экспорт - $/баррель, внутренний рынок - тенге/тонна):</th>
                            <th width="220px">{{__('app.action')}}</th>
                        </tr>
                        @foreach ($ecorefsdiscontcoefbar as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->scfa->name}}</td>
                                <td>{{ $item->company->name}}</td>
                                <td>{{ $item->direction->name }}</td>
                                <td>{{ $item->route->name }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->barr_coef }}</td>
                                <td>{{ $item->discont }}</td>
                                <td>{{ $item->macro }}</td>
                                <td>
                                    <form action="{{ route('ecorefsdiscontcoefbar.destroy',$item->id) }}" method="POST">
                                        <a class="btn btn-primary" href="{{ route('ecorefsdiscontcoefbar.edit',$item->id) }}">{{__('app.edit')}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  class="btn btn-danger mt-2">{{__('app.delete')}}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $ecorefsdiscontcoefbar->links() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    @import "../../css/ecorefs.css";
</style>
