@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('omgca.create') }}">+</a>
            </div>
            <h1 style="color:#fff">База данных ОМГ ДДНГ</h1>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <td colspan="1">Узел отбора</td>
                        <td colspan="3">Фактические данные ОМГ ЦА</td>
                        <td rowspan="2">{{__('app.action')}}</td>
                    </tr>
                    <tr>
                        <td>ГУ</td>
                        <td>Год</td>
                        <td>Планируемая дозировка, г/м3 </td>
                        <td>Техрежим Qв , тыс.м³/год </td>
                    </tr>
                    @foreach ($omgca as $item)
                        <tr>
                            <td>{{ $item->gu->name }}</td>
                            <td>{{ date('Y', strtotime($item->date)) }}</td>
                            <td>{{ $item->plan_dosage }}</td>
                            <td>{{ $item->q_v }}</td>
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
