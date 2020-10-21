@extends('layouts.app')
@section('content')
<div class="col p-4">
    <div>
        <link href="style.css" type="text/css" rel="stylesheet" />
        <div class="head-info">Оперативная информация по ДЗО для АО "НК "КазМунайГаз"</div>
        <table>
            <tr>
                <td class="fs" rowspan="3">Добыча нефти</td>
                <td class="bg" colspan="7">Добыча нефти, тонн</td>
                <td class="bg" colspan="7">Сдача нефти, тонн</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">
                    <div>План<div>на месяц,тонн
                </td>
                <td class="bg" colspan="3">За сутки</td>
                <td class="bg" colspan="3">С начала месяца</td>
                <td class="bg" rowspan="2">План<div>на месяц,<div>тонн</td>
                <td class="bg" colspan="3">За сутки</td>
                <td class="bg" colspan="3">С начала месяца</td>
            </tr>
            <tr>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
            </tr>
            <tr>
                <td class="fs">Нефть,тн</td>
                <td>460538</td>
                <td>1</td>
                <td><input type="text" value="" class="square2"></td>
                <td>3</td>
                <td>5</td>
                <td>7</td>
                <td>9</td>
                <td>459593</td>
                <td>13</td>
                <td><input type="text" value="" class="square2"></td>
                <td>15</td>
                <td>17</td>
                <td>19</td>
                <td></td>
            </tr>
            <tr>
                <td class="fs">Конденсат,тн</td>
                <td>474</td>
                <td>2</td>
                <td><input type="text" value="" class="square2"></td>
                <td>4</td>
                <td>6</td>
                <td>8</td>
                <td>10</td>
                <td>12</td>
                <td>14</td>
                <td><input type="text" value="" class="square2"></td>
                <td>16</td>
                <td>18</td>
                <td>20</td>
                <td></td>
            </tr>

            </tr>
            <td colspan="8"></td>
            <td colspan="7">Дополнительная информация будет отображаться в этой ячейке</td>
            <tr>
        </table>

        <br>
        <br>

        <div class="left-side">
            <table>
                <tr>
                    <td class="fs" rowspan="2">Добыча газа</td>
                    <td class="bg" rowspan="2">
                        <div>План<div>на месяц,тыс. м3
                    </td>
                    <td class="bg" colspan="3">За сутки</td>
                    <td class="bg" colspan="3">С начала месяца</td>
                </tr>
                <tr>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                </tr>
                <tr>
                    <td class="fs">Всего, в т.ч</td>
                    <td>1</td>
                    <td>2</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td class="fs">Всего природный</td>
                    <td>7</td>
                    <td>8</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td class="fs">Газовые месторождения ДЗО</td>
                    <td>13</td>
                    <td>14</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                </tr>
                <tr>
                    <td class="fs">Гсп ДЗО</td>
                    <td>19</td>
                    <td>20</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>21</td>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                </tr>
                <tr>
                    <td class="fs">Попутный</td>
                    <td>25</td>
                    <td>26</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>27</td>
                    <td>28</td>
                    <td>29</td>
                    <td>30</td>
                </tr>

            </table>


            <br><br>
            <table>
                <tr>
                    <td class="fs" rowspan="2">Закачка воды, тыс.м3</td>
                    <td class="bg" rowspan="2">План<div>на месяц,<div>тыс. м3</td>
                    <td class="bg" colspan="3">За сутки</td>
                    <td class="bg" colspan="3">С начала месяца</td>
                </tr>
                <tr>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                </tr>
                <tr>
                    <td class="fs">Всего</td>
                    <td>
                        <div>4760
                    </td>
                    <td>154</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td class="fs">В .т. ч. морская</td>
                    <td>1111</td>
                    <td>36</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td class="fs">Сточная</td>
                    <td>3649</td>
                    <td>118</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                </tr>
            </table>
        </div>

        <div class="right-side">

            <table>
                <tr>
                    <td class="bg" colspan="2">Простой добывающих скважин</td>
                </tr>

                <tr>
                    <td class="left">ПРС</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">ОПРС</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">ОКРС</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">КРС</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">Исследования скважин</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">Прочие</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">Нерентабельные</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">Ограничение скважин по добыче</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">Ограничение скважин с чрф</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">Всего</td>
                    <td>483</td>
                </tr>
                <tr>
                    <td class="left">Недобор нефти, тонн</td>
                    <td>1212</td>
                </tr>
            </table>

        </div>

        <br><br>
        <table>
            <tr>
                <td class="fs" rowspan="3">Динамика фонда скважин</td>
                <td class="bg" colspan="5">Добывающий фонд</td>
                <td class="bg" rowspan="2">
                    <div>Ожид.ликвид
                </td>
                <td class="bg" rowspan="2">В консер-ии</td>
                <td class="bg" colspan="5">Нагнетательный фонд</td>
                <td class="bg" rowspan="2">
                    <div>Ожид.ликвид
                </td>
                <td class="bg" rowspan="2">В консервации</td>
            </tr>
            <tr>
                <td class="bg">Экспл.</td>
                <td class="bg">Действ.</td>
                <td class="bg">Простой</td>
                <td class="bg">Б/д</td>
                <td class="bg">Освоение</td>
                <td class="bg">Экспл.</td>
                <td class="bg">Действ.</td>
                <td class="bg">Простой</td>
                <td class="bg">Б/д</td>
                <td class="bg">Обустр-во</td>
            </tr>
            <tr>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
                <td><input type="text" value="" class="square2"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="7">Из освоения 9816/73</td>
                <td colspan="7">Из бурения 809/10</td>
            </tr>
        </table>

        <br><br>

        <table>
            <tr>
                <td class="fs" rowspan="4">Бурение скважин</td>
                <td class="bg" colspan="7">Проходка, метр</td>
                <td class="bg" colspan="4">Ввод скважин</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">План<div>на месяц</td>
                <td class="bg" colspan="3">Суточная</td>
                <td class="bg" colspan="3">С начала месяца</td>
                <td class="bg" rowspan="2">План<div>на месяц</td>
                <td class="bg">За сутки</td>
                <td class="bg" colspan="2">С начала месяца</td>
            </tr>
            <tr>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">Факт</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
            </tr>
            <tr>
                <td>26828</td>
                <td>865</td>
                <td><input type="text" value="" class="square2"></td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>19</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
            </tr>
        </table>

        <br><br>
        <table>
            <tr>
                <td class="fs">Причины невыполнения</td>
                <td></td>
            </tr>
        </table>

        <br><br>

        <table>
            <tr>
                <td class="bg" colspan="9">Аварийные остановки месторождения (откл.эл.энергий и др.)</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">НГДУ</td>
                <td class="bg" rowspan="2">ГУ</td>
                <td class="bg" rowspan="2">Кол.скв.</td>
                <td class="bg" rowspan="2">Вр.откл.</td>
                <td class="bg" rowspan="2">Вр.вкл.</td>
                <td class="bg" colspan="2">Потери</td>
                <td class="bg" rowspan="2">
                    <div>Вр.прост.,<div>мин
                </td>
                <td class="bg" rowspan="2">Причины аварийного отключения</td>
            </tr>
            <tr>
                <td class="bg">Qж м3.</td>
                <td class="bg">Qн тн.</td>


            </tr>
            <tr>
                <td>Итого</td>
                <td></td>
                <td>19</td>
                <td></td>
                <td></td>
                <td>6,9</td>
                <td>0,8</td>
                <td>0:11</td>
                <td></td>

            </tr>
            <tr>
                <td>2</td>
                <td>41</td>
                <td>19</td>
                <td>8:54:00</td>
                <td>9:05:00</td>
                <td>6,9</td>
                <td>0,8</td>
                <td>0:11</td>
                <td>Касание проводов спец/техникой трубоукладчика(ккс)</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>




    </div>
</div>
@endsection
<link href="{{ asset('css/visualcenter2.css')}}" rel="stylesheet">