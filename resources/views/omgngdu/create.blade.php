@extends('layouts.monitor')

@section('content')
    <div  >
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="x_panel">
            <h1>{{ trans('monitoring.omgngdu.create_title') }}</h1>
            <a class="btn btn-primary float-left" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i></a>
                <form action="{{ route('omgngdu.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <omgngdu-form :is-editable="true" :validation-params='@json($validationParams)'></omgngdu-form>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
