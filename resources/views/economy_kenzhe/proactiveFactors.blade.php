@extends('layouts.economics')
@section('content')
<div>
    <proactive-factors></proactive-factors>
</div>
@endsection
<style>
    .proactive-factors-page-container {
        flex-wrap: wrap;
        margin: 0 !important;
        color: #fff;
    }

    .container-col_color {
        background: #272953;
        width: 100%;
    }

    .filter__input {
        background-color: #272953;
        color: #fff;
        border: none;
        height: 70px;
        width: 100%;
    }

    .filter__input option {
        width: 100%;
    }

    .bootstrap-select ul.filter__input li:first-child {
        display: none;
    }

    .middle-block-columns {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
</style>
