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

    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ecorefs-header">
                        <a class="btn btn-success" href="{{ route('ecorefselectprsbrigcost.create') }}">+</a>
                        <div class="ecorefs-title">{{__('economic_reference.eco_refs_select_prs_brig_cost')}}</div>
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
                                <th>Компания:</th>
                                <th>Дата:</th>
                                <th>Стоимость электроэнергии, тенге/кВт*ч:</th>
                                <th>Стоимость транспортировки и подготовки, тенге/тонна:</th>
                                <th>Стоимость 1 сутки бригады ПРС, тенге:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefselectprsbrigcost as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->scfa->name}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->elect_cost }}</td>
                                    <td>{{ $item->trans_prep_cost }}</td>
                                    <td>{{ $item->prs_brigade_cost }}</td>
                                    <td>
                                        <form action="{{ route('ecorefselectprsbrigcost.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefselectprsbrigcost.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefselectprsbrigcost->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    @import "../../css/ecorefs.css";
</style>