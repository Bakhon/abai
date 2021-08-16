@extends('layouts.db')

@section('content')
    <div class="row"  >
        <div class="col-md-12">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="x_panel">
                <div class="col-6">
                    <h1>Бурение скважины</h1>
                    <bigdata-plain-form :params="{{json_encode($params)}}" :well-id="0"></bigdata-plain-form>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    body {
        color: white !important;
    }

    .table {
        color: white !important;
    }
</style>
