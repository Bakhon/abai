@extends('admin.layouts.app')

@section('content')
    <div id="app" class="users-list ml-auto mr-auto col-8">
        <view-table :params='@json($params)'></view-table>
    </div>
@endsection
@section('custom_css')
    <style>
        .users-list .table-page .table tbody tr td .row__links {
            width: 90px;
        }
        .users-list .table-page .table tbody tr td .links {
            width: 50px;
        }
    </style>
@endsection
