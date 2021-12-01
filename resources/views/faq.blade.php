@extends('layouts.app')

@section('content')
<div class="faq-background">
    <div class="faq-header container-fuild">
        <div class="col-4">
            <a class="row faq__link" href="{{route('mainpage')}}">
                <div class="faq-header_logo col-2">
                </div>
                <div class="col-2 row">
                    <div class="w-25 faq__link__img"></div>
                    <div class="w-25">{{ __('faq.back') }}
                    </div>
                </div>
        </div>
    </div></a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 faq-header_img">
                <div class="faq-header_name">{{ __('faq.header') }}</div>
                <faq-page :faq-Data="{{ $faqData }}"></faq-page>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .faq-background {
        position: fixed;
        background: #181837 !important;
        width: 100%;
        height: 100%;
        margin-left: -10px;
        margin-top: -6px;
    }

    .faq-header_logo {
        background: url(/img/faq/smal-logo-abai.png) no-repeat;
        height: 25px;
        margin-left: 10px;
    }

    a.faq__link {
        color: #fff !important;
        margin-bottom: 5px;
    }

    .faq__link__img {
        background: url(/img/faq/back.png) no-repeat;
        height: 25px;
        margin-top: 5px;
    }

    .faq-header {
        background: #20274F;
        height: 30px;
    }

    .faq-header_img {
        background: url(/img/faq/faq.png) 18px no-repeat;
        height: 324px;
    }

    .faq-header_name {
        font-size: 1.6em;
        position: relative;
        color: #fff;
        margin: 113px 0px -109px;
        text-align: center;
        height: 0px;
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
        background: #393d75;
        border: none;
        outline: none;
        width: 176px;
    }

    .faq-page__search__img {
        background: url(/img/faq/search.png) no-repeat;
        width: 68px;
        height: 22px;
        margin: 17px 127px;
    }

    .faq-page__search input {
        background: #393d75 url(/img/icons/search.svg) 19px 50% no-repeat;
        border-radius: 5px 0 0 5px;
        border: none;
        color: #fff;
        font-size: 16px;
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

    .faq-question_up {
        background: #393d75 url(/img/faq/up.png) no-repeat;
        width: 13px;
        height: 8px;
    }

    .faq-question_down {
        background: #393d75 url(/img/faq/down.png) no-repeat;
        width: 13px;
        height: 8px;
    }

    .faq-ansver {
        min-height: 63px;
        background: #fff;
        color: #000;
        padding: 10px;
    }
</style>