@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('ecorefsrenttax.create') }}">+</a>
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
                                <th>Сценарий/Факт:</th>
                                <th>Мировая цена, от:</th>
                                <th>Мировая цена, до:</th>
                                <th>Ставка, в %:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefsrenttax as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->world_price_beg }}</td>
                                    <td>{{ $item->world_price_end }}</td>
                                    <td>{{ $item->rate }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsrenttax.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsrenttax.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefsrenttax->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
