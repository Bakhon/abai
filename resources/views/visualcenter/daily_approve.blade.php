@extends('layouts.visualcenter')
@section('content')
<div>
        <div>
        <visual-center-daily-approve user-id={{Auth::id()}}></visual-center-daily-approve>
        </div>
    </div>
@endsection