@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="/css/digital_drilling.css">
    <div class="row digital_drilling">
        <daily-raport />
    </div>
@endsection
@section('sidebar_menu_additional')
    @include('partials.sidebar.digital_drilling_menu')
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.rangeInput').each(function () {
            var value = ((this.value - this.min) / (this.max - this.min)) * 100;
            var inputVal = this.value;
            var back = "linear-gradient(to right, #454D7D 0%, #454D7D " + value + "%, #3C4270 " + value + "%, #3C4270 100%)";
            $(this).css("background", back);
        });
    });
</script>