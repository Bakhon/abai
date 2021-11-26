@extends('layouts.app')

@section('content')
<div class="faq-backgorund">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 faq-header">
                <faq-page></faq-page>
            </div>
        </div>
    </div>
</div>
@endsection
<style scope>
    .faq-backgorund {
        position: fixed;
        background: #181837 !important;
        width: 100%;
        height: 100%;
    }

    .faq-header {
        background: url(/img/level1/faq.png) no-repeat;
        height: 324px;
    }

    .faq-page__inner {
        margin-top: 12em;
    }

    .faq-page__search {
        display: flex;
        position: relative;
        width: 806px;
        height: 40px;
        margin: 0 auto;
    }

    .faq-page__search button {
        background: #3366FF;
        border: none;
        border-radius: 0 5px 5px 0;
        color: #fff;
        font-size: 24px;
        outline: none;
        width: 176px;
    }

    .faq-page__search input {
        background: #393d75 url(/img/icons/search.svg) 19px 50% no-repeat;
        border-radius: 5px 0 0 5px;
        border: none;
        color: #fff;
        font-size: 21px;
        outline: none;
        padding: 0 80px;
        width: calc(100% - 176px);
    }


    .faq-blocks-holder {
        width: 806px;
        height: 40px;
        margin: 135px auto;
    }

    .faq-question {
        background: #363B68;
        width: 806px;
        min-height: 40px;
        padding: 10px;
        color: #fff;
        margin-top: 5px;
    }

    .faq-ansver {
        min-height: 63px;
        background: #fff;
        color: #000;
        padding: 10px;     
    }
</style>