@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-responsive ">
                    <tbody class="w-100">
                    @foreach($data as $date=> $values)
                        <tr>
                            <td colspan="2">{{$date}}</td>
                        </tr>
                        @if(is_array($values))
                            @foreach($values as $k => $v)
                                @if(is_array($v))
                                    @foreach($v as $title => $vs)
                                        @if(is_array($vs))

                                            @else
                                            <tr>
                                                <td style="color: white;">{{trans('economy_kenzhe.'.$k)}} {{trans()->has('economy_kenzhe.'.$title) ? trans('economy_kenzhe.'.$title) : $title}}</td>
                                                <td style="color: white;">{{$vs}}</td>
                                            </tr>
                                        @endif

                                    @endforeach
                                @else
                                    <tr>
                                        <td style="color: white;">{{trans('economy_kenzhe.'.$k)}}</td>
                                        <td style="color: white;">{{$v}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td style="color: white;">{{$date}}</td>
                                <td style="color: white;">{{$values}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection