@extends('layouts.app')
@section('body_class', 'body_bigdata')
@section('module_icon')
    <svg width="27" height="31" viewBox="0 0 27 31" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.2803 7.56966V28.6219H5.625V30.3291H26.0106V7.56966H24.2803Z" fill="#3366FF"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5481 6.34473L16.957 0.754069V6.34473H22.5481Z" fill="#3366FF"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2237 0.753174H0.539062V26.8887H22.5477V8.07674H15.2237V0.753174ZM16.8009 11.9867H18.5339V22.6408H16.8009V11.9867ZM4.67013 8.55143H8.99467V10.2843H4.67013V8.55143ZM6.40346 22.6408H4.67013V16.6078H6.40346V22.6408ZM10.4468 22.6408H8.71387V14.297H10.4468V22.6408ZM12.1139 6.81852H4.67013V5.08521H12.1139V6.81852ZM14.4905 22.6408H12.7576V10.8313H14.4905V22.6408Z" fill="#3366FF"/>
    </svg>
@endsection
@section('module_title', 'Конструктор отчетов')
@section('content')
    <div id="app">
        <report-constructor></report-constructor>
    </div>
@endsection
