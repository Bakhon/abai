@extends('layouts.economics')
@section('content')
<div>
    <company-valuation></company-valuation>
</div>
@endsection
<style scoped>
    .proactive-factors-page-container {
        flex-wrap: wrap;
        margin: 0 !important;
        color: #fff;
    }

    .container-col_color {
        background: #272953;
        width: 100%;
    }

    .contro-panel-col_height {
        height: 75px;
        font-weight: bold;
    }

    .contro-panel-col_text {
        position: relative;
        top: 2em;

    }

    .filter__input {
        background-color: #272953;
        color: #fff;
        border: none;
        height: 75px;
    }

    .filter__option {
        border: none;
    }

    .bootstrap-select ul.filter__input li:first-child {
        display: none;
    }

    .middle-block-columns {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .btn.btn_color {
        background-color: #293688;
        border: none;
    }  
</style>