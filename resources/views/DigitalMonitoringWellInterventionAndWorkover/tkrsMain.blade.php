@extends('layouts.tkrs')
@section('content')
    <div class="pip-4 tkrs_page"  >
        <a href="{{url('/')}}/ru/export" class="float-right">
        </a>
        <div class="level1-content row-tkrs">
            <div class="main md-12 lg-12 row-tkrs">
            <tkrs-main></tkrs-main>

            </div>
        </div>
    </div>
@endsection
<style>
    .pip-4{
        background-color: #0F1430;
        width: 100%;
        height: 100%;
    }
    .title, .subtitle {
        color:white;
    }
    .top{
        display: none;
    }
    .row-tkrs {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    }
    .level1-content {
    width: 100%;
    }
</style>