@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-9">
                <table class="table table-responsive ">
                    <tbody class="w-100">
                    @foreach($datas as $key=> $value)
                        @if(is_array($value))
                                <tr>
                                    <td style="color: white;">{{$value['name']}}</td>
                                    <td style="color: white;">{{$value['value']}}</td>
                                </tr>
                        @else
                            <tr>
                                <td  style="color: white;">{{$key}}</td>
                                <td  style="color: white;">{{$value}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach($data as $key=> $value)
                        <tr>
                            <td colspan="2">{{$key}}</td>
                        </tr>
                        @if(is_array($value))
                            @foreach($value as $k => $v)
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
{{--                    @foreach($data['2021']['opiu'] as $key=> $value)--}}
{{--                        @if(is_array($value))--}}
{{--                            @foreach($value as $k=> $v)--}}
{{--                                <tr>--}}
{{--                                    <td style="color: white;">{{$k}}</td>--}}
{{--                                    <td style="color: white;">{{$v}}</td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <tr>--}}
{{--                                <td  style="color: white;">{{$key}}</td>--}}
{{--                                <td  style="color: white;">{{$value}}</td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
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
                                <option value="30, 40, 50, 50, 50">на 2021-2025 г. 30-40-50-50-50</option>
                                <option value="30, 40, 50, 55, 60">на 2021-2025 г. 40-50-50-50-50</option>
                                <option value="30, 40, 50, 60, 60">на 2021-2025 г. 30-40-60-60-60</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="">Курс $/Тенге</label>
                            <select name="rates" id="rates" class="form-control"  onchange="$('#calc').submit()">
                                <option value="430,430,430,430,430">Корр. 1 на 2021-2025 г. 430-430-430-430-430</option>
                                <option value="450,450,450,450,450">Корр. 1 на 2021-2025 г. 450-450-450-450-450</option>
                                <option value="480,480,480,480,480">Корр. 1 на 2021-2025 г. 480-480-480-480-480</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="">База распределения затрат</label>
                            <select name="cost_allocation_base" id="wells" class="form-control"  onchange="$('#calc').submit()">
                                <option value="1">По раздельному учету</option>
                                <option value="2">По скважинам</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection