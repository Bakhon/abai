@extends('layouts.monitor')

@section('content')
    <div class="row" id="app">
        <div class="col-md-12">
            <table>
                <thead>
                <tr>
                    <th>Название</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($wells as $well)
                    <tr>
                        <td><a href="{{route('bigdata.wells.show', ['well' => $well])}}">{{$well->uwi}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$wells->links()}}
        </div>
    </div>
@endsection