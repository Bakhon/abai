@extends('admin.layouts.app')

@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="x_panel">
                <h1>Создание роли</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="row col-4">
                        <div class="col-12 mb-4">
                            <label>Название</label>
                            <div class="form-label-group">
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder=""
                                >
                            </div>
                        </div>
                        <div class="col-12">
                            <h2>Список разрешений</h2>
                            <h4>Модуль Мониторинг</h4>
                            <div class="form-check">
                                <input
                                        class="form-check-input"
                                        id="permission_{{$permissions->get('monitoring view main')->id}}"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{$permissions->get('monitoring view main')->id}}"
                                >
                                <label class="form-check-label"
                                       for="permission_{{$permissions->get('monitoring view main')->id}}">Просмотр главной страницы</label>
                            </div>
                            <div class="form-check">
                                <input
                                        class="form-check-input"
                                        id="permission_{{$permissions->get('monitoring make report')->id}}"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{$permissions->get('monitoring make report')->id}}"
                                >
                                <label class="form-check-label"
                                       for="permission_{{$permissions->get('monitoring make report')->id}}">Создание сводного отчета</label>
                            </div>
                            <div class="form-check mb-4">
                                <input
                                        class="form-check-input"
                                        id="permission_{{$permissions->get('monitoring view pipes map')->id}}"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{$permissions->get('monitoring view pipes map')->id}}"
                                >
                                <label class="form-check-label"
                                       for="permission_{{$permissions->get('monitoring view pipes map')->id}}">Просмотр карты</label>
                            </div>
                            @foreach($sections as $code => $name)
                                <div class="section mb-4">
                                    <h5>{{$name}}</h5>
                                    @foreach([
                                        'list' => 'Просмотр списка',
                                        'create' => 'Создание',
                                        'read' => 'Просмотр',
                                        'update' => 'Изменение',
                                        'delete' => 'Удаление',
                                        'export' => 'Экспорт в excel',
                                        'view history' => 'Просмотр истории',
                                    ] as $fieldCode => $fieldName)
                                        <div class="form-check">
                                            <input
                                                    class="form-check-input"
                                                    id="permission_{{$permissions->get('monitoring '.$fieldCode.' '.$code)->id}}"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{$permissions->get('monitoring '.$fieldCode.' '.$code)->id}}"
                                            >
                                            <label class="form-check-label"
                                                   for="permission_{{$permissions->get('monitoring '.$fieldCode.' '.$code)->id}}">{{$fieldName}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<style>
    body {
        color: white !important;
    }

    .table {
        color: white !important;
    }
</style>
