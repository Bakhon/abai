@extends('admin.layouts.app')

@section('content')
    <div class="row"  >
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{ $message }}</p>
                </div>
            @endif
            <admin-user-settings :user="{{json_encode($user)}}"></admin-user-settings>
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
