@extends('admin.layouts.app')

@section('content')
<div class="container">

    <div class="table-page accessesTable">
        <h1>Список запросов</h1>

        <div class="table-page__wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th class="">
                            Дата и время
                        </th>
                        <th>
                            Пользователь
                        </th>
                        <th>
                            Модуль
                        </th>
                        <th>
                            Статус
                        </th>
                        <th>
                            Управление
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($accesses as $item)
                    <tr>
                        <td>
                            <p class="default">{{date('d-m-Y', strtotime($item->updated_at))}}</p>
                        </td>
                        <td>
                            <p class="default">{{$item->user_name}}</p>
                        </td>
                        <td>
                            <p class="default"><span>{!! $item->module_icon !!}</span><span>{{$item->module_name}}</span></p>
                        </td>
                        <td>
                            <p class="default {{$item->status}}">
                            @if($item->status == 'open')
                                Одобрено
                            @elseif($item->status == 'close')
                                Отклонено
                            @elseif($item->status == 'process')
                                На рассмотрении
                            @endif 
                            </p>
                        </td>
                        <td>
                            <div class="links">
                                <a href="/admin/accesses-list/{{$item->id}}/edit" class="links__item links__item_edit"></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>


@endsection

<style>
.accessesTable p.default {
    display: table;
    margin: 0;
}

.accessesTable p.default svg {
    height: 20px;
    width: 20px;
    margin: 0 10px;
}

.accessesTable p.default svg * {
    fill: #fff;
}
.accessesTable p.default {
    color: #fff;
    font-size: 14px;
    font-weight: 300;
    text-shadow: none;
    float: unset;
}

.accessesTable p.default.open {
    color: #38c172;
}

.accessesTable p.default.close {
    color: #ff9491;
    opacity: 1;
}
</style>