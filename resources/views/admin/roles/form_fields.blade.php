<div class="row col-4">
    <div class="col-12 mb-4">
        <label>Название</label>
        <div class="form-label-group">
            <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder=""
                    value="{{!empty($role) ? $role->name : ''}}"
            >
        </div>
    </div>
    <div class="col-12 permissions">
        <h2>Список разрешений</h2>
        <nav class="navbar navbar-light justify-content-start mb-3">
            <button class="btn btn-outline-secondary active" type="button" data-tab="monitoring">Модуль мониторинг</button>
            <button class="btn btn-outline-secondary ml-3" type="button" data-tab="economic">Модуль экономика</button>
            <button class="btn btn-outline-secondary ml-3" type="button" data-tab="bigdata">Модуль Прототип БД</button>
            <button class="btn btn-outline-secondary ml-3" type="button" data-tab="tr">Модуль ТР</button>
            <button class="btn btn-outline-secondary ml-3" type="button" data-tab="viscenter">Модуль центр визуализации</button>
            <button class="btn btn-outline-secondary ml-3" type="button" data-tab="podborGno">Модуль Подбор ГНО</button>
            <button class="btn btn-outline-secondary ml-3" type="button" data-tab="paegtm">Модуль Подбор ГТМ</button>
        </nav>
        <div class="tabs tab-monitoring active">
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('monitoring view main')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('monitoring view main')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('monitoring view main')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('monitoring view main')->id}}">Просмотр главной
                    страницы</label>
            </div>
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('monitoring make report')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('monitoring make report')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('monitoring make report')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('monitoring make report')->id}}">Создание сводного
                    отчета</label>
            </div>
            <div class="form-check mb-4">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('monitoring view pipes map')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('monitoring view pipes map')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('monitoring view pipes map')->id)->isNotEmpty() ? 'checked' : ''}}
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
                                    {{!empty($role) && $role->permissions->where('id', $permissions->get('monitoring '.$fieldCode.' '.$code)->id)->isNotEmpty() ? 'checked' : ''}}
                            >
                            <label class="form-check-label"
                                   for="permission_{{$permissions->get('monitoring '.$fieldCode.' '.$code)->id}}">{{$fieldName}}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="tabs tab-economic">
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('economic view main')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('economic view main')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('economic view main')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('economic view main')->id}}">Просмотр главной
                    страницы</label>
            </div>
        </div>
        
        <div class="tabs tab-podborGno">
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('podborGno view main')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('podborGno view main')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('podborGno view main')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('podborGno view main')->id}}">Просмотр главной
                    страницы</label>
            </div>
        </div>

        <div class="tabs tab-paegtm">
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('paegtm view main')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('paegtm view main')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('paegtm view main')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('paegtm view main')->id}}">Просмотр главной
                    страницы</label>
            </div>
        </div>
        <div class="tabs tab-bigdata">
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('bigdata view main')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('bigdata view main')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('bigdata view main')->id)->isNotEmpty() ? 'checked' : ''}}>
                <label class="form-check-label" for="permission_{{$permissions->get('bigdata view main')->id}}">Просмотр главной</label>
            </div>
            <div class="form-check mb-4">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('bigdata load_las')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('bigdata load_las')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('bigdata load_las')->id)->isNotEmpty() ? 'checked' : ''}}>
                <label class="form-check-label" for="permission_{{$permissions->get('bigdata load_las')->id}}">Загрузка las</label>
            </div>
            @foreach([
                'file_status' => 'Справочник статус файла',
                'file_type' => 'Справочник тип файла',
                'recording_method' => 'Справочник метод записи',
                'recording_state' => 'Справочник статус записи',
                'stem_section' => 'Справочник секция ствола',
                'stem_type' => 'Справочник тип ствола',
            ] as $code => $name)
                <div class="section mb-4">
                    <h5>{{$name}}</h5>
                    @foreach([
                        'list' => 'Просмотр списка',
                        'create' => 'Создание',
                        'read' => 'Просмотр',
                        'update' => 'Изменение',
                        'delete' => 'Удаление',
                    ] as $fieldCode => $fieldName)
                        <div class="form-check">
                            <input
                                    class="form-check-input"
                                    id="permission_{{$permissions->get('bigdata '.$fieldCode.' '.$code)->id}}"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{$permissions->get('bigdata '.$fieldCode.' '.$code)->id}}"
                                    {{!empty($role) && $role->permissions->where('id', $permissions->get('bigdata '.$fieldCode.' '.$code)->id)->isNotEmpty() ? 'checked' : ''}}
                            >
                            <label class="form-check-label"
                                   for="permission_{{$permissions->get('bigdata '.$fieldCode.' '.$code)->id}}">{{$fieldName}}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="tabs tab-tr">
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('tr view main')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('tr view main')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('tr view main')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('tr view main')->id}}">Просмотр главной
                    страницы</label>
                    
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('tr edit')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('tr edit')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('tr edit')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('tr edit')->id}}">Редактирование
                    </label>
            </div>
        </div>
        <div class="tabs tab-viscenter">
            <div class="form-check">
                <input
                        class="form-check-input"
                        id="permission_{{$permissions->get('visualcenter view main')->id}}"
                        type="checkbox"
                        name="permissions[]"
                        value="{{$permissions->get('visualcenter view main')->id}}"
                        {{!empty($role) && $role->permissions->where('id', $permissions->get('visualcenter view main')->id)->isNotEmpty() ? 'checked' : ''}}
                >
                <label class="form-check-label"
                       for="permission_{{$permissions->get('visualcenter view main')->id}}">Просмотр главной
                    страницы</label>
            </div>
        </div>

    </div>
    <div class="col-12 mt-3 text-center">
        <button type="submit" class="btn btn-success">Сохранить</button>
    </div>
</div>
@section('custom_js')
    <script>
        $(function(){
            $('.permissions .navbar button').click(function(){
                $('.tab-'+$(this).data('tab')).addClass('active').siblings().removeClass('active')
                $(this).addClass('active').siblings().removeClass('active')
            })
        })
    </script>
    <style>
        .tabs{
            display: none;
        }
        .tabs.active{
            display: block;
        }
    </style>
@endsection