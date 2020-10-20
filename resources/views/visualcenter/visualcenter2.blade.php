@extends('layouts.app')
@section('content')
<div class="col p-4">
    <div>
        <link href="style.css" type="text/css" rel="stylesheet" />
        <div class="head-info">Оперативная информация по АО "ОзенМунайГаз" для АО "НК "КазМунайГаз"</div>
        <table>
            <tr>
                <td class="fs" rowspan="3">добыча нефти</td>
                <td class="bg" colspan="7">добыча нефти, тонн</td>
                <td class="bg" colspan="7">сдача нефти, тонн</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">
                    <div>план<div>на месяц,тонн
                </td>
                <td class="bg" colspan="3">за сутки</td>
                <td class="bg" colspan="3">с начала месяца</td>
                <td class="bg" rowspan="2">план<div>на месяц,<div>тонн</td>
                <td class="bg" colspan="3">за сутки</td>
                <td class="bg" colspan="3">с начала месяца</td>
            </tr>
            <tr>
                <td class="bg">план</td>
                <td class="bg">факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">план</td>
                <td class="bg">факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">план</td>
                <td class="bg">факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">план</td>
                <td class="bg">факт</td>
                <td class="bg">(+,-)</td>
            </tr>
            <tr>
                <td class="fs">нефть,тн</td>
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
                <td class="fs">конденсат,тн</td>
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
            <td colspan="7">Сдача "Теnge OiL & Gas"=тн, Трикантер УХЭ=110тн, Трикантер BSG Technology ЦППН=97тн,
                Трикантер BSG Technology УПСВ 1/2=тн, СНО из УХЭ=тн,Сторонн.орг.=тн.</td>
            <tr>
        </table>

        <br>
        <br>

        <div class="left-side">
            <table>
                <tr>
                    <td class="fs" rowspan="2">добыча газа</td>
                    <td class="bg" rowspan="2">
                        <div>план<div>на месяц,тыс. м3
                    </td>
                    <td class="bg" colspan="3">за сутки</td>
                    <td class="bg" colspan="3">с начала месяца</td>
                </tr>
                <tr>
                    <td class="bg">план</td>
                    <td class="bg">факт</td>
                    <td class="bg">(+,-)</td>
                    <td class="bg">план</td>
                    <td class="bg">факт</td>
                    <td class="bg">(+,-)</td>
                </tr>
                <tr>
                    <td class="fs">всего, в т.ч</td>
                    <td>1</td>
                    <td>2</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td class="fs">всего природный</td>
                    <td>7</td>
                    <td>8</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td class="fs">газовые месторождения ао "омг"</td>
                    <td>13</td>
                    <td>14</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                </tr>
                <tr>
                    <td class="fs">гсп ао "омг"</td>
                    <td>19</td>
                    <td>20</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>21</td>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                </tr>
                <tr>
                    <td class="fs">попутный</td>
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
                    <td class="fs" rowspan="2">закачка воды, тыс.м3</td>
                    <td class="bg" rowspan="2">план<div>на месяц,<div>тыс. м3</td>
                    <td class="bg" colspan="3">за сутки</td>
                    <td class="bg" colspan="3">с начала месяца</td>
                </tr>
                <tr>
                    <td class="bg">план</td>
                    <td class="bg">факт</td>
                    <td class="bg">(+,-)</td>
                    <td class="bg">план</td>
                    <td class="bg">факт</td>
                    <td class="bg">(+,-)</td>
                </tr>
                <tr>
                    <td class="fs">всего</td>
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
                    <td class="fs">в .т. ч. морская</td>
                    <td>1111</td>
                    <td>36</td>
                    <td><input type="text" value="" class="square2"></td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td class="fs">сточная</td>
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
                    <td class="bg" colspan="2">простой добывающих скважин</td>
                </tr>
                <tr>
                    <td class="left">причины простоя</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">прс</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">опрс</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">окрс</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">КРС</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">иссл скв (рпл, гис, кву, квд, муо)</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">прочие (вувэ, экв, вус, обводн. и т.д.)</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">нерентабельные</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">ограничение скважин по добыче</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">ограничение скважин с чрф</td>
                    <td><input type="text" value="" class="square2"></td>
                </tr>
                <tr>
                    <td class="left">всего</td>
                    <td>483</td>
                </tr>
                <tr>
                    <td class="left">недобор нефти, тонн</td>
                    <td>1212</td>
                </tr>
            </table>

        </div>


        <table>
            <tr>
                <td class="fs" rowspan="3">динамика фонда скважин</td>
                <td class="bg" colspan="5">добывающий фонд</td>
                <td class="bg" rowspan="2">
                    <div>ожид.ликвид
                </td>
                <td class="bg" rowspan="2">в консер-ии</td>
                <td class="bg" colspan="5">нагнетательный фонд</td>
                <td class="bg" rowspan="2">
                    <div>ожид.ликвид
                </td>
                <td class="bg" rowspan="2">в консервации</td>
            </tr>
            <tr>
                <td class="bg">экспл.</td>
                <td class="bg">действ.</td>
                <td class="bg">простой</td>
                <td class="bg">б/д</td>
                <td class="bg">освоение</td>
                <td class="bg">экспл.</td>
                <td class="bg">действ.</td>
                <td class="bg">простой</td>
                <td class="bg">б/д</td>
                <td class="bg">обустр-во</td>
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
                <td colspan="7">из освоения 9816/73</td>
                <td colspan="7">из бурения 809/10</td>
            </tr>
        </table>

        <br><br>

        <table>
            <tr>
                <td class="fs" rowspan="4">бурение скважин</td>
                <td class="bg" colspan="7">проходка, метр</td>
                <td class="bg" colspan="4">ввод скважин</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">план<div>на месяц</td>
                <td class="bg" colspan="3">суточная</td>
                <td class="bg" colspan="3">с начала месяца</td>
                <td class="bg" rowspan="2">план<div>на месяц</td>
                <td class="bg">за сутки</td>
                <td class="bg" colspan="2">с начала месяца</td>
            </tr>
            <tr>
                <td class="bg">план</td>
                <td class="bg">факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">план</td>
                <td class="bg">факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">факт</td>
                <td class="bg">план</td>
                <td class="bg">факт</td>
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
                <td class="fs">причины невыполнения</td>
                <td></td>
            </tr>
        </table>

        <br><br>

        <table>
            <tr>
                <td class="bg" colspan="9">аварийные остановки месторождения (откл.эл.энергий и др.)</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">нгду</td>
                <td class="bg" rowspan="2">гу</td>
                <td class="bg" rowspan="2">кол.скв.</td>
                <td class="bg" rowspan="2">вр.откл.</td>
                <td class="bg" rowspan="2">вр.вкл.</td>
                <td class="bg" colspan="2">потери</td>
                <td class="bg" rowspan="2">
                    <div>вр.прост.,<div>мин
                </td>
                <td class="bg" rowspan="2">причины аварийного отключения</td>
            </tr>
            <tr>
                <td class="bg">qж м3.</td>
                <td class="bg">qн тн.</td>
                

            </tr>
            <tr>
                <td>итого</td>
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
                <td>касание проводов спец/техникой трубоукладчика(ккс)</td>
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