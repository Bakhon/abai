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
            @foreach($modules as $module)
                <button class="btn btn-outline-secondary @if($module['name'] == 'monitoring') active @endif"
                        type="button" data-tab="{{$module['name']}}">{{$module['title']}}</button>
            @endforeach
        </nav>

        @foreach($modules as $index => $module)
            <div class="tabs tab-{{$module['name']}}
            @if($module['name'] == 'monitoring') active @endif">

                @foreach($sections as $section)
                    @if ($section->module != $module['name'])
                        @continue
                    @endif

                    <div class="section mb-4">
                        @if($section->title_trans)
                            <h5>{{trans($section->title_trans)}}</h5>
                        @endif
                        @foreach($fieldCodes as $fieldCode => $fieldName)
                            @php
                                if ($fieldCode == 'load_las') {
                                    $permission_name = $module['name'].' '.$section->code;
                                } else {
                                    $permission_name = $module['name'].' '.$fieldCode.' '.$section->code;
                                }
                                $permission = $permissions->get($permission_name);
                            @endphp

                            @if (!$permission)
                                @continue
                            @endif

                            <div class="form-check">
                                <input
                                        class="form-check-input"
                                        id="permission_{{$permission->id}}"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{$permission->id}}"
                                        {{!empty($role) && $role->permissions->where('id', $permission->id)->isNotEmpty() ? 'checked' : ''}}
                                >
                                <label class="form-check-label" for="permission_{{$permission->id}}">
                                    {{$module['name'] == 'bigdata' ? trans('bd.'.$fieldCode) : $fieldName}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="col-12 mt-3 text-center">
        <button type="submit" class="btn btn-success">{{trans('app.save')}}</button>
    </div>
</div>
@section('custom_js')
    <script>
        $(function () {
            $('.permissions .navbar button').click(function () {
                $('.tab-' + $(this).data('tab')).addClass('active').siblings().removeClass('active')
                $(this).addClass('active').siblings().removeClass('active')
            })
        })
    </script>
    <style>
        .tabs {
            display: none;
        }

        .tabs.active {
            display: block;
        }
    </style>
@endsection