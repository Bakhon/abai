@extends('layouts.economics')
@section('content')
    <div>
        <budget-execution></budget-execution>
    </div>
@endsection
<link href="{{ asset('css/visualcenter4.css')}}" rel="stylesheet">
<style>
.visualcenter-page-container {
    flex-wrap: wrap;
    margin: 0 !important;
    color:#fff;
}

.middle-block-columns{
    padding-left: 0 !important;
    padding-right: 0 !important;
}

.right-side2 {
    overflow: hidden;   
}
</style>