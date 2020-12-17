@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('marab1.create') }}">+</a>
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
                                <th>Тип:</th>
                                <th>Дата:</th>
                                <th>Прирост извлекаемых запасов нефти и конденсата по категории А:</th>
                                <th>Прирост извлекаемых запасов нефти и конденсата по категории B:</th>
                                <th>Прирост извлекаемых запасов нефти и конденсата по категории C1:</th>
                                <!-- <th width="220px">{{__('app.action')}}</th> -->
                            </tr>
                            @foreach ($marab1 as $item)
                                <tr>
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->type->name}}</td>
                                    <td>{{ $item->date}}</td>
                                    <td>{{ $item->A_category }}</td>
                                    <td>{{ $item->B_category }}</td>
                                    <td>{{ $item->C1_category }}</td>
                                    <td>
                                        <form action="{{ route('marab1.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('marab1.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $marab1->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
