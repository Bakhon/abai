@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('corpall.create') }}">+</a>
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
                                <th>Компания:</th>
                                <th>Корпоративные KPI:</th>
                                <th>Тип:</th>
                                <th>Дата:</th>
                                <th>Значение:</th>
                                <!-- <th width="220px">{{__('app.action')}}</th> -->
                            </tr>
                            @foreach ($corpall as $item)
                                <tr>
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->corpkpi->name}}</td>
                                    <td>{{ $item->type->name}}</td>
                                    <td>{{ $item->date}}</td>
                                    <td>{{ $item->value}}</td>
                                    <td>
                                        <form action="{{ route('corpall.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('corpall.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $corpall->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
