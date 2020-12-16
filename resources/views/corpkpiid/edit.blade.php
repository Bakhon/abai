@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('corpkpiid.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('corpkpiid.update',$corpkpiid->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>KPI Корпоративные:</strong>
                                        <input type="text" name="name" class="form-control" placeholder="Заключение/ реализация контрактов на недропользование, включая сделки по слияниям и поглощениям" value="{{$marabkpiid->name}}">
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
