@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-9">
                <table class="table table-responsive ">
                    <tbody class="w-100">
                    @foreach($data['2021']['opiu'] as $key=> $value)
                        @if(is_array($value))
                            @foreach($value as $k=> $v)
                                <tr>
                                    <td style="color: white;">{{$k}}</td>
                                    <td style="color: white;">{{$v}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td  style="color: white;">{{$key}}</td>
                                <td  style="color: white;">{{$value}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-3">
                <div class="row">
                    <form action="" method="get" id="calc">
                        <div class="col-12">
                            <label for="" style="color: white;">Компания</label>
                            <select name="company" class="form-control" id="scfa" onchange="$('#calc').submit()">
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}" @if(request('company') == $company->id) selected @endif>{{$company->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="" style="color: white;">Версия БП</label>
                            <select name="scenario" class="form-control" id="scfa" onchange="$('#calc').submit()">
                                <option value="2" @if(request('company') == 2) selected @endif>Корр. 5 на 2021-2025</option>
                                <option value="3" @if(request('company') == 3) selected @endif>Корр. 6 на 2021-2025</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="">Цена на нефть Brent</label>
                            <select name="oil" id="oil" class="form-control" onchange="$('#calc').submit()">
                                <option value="30, 40, 50, 50">на 2021-2025 г. 30-40-50-50-50</option>
                                <option value="30, 40, 50, 50">на 2021-2025 г. 40-50-50-50-50</option>
                                <option value="30, 40, 50, 50">на 2021-2025 г. 30-40-60-60-60</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="">Курс $/Тенге</label>
                            <select name="rate" id="rate" class="form-control"  onchange="$('#calc').submit()">
                                <option value="430,430,430,430,430">Корр. 1 на 2021-2025 г. 430-430-430-430-430</option>
                                <option value="450,450,450,450,450">Корр. 1 на 2021-2025 г. 450-450-450-450-450</option>
                                <option value="480,480,480,480,480">Корр. 1 на 2021-2025 г. 480-480-480-480-480</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection