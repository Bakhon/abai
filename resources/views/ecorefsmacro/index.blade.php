@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('eco_refs_list') }}"
               class="btn btn-info">
                {{ __('economic_reference.return_menu') }}
            </a>
        </div>
    </div>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="list-group text-center">
                    <a href="{{ route('macro_data_upload') }}"
                       class="list-group-item list-group-item-action">
                        {{ __('economic_reference.upload_excel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col p-4 bg-light" id="app">
            <economic-data-macro-component></economic-data-macro-component>
    </div> --}}

    <div class="row justify-content-center" style="margin-top: 75px;">
        <div class="col-md-12">
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
                            <th style="width: 120px;">Дата:</th>
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
                                        <button type="submit" class="btn btn-danger" style="margin-top: 7px;">{{__('app.delete')}}</button>
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

@endsection

<style>
    .container-main {
        overflow-x: auto;
    }
</style>
