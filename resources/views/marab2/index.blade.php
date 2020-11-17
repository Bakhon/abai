@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('marab2.create') }}">+</a>
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
                                <th>Дивиденды:</th>
                                <th>Вклад в уставной капитал:</th>
                                <th>Выдача займов/финансовая помощь с КМГ:</th>
                                <th>Возврат займов и фин. помощи:</th>
                                <th>Возврат уставного капитала:</th>
                                <th>Прочие:</th>
                                <!-- <th width="220px">{{__('app.action')}}</th> -->
                            </tr>
                            @foreach ($marab2 as $item)
                                <tr>
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->type->name}}</td>
                                    <td>{{ $item->date_col }}</td>
                                    <td>{{ $item->dividends }}</td>
                                    <td>{{ $item->vklad_v_ustavnoy_kapital }}</td>
                                    <td>{{ $item->vydacha_zaimov }}</td>
                                    <td>{{ $item->vozvrat_zaimov }}</td>
                                    <td>{{ $item->vozvrat_ustavnogo_kapitala }}</td>
                                    <td>{{ $item->others }}</td>
                                    <td>
                                        <form action="{{ route('marab2.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('marab2.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $marab2->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
