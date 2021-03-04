@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_refs_list') }}" class="btn btn-info">
                Вернуться в справочник</a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('techrefsfield.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('techrefsfield.store') }}" method="POST">
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
                                        <strong>Месторождение:</strong>
                                        <input type="text" name="name" class="form-control"
                                               placeholder="Пример: Месторождение">
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
