@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('dzodaily.create') }}">+</a>
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
                                <th>Дата:</th>
                                <th>ДЗО:</th>
                                <th>Добыча нефти план(oil_plan):</th>
                                <th>Добыча нефти ОПЕК план(oil_opek_plan):</th>
                                <th>Добыча нефти факт(oil_fact):</th>
                                <th>Товарный остаток(tovarnyi_ostatok_nefti_today):</th>
                
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($dzodaily as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->date}}</td>
                                    <td>{{ $item->dzo}}</td>
                                    <td>{{ $item->oil_plan}}</td>
                                    <td>{{ $item->oil_opek_plan }}</td>
                                    <td>{{ $item->oil_fact }}</td>
                                    <td>{{ $item->tovarnyi_ostatok_nefti_today }}</td>
                                    <td>
                                        <form action="{{ route('dzodaily.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('dzodaily.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $dzodaily ?? ''->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
