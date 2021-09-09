@extends('layouts.app')
@section('module_icon')
    <svg width="48" height="43" viewBox="0 0 48 43" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M47.6795 23.0782C45.75 34.3883 35.8664 43 23.9619 43C13.0237 43 3.791 35.7294 0.867906 25.7756C0.609472 24.8965 0.400959 23.996 0.243788 23.0782L0 20.9084C0.800499 22.8092 2.00889 23.0618 3.1883 21.7501C7.9672 16.4348 10.5399 10.7965 19.3536 11.7357C18.0527 13.0394 17.1107 14.5389 16.5371 16.241C15.0818 20.5655 16.3174 24.7127 19.1276 27.3581L24.698 4.31018H24.0651C23.5373 4.31018 23.0096 3.78449 23.0096 3.25884V1.05162C23.0096 0.420723 23.5373 0 24.0651 0H28.2858H30.3969H34.6183C35.1464 0 35.6741 0.526134 35.6741 1.05162V3.25884C35.6741 3.8899 35.1464 4.31018 34.6183 4.31018H33.9852L38.84 24.2957C40.2543 23.0904 41.5935 21.8626 42.8498 20.786C43.9457 19.847 44.8957 19.0844 45.6541 18.5531C47.4081 17.3268 48.0424 17.2365 47.9978 19.5771C47.9813 20.4896 47.8616 21.6953 47.6795 23.0782ZM20.97 28.7404C22.8017 29.821 25.0296 30.3865 27.477 30.227C27.7471 30.21 28.0167 30.1812 28.2858 30.1419V21.7599L21.5321 26.2798L20.97 28.7404ZM30.3969 29.6356C32.6272 28.892 34.7478 27.5443 36.7419 26.0058L30.3969 21.7599V29.6356ZM22.2708 23.2312L27.3363 19.8675L23.6427 17.4499L22.2708 23.2312ZM25.3314 10.512L27.3363 9.14511L25.8591 8.19938L25.3314 10.512ZM28.2858 4.31018H26.8086L26.3869 5.88675L28.2858 7.14824V4.31018ZM28.2858 11.1426L24.5926 13.5605L24.4868 13.9807H28.2858V11.1426ZM28.2858 15.0319H24.2761V15.1373L28.2858 17.7657V15.0319ZM31.8746 4.31018H30.3969V7.04283L32.1912 5.88675L31.8746 4.31018ZM32.7187 8.19938L31.241 9.14511L33.3523 10.512L32.7187 8.19938ZM34.0906 13.5605L30.3969 11.1426V13.9807H34.1959L34.0906 13.5605ZM34.4076 15.0319H30.3969V17.8701L34.4076 15.2422V15.0319ZM34.9352 17.3445L31.241 19.7625L36.4129 23.1263L34.9352 17.3445Z" fill="#2E50E9"/></svg>
@endsection
@section('module_title', trans('waterflooding_management.module_title'))
@section('content')
    <water-flooding-management-main></water-flooding-management-main>
@endsection