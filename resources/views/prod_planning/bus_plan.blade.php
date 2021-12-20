@extends('layouts.app')
@section('module_icon')
    <svg width="34" height="42" viewBox="0 0 34 42" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.418945 38.6704V41.1366H33.0827V38.6704H0.418945Z" fill="#3366FF"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M16.257 15.7288H13.241L16.257 17.834V15.7288ZM10.477 13.269H23.0228V14.9902H21.6463L25.5441 37.935H7.95605L11.8811 14.9902H10.477V13.269ZM24.0364 35.0316L23.4196 31.444L17.7995 34.2095L19.5743 35.0316H24.0364ZM14.1155 35.0316L15.7392 34.2454L10.1043 31.557L9.51059 35.0316H14.1155ZM20.04 15.7288H17.279V17.7844L20.04 15.7288ZM16.257 23.4764H12.575L16.257 25.5514V23.4764ZM21.0831 23.4764H17.279V25.6557L21.0831 23.4764ZM17.279 22.5519H21.1878L17.279 19.7865V22.5519ZM12.3751 22.5519H16.257V19.7695L12.3751 22.5519ZM16.257 30.995H11.2333L16.257 33.4623V30.995ZM22.2684 30.995H17.279V33.4649L22.2684 30.995ZM17.279 30.0702H21.9547L17.279 27.3089V30.0702ZM11.4374 30.0702H16.257V27.423L11.4374 30.0702ZM11.423 23.8498L10.4441 29.5728L15.8587 26.4706L11.423 23.8498ZM12.6748 16.5289L15.901 18.8113L11.7564 21.8985L12.6748 16.5289ZM21.7373 21.6592L20.8473 16.4809L17.6256 18.7887L21.7373 21.6592ZM23.0666 29.3872L22.1705 24.176L17.9401 26.4993L23.0666 29.3872Z" fill="#3366FF"></path><path d="M2.30176 15.1192L7.95518 9.56974L16.1209 8.95292L21.7743 3.40306L29.3118 2.78662" stroke="#3366FF" stroke-width="0.2646" stroke-miterlimit="22.9256"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M4.1879 15.1187C4.1879 14.0971 3.34429 13.269 2.30341 13.269C1.26252 13.269 0.418945 14.0971 0.418945 15.1187C0.418945 16.1407 1.26252 16.9688 2.30341 16.9688C3.34429 16.9688 4.1879 16.1407 4.1879 15.1187Z" fill="#3366FF"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M9.84259 9.56834C9.84259 8.54636 8.99861 7.71826 7.9581 7.71826C6.91721 7.71826 6.07324 8.54636 6.07324 9.56834C6.07324 10.5899 6.91721 11.418 7.9581 11.418C8.99861 11.418 9.84259 10.5899 9.84259 9.56834Z" fill="#3366FF"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M18.0072 8.9492C18.0072 7.92722 17.1636 7.09912 16.1228 7.09912C15.0819 7.09912 14.2383 7.92722 14.2383 8.9492C14.2383 9.97081 15.0819 10.7989 16.1228 10.7989C17.1636 10.7989 18.0072 9.97081 18.0072 8.9492Z" fill="#3366FF"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M23.6609 3.40341C23.6609 2.38181 22.817 1.55371 21.7765 1.55371C20.7356 1.55371 19.8916 2.38181 19.8916 3.40341C19.8916 4.4254 20.7356 5.25349 21.7765 5.25349C22.817 5.25349 23.6609 4.4254 23.6609 3.40341Z" fill="#3366FF"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M31.1977 2.78465C31.1977 1.76266 30.3541 0.93457 29.3132 0.93457C28.2723 0.93457 27.4287 1.76266 27.4287 2.78465C27.4287 3.80626 28.2723 4.63435 29.3132 4.63435C30.3541 4.63435 31.1977 3.80626 31.1977 2.78465Z" fill="#3366FF"></path></svg>
@endsection
@section('module_title', trans('prod-plan.module-title'))
@section('module_home_url', route('prod_planning_index'))
@section('content')
<navbar-prod-plan></navbar-prod-plan>
<bus-plan></bus-plan>
@endsection
