@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="list-group">
                    <a href="{{url('/')}}/ru/marabkpiid" class="list-group-item list-group-item-action">KPI Марабаева справочник</a>
                    <a href="{{url('/')}}/ru/abdkpiid" class="list-group-item list-group-item-action">KPI Абдулгафарова справочник</a>
                    <a href="{{url('/')}}/ru/typeid" class="list-group-item list-group-item-action"> Тип (Порог, Цель, Вызов, Факт) справочник</a>
                    <a href="{{url('/')}}/ru/marab1" class="list-group-item list-group-item-action"> 1 KPI Марабаева: <br> - Прирост извлекаемых запасов нефти и конденсата (не включает возврат /реализацию долей участия) по категориям А+В+С1 с учетом  долей в СП и ДЗО </a>
                    <a href="{{url('/')}}/ru/marab2" class="list-group-item list-group-item-action"> 2 KPI Марабаева: <br> - Чистый денежный поток в КЦ КМГ от ДЗО дивизиона </a>
                    <a href="{{url('/')}}/ru/marab345" class="list-group-item list-group-item-action"> 3, 4, 5 KPI Марабаева: <br> - Операционные затраты, связанные с добычей нефти <br> - Капитальные затраты по операционным активам <br> - Операционные и капитальные затраты крупных проектов </a>
                    <a href="{{url('/')}}/ru/marab6" class="list-group-item list-group-item-action"> 6 KPI Марабаева: <br> - Стратегическое развитие АО НК "КазМунайГаз" в области техники и технологии </a>
                    <a href="{{url('/')}}/ru/abd12" class="list-group-item list-group-item-action"> 1,2 KPI Абдулгафарова: <br> - Заключение/ реализация контрактов на недропользование, включая сделки по слияниям и поглощениям <br> - Привлечение стратегических партнеров с соответствующим опытом и необходимыми финансовыми возможностями для реализации совместных проектов </a>
                    <a href="{{url('/')}}/ru/abd35" class="list-group-item list-group-item-action"> 3,5 KPI Абдулгафарова: <br> - ESG Рейтинг <br> - Исполнение мероприятий по реструктуризации активов группы компаний АО НК «КазМунайГаз» </a>
                    <a href="{{url('/')}}/ru/abd46" class="list-group-item list-group-item-action"> 4,6 KPI Абдулгафарова: <br> - Оптимизированный Инвестиционный портфель на 2021-2025 гг. с учетом приоритизации проектов <br> - Исполнение мероприятия по передаче АО "КазТрансГаз" в структуру АО "Самрук Казына" в установленные сроки </a>
                    <a href="{{url('/')}}/ru/kpicalc" class="list-group-item list-group-item-action"> Расчеты </a>
                </div>
            </div>
        </div>
    </div>
@endsection
