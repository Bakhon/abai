@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('marab1.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('marab1.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Компания:</strong>
                                        <select class="form-control" name="company_id">
                                        <option>Select Item</option>
                                        @foreach ($company as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Тип:</strong>
                                        <select class="form-control" name="type_id">
                                        <option>Select Item</option>
                                        @foreach ($type as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Дата:</strong>
                                        <input type="date" name="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Прирост извлекаемых запасов нефти и конденсата по категории А:</strong>
                                        <input type="float" name="A_category" class="form-control" placeholder="Пример: 7.2">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Прирост извлекаемых запасов нефти и конденсата по категории B:</strong>
                                        <input type="float" name="B_category" class="form-control" placeholder="Пример: 7.2">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Прирост извлекаемых запасов нефти и конденсата по категории C1:</strong>
                                        <input type="float" name="C1_category" class="form-control" placeholder="Пример: 7.2">
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
