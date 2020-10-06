@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('ecorefsannualprodvolume.create') }}">+</a>
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
                                <th>Объем годовой добычи, от:</th>
                                <th>Объем годовой добычи, до:</th>
                                <th>Ставка НДПИ, в %:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefsannualprodvolume as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->annual_prod_volume_beg }}</td>
                                    <td>{{ $item->annual_prod_volume_end }}</td>
                                    <td>{{ $item->ndpi }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsannualprodvolume.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsannualprodvolume.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefsannualprodvolume->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
