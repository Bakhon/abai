@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <a href="{{ route('eco_refs_gtm.index')}}"
           class="btn btn-info">
            {{ __('economic_reference.return_menu') }}
        </a>
    </div>

    <div class="container bg-dark text-white my-3 py-3">
        <h3 class="mb-3">
            {{ __('economic_reference.import_data_from_excel') }}
        </h3>

        @if(count($errors))
            <div class="alert alert-danger">
                <div>
                    {{ __('economic_reference.upload_validation_error') }}
                </div>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>

                <strong>{{ $message }}</strong>
            </div>
        @endif

        <form method="post"
              enctype="multipart/form-data"
              action="{{ route($isTechnical ? 'eco_refs_gtm_value_import' : 'eco_refs_gtm_import') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="file"
                       name="file"
                       accept="{{$mimeTypes}}"
                       class="form-control-file"/>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('economic_reference.upload')}}
                    </button>

                    <a href="/{{$isTechnical ? 'eco_refs_gtm_value' : 'eco_refs_gtm'}}.xlsx"
                       class="btn btn-primary float-right"
                       download>
                        {{ __('economic_reference.download_example')}}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection