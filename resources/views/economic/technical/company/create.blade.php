@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('economic.technical.list') }}" class="btn btn-info">
                {{ __('forecast.return_menu') }}
            </a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('tech_struct_company.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tech_struct_company.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Название компании:</strong>
                                        <input type="text" name="name" class="form-control"
                                               placeholder="Пример: АО МангистауМунайГаз">
                                        <strong>Сокращённое название компании:</strong>
                                        <input type="text" name="short_name" class="form-control"
                                               placeholder="Пример: MMG">
                                        <strong>ID в базе TBD:</strong>
                                        <input type="number" name="tbd_id" class="form-control"
                                               placeholder="Пример: 2000000002">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">{{__('app.submit')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
