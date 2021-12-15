@extends('layouts.app')
@section('module_icon')
    <svg width="35" height="46" viewBox="0 0 35 46" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4065 45.2258H17.8493C18.1407 45.2258 18.379 44.9875 18.379 44.6961V41.114H34.5299C34.7886 41.114 35 40.9026 35 40.6441V40.1387C35 39.8801 34.7886 39.6686 34.5299 39.6686H27.6755V34.9001H27.672L24.7136 21.4967C25.5297 21.4152 26.1725 20.7214 26.1725 19.8847V18.143C26.1725 17.252 25.4434 16.5231 24.5526 16.5231H23.6158L21.0209 4.7661C21.2061 4.60646 21.3238 4.3703 21.3238 4.10808V3.38169C21.3238 2.92696 20.9699 2.55101 20.5241 2.51533L18.3706 0.435001C18.3256 0.188351 18.1083 -1.14441e-05 17.8493 -1.14441e-05H17.4065C17.1222 -1.14441e-05 16.8883 0.226925 16.8771 0.508656L14.5359 2.51269C14.0622 2.51777 13.6762 2.90678 13.6762 3.38169V4.10808C13.6762 4.37227 13.7957 4.60996 13.9833 4.7696L11.3873 16.5231H10.7033C9.81225 16.5231 9.0833 17.252 9.0833 18.143V19.8847C9.0833 20.636 9.60166 21.2722 10.2983 21.4531L7.3281 34.9001H7.32447V39.6686H0.470048C0.211447 39.6686 0 39.8801 0 40.1387V40.6441C0 40.9026 0.211447 41.114 0.470048 41.114H16.8768V44.6961C16.8768 44.9875 17.1151 45.2258 17.4065 45.2258ZM12.4459 15.7076L16.8768 12.7474V6.85552L14.7916 5.21003L12.4459 15.7076ZM18.379 11.7438L20.9201 10.0462L18.379 8.04099V11.7438ZM15.7984 4.97721L16.8768 5.82816V4.97721H15.7984ZM18.379 7.01363L21.1741 9.21929L20.2375 4.97721H18.379V7.01363ZM21.4873 10.6382L18.379 12.7147V16.5231H22.7866L21.4873 10.6382ZM16.8768 13.7183L12.6785 16.5231H16.8768V13.7183ZM8.24622 34.5022L16.8768 31.1747V24.713L11.0494 21.9569L8.24622 34.5022ZM18.379 30.5953L24.4032 28.2727L18.379 25.4235V30.5953ZM11.9833 21.5046L16.8768 23.819V21.5046H11.9833ZM18.379 24.5296L25.2743 27.7906L23.8864 21.5046H18.379V24.5296ZM25.48 28.7228L18.379 31.4607V34.9001H26.8439L25.48 28.7228ZM16.8768 32.0399L9.45866 34.9001H16.8768V32.0399ZM19.3414 2.51256H18.379V1.57327L19.3414 2.51256ZM16.8768 1.57204V2.51256H15.7774L16.8768 1.57204Z" fill="#2E50E9"/>
    </svg>
@endsection
@section('module_title', trans('digital_drilling.module_title'))
@section('module_home_url', route('digital-drilling'))
@section('content')
    <link rel="stylesheet" href="/css/digital-drilling.css">
    <div class="digital_drilling">
        <daily-raport-catalog />
    </div>
@endsection
@section('sidebar_menu_additional')
    @include('partials.sidebar.digital_drilling_menu')
@endsection