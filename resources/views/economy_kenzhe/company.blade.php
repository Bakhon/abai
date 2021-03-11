@extends('layouts.app')
@section('content')
        <div class="container">
                <div class="row">
                        <div class="col-12">
                                <table class="table table-hover">
                                        @foreach($stats as $stat)
                                                <tr>
                                                        <td style="color: white">{{$stat->rept->name}}</td>
                                                        <td style="color: white">{{$stat->value}}</td>
                                                </tr>
                                        @endforeach
                                </table>
                        </div>
                </div>
        </div>
@endsection