@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_refs_list') }}" class="btn btn-info">
                Вернуться в справочник</a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('techrefscompany.create') }}">+</a>
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
                                <th>Название компании:</th>
                                <th>Сокращённое название компании:</th>
                                <th>ID в базе TBD:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($techRefsCompany as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->short_name }}</td>
                                    <td>{{ $item->tbd_id }}</td>
                                    <td>
                                        <form action="{{ route('techrefscompany.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('techrefscompany.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $techRefsCompany->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
