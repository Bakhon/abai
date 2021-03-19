@extends('admin.layouts.app')

@section('content')
<div class="container">
    @if ($message = Session::get('message'))
        <div class="alert alert-success alert-block">	
            <button type="button" class="close" data-dismiss="alert">×</button>	        
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="table-page accessesTable">
        <h1>Запрос №{{$access->id}}</h1>

        <div class="accessInfo">
            <span>Дата:</span>
            <p class="default">{{date('d-m-Y', strtotime($access->updated_at))}}</p>
            <span>ФИО пользователя:</span>
            <p class="default">{{$access->user_name}}</p>
            <span>Модуль:</span>
            <p class="default"><span>{!! $access->module_icon !!}</span><span>{{$access->module_name}}</span></p>
            @if($access->status == 'process')
            <span>Статус запроса:</span>
            <p class="status">На рассмотрении</p>
            <form action="{{route('accesses-update')}}" method="post">
                @csrf
                <input type="text" name="access_id" value="{{$access->id}}" class="d-none">
                <input type="text" name="user_id" value="{{$access->user_id}}" class="d-none">
                <input type="text" name="module_id" value="{{$access->module_id}}" class="d-none">
                <select name="access_status" id="status">
                    <option value="close">Отклонить</option>
                    <option value="open">Разрешить</option>
                </select>
                <button type="submit">Сохранить</button>
            </form>
            @else
            <span>Статус запроса:</span>
                @if($access->status == 'open')
                    <p class="status green">Одобрено</p>
                @elseif($access->status == 'close')
                    <p class="status red">Отклонено</p>
                @endif
            <a href="{{route('accesses-list')}}" class="back">Назад</a>
            @endif
        </div>

    </div>
</div>


@endsection
<style>
    .accessInfo {
    display: table;
    margin: 0;
    background: #424586;
    border-radius: 2px;
    padding: 25px 30px;
}

.accessInfo p {
    display: table;
    margin: 0 0 22px;
    font-size: 16px;
    color: #fff;
}

.accessInfo p span {
    display: inline-table;
    vertical-align: middle;
    margin: 0 15px 0 0;
}

.accessInfo p span svg {
    height: 24px;
}

.accessInfo p span svg * {
    fill: #fff;
}

.accessInfo form {
    display: table;
    margin: 25px 0 0;
}

.accessInfo form select {
    display: inline-table;
    margin: 0 25px 0 0;
    vertical-align: middle;
    padding: 8px 18px;
    border: none;
    background: #272953;
    border-radius: 3px;
    color: #fff;
}

.accessInfo form button {
    border: none;
    display: inline-table;
    vertical-align: middle;
    margin: 0;
    padding: 7px 25px;
    background: #38c172;
    color: #fff;
    border-radius: 3px;
}

.accessInfo form select:hover,.accessInfo form button:hover {
    cursor: pointer;
    opacity: 0.7;
}
.accessInfo p.status {
    background: #6cb2eb;
    padding: 8px 25px;
    border-radius: 3px;
}
.accessInfo>span {
    color: #fff;
    margin: 0 0 10px;
    display: table;
    font-size: 12px;
}

.accessInfo p {
    width: 100%;
    border-bottom: 1px solid #5c60af;
    padding-bottom: 5px;
}

.accessInfo p.status {
    border: none;
    text-align: center;
}
.accessInfo a.back {
    display: table;
    padding: 8px 18px;
    background: #656a8a;
    border-radius: 3px;
    color: #fff;
    text-align: center;
    margin: 0 auto;
    width: 100%;
}
.accessInfo p.status.green {
    background: #38c172;
}

.accessInfo p.status.red {
    background: #f56c6c;
}
</style>