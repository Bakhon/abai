@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_data_list') }}" class="btn btn-info">
                Вернуться в справочник</a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('tech_struct_source.create') }}">+</a>
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
                                <th>Источник данных:</th>
                                <th>Дата обновления/добавления:</th>
                                <th>Автор обновления/добавления:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($technicalForecast as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>{{ optional($item->user)->name  }}</td>
                                    <td>
                                        <form action="{{ route('tech_struct_source.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('tech_struct_source.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $technicalForecast->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
