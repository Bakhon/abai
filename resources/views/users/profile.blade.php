@extends('layouts.app')
@section('content')
    <div class="user-profile row">
        <div class="col-3">
            <div class="user-profile__sidebar">
                <div class="user-profile__sidebar-avatar">
                    @if(auth()->user()->thumb)
                        <img src="{{ auth()->user()->thumb }}">
                    @else
                        <img src="{{ asset('img/level1/icon_user.svg') }}">
                    @endif
                </div>
                <p class="user-profile__sidebar-username">{{auth()->user()->name}}</p>
            </div>
        </div>
        <div class="col-9">
            <div class="user-profile__info">
                <p><b>Был в последний раз:</b> {{ auth()->user()->last_authorized_at }}</p>
                <p>
                    <b>Роли:</b>
                    {{ implode(', ', auth()->user()->roles->pluck('name')->toArray()) }}
                </p>
            </div>
        </div>
    </div>
@endsection