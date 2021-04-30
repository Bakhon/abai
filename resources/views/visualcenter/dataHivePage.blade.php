@extends('layouts.app')
@section('content')
<div class="col">
    <form action="" method="POST">
        @csrf
        <get-data-hive></get-data-hive>
    </form> 
</div>
@endsection
<style scoped>
body{
color:#fff!important;
}
</style>