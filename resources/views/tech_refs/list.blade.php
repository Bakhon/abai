@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('techrefssource.index') }}" class="list-group-item list-group-item-action">
                        Источник данных </a>
                    <a href="{{url('/')}}/ru/ecorefscompaniesids" class="list-group-item list-group-item-action">
                        Наименование компании</a>
                    <a href="{{url('/')}}/ru/ecorefsavgprs" class="list-group-item list-group-item-action">
                        Средняя продолжительность 1 ПРС, сут</a>
                    <a href="{{ route('ecorefscost.index') }}" class="list-group-item list-group-item-action">
                        Входные параметры для модуля Ibrahim </a>
                </div>
            </div>
        </div>
    </div>
@endsection
