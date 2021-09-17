@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ url()->previous() }}" class="btn btn-info">
                {{ __('app.back') }}
            </a>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
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
                                <th>{{ __('economic_reference.name') }}:</th>
                                <th>{{ __('economic_reference.date_added') }}:</th>
                                <th>{{ __('economic_reference.author_added') }}:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->name }}</td>
                                    <td>{{ $log->created_at  }}</td>
                                    <td>{{ $log->author->name  }}</td>
                                    <td>
                                        <form action="{{ route('economic.log.destroy', $log->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                {{__('app.delete')}}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $logs->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
