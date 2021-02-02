@extends('admin.layouts.app')

@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            <div class="x_panel">
                <h1>История посещения страниц {{$user->username}}</h1>
                <a class="btn btn-primary float-left" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="row logs">
                    <div class="col-9">
                        <table class="table table-bordered history__fields">
                            <tr>
                                <th>Время посещения</th>
                                <th>Url</th>
                            </tr>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{$log->created_at}}</td>
                                    <td>{{url($log->url)}}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{$logs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    body {
        color: white !important;
    }

    .table {
        color: white !important;
    }
</style>
