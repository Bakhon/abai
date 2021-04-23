@extends('layouts.app')
@section('body_class', 'body_bigdata')
@section('module_icon')
    <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M24.9764 5.36837C24.9764 2.40411 19.3854 0.00108624 12.4887 0.00108624C5.59184 0.00108624 0.000915527 2.40411 0.000915527 5.36837C0.000915527 8.33264 5.59184 10.7357 12.4887 10.7357C19.3854 10.7357 24.9764 8.33264 24.9764 5.36837Z"
              fill="#3366FF"/>
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M12.4862 16.8936C12.6118 16.8936 12.7348 16.8847 12.8601 16.8831C14.5692 13.7566 17.887 11.6309 21.6928 11.6309C22.8112 11.6309 23.8841 11.8219 24.8901 12.1602C24.9431 11.9514 24.9735 11.74 24.9735 11.5267V8.33424C22.874 10.5858 18.3215 12.0056 12.4887 12.0056C6.65119 12.0056 2.09627 10.5835 -0.0010376 8.32899V11.5267C-0.0010376 14.5861 5.36712 16.8936 12.4862 16.8936Z"
              fill="#3366FF"/>
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M11.6631 22.3232C11.6502 22.1158 11.6315 21.9098 11.6315 21.6992C11.6315 20.453 11.8695 19.2641 12.2851 18.1616C6.54717 18.129 2.07247 16.7173 -0.0010376 14.4903V16.9731C-0.0010376 19.9126 4.9599 22.1518 11.6631 22.3232Z"
              fill="#3366FF"/>
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M-0.0010376 19.9356V22.4182C-0.0010376 25.4776 5.36712 27.7852 12.4862 27.7852C12.8857 27.7852 13.2801 27.7674 13.675 27.7519C12.7635 26.5476 12.1129 25.1381 11.8172 23.5997C6.30494 23.4945 2.01577 22.1014 -0.0010376 19.9356Z"
              fill="#3366FF"/>
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M21.6917 19.6283C20.5547 19.6283 19.6273 20.5557 19.6273 21.6927C19.6273 22.836 20.5547 23.7633 21.6917 23.7633C22.835 23.7633 23.7624 22.836 23.7624 21.6927C23.7624 20.5557 22.835 19.6283 21.6917 19.6283Z"
              fill="#3366FF"/>
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M21.6925 12.9016C16.846 12.9016 12.9016 16.8461 12.9016 21.6988C12.9016 26.5454 16.846 30.4898 21.6925 30.4898C26.5454 30.4898 30.4898 26.5454 30.4898 21.6988C30.4898 16.8461 26.5454 12.9016 21.6925 12.9016ZM27.4656 22.0357C25.9474 24.443 23.8958 25.7706 21.6917 25.7706C19.4939 25.7706 17.4422 24.443 15.9241 22.0357L15.7083 21.6926L15.9241 21.356C17.4422 18.9486 19.4939 17.6211 21.6917 17.6211C23.8958 17.6211 25.9474 18.9486 27.4656 21.356L27.6815 21.6926L27.4656 22.0357Z"
              fill="#3366FF"/>
    </svg>
@endsection
@section('module_title', 'Прототип БД')
@section('sidebar_menu_additional')
    @include('partials.sidebar.bigdata_menu')
@endsection