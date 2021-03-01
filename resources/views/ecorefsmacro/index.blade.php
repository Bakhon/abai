@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('ecorefsmacro.create') }}">+</a>
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
                                <th>Дата:</th>
                                <th>Курс доллара, тенге:</th>
                                <th>Курс рубля, тенге:</th>
                                <th>Инфляция, в % на конец периода:</th>
                                <th>Мировая стоимость барреля нефти, доллар:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefsmacro as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->ex_rate_dol }}</td>
                                    <td>{{ $item->ex_rate_rub }}</td>
                                    <td>{{ $item->inf_end }}</td>
                                    <td>{{ $item->barrel_world_price }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsmacro.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsmacro.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefsmacro->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
