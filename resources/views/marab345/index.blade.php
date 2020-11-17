@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-success" href="{{ route('marab345.create') }}">+</a>
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
                                <th>KPI Марабаева:</th>
                                <th>Тип:</th>
                                <th>Дата:</th>
                                <th>Фактические затраты на себестоимость добычи нефти (себестоимость за минусом износа и амортизации, налогов и резервов):</th>
                                <th>Фактические затраты капитального вложения:</th>
                                <th>Операционные и капитальные затраты крупных проектов:</th>
                                <!-- <th width="220px">{{__('app.action')}}</th> -->
                            </tr>
                            @foreach ($marab345 as $item)
                                <tr>
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->company->name}}</td>
                                    <td>{{ $item->marabkpi->name}}</td>
                                    <td>{{ $item->type->name}}</td>
                                    <td>{{ $item->date_col}}</td>
                                    <td>{{ $item->fact_zatraty_na_sebestoimost_dobychi_nefti }}</td>
                                    <td>{{ $item->fact_zatraty_kapitalnogo_vlozhenia }}</td>
                                    <td>{{ $item->opearacionnyie_kapitalnyie_zatraty_krupnyh_proektov }}</td>
                                    <td>
                                        <form action="{{ route('marab345.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('marab345.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $marab345->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
