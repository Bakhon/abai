@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('tech_data_forecast.index') }}" class="btn btn-info">
                {{ __('forecast.return_menu') }}</a>
        </div>
    </div>
    <div class="container bg-dark text-dark my-3 py-3">
        <h3 align="center">{{ __('forecast.import_data_from_excel') }}</h3>
        <br/>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                {{ __('forecast.upload_validation_error') }}<br><br>
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

        <form method="post" enctype="multipart/form-data" action="{{ route('tech_refs_import') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <table class="table">
                    <tr>
                        <td width="40%" align="right"><label>{{ __('forecast.choose_excel_file') }}</label></td>
                        <td width="30" class="text-light ">
                            <input type="file" name="select_file"/>
                        </td>
                        <td width="30%" align="left">
                            <input type="submit" name="upload" class="btn btn-primary"
                                   value="{{ __('forecast.upload') }}">
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" align="right"></td>
                        <td width="30"><span class="text-muted">.xls, .xslx</span></td>
                        <td width="30%" align="left"></td>
                    </tr>
                </table>
            </div>
        </form>
    </div class="container bg-dark text-dark my-3 py-3">
@endsection