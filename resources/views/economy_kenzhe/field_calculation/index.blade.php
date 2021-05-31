@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-responsive ">
                    <tbody class="w-100">
                    @foreach($data as $key=> $value)
                        <tr>
                            <td colspan="2">{{$key}}</td>
                        </tr>
                        @if(is_array($value))
                            @foreach($value as $k => $v)
                                @if(is_array($v))
                                    @foreach($v as $k => $vs)
                                    @if(array_key_exists('num', $vs))
                                        <tr>
                                            <td style="color: white;">{{$vs['name']}}</td>
                                            <td style="color: white;">{{$vs['value']}}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td style="color: white;">{{$k}}</td>
                                            <td style="color: white;">{{$v}}</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td style="color: white;">{{$k}}</td>
                                        <td style="color: white;">{{$v}}</td>
                                    </tr>
                                @endif
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
        </div>
    </div>
@endsection