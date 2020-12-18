@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('abd12.create') }}">+</a>
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
                                <th>KPI Абдулгафарова:</th>
                                <th>Тип:</th>
                                <!-- <th>Дата:</th> -->
                                <th>Целевые параметры:</th>
                                <!-- <th>Факт:</th> -->
                                <th>Остаток дней для исполнения:</th>
                                <th>Ожидаемое исполнение:</th>
                
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($abd12 as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->abdkpi->name}}</td>
                                    <td>{{ $item->type->name}}</td>
                                    <!-- <td>{{ $item->date_col }}</td> -->
                                    <td>{{ $item->aim_params }}</td>
                                    <!-- <td>{{ $item->fact }}</td> -->
                                    <td>{{ $item->remaining_days }}</td>
                                    <td>{{ $item->expactations_percentage }}</td>
                                    <td>
                                        <form action="{{ route('abd12.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('abd12.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $abd12->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
