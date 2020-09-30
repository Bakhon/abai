@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('omgca.create') }}">+</a>
            </div>
            <h1 style="color:#fff">Форма ввода данных ОМГ ЦА</h1>
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
                        <th>{{__('app.action')}}</th>
                    </tr>
                    @foreach ($omgca as $item)
                        <tr>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->ngdu->name }}</td>
                            <td>{{ $item->cdng->name }}</td>
                            <td>{{ $item->gu->name }}</td>
                            <td>{{ $item->zu->name }}</td>
                            <td>{{ $item->well->name }}</td>
                            <td>
                                <form action="{{ route('omgca.destroy',$item->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('omgca.edit',$item->id) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-primary" href="{{ route('omgca.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>

                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {!! $omgca->links() !!}
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
