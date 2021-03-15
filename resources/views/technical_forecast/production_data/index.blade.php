@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_data_list') }}" class="btn btn-info">
                Вернуться в справочник</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="{{ route('tech_data_forecast.create') }}">+</a>
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
                            <th>Источник:</th>
                            <th>Гу:</th>
                            <th>Скважина:</th>
                            <th>Дата:</th>
                            <th>Добыча нефти тыс.т:</th>
                            <th>Добыча жидкости тыс.т:</th>
                            <th>Отработанные дни:</th>
                            <th>ПРС:</th>
                            <th>Добавлено: дата / автор:</th>
                            <th>Изменение: дата / автор:</th>
                            <th width="220px">{{__('app.action')}}</th>
                        </tr>
                        @foreach ($technicalDataForecast as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->source->name }}</td>
                                <td>{{ $item->gu->name }}</td>
                                <td>{{ $item->well_id }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->oil }}</td>
                                <td>{{ $item->liquid }}</td>
                                <td>{{ $item->days_worked }}</td>
                                <td>{{ $item->prs }}</td>
                                <td>{{ $item->created_at }} / {{ optional($item->author)->name  }}</td>
                                <td>{{ $item->updated_at }} / {{ optional($item->editor)->name  }}</td>
                                <td>
                                    <form action="{{ route('tech_data_forecast.destroy',$item->id) }}"
                                          method="POST">
                                        <a class="btn btn-primary"
                                           href="{{ route('tech_data_forecast.edit',$item->id) }}">{{__('app.edit')}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $technicalDataForecast->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
