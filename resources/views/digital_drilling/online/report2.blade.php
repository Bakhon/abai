@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Отчеты</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Календарный план сопровождения бурения сложных скв. по ДЗО НК КМГ на 2021г.<i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('digital-drilling-report1')}}">Доля коллектора в горизонтальных скв. (по данным интерпретации ГИС)</a>
                        <a class="dropdown-item">Отчет службы супервайзинга об окончании строительства скважины</a>
                        <a class="dropdown-item">Отчет службы сопровождения 24/7 с офиса КМГИ</a>
                        <a class="dropdown-item">Отчет буровой компании по строительству скважины</a>
                        <a class="dropdown-item">Отчет подрядной компании по буровым растворам</a>
                        <a class="dropdown-item">Отчет подрядной компании по ННБ и геонавигации </a>
                        <a class="dropdown-item">Отчет подрядной компании по цементированию скважины</a>
                        <a class="dropdown-item">Отчет подрядной компании по ГИС</a>
                        <a class="dropdown-item">Отчет подрядной компании по ГТИ  </a>
                        <a class="dropdown-item">Сводная таблица анализа проектных скважин 2021г</a>
                        <a class="dropdown-item">Консолидированные рекомендации по улучшению и осложнениям в процессе строительства скважины</a>
                        <a class="dropdown-item">Отчет по извлеченным урокам в процессе строительства скважины</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tr>
                                <th>№ п/п</th>
                                <th>Наименование ДЗО КМГ</th>
                                <th>Месторождение</th>
                                <th>№ скв</th>
                                <th>Тип скважины</th>
                                <th>Пр. гл. м по верт.</th>
                                <th>Пр. гл. м по стволу</th>
                                <th>Дата начала бурения</th>
                                <th>янв</th>
                                <th>фев</th>
                                <th>мар</th>
                                <th>апр</th>
                                <th>май</th>
                                <th>июн</th>
                                <th>июл</th>
                                <th>авг</th>
                                <th>сен</th>
                                <th>окт</th>
                                <th>ноя</th>
                                <th>дек</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>АО "Эмбамунайгаз"</td>
                                <td>С.Нуржанов</td>
                                <td>718</td>
                                <td>ГС</td>
                                <td>1886</td>
                                <td>3045</td>
                                <td>33.02.21</td>
                                <td></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>АО "Эмбамунайгаз"</td>
                                <td>С.Нуржанов</td>
                                <td>718</td>
                                <td>ГС</td>
                                <td>1886</td>
                                <td>3045</td>
                                <td>33.02.21</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>АО "Эмбамунайгаз"</td>
                                <td>С.Нуржанов</td>
                                <td>718</td>
                                <td>ГС</td>
                                <td>1886</td>
                                <td>3045</td>
                                <td>33.02.21</td>
                                <td></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td class="green"></td>
                                <td></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>АО "Эмбамунайгаз"</td>
                                <td>С.Нуржанов</td>
                                <td>718</td>
                                <td>ГС</td>
                                <td>1886</td>
                                <td>3045</td>
                                <td>33.02.21</td>
                                <td></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>АО "Эмбамунайгаз"</td>
                                <td>С.Нуржанов</td>
                                <td>718</td>
                                <td>ГС</td>
                                <td>1886</td>
                                <td>3045</td>
                                <td>33.02.21</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>АО "Эмбамунайгаз"</td>
                                <td>С.Нуржанов</td>
                                <td>718</td>
                                <td>ГС</td>
                                <td>1886</td>
                                <td>3045</td>
                                <td>33.02.21</td>
                                <td></td>
                                <td class="green"></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td class="green"></td>
                                <td></td>
                                <td class="green"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection