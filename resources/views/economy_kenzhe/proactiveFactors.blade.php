@extends('layouts.economics')
@section('content')
<div>
    <proactive-factors></proactive-factors>
</div>
@endsection
<style scoped>
    th.reptt-cell>.cell {
        font-size: 14px;
        color: #fff;       
        height: auto;
        word-break: normal!important;
        white-space: normal;
    }
    
    td.reptt-cell>.cell {
        font-size: 14px;      
        margin: 0;
        height: auto;
        width: auto;
        background: transparent;
        color: white;
        float: unset;      
        line-height:unset!important;
        padding: unset!important;
        white-space: normal;
    }

    td.reptt-cell {
        padding: unset!important;
    }

    th.reptt-column-zero, th.reptt-column{
        background:#323370!important;
    }
  
    tr:hover>td.reptt-cell{
        background: #293688!important;
    }

    td.reptt-column-blue3 , th.reptt-column-blue3>.cell, .reptt-column-blue3 {
        background:#12135c!important;
    }
  
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
        height: 73px;
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
    .hidden-row{
        display: none;
    }
</style>
