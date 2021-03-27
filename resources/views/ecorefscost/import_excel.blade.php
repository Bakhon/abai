@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('eco_refs_list') }}" class="btn btn-info">
                {{ __('economic_reference.return_menu') }}</a>
        </div>
    </div>
    <div class="container bg-dark text-dark my-3 py-3">
        <h3 class="center">{{ __('economic_reference.import_data_from_excel') }}</h3>
        <br>
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                {{ __('economic_reference.upload_validation_error') }}<br><br>
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

        <form method="post" enctype="multipart/form-data" action="{{ route('economic_data_import') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <table class="table">
                    <tr>
                        <td width="40%" align="right">
                            <label>{{ __('economic_reference.choose_excel_file') }}</label>
                        </td>
                        <td width="30">
                            <input type="file" name="select_file"/>
                        </td>
                        <td width="30%" align="left">
                            <input type="submit" name="upload" class="btn btn-primary"
                                   value="{{ __('economic_reference.upload') }}">
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" align="right"></td>
                        <td width="30"><span class="text-light">.xls, .xslx</span></td>
                        <td width="30%" align="left"></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
@endsection