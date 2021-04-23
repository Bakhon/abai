@extends('layouts.economics')
@section('content')
<div>
    <proactive-factors></proactive-factors>
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


    tr.reptt-header>th div {
        background: #323370;
        height: 75px !important;
        padding: 20px 0;
        color: #fff;
        font-size: 14px;
    }

    td.reptt-column,
    td.reptt-column-zero {
        background: #25264e;
        height: 75px !important;
        padding: 20px 0;
        color: #fff;
        font-size: 14px;
    }

    td.reptt-column-zero .cell {
        text-align: left;
        color: #fff;
    }

    td.reptt-column-blue,
    th.reptt-column-blue .cell {
        background: #12135c !important;
    }

    td.reptt-column-blue-lighter,
    th.reptt-column-blue-lighter .cell {
        background: #1a2370 !important;
    }  

    td.reptt-cell .el-table__expand-icon {
        color: white;
    }

    td.reptt-cell {
        font-size: 14px;
        text-align: left;
    }

    .el-table--border td.reptt-cell,
    .el-table--border th.reptt-cell,
    .el-table.reptt th.is-leaf {
        border-color: #424a7e;
    }

    .el-table .cell {
        white-space: pre-line;
    }

    .reptt.el-table--border {
        border-color: #424a7e;
    }

    .reptt.el-table::before,
    .reptt.el-table::after {
        background-color: #424a7e;
    }
</style>