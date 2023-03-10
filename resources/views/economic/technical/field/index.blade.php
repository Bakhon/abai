@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('economic.technical.list') }}" class="btn btn-info">
                {{ __('forecast.return_menu') }}
            </a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success"
                           href="{{ route('economic.technical.field.create') }}">+</a>
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
                                <th>{{ __('forecast.company') }}:</th>
                                <th>{{ __('forecast.field') }}:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($models as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->company->name }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <form action="{{ route('economic.technical.field.destroy',$item->id) }}"
                                              method="POST">
                                            <a class="btn btn-primary"
                                               href="{{ route('economic.technical.field.edit',$item->id) }}">
                                                {{__('app.edit')}}
                                            </a>
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
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
