@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{url('/')}}/ru/ecorefsscfa" class="list-group-item list-group-item-action">
                        Сценарий/Факт
                    </a>
                    <a href="{{url('/')}}/ru/ecorefsbranchid" class="list-group-item list-group-item-action">
                        Филиал
                    </a>
                    <a href="{{url('/')}}/ru/ecorefscompaniesids" class="list-group-item list-group-item-action"> Наименование компании</a>
                    <a href="{{url('/')}}/ru/ecorefsequipid" class="list-group-item list-group-item-action"> Наименование оборудования</a>
                    <a href="{{url('/')}}/ru/ecorefsrouteid" class="list-group-item list-group-item-action"> Маршрут</a>
                    <a href="{{url('/')}}/ru/ecorefsroutetnid" class="list-group-item list-group-item-action"> Маршрут ТН</a>
                    <a href="{{url('/')}}/ru/ecorefsdirection" class="list-group-item list-group-item-action"> Направление</a>
                    <a href="{{url('/')}}/ru/ecorefsannualprodvolume" class="list-group-item list-group-item-action"> Налог на добычу полезных ископаемых, Нефть</a>
                    <a href="{{url('/')}}/ru/ecorefsavgmarketprice" class="list-group-item list-group-item-action"> ЭТП</a>
                    <a href="{{url('/')}}/ru/ecorefsdiscontcoefbar" class="list-group-item list-group-item-action"> Коэф баррелизации/Дисконт/Стоимость нефти/Макро</a>
                    <a href="{{url('/')}}/ru/ecorefselectprsbrigcost" class="list-group-item list-group-item-action"> Стоимость электроэнергии/Стоимость транспортировки и подготовки 1 м3/ Стоимость 1 сутки бригады ПРС</a>
                    <a href="{{url('/')}}/ru/ecorefsndorates" class="list-group-item list-group-item-action"> Средняя ставка НДПИ по НДО</a>
                    <a href="{{url('/')}}/ru/ecorefsrentequipelectservcost" class="list-group-item list-group-item-action"> Стоимость оборудования/Стоимость аренды/Расход электроэнергии/Стоимость суточного обслуживания</a>
                    <a href="{{url('/')}}/ru/ecorefsservicetime" class="list-group-item list-group-item-action"> Средний срок службы оборудования</a>
                    <a href="{{url('/')}}/ru/ecorefstarifytn" class="list-group-item list-group-item-action"> Тарифы ТН/Протяженность</a>
                    <a href="{{url('/')}}/ru/ecorefsempper" class="list-group-item list-group-item-action"> Процент реализации</a>
                    <a href="{{url('/')}}/ru/ecorefsmacro" class="list-group-item list-group-item-action"> Курс доллара/Курс рубля/Инфляция, в % на конец периода</a>
                    <a href="{{url('/')}}/ru/ecorefsrenttax" class="list-group-item list-group-item-action"> Рентный налог</a>
                    <a href="{{url('/')}}/ru/ecorefsexc" class="list-group-item list-group-item-action"> Тенге/Доллар/Рубль</a>
                    <a href="{{url('/')}}/ru/ecorefsprocdob" class="list-group-item list-group-item-action"> Процент от добычи на реализацию</a>
                    <a href="{{url('/')}}/ru/ecorefsavgprs" class="list-group-item list-group-item-action"> Средняя продолжительность 1 ПРС, сут</a>
                    <a href="{{url('/')}}/ru/ecorefsavgprs" class="list-group-item list-group-item-action"> Средняя продолжительность 1 ПРС, сут</a>
                    <a href="{{ route('ecorefscost.index') }}" class="list-group-item list-group-item-action">
                        Входные параметры для модуля Ibrahim </a>
                </div>
            </div>
        </div>
    </div>
@endsection
