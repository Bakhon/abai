@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('tech_struct_source.index') }}" class="list-group-item list-group-item-action">
                        Источники данных </a>
                    <a href="{{ route('tech_struct_bkns.index') }}" class="list-group-item list-group-item-action">
                        БКНС</a>
                    <a href="{{ route('tech_struct_company.index') }}" class="list-group-item list-group-item-action">
                        Компании</a>
                    <a href="{{ route('tech_struct_field.index') }}" class="list-group-item list-group-item-action">
                        Месторождения</a>
                    <a href="{{ route('tech_struct_ngdu.index') }}" class="list-group-item list-group-item-action">
                        НГДУ</a>
                    <a href="{{ route('tech_struct_cdng.index') }}" class="list-group-item list-group-item-action">
                        СДНГ</a>
                    <a href="{{ route('tech_struct_gu.index') }}" class="list-group-item list-group-item-action">
                        ГУ</a>
                    <a href="{{ route('tech_data_forecast.index') }}" class="list-group-item list-group-item-action">
                        Нефть / Жидкость / Отработанные дни / ПРС</a>
                </div>
            </div>
        </div>
    </div>
@endsection
