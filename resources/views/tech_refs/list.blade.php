@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{ route('techrefssource.index') }}" class="list-group-item list-group-item-action">
                        Источники данных </a>
                    <a href="{{ route('techrefsbkns.index') }}" class="list-group-item list-group-item-action">
                        БКНС</a>
                    <a href="{{ route('techrefscompany.index') }}" class="list-group-item list-group-item-action">
                        Компании</a>
                    <a href="{{ route('techrefsfield.index') }}" class="list-group-item list-group-item-action">
                        Месторождения</a>
                    <a href="{{ route('techrefsngdu.index') }}" class="list-group-item list-group-item-action">
                        НГДУ</a>
                    <a href="{{ route('techrefscdng.index') }}" class="list-group-item list-group-item-action">
                        СДНГ</a>
                    <a href="{{ route('techrefsgu.index') }}" class="list-group-item list-group-item-action">
                        ГУ</a>
                    <a href="{{ route('techrefsproductiondata.index') }}" class="list-group-item list-group-item-action">
                        Нефть / Жидкость / Отработанные дни / ПРС</a>
                </div>
            </div>
        </div>
    </div>
@endsection
