@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('watermeasurement.create') }}">+</a>
            </div>
            <h1 style="color:#fff">Лабораторные данные по промысловой жидкости</h1>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>Дата отбора</th>
                        <th>Прочие объекты</th>
                        <th>НГДУ</th>
                        <th>ЦДНГ</th>
                        <th>ГУ</th>
                        <th>ЗУ</th>
                        <th>Скважина</th>
                        <th>НСО3-</th>
                        <th>СО32-</th>
                        <th>SO42-</th>
                        <th>Cl-</th>
                        <th>Ca2+</th>
                        <th>Mg2+</th>
                        <th>Na+K+</th>
                        <th width="220px">{{__('app.action')}}</th>
                    </tr>
                    @foreach ($wm as $item)
                        <tr>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->other_objects->name }}</td>
                            <td>{{ $item->ngdu->name }}</td>
                            <td>{{ $item->cdng->name }}</td>
                            <td>{{ $item->gu->name }}</td>
                            <td>{{ $item->zu->name }}</td>
                            <td>{{ $item->well->name }}</td>
                            <td>{{ $item->hydrocarbonate_ion }}</td>
                            <td>{{ $item->carbonate_ion }}</td>
                            <td>{{ $item->sulphate_ion }}</td>
                            <td>{{ $item->chlorum_ion }}</td>
                            <td>{{ $item->calcium_ion }}</td>
                            <td>{{ $item->magnesium_ion }}</td>
                            <td>{{ $item->potassium_ion_sodium_ion }}</td>
                            <td>
                                <form action="{{ route('watermeasurement.destroy',$item->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('watermeasurement.edit',$item->id) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-primary" href="{{ route('watermeasurement.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    {{-- <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button> --}}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {!! $wm->links() !!}
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
