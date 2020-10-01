@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('omguhe.create') }}">+</a>
            </div>
            <h1 style="color:#fff">Форма ввода данных ОМГ УХЭ</h1>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th colspan="6">Узел отбора</th>
                        <th colspan="6">Фактические данные от УХЭ</th>
                        <th rowspan="2">{{__('app.action')}}</th>
                    </tr>
                    <tr>
                        <th>Месторождение</th>
                        <th>НГДУ</th>
                        <th>ЦДНГ</th>
                        <th>ГУ</th>
                        <th>ЗУ</th>
                        <th>Скважина</th>
                        <th>Дата</th>
                        <th>Фактическая дозировка, г/м3</th>
                        <th>Суточный расход ингибитора, кг/сут</th>
                        <th>Расход ингибитора за месяц, т/мес</th>
                        <th>Простой дозатора, сутки</th>
                        <th>Причина</th>
                    </tr>
                    @foreach ($omguhe as $item)
                        <tr>
                            <td>
                                @if ($item->field === 1)
                                    Узень
                                @else
                                    Карамандыбас
                                @endif
                            </td>
                            <td>{{ $item->ngdu->name }}</td>
                            <td>{{ $item->cdng->name }}</td>
                            <td>{{ $item->gu->name }}</td>
                            <td>{{ $item->zu->name }}</td>
                            <td>{{ $item->well->name }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->current_dosage }}</td>
                            <td>{{ $item->daily_inhibitor_flowrate }}</td>
                            <td>{{ $item->monthly_inhibitor_flowrate }}</td>
                            <td>{{ $item->out_of_service_оf_dosing }}</td>
                            <td>{{ $item->reason }}</td>
                            <td>
                                <form action="{{ route('omguhe.destroy',$item->id) }}" method="POST">
                                    {{-- <a class="btn btn-primary" href="{{ route('omguhe.edit',$item->id) }}"><i class="fas fa-edit"></i></a> --}}
                                    <a class="btn btn-primary" href="{{ route('omguhe.show',$item->id) }}"><i class="fas fa-eye"></i></a>
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
                {!! $omguhe->links() !!}
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
