@extends('layouts.app')
@section('content')
    <h3 align="center">{{trans('economy_kenzhe.import_reptt_titles')}}</h3>
    <br/>
    @if(count($errors) > 0)
        <div class="alert alert-danger">
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

    <form method="post" enctype="multipart/form-data" action="{{ route('import_reptt_titles') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <table class="table">
                <tr>
                    <td width="20%" align="right"><label style="color: white;">{{trans('economy_kenzhe.chose_file')}}</label></td>
                    <td width="30">
                        <input type="file" name="select_file"/>
                    </td>
                    <td width="20%">
                        <select name="importExcelType" id="" class="form-control">
                            <option value="opiu">{{trans('economy_kenzhe.opiu')}}</option>
                            <option value="production">{{trans('economy_kenzhe.production')}}</option>
                            <option value="companies">{{trans('economy_kenzhe.companies')}}</option>
                            <option value="balance">{{trans('economy_kenzhe.balance')}}</option>
                            <option value="kvl">{{trans('economy_kenzhe.kvl')}}</option>
                        </select>
                    </td>
                    <td width="30%" align="left">
                        <input type="submit" name="upload" class="btn btn-primary" value="Загрузить">
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
@endsection