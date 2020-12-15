@extends('layouts.app')

@section('content')
<div class="col p-4" id="app">
            <div class="card-header float-right">
                <a class="btn btn-success" href="{{ route('corrosioncrud.export') }}"><i class="fas fa-file-export"></i></a>
                <a class="btn btn-success" href="{{ route('corrosioncrud.create') }}">+</a>
            </div>
            <h1 style="color:#fff">База данных по скорости коррозии</h1>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <td>Месторождение</td>
                        <td>НГДУ</td>
                        <td>ЦДНГ</td>
                        <td>ГУ</td>
                        <td>Дата начала</td>
                        <td>Дата окончания </td>
                        <td>Фоновая скорость </td>
                        <td>Дата начало замера скорости коррозии с реагентом</td>
                        <td>Дата окончания замера скорости коррозии с реагентом</td>
                        <td>Скорость коррозии</td>
                        <td>{{__('app.action')}}</td>
                    </tr>
                    @foreach ($corrosion as $item)
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
                            <td>{{ $item->start_date_of_background_corrosion }}</td>
                            <td>{{ $item->final_date_of_background_corrosion }}</td>
                            <td>{{ $item->background_corrosion_velocity }}</td>
                            <td>{{ $item->start_date_of_corrosion_velocity_with_inhibitor_measure }}</td>
                            <td>{{ $item->final_date_of_corrosion_velocity_with_inhibitor_measure }}</td>
                            <td>{{ $item->corrosion_velocity_with_inhibitor }}</td>
                            <td>
                                <form action="{{ route('corrosioncrud.destroy',$item->id) }}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('corrosioncrud.edit',$item->id) }}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-primary" href="{{ route('corrosioncrud.show',$item->id) }}"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-primary" href="{{ route('corrosioncrud.history',$item->id) }}"><i class="fas fa-history"></i></a>
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
                {!! $corrosion->links() !!}
            </div>
        </div>
@endsection
<style>
    .table{
        color: white !important;
    }
</style>
