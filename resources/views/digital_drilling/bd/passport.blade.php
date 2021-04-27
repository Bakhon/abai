@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
            <p class="bigTitle">Паспорт скважины</p>
                <div class="row">
                    <div class="col-sm-4">
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">План бурения</th>
                            </tr>
                            <tr>
                                <td colspan="1">Дата начала бурения</td>
                                <td colspan="1">20.09.2017</td>
                            </tr>
                            <tr>
                                <td colspan="1">Дата окончания бурения</td>
                                <td colspan="1">23.10.2017</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">Договор</th>
                            </tr>
                            <tr>
                                <td colspan="1">Подрядчик</td>
                                <td colspan="1">ТОО “Сибу Кызылорда”</td>
                            </tr>
                            <tr>
                                <td colspan="1">Номер договора</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">Дата договора</td>
                                <td colspan="1">20.09.2017</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">Сводка по бурению</th>
                            </tr>
                            <tr>
                                <td colspan="1">Начало бурения</td>
                                <td colspan="1">20.09.2017 - 00:00</td>
                            </tr>
                            <tr>
                                <td colspan="1">Окончание бурения</td>
                                <td colspan="1">20.09.2017 - 05:15</td>
                            </tr>
                            <tr>
                                <td colspan="1">Общая проходка</td>
                                <td colspan="1">45</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">Конструкция скважины</th>
                            </tr>
                            <tr>
                                <td colspan="1">Диаметр экспл.колонны</td>
                                <td colspan="1">168.3</td>
                            </tr>
                            <tr>
                                <td colspan="1">Глубина спуска</td>
                                <td colspan="1">2453.64</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table secondTable">
                            <tr>
                                <th colspan="3">Общая информация</th>
                            </tr>
                            <tr>
                                <td colspan="1">1</td>
                                <td colspan="1">Скважина</td>
                                <td colspan="1">АКН_0453</td>
                            </tr>
                            <tr>
                                <td colspan="1">2</td>
                                <td colspan="1">Вид скважины</td>
                                <td colspan="1">Горизонтальная</td>
                            </tr>
                            <tr>
                                <td colspan="1">3</td>
                                <td colspan="1">Месторождение</td>
                                <td colspan="1">Акшабулак Центральный</td>
                            </tr>
                            <tr>
                                <td colspan="1">4</td>
                                <td colspan="1">Блок</td>
                                <td colspan="1">I объект</td>
                            </tr>
                            <tr>
                                <td colspan="1">5</td>
                                <td colspan="1">Горизонт</td>
                                <td colspan="1">М-II-1</td>
                            </tr>
                            <tr>
                                <td colspan="1">6</td>
                                <td colspan="1">Тех.структура</td>
                                <td colspan="1">“ЦППН / ЦППН-3” манифольд</td>
                            </tr>
                            <tr>
                                <td colspan="1">7</td>
                                <td colspan="1">Орг.структура</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">8</td>
                                <td colspan="1">Зона скважины</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">9</td>
                                <td colspan="1">Альтитуда устья скважины</td>
                                <td colspan="1">125.0</td>
                            </tr>
                            <tr>
                                <td colspan="1">10</td>
                                <td colspan="1">Координаты Х (устья)</td>
                                <td colspan="1">65.7</td>
                            </tr>
                            <tr>
                                <td colspan="1">11</td>
                                <td colspan="1">Координаты Y (устья)</td>
                                <td colspan="1">45.96</td>
                            </tr>
                            <tr>
                                <td colspan="1">12</td>
                                <td colspan="1">Координаты забоя X</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">13</td>
                                <td colspan="1">Координаты забоя Y</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">14</td>
                                <td colspan="1"></td>
                                <td colspan="1">Контрольная</td>
                            </tr>
                            <tr>
                                <td colspan="1">15</td>
                                <td colspan="1">Категория</td>
                                <td colspan="1">Контрольная</td>
                            </tr>
                            <tr>
                                <td colspan="1">16</td>
                                <td colspan="1">Дата ввода в эксплуатацию</td>
                                <td colspan="1">09.02.2018</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table secondTable">
                            <tr>
                                <td colspan="1">17</td>
                                <td colspan="1">Буровой подрядчик</td>
                                <td colspan="1">ТОО “Сибу Кызылорда”</td>
                            </tr>
                            <tr>
                                <td colspan="1">18</td>
                                <td colspan="1">Проектная глубина</td>
                                <td colspan="1">2433.35</td>
                            </tr>
                            <tr>
                                <td colspan="1">19</td>
                                <td colspan="1">Радиус дренирования</td>
                                <td colspan="1">0.0</td>
                            </tr>
                            <tr>
                                <td colspan="1">20</td>
                                <td colspan="1">Состояние</td>
                                <td colspan="1">В простое</td>
                            </tr>
                            <tr>
                                <td colspan="1">21</td>
                                <td colspan="1">Способ эксплуатации</td>
                                <td colspan="1">УЭЦН</td>
                            </tr>
                            <tr>
                                <td colspan="1">22</td>
                                <td colspan="1">Дин уровень</td>
                                <td colspan="1">1462.14/(15.01.2019)</td>
                            </tr>
                            <tr>
                                <td colspan="1">23</td>
                                <td colspan="1">Стат уровень</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">24</td>
                                <td colspan="1">Рпл / (дата замера)</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">25</td>
                                <td colspan="1">Рзаб / (дата замера)</td>
                                <td colspan="1">61.97/(26.06.2018)</td>
                            </tr>
                            <tr>
                                <td colspan="1">26</td>
                                <td colspan="1">Факт.забой (дата отбивки)</td>
                                <td colspan="1">2471/(07.02.2018)</td>
                            </tr>
                            <tr>
                                <td colspan="1">27</td>
                                <td colspan="1">Дата последнего КРС</td>
                                <td colspan="1">19.12.2017</td>
                            </tr>
                            <tr>
                                <td colspan="1">28</td>
                                <td colspan="1">Дата последнего ПРС</td>
                                <td colspan="1">19.12.2017</td>
                            </tr>
                            <tr>
                                <td colspan="1">29</td>
                                <td colspan="1">Дата последнего ГИС</td>
                                <td colspan="1"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection