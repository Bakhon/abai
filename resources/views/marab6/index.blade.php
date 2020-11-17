@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('marab6.create') }}">+</a>
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
                                <th>Тип:</th>
                                <!-- <th>Дата:</th> -->
                                <th>Целевые даты для исполнения:</th>
                                <th>Остаток дней для исполнения:</th>
                                <th>Ожидаемая вероятность иполнения ответственным:</th>
                                <!-- <th width="220px">{{__('app.action')}}</th> -->
                            </tr>
                            @foreach ($marab6 as $item)
                                <tr>
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->type->name}}</td>
                                    <!-- <td>{{ $item->date_col}}</td> -->
                                    <td>{{ $item->aim_dates }}</td>
                                    <td>{{ $item->remained_days }}</td>
                                    <td>{{ $item->completion_probability }}</td>
                                    <td>
                                        <form action="{{ route('marab6.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('marab6.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $marab6->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
