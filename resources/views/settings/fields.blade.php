@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="container">
            <h1>Настройки валидации полей</h1>
            <field-settings :fields='@json($fields)'></field-settings>
        </div>
    </div>
@endsection