@extends('layouts.economics')
@section('content')
<div>
    <proactive-factors></proactive-factors>
</div>
@endsection
<style scoped>
   th.reptt-cell>.cell, td.reptt-cell>.cell {
        line-height: 1.3!important;
        padding: 12px 0;
        margin: 0;
        height: auto;
        width: auto;
        background: transparent;
        color: white;
        float: unset;
        word-break: normal!important;
        line-height:unset!important;
        white-space: normal;
    }

        th.reptt-column-zero, th.reptt-column{
        background:#323370!important;
    }

    td.reptt-column, td.reptt-column-zero {
    height: 0px!important;
    }

    .el-table--enable-row-hover .el-table__body tr:hover>td{
        background: #293688!important;
    }

    td.reptt-cell {
        padding: unset!important;
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
    .hidden-row{
        display: none;
    }
    
    td.reptt-column-blue3 , th.reptt-column-blue3 .cell, .reptt-column-blue3 {
        background:#12135c!important;
    }
</style>
