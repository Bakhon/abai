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
                <h1>Настройка прав пользователя {{$user->username}}</h1>
                <a class="btn btn-primary float-left" href="{{ url()->previous() }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="row col-4">
                        <div class="col-12">
                            <h3>Список ролей</h3>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        id="role_{{$role->id}}"
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{$role->id}}"
                                        {{$user->roles->where('id', $role->id)->isNotEmpty() ? 'checked' : ''}}
                                    >
                                    <label class="form-check-label" for="role_{{$role->id}}">{{$role->name}}</label>
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
