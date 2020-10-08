@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('ecorefsdiscontcoefbar.create') }}">+</a>
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
                                <th>Компания:</th>
                                <th>Направление:</th>
                                <th>Маршрут:</th>
                                <th>Дата:</th>
                                <th>Коэффициент баррелизации:</th>
                                <th>Дисконт:</th>
                                <th>Стоимость нефти:</th>
                                <th>Макро:</th>
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
                                    <td>{{ $item->oil_cost }}</td>
                                    <td>{{ $item->macro }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsdiscontcoefbar.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsdiscontcoefbar.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
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
    </div>
@endsection
