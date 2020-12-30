@extends('layouts.app')
@section('module_icon')
    <svg width="35" height="26" viewBox="0 0 35 26" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M17.2121 24.2993V20.4489H2.12792C1.38597 20.4489 0.820801 19.8484 0.820801 19.1418L0.820801 6.77752C0.820801 6.03557 1.42132 5.43531 2.12792 5.43531L17.2121 5.43531V1.54932C17.2121 0.454067 18.484 -0.181813 19.3669 0.489424L33.8862 11.8647C34.5571 12.3946 34.5571 13.4192 33.8862 13.9487L19.3669 25.3238C18.484 25.9951 17.2121 25.3946 17.2121 24.2993ZM9.62248 11.5283L17.6745 11.5283V7.4879H20.0111V18.3328H17.6745V14.3016L9.62248 14.3016V11.5283ZM20.8722 11.5283V7.4879L23.2091 7.4879V18.3328H20.8722V14.3016V11.5283Z"
              fill="#3366FF"/>
    </svg>
@endsection
@section('module_title', 'Оптимизация разработки')
@section('content')
    <div class="anticrisis-wrapper d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="left-side flex-grow-1 pr-2">
            <div class="first-string">
                <div class="table-responsive">
                    <table class="table table1">
                        <tr>
                            <td>
                                <div class="first-td-header">
                                    <div class="nu">
                                        <div class="number">
                                            259 846
                                        </div>
                                        <div class="unit-vc">млн. тенге</div>
                                    </div>
                                    <div class="txt1 ml-2">Выручка</div>
                                    <div class="progress"><br>
                                        <div role="progressbar" aria-valuenow="50416" aria-valuemin="0"
                                             aria-valuemax="49408" class="progress-bar" style="width: 89%;"></div>
                                    </div>
                                    <div class="percent-header">
                                        89.25%
                                    </div>
                                    <div class="plan-header">
                                        291 167
                                    </div>
                                    <div class="dynamic">
                                        <div class="arrow2"></div>
                                        <div class="txt2">
                                            10,75%
                                        </div>
                                        <div class="txt3">vs Базовый вариант</div>
                                    </div>
                                </div>
                                <div class="second-td-header">
                                    <div class="vert-line"></div>
                                </div>
                            </td>
                            <td>
                                <div class="first-td-header">
                                    <div class="nu">
                                        <div class="number">
                                            175 083
                                        </div>
                                        <div class="unit-vc">млн. тенге</div>
                                    </div>
                                    <div class="txt1">Расходы</div>
                                    <div class="progress"><br>
                                        <div role="progressbar" aria-valuenow="50416" aria-valuemin="0"
                                             aria-valuemax="49408" class="progress-bar" style="width: 71%;"></div>
                                    </div>
                                    <div class="percent-header">
                                        71.1%
                                    </div>
                                    <div class="plan-header">
                                        246&nbsp;236
                                    </div>
                                    <div class="dynamic">
                                        <div class="arrow" style="transform: rotate(180deg); top: 0"></div>
                                        <div class="txt2">
                                            28,9%
                                        </div>
                                        <div class="txt3">vs Базовый вариант</div>
                                    </div>
                                </div>
                                <div class="second-td-header">
                                    <div class="vert-line"></div>
                                </div>
                            </td>
                            <td>
                                <div class="first-td-header">
                                    <div class="nu">
                                        <div class="number">
                                            1 603
                                        </div>
                                        <div class="unit-vc">млн. тенге</div>
                                    </div>
                                    <div class="txt1">Операционная прибыль</div>
                                    <div class="progress"><br>
                                        <div role="progressbar" aria-valuenow="50416" aria-valuemin="0"
                                             aria-valuemax="49408" class="progress-bar" style="width: 100%;"></div>
                                    </div>
                                    <div class="percent-header">

                                    </div>
                                    <div class="plan-header">
                                        -48&nbsp;253
                                    </div>
                                    <div class="dynamic">
                                        <div class="arrow"></div>
                                        <div class="txt2">
                                            49 856
                                        </div>
                                        <div class="txt3">млн. тенге vs Базовый вариант</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-small">
                                <div class="nu">
                                    <div class="number">20$</div>
                                    <div class="unit-vc">$ / bbl</div>
                                </div>
                                <br>
                                <div class="txt1">Цена на нефть</div>
                                <div class="percent-currency">
                                    <div class="arrow" style="position: relative; top: 5px"></div>
                                    <div class="txt2">0,1%</div>
                                    <div class="txt3">vs вчера</div>
                                </div>
                            </td>
                            <td class="td-small">
                                <div class="nu">
                                    <div class="number">435</div>
                                    <div class="unit-vc">тг/$</div>
                                </div>
                                <br>
                                <div class="txt1">Курс доллара</div>
                                <div class="percent-currency">
                                    <div class="arrow2" style="position: relative; top: 5px"></div>
                                    <div class="txt2">0,1%</div>
                                    <div class="txt3">vs вчера</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="first-table big-area" style="display: block;">
                <div class="first-string first-string2">
                    <div class="row px-4 mt-3">
                        <div class="col dropdown3">
                            <div class="button1 active" data-tab="tab1">
                                <p>Экономическая эффективность</p>
                            </div>
                        </div>
                        <div class="col dropdown3">
                            <div class="button1" data-tab="tab2">
                                <p>Технологические показатели</p>
                            </div>
                        </div>
                        <div class="col dropdown3">
                            <div class="button1" data-tab="tab3">
                                <p>Технико-экономические показатели</p>
                            </div>
                        </div>
                        <div class="col dropdown3">
                            <div class="button1" data-tab="tab4">
                                <p>Обзорная карта скважин</p>
                            </div>
                        </div>
                        <div class="col dropdown3">
                            <div class="button1" data-tab="tab5">
                                <p>Таблица изменений скважины «Светофор»</p>
                            </div>
                        </div>
                        <div class="col dropdown3">
                            <div class="button1" data-tab="tab6">
                                <p>Зависимость прибыли скважин “Дикобраз”</p>
                            </div>
                        </div>
                        <div class="col dropdown3">
                            <div class="button1" data-tab="tab7">
                                <p>Варианты при цене на нефть в Х $/баррель</p>
                            </div>
                        </div>
                        <div class="col dropdown3">
                            <div class="button1" data-tab="tab8">
                                <p>Денежный поток НДО “Шахматка”</p>
                            </div>
                        </div>
                    </div>
                    <div class="tabs">
                        <div class="tab tab_1 active" id="tab1">
                            <div class="row">
                                <div class="col-12">
                                    <p class="tab__title">Зависимость экономической эффективности от остановки
                                        нерентабельных
                                        скважин и доли оплаты простаивающего персонала</p>
                                    <div class="chart-wrap">
                                        <div class="chart-inner">
                                            <div id="main_chart"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <table class="anti-table w-100">
                                        <thead>
                                        <tr>
                                            <th colspan="2">Удельные показатели</th>
                                            <th>Единица измерения</th>
                                            <th>ОМГ</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2"><b>Курс $</b></th>
                                            <th>тенге</th>
                                            <th>435</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td rowspan="7"><b>Средняя цена на нефть при BRENT</b></td>
                                            <td>20 $/bbl</td>
                                            <td rowspan="7">тенге/тонну нефти</td>
                                            <td>59,356</td>
                                        </tr>
                                        <tr>
                                            <td>25 $/bbl</td>
                                            <td>68,306</td>
                                        </tr>
                                        <tr>
                                            <td>30 $/bbl</td>
                                            <td>77,256</td>
                                        </tr>
                                        <tr>
                                            <td>35 $/bbl</td>
                                            <td>86,206</td>
                                        </tr>
                                        <tr>
                                            <td>40 $/bbl</td>
                                            <td>95,156</td>
                                        </tr>
                                        <tr>
                                            <td>50 $/bbl</td>
                                            <td>113,056</td>
                                        </tr>
                                        <tr>
                                            <td>60 $/bbl</td>
                                            <td>130,955</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Условно-переменные расходы (сырье, материалы, энергия, за
                                                    исключением расходов на ПРС)</b></td>
                                            <td>тенге/тонну жидкости</td>
                                            <td>348</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Затраты на персонал</b></td>
                                            <td rowspan="4">тыс. тенге/скв</td>
                                            <td>19,108</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>КРС</b></td>
                                            <td>9,010</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Условно-постоянные расходы</b></td>
                                            <td>14,452</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>ОАР</b></td>
                                            <td>2,697</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Средняя стоимость ПРС (с ФОТ)</b></td>
                                            <td>тыс.тенге на операцию</td>
                                            <td>3,950</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6 text-center">
                                    <div style="display: inline-block" id="small_chart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab tab_2" id="tab2">
                            <p class="tab__title">Технологические показатели</p>
                            <table class="anti-table w-100">
                                <thead>
                                <tr>
                                    <th rowspan="2">Показатели</th>
                                    <th rowspan="2">Ед. изм</th>
                                    <th colspan="8">Сценарии</th>
                                </tr>
                                <tr>
                                    <th>ПП-2020</th>
                                    <th>60$/бар</th>
                                    <th>50$/бар</th>
                                    <th>40$/бар</th>
                                    <th>35$/бар</th>
                                    <th>30$/бар</th>
                                    <th>25$/бар</th>
                                    <th>20$/бар</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Добыча нефти</td>
                                    <td>тыс. т/год</td>
                                    <td>5,660</td>
                                    <td class="green">5,320</td>
                                    <td class="green">5,225</td>
                                    <td class="green">5,181</td>
                                    <td class="green">5,020</td>
                                    <td class="green">4,947</td>
                                    <td class="green">4,673</td>
                                    <td class="green">4,378</td>
                                </tr>
                                <tr>
                                    <td>Добыча от ГТМ</td>
                                    <td>тыс. т/год</td>
                                    <td>648,6</td>
                                    <td>639,9</td>
                                    <td>639,9</td>
                                    <td>638,6</td>
                                    <td>636,7</td>
                                    <td>634,4</td>
                                    <td>592,4</td>
                                    <td>475,7</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;в т.ч. от ВНС</td>
                                    <td>тыс. т/год</td>
                                    <td>241,5</td>
                                    <td class="green">229,1</td>
                                    <td class="green">229,1</td>
                                    <td class="green">229,1</td>
                                    <td class="green">229,1</td>
                                    <td class="green">229,1</td>
                                    <td class="green">189,6</td>
                                    <td class="green">76,6</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;в т.ч. от ГТМ</td>
                                    <td>тыс. т/год</td>
                                    <td>407,1</td>
                                    <td>410,8</td>
                                    <td>410,8</td>
                                    <td>409,6</td>
                                    <td>407,6</td>
                                    <td>405,3</td>
                                    <td>402,7</td>
                                    <td>399,1</td>
                                </tr>
                                <tr>
                                    <td>Действующий фонд скважин</td>
                                    <td>скв.</td>
                                    <td>3,629</td>
                                    <td>3,029</td>
                                    <td>2,797</td>
                                    <td>2,726</td>
                                    <td>2,480</td>
                                    <td>2,381</td>
                                    <td>2,068</td>
                                    <td>1,812</td>
                                </tr>
                                <tr>
                                    <td>Остановка НРС</td>
                                    <td>скв.</td>
                                    <td></td>
                                    <td>752</td>
                                    <td>943</td>
                                    <td>1,014</td>
                                    <td>1,260</td>
                                    <td>1,359</td>
                                    <td>1,649</td>
                                    <td>1,830</td>
                                </tr>
                                <tr>
                                    <td>Количество КРС</td>
                                    <td>рем./год</td>
                                    <td>933</td>
                                    <td>723</td>
                                    <td>669</td>
                                    <td>650</td>
                                    <td>581</td>
                                    <td>553</td>
                                    <td>473</td>
                                    <td>422</td>
                                </tr>
                                <tr>
                                    <td>Количество ГТМ по видам</td>
                                    <td>скв.</td>
                                    <td>1110</td>
                                    <td>1110</td>
                                    <td>934</td>
                                    <td>832</td>
                                    <td>739</td>
                                    <td>715</td>
                                    <td>650</td>
                                    <td>552</td>
                                </tr>
                                <tr>
                                    <td>ГРП</td>
                                    <td>скв.</td>
                                    <td>116</td>
                                    <td>116</td>
                                    <td>116</td>
                                    <td>116</td>
                                    <td>116</td>
                                    <td>116</td>
                                    <td>116</td>
                                    <td>116</td>
                                </tr>
                                <tr>
                                    <td>скин_ГРП</td>
                                    <td>скв.</td>
                                    <td>100</td>
                                    <td>100</td>
                                    <td>100</td>
                                    <td>100</td>
                                    <td>100</td>
                                    <td>100</td>
                                    <td>100</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <td>ПОТ</td>
                                    <td>скв.</td>
                                    <td>250</td>
                                    <td>250</td>
                                    <td>250</td>
                                    <td>250</td>
                                    <td>250</td>
                                    <td>250</td>
                                    <td>250</td>
                                    <td>250</td>
                                </tr>
                                <tr>
                                    <td>Перевод под нефть</td>
                                    <td>скв.</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>ПВР (дострел+перестрел)</td>
                                    <td>скв.</td>
                                    <td>190</td>
                                    <td>190</td>
                                    <td>124</td>
                                    <td>95</td>
                                    <td>61</td>
                                    <td>46</td>
                                    <td>18</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>ПВЛГ</td>
                                    <td>скв.</td>
                                    <td>37</td>
                                    <td>37</td>
                                    <td>37</td>
                                    <td>34</td>
                                    <td>30</td>
                                    <td>26</td>
                                    <td>22</td>
                                    <td>17</td>
                                </tr>
                                <tr>
                                    <td>РИР</td>
                                    <td>скв.</td>
                                    <td>100</td>
                                    <td>100</td>
                                    <td>60</td>
                                    <td>30</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>Углубление</td>
                                    <td>скв.</td>
                                    <td>7</td>
                                    <td>7</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>Ввод из бездействия</td>
                                    <td>скв.</td>
                                    <td>40</td>
                                    <td>40</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>Перевод под ППД</td>
                                    <td>скв.</td>
                                    <td>48</td>
                                    <td>48</td>
                                    <td>40</td>
                                    <td>25</td>
                                    <td>25</td>
                                    <td>20</td>
                                    <td>10</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <td>Бурение нагнет. скважин</td>
                                    <td>скв.</td>
                                    <td>65</td>
                                    <td>65</td>
                                    <td>50</td>
                                    <td>25</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab tab_3" id="tab3">
                            <p class="tab__title">Техно-экономические показатели по АО “Озенмунайгаз”</p>
                            <table class="anti-table w-100">
                                <thead>
                                <tr>
                                    <th rowspan="3">Показатели</th>
                                    <th rowspan="3">Ед. изм</th>
                                    <th colspan="8">Сценарии</th>
                                </tr>
                                <tr>
                                    <th rowspan="2">ПП-2020 20$/барр.</th>
                                    <th>60$/</th>
                                    <th>50$/</th>
                                    <th>40$/</th>
                                    <th>35$/</th>
                                    <th>30$/</th>
                                    <th>25$/</th>
                                    <th>20$/</th>
                                </tr>
                                <tr>
                                    <th>барр.</th>
                                    <th>барр.</th>
                                    <th>барр.</th>
                                    <th>барр.</th>
                                    <th>барр.</th>
                                    <th>барр.</th>
                                    <th>барр.</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Добыча нефти</td>
                                    <td>тыс.т/год</td>
                                    <td>5,660</td>
                                    <td>5,320</td>
                                    <td>5,225</td>
                                    <td>5,181</td>
                                    <td>5,020</td>
                                    <td>4,947</td>
                                    <td>4,673</td>
                                    <td>4,378</td>
                                </tr>
                                <tr>
                                    <td>в т.ч. от новых скважин</td>
                                    <td>тыс.т/год</td>
                                    <td>241.5</td>
                                    <td>229.1</td>
                                    <td>229.1</td>
                                    <td>229.1</td>
                                    <td>229.1</td>
                                    <td>229.1</td>
                                    <td>189.6</td>
                                    <td>76.6</td>
                                </tr>
                                <tr>
                                    <td>Действующий фонд скважин</td>
                                    <td>скв.</td>
                                    <td>3,629</td>
                                    <td>3,029</td>
                                    <td>2,797</td>
                                    <td>2,726</td>
                                    <td>2,480</td>
                                    <td>2,381</td>
                                    <td>2,068</td>
                                    <td>1,812</td>
                                </tr>
                                <tr>
                                    <td>в т.ч. новые скважины</td>
                                    <td>скв.</td>
                                    <td>151</td>
                                    <td>151</td>
                                    <td>151</td>
                                    <td>151</td>
                                    <td>151</td>
                                    <td>151</td>
                                    <td>128</td>
                                    <td>53</td>
                                </tr>
                                <tr class="tr_blue">
                                    <td>Остановка НРС</td>
                                    <td>скв.</td>
                                    <td>&nbsp;174</td>
                                    <td>752</td>
                                    <td>943</td>
                                    <td>1,014</td>
                                    <td>1,260</td>
                                    <td>1,359</td>
                                    <td>1,649</td>
                                    <td>1,830</td>
                                </tr>
                                <tr class="tr_blue">
                                    <td>Количество ПРС</td>
                                    <td>рем./год</td>
                                    <td>17,056</td>
                                    <td>11,886</td>
                                    <td>10,841</td>
                                    <td>10,417</td>
                                    <td>9,020</td>
                                    <td>8,492</td>
                                    <td>7,020</td>
                                    <td>6,077</td>
                                </tr>
                                <tr class="tr_blue">
                                    <td>Количество бригад ПРС</td>
                                    <td>бригад</td>
                                    <td>95</td>
                                    <td>71</td>
                                    <td>66</td>
                                    <td>64</td>
                                    <td>57</td>
                                    <td>54</td>
                                    <td>47</td>
                                    <td>43</td>
                                </tr>
                                <tr class="tr_blue">
                                    <td>Количество КРС</td>
                                    <td>рем./год</td>
                                    <td>933</td>
                                    <td>723</td>
                                    <td>669</td>
                                    <td>650</td>
                                    <td>581</td>
                                    <td>553</td>
                                    <td>473</td>
                                    <td>422</td>
                                </tr>
                                <tr class="tr_blue">
                                    <td>Затраты на персонал (ФОТ)</td>
                                    <td>млн. тг</td>
                                    <td>111,223</td>
                                    <td>99,324</td>
                                    <td>96,189</td>
                                    <td>94,980</td>
                                    <td>90,878</td>
                                    <td>89,270</td>
                                    <td>84,364</td>
                                    <td>80,506</td>
                                </tr>
                                <tr class="tr_green">
                                    <td>Доходы по переходящему фонду</td>
                                    <td>млн. тг</td>
                                    <td>&nbsp;</td>
                                    <td>666,631</td>
                                    <td>564,829</td>
                                    <td>471,220</td>
                                    <td>413,036</td>
                                    <td>364,507</td>
                                    <td>306,255</td>
                                    <td>255,298</td>
                                </tr>
                                <tr class="tr_green">
                                    <td>Расходы по переходящем фонду</td>
                                    <td>млн. тг</td>
                                    <td>&nbsp;</td>
                                    <td>483,207</td>
                                    <td>408,261</td>
                                    <td>336,492</td>
                                    <td>314,138</td>
                                    <td>290,411</td>
                                    <td>262,835</td>
                                    <td>237,430</td>
                                </tr>
                                <tr class="tr_green">
                                    <td>Финансовый результат после оптимизации</td>
                                    <td>млн. тг</td>
                                    <td></td>
                                    <td>183,423</td>
                                    <td>156,568</td>
                                    <td>134,729</td>
                                    <td>98,898</td>
                                    <td>74,096</td>
                                    <td>45,881</td>
                                    <td>17,868</td>
                                </tr>
                                <tr class="tr_green">
                                    <td><b> КВЛ, в том числе:</b></td>
                                    <td><b>млн. тг</b></td>
                                    <td><b>130,054</b></td>
                                    <td><b>117,324</b></td>
                                    <td><b>117,324</b></td>
                                    <td><b>117,324</b></td>
                                    <td><b>107,765</b></td>
                                    <td><b>81,735</b></td>
                                    <td><b>50,874</b></td>
                                    <td><b>19,354</b></td>
                                </tr>
                                <tr class="tr_green">
                                    <td>Бурение</td>
                                    <td>млн. тг</td>
                                    <td>68,395</td>
                                    <td>55,665</td>
                                    <td>55,665</td>
                                    <td>55,665</td>
                                    <td>55,665</td>
                                    <td>55,665</td>
                                    <td>45,636</td>
                                    <td>17,751</td>
                                </tr>
                                <tr class="tr_green">
                                    <td>Приобретение ОС</td>
                                    <td>млн. тг</td>
                                    <td>34,739</td>
                                    <td>34,739</td>
                                    <td>34,739</td>
                                    <td>34,739</td>
                                    <td>34,739</td>
                                    <td>26,070</td>
                                    <td>5,238</td>
                                    <td>1,603</td>
                                </tr>
                                <tr class="tr_green">
                                    <td>Строител-во, модернизация</td>
                                    <td>млн. тг</td>
                                    <td>26,920</td>
                                    <td>26,920</td>
                                    <td>26,920</td>
                                    <td>26,920</td>
                                    <td>17,361</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td><b>Доходы (выручка)</b></td>
                                    <td><b>млн.тг/год</b></td>
                                    <td><b>332,370</b></td>
                                    <td><b>696,628</b></td>
                                    <td><b>590,725</b></td>
                                    <td><b>493,017</b></td>
                                    <td><b>432,782</b></td>
                                    <td><b>382,203</b></td>
                                    <td><b>319,209</b></td>
                                    <td><b>259,846</b></td>
                                </tr>
                                <tr>
                                    <td><b>Расходы*</b></td>
                                    <td><b>млн.тг/год</b></td>
                                    <td><b>362,794</b></td>
                                    <td><b>495,457</b></td>
                                    <td><b>419,963</b></td>
                                    <td><b>347,645</b></td>
                                    <td><b>325,017</b></td>
                                    <td><b>300,469</b></td>
                                    <td><b>268,334</b></td>
                                    <td><b>240,492</b></td>
                                </tr>
                                <tr>
                                    <td><b>Финансовый результат после КВЛ</b></td>
                                    <td><b>млн.тг/год</b></td>
                                    <td><b>-160,079</b></td>
                                    <td><b>83,846</b></td>
                                    <td><b>53,438</b></td>
                                    <td><b>28,048</b></td>
                                    <td><b>-</b></td>
                                    <td><b>-</b></td>
                                    <td><b>-</b></td>
                                    <td><b>-</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab tab_4" id="tab4">
                            <p class="tab__title">Обзорная карта расположения скважин по экономической эффективности</p>
                            <div class="tab__map">
                                <img src="/img/anticrisis_map.svg">
                                <div class="tab__map-legend">
                                    <div class="tab__map-legend-row tab__map-legend-row_1">
                                        <p class="tab__map-legend-row-item tab__map-legend-row-item_1"><span>НГДУ-1</span></p>
                                        <p class="tab__map-legend-row-item tab__map-legend-row-item_2"><span>НГДУ-2</span></p>
                                        <p class="tab__map-legend-row-item tab__map-legend-row-item_3"><span>НГДУ-3</span></p>
                                        <p class="tab__map-legend-row-item tab__map-legend-row-item_4"><span>НГДУ-4</span></p>
                                    </div>
                                    <div class="tab__map-legend-row tab__map-legend-row_2">
                                        <p class="tab__map-legend-row-item tab__map-legend-row-item_1"><span>Рентабельные</span></p>
                                        <p class="tab__map-legend-row-item tab__map-legend-row-item_2"><span>Нерентабельные</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab tab_5" id="tab5">
                            <table class="anti-table w-100">
                                <thead>
                                <tr>
                                    <th>Скв.</th>
                                    <th>НГДУ</th>
                                    <th>20$</th>
                                    <th>25$</th>
                                    <th>30$</th>
                                    <th>35$</th>
                                    <th>40$</th>
                                    <th>50$</th>
                                    <th>60$</th>
                                    <th></th>
                                    <th>Скв.</th>
                                    <th>НГДУ</th>
                                    <th>20$</th>
                                    <th>25$</th>
                                    <th>30$</th>
                                    <th>35$</th>
                                    <th>40$</th>
                                    <th>50$</th>
                                    <th>60$</th>
                                    <th></th>
                                    <th>Скв.</th>
                                    <th>НГДУ</th>
                                    <th>20$</th>
                                    <th>25$</th>
                                    <th>30$</th>
                                    <th>35$</th>
                                    <th>40$</th>
                                    <th>50$</th>
                                    <th>60$</th>
                                    <th></th>
                                    <th>Скв.</th>
                                    <th>НГДУ</th>
                                    <th>20$</th>
                                    <th>25$</th>
                                    <th>30$</th>
                                    <th>35$</th>
                                    <th>40$</th>
                                    <th>50$</th>
                                    <th>60$</th>
                                    <th></th>
                                    <th>Скв.</th>
                                    <th>НГДУ</th>
                                    <th>20$</th>
                                    <th>25$</th>
                                    <th>30$</th>
                                    <th>35$</th>
                                    <th>40$</th>
                                    <th>50$</th>
                                    <th>60$</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                <tr>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="red"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td></td>
                                    <td>UZN_0119</td>
                                    <td>НГДУ-1</td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                    <td class="green"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab tab_6" id="tab6">
                            <div id="hedgehog_chart"></div>
                        </div>
                        <div class="tab tab_7" id="tab7">
                            <p class="tab__title">Сравнение исходного и предлагаемого вариантов при цене на нефть в Х
                                $/баррель</p>
                            <p class="tab__title">ОМГ</p>
                            <table class="anti-table w-100">
                                <thead>
                                <tr>
                                    <th><b>Показатели</b></th>
                                    <th><b>Скважин</b></th>
                                    <th><b>Кол-во ПРС</b></th>
                                    <th style="min-width: 70px"><b>Кол-во ПРС на 1 скв.</b></th>
                                    <th><b>Обводненность средняя</b></th>
                                    <th><b>qн средний</b></th>
                                    <th><b>Добыча</b></th>
                                    <th><b>Численность ПП</b></th>
                                    <th><b>Выручка</b></th>
                                    <th><b>Реализация и НДПИ</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>Валовый доход</b></th>
                                    <th><b>Всего расходов</b></th>
                                    <th><b>в том числе:</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>Операц. прибыль / убыток</b></th>
                                    <th>Амортизация</th>
                                    <th><b>Операц. прибыль / убыток</b></th>
                                    <th><b>КПН</b></th>
                                    <th><b>Чистый доход / убыток</b></th>
                                    <th><b>Денежный поток</b></th>
                                    <th><b>КВЛ</b></th>
                                    <th><b>в том числе</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>Денежный поток-КВЛ</b></th>
                                </tr>
                                <tr>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th>НДПИ</th>
                                    <th>Рентный налог, ЭТП</th>
                                    <th>Транспортные расходы</th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th>Переменные</th>
                                    <th>ПРС с ФОТ</th>
                                    <th>Затраты на персонал</th>
                                    <th>Затраты на КРС</th>
                                    <th>Постоянные расходы</th>
                                    <th>ОАР</th>
                                    <th><b>&nbsp;</b></th>
                                    <th>Амортизация</th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th><b>&nbsp;</b></th>
                                    <th>Бурение</th>
                                    <th>ОС</th>
                                    <th>Стр-во и модер</th>
                                    <th>Прочие (ПИР, НМА)</th>
                                    <th><b>&nbsp;</b></th>
                                </tr>
                                <tr class="units">
                                    <th><b>&nbsp;</b></th>
                                    <th>ед.</th>
                                    <th>ед.</th>
                                    <th>ед.</th>
                                    <th>%</th>
                                    <th>тн/сут</th>
                                    <th>тыс. тн</th>
                                    <th>чел.</th>
                                    <th>млн. тенге</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>млн. тенге</th>
                                    <th>млн. тенге</th>
                                    <th>млн. тенге</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>млн. тенге</th>
                                    <th>&nbsp;</th>
                                    <th>млн. тенге</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>млн. тенге</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="32" class="text-left">
                                        <b style="font-size: 18px">при цене на экспорт - 20 $/bbl</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Всего скважин, в т.ч.:</b></td>
                                    <td><b>3,583</b></td>
                                    <td><b>16,944</b></td>
                                    <td><b>4.7</b></td>
                                    <td><b>88.1%</b></td>
                                    <td><b>4.0</b></td>
                                    <td><b>4,905 </b></td>
                                    <td><b>9,214 </b></td>
                                    <td><b>291,167 </b></td>
                                    <td><b>28,620 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>64,563 </b></td>
                                    <td><b>197,983 </b></td>
                                    <td><b>246,236 </b></td>
                                    <td><b>17,116 </b></td>
                                    <td><b>66,929 </b></td>
                                    <td><b>68,463 </b></td>
                                    <td><b>32,283 </b></td>
                                    <td><b>51,782 </b></td>
                                    <td><b>9,663 </b></td>
                                    <td><b>-48,253 </b></td>
                                    <td><b>26,992 </b></td>
                                    <td><b>-75,244 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-75,244 </b></td>
                                    <td><b>-48,253 </b></td>
                                    <td><b>130,054 </b></td>
                                    <td><b>68,395 </b></td>
                                    <td><span style="font-family: Arial;">34,739 </span></td>
                                    <td><span style="font-family: Arial;">26,167 </span></td>
                                    <td><span style="font-family: Arial;">753 </span></td>
                                    <td><span style="font-family: Arial;">-178,307 </span></td>
                                </tr>
                                <tr>
                                    <td><b>Рентабельные</b></td>
                                    <td><b>1,044</b></td>
                                    <td><b>3,258</b></td>
                                    <td><b>3.1</b></td>
                                    <td><b>78.6%</b></td>
                                    <td><b>8.5</b></td>
                                    <td><b>3,015 </b></td>
                                    <td><b>2,685 </b></td>
                                    <td><b>178,947 </b></td>
                                    <td><b>17,590 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>39,680 </b></td>
                                    <td><b>121,678 </b></td>
                                    <td><b>65,990 </b></td>
                                    <td><b>5,862 </b></td>
                                    <td><b>12,869 </b></td>
                                    <td><b>19,949 </b></td>
                                    <td><b>9,406 </b></td>
                                    <td><b>15,088 </b></td>
                                    <td><b>2,816 </b></td>
                                    <td><b>55,688 </b></td>
                                    <td><b>16,589 </b></td>
                                    <td><b>39,099 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>39,099 </b></td>
                                    <td><b>55,688 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Условно-рентабельные</b></td>
                                    <td><b>709</b></td>
                                    <td><b>2,819</b></td>
                                    <td><b>4.0</b></td>
                                    <td><b>90.0%</b></td>
                                    <td><b>3.7</b></td>
                                    <td><b>887 </b></td>
                                    <td><b>1,823 </b></td>
                                    <td><b>52,664 </b></td>
                                    <td><b>5,177 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>11,678 </b></td>
                                    <td><b>35,809 </b></td>
                                    <td><b>46,905 </b></td>
                                    <td><b>3,676 </b></td>
                                    <td><b>11,135 </b></td>
                                    <td><b>13,547 </b></td>
                                    <td><b>6,388 </b></td>
                                    <td><b>10,247 </b></td>
                                    <td><b>1,912 </b></td>
                                    <td><b>-11,096 </b></td>
                                    <td><b>4,882 </b></td>
                                    <td><b>-15,978 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-15,978 </b></td>
                                    <td><b>-11,096 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Нерентабельные, в т.ч.:</b></td>
                                    <td><b>1,830</b></td>
                                    <td><b>10,867</b></td>
                                    <td><b>5.9</b></td>
                                    <td><b>94.5%</b></td>
                                    <td><b>1.6</b></td>
                                    <td><b>1,003 </b></td>
                                    <td><b>4,706 </b></td>
                                    <td><b>59,556 </b></td>
                                    <td><b>5,854 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>13,206 </b></td>
                                    <td><b>40,496 </b></td>
                                    <td><b>133,340 </b></td>
                                    <td><b>7,577 </b></td>
                                    <td><b>42,925 </b></td>
                                    <td><b>34,967 </b></td>
                                    <td><b>16,488 </b></td>
                                    <td><b>26,447 </b></td>
                                    <td><b>4,935 </b></td>
                                    <td><b>-92,844 </b></td>
                                    <td><b>5,521 </b></td>
                                    <td><b>-98,365 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-98,365 </b></td>
                                    <td><b>-92,844 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Категория 1 - 1120 скв.</b></td>
                                    <td><b>1,120</b></td>
                                    <td><b>7,621</b></td>
                                    <td><b>6.8</b></td>
                                    <td><b>95.7%</b></td>
                                    <td><b>1.2</b></td>
                                    <td><b>470 </b></td>
                                    <td><b>2,880 </b></td>
                                    <td><b>27,918 </b></td>
                                    <td><b>2,744 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>6,191 </b></td>
                                    <td><b>18,984 </b></td>
                                    <td><b>85,366 </b></td>
                                    <td><b>4,564 </b></td>
                                    <td><b>30,103 </b></td>
                                    <td><b>21,401 </b></td>
                                    <td><b>10,091 </b></td>
                                    <td><b>16,186 </b></td>
                                    <td><b>3,021 </b></td>
                                    <td><b>-66,382 </b></td>
                                    <td><b>2,588 </b></td>
                                    <td><b>-68,970 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-68,970 </b></td>
                                    <td><b>-66,382 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Категория 2 - 710 скв.</b></td>
                                    <td><b>710</b></td>
                                    <td><b>3,246</b></td>
                                    <td><b>4.0</b></td>
                                    <td><b>94.5%</b></td>
                                    <td><b>2.2</b></td>
                                    <td><b>533</b></td>
                                    <td><b>1,826</b></td>
                                    <td><b>31,637</b></td>
                                    <td><b>3,110</b></td>
                                    <td><b>0</b></td>
                                    <td><b>7,015</b></td>
                                    <td><b>21,512</b></td>
                                    <td><b>47,975</b></td>
                                    <td><b>3,013</b></td>
                                    <td><b>12,822</b></td>
                                    <td><b>13,567</b></td>
                                    <td><b>6,397</b></td>
                                    <td><b>10,261</b></td>
                                    <td><b>1,915</b></td>
                                    <td><b>-26,462</b></td>
                                    <td><b>2,933</b></td>
                                    <td><b>-29,395</b></td>
                                    <td><b>-</b></td>
                                    <td><b>-29,395</b></td>
                                    <td><b>-26,462</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                </tr>
                                <tr>
                                    <td colspan="32" class="text-left"><b style="font-size: 18px">Экономика с учетом
                                            эксплуатационного бурения</b></td>
                                </tr>
                                <tr>
                                    <td><b>Всего скважин, в т.ч.:</b></td>
                                    <td><b>1,806</b></td>
                                    <td><b>6,130</b></td>
                                    <td><b>3.5</b></td>
                                    <td><b>94.5%</b></td>
                                    <td><b>7.2</b></td>
                                    <td><b>4,378 </b></td>
                                    <td><b>9,214 </b></td>
                                    <td><b>259,846 </b></td>
                                    <td><b>25,542 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>57,618 </b></td>
                                    <td><b>176,686 </b></td>
                                    <td><b>175,083 </b></td>
                                    <td><b>9,665 </b></td>
                                    <td><b>37,835 </b></td>
                                    <td><b>51,516 </b></td>
                                    <td><b>15,795 </b></td>
                                    <td><b>53,001 </b></td>
                                    <td><b>7,271 </b></td>
                                    <td><b>1,603 </b></td>
                                    <td><b>24,088 </b></td>
                                    <td><b>-22,485 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-22,485 </b></td>
                                    <td><b>-22,485 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><span style="font-family: Arial;">0 </span></td>
                                    <td><span style="font-family: Arial;">0 </span></td>
                                    <td><span style="font-family: Arial;">0 </span></td>
                                    <td><span style="font-family: Arial;">0 </span></td>
                                </tr>
                                <tr>
                                    <td><b>Рентабельные</b></td>
                                    <td><b>1,044</b></td>
                                    <td><b>3,258</b></td>
                                    <td><b>3</b></td>
                                    <td><b>75.8%</b></td>
                                    <td><b>9.6</b></td>
                                    <td><b>3,414 </b></td>
                                    <td><b>2,685 </b></td>
                                    <td><b>202,634 </b></td>
                                    <td><b>19,918 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>44,932 </b></td>
                                    <td><b>137,784 </b></td>
                                    <td><b>65,990 </b></td>
                                    <td><b>5,862 </b></td>
                                    <td><b>12,869 </b></td>
                                    <td><b>19,949 </b></td>
                                    <td><b>9,406 </b></td>
                                    <td><b>15,088 </b></td>
                                    <td><b>2,816 </b></td>
                                    <td><b>71,794</b></td>
                                    <td><b>18,785</b></td>
                                    <td><b>53,009</b></td>
                                    <td><b>-</b></td>
                                    <td><b>53,009</b></td>
                                    <td><b>71,794</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                </tr>
                                <tr>
                                    <td><b>Условно рентабельные - в работе - 709 скв.</b></td>
                                    <td><b>709</b></td>
                                    <td><b>2,819</b></td>
                                    <td><b>4</b></td>
                                    <td><b>90.0%</b></td>
                                    <td><b>3.7</b></td>
                                    <td><b>887 </b></td>
                                    <td><b>1,823 </b></td>
                                    <td><b>52,664 </b></td>
                                    <td><b>5,177 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>11,678 </b></td>
                                    <td><b>35,809 </b></td>
                                    <td><b>46,905 </b></td>
                                    <td><b>3,676 </b></td>
                                    <td><b>11,135 </b></td>
                                    <td><b>13,547 </b></td>
                                    <td><b>6,388 </b></td>
                                    <td><b>10,247 </b></td>
                                    <td><b>1,912 </b></td>
                                    <td>
                                        <b><u><span style="font-family: Arial; font-size: medium;">-11,096 </span></u></b>
                                    </td>
                                    <td><b>4,882 </b></td>
                                    <td><b>-15,978 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-15,978 </b></td>
                                    <td><b>-11,096 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Нерентабельные, в т.ч.:</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>7,586</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>42,830</b></td>
                                    <td><b>0</b></td>
                                    <td><b>13,622</b></td>
                                    <td><b>17,484</b></td>
                                    <td><b>0</b></td>
                                    <td><b>9,257</b></td>
                                    <td><b>2,468</b></td>
                                    <td><b>-42,830 </b></td>
                                    <td><b>0</b></td>
                                    <td><b>-42,830</b></td>
                                    <td><b>0</b></td>
                                    <td><b>-42,830</b></td>
                                    <td><b>-42,830</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Категория 1 - 1120 скв.</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0.0%</b></td>
                                    <td><b>0.0</b></td>
                                    <td><b>0 </b></td>
                                    <td><b>2,880 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>27,429 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>9,553 </b></td>
                                    <td><b>10,700 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>5,665 </b></td>
                                    <td><b>1,510 </b></td>
                                    <td><b>-27,429 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>-27,429 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-27,429 </b></td>
                                    <td><b>-27,429 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Категория 2 - 710 скв.</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0</b></td>
                                    <td><b>0.0%</b></td>
                                    <td><b>0.0</b></td>
                                    <td><b>0 </b></td>
                                    <td><b>4,706 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>15,401 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>4,069 </b></td>
                                    <td><b>6,783 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>3,591 </b></td>
                                    <td><b>957 </b></td>
                                    <td><b>-15,401 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>-15,401 </b></td>
                                    <td><b>-</b></td>
                                    <td><b>-15,401 </b></td>
                                    <td><b>-15,401 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>0 </b></td>
                                </tr>
                                <tr>
                                    <td><b>Новые Скважины</b></td>
                                    <td><b>53</b></td>
                                    <td><b>53</b></td>
                                    <td><b>1</b></td>
                                    <td><b>78.9%</b></td>
                                    <td><b>8.0</b></td>
                                    <td><b>77</b></td>
                                    <td><b>0</b></td>
                                    <td><b>4,548 </b></td>
                                    <td><b>447 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>1,009 </b></td>
                                    <td><b>3,093 </b></td>
                                    <td><b>19,358 </b></td>
                                    <td><b>127 </b></td>
                                    <td><b>209 </b></td>
                                    <td><b>536 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>18,410 </b></td>
                                    <td><b>76 </b></td>
                                    <td><b>-16,265 </b></td>
                                    <td><b>422 </b></td>
                                    <td><b>-16,687 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>-16,687 </b></td>
                                    <td><b>-16,687 </b></td>
                                    <td><b>0 </b></td>
                                    <td><b>&nbsp;</b></td>
                                    <td><b>&nbsp;</b></td>
                                    <td><b>&nbsp;</b></td>
                                    <td><b>&nbsp;</b></td>
                                    <td>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab tab_8" id="tab8">
                            <p class="tab__title">Денежный поток НДО при различных сценариях производственной программы
                                «Шахматка»</p>
                            <table class="anti-table w-100">
                                <thead>
                                <tr>
                                    <th colspan="9">Потребность в субсидировании со стороны КМГ при различных ценах на
                                        нефть и ПП
                                    </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th colspan="6">Производственная программа при цене на нефть</th>
                                </tr>
                                <tr>
                                    <th>курс 450 тенге/$</th>
                                    <th>ПП-2020</th>
                                    <th>60$/барр.</th>
                                    <th>50$/барр.</th>
                                    <th>40$/барр.</th>
                                    <th>35$/барр.</th>
                                    <th>30$/барр.</th>
                                    <th>25$/барр.</th>
                                    <th>20$/барр.</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr-subtitle">
                                    <td>Добыча, тыс.тонн</td>
                                    <td>5 560</td>
                                    <td>5 422</td>
                                    <td>5 300</td>
                                    <td>5 180</td>
                                    <td>5 112</td>
                                    <td>5 055</td>
                                    <td>4 844</td>
                                    <td>4 607</td>
                                </tr>
                                <tr class="tr-subsubtitle">
                                    <td></td>
                                    <td colspan="7">Доходы, млн. тенге</td>
                                </tr>
                                <tr>
                                    <td>60$/</td>
                                    <td></td>
                                    <td class="green">729 206</td>
                                    <td class="yellow">712 797</td>
                                    <td>696 676</td>
                                    <td>687 506</td>
                                    <td>679 853</td>
                                    <td>651 470</td>
                                    <td>619 606</td>
                                </tr>
                                <tr>
                                    <td>50$/</td>
                                    <td></td>
                                    <td class="yellow">628 601</td>
                                    <td class="green">614 652</td>
                                    <td class="yellow">600 750</td>
                                    <td>592 843</td>
                                    <td>586 243</td>
                                    <td>561 768</td>
                                    <td>534 291</td>
                                </tr>
                                <tr>
                                    <td>40$/</td>
                                    <td></td>
                                    <td class="orange">528 396</td>
                                    <td class="yellow">516 506</td>
                                    <td class="green">504 824</td>
                                    <td class="yellow">498 179</td>
                                    <td>492 633</td>
                                    <td>472 067</td>
                                    <td>448 977</td>
                                </tr>
                                <tr>
                                    <td>35$/</td>
                                    <td></td>
                                    <td class="text-danger">478 193</td>
                                    <td class="orange">467 433</td>
                                    <td class="yellow">456 861</td>
                                    <td class="green">450 848</td>
                                    <td class="yellow">445 829</td>
                                    <td>427 216</td>
                                    <td>406 320</td>
                                </tr>
                                <tr>
                                    <td>30$/</td>
                                    <td></td>
                                    <td class="text-danger">427 991</td>
                                    <td class="text-danger">418 360</td>
                                    <td class="orange">408 898</td>
                                    <td class="yellow">403 516</td>
                                    <td class="green">399 024</td>
                                    <td class="yellow">382 365</td>
                                    <td>363 663</td>
                                </tr>
                                <tr>
                                    <td>25$/</td>
                                    <td></td>
                                    <td class="text-danger">377 788</td>
                                    <td class="text-danger">369 287</td>
                                    <td class="text-danger">360 935</td>
                                    <td class="orange">356 184</td>
                                    <td class="yellow">352 219</td>
                                    <td class="green">337 515</td>
                                    <td class="yellow">321 006</td>
                                </tr>
                                <tr>
                                    <td>20$/</td>
                                    <td></td>
                                    <td class="text-danger">327 566</td>
                                    <td class="text-danger">320 214</td>
                                    <td class="text-danger">312 972</td>
                                    <td class="text-danger">308 853</td>
                                    <td class="orange">305 414</td>
                                    <td class="yellow">292 664</td>
                                    <td class="green">278 349</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="tr-subsubtitle">
                                    <td></td>
                                    <td colspan="7">Расходы, млн. тенге</td>
                                </tr>
                                <tr>
                                    <td>60$/</td>
                                    <td></td>
                                    <td class="green">482 291</td>
                                    <td class="yellow">466 581</td>
                                    <td class="orange">450 127</td>
                                    <td class="text-danger">442 202</td>
                                    <td class="text-danger">435 537</td>
                                    <td class="text-danger">412 163</td>
                                    <td class="text-danger">392 169</td>
                                </tr>
                                <tr>
                                    <td>50$/</td>
                                    <td></td>
                                    <td class="yellow">431 492</td>
                                    <td class="green">416 926</td>
                                    <td class="yellow">401 594</td>
                                    <td class="orange">394 308</td>
                                    <td class="text-danger">388 176</td>
                                    <td class="text-danger">366 779</td>
                                    <td class="text-danger">349 006</td>
                                </tr>
                                <tr>
                                    <td>40$/</td>
                                    <td></td>
                                    <td class="orange">377 073</td>
                                    <td class="yellow">363 731</td>
                                    <td class="green">349 603</td>
                                    <td class="yellow">343 001</td>
                                    <td class="orange">337 440</td>
                                    <td class="text-danger">318 161</td>
                                    <td class="text-danger">302 766</td>
                                </tr>
                                <tr>
                                    <td>35$/</td>
                                    <td></td>
                                    <td class="text-danger">366 076</td>
                                    <td class="orange">352 982</td>
                                    <td class="yellow">339 096</td>
                                    <td class="green">332 633</td>
                                    <td class="yellow">327 188</td>
                                    <td class="orange">308 337</td>
                                    <td class="text-danger">293 422</td>
                                </tr>
                                <tr>
                                    <td>30$/</td>
                                    <td></td>
                                    <td class="text-danger">341 076</td>
                                    <td class="text-danger">329 120</td>
                                    <td class="orange">315 774</td>
                                    <td class="yellow">309 618</td>
                                    <td class="green">304 429</td>
                                    <td class="yellow">286 528</td>
                                    <td class="orange">272 679</td>
                                </tr>
                                <tr>
                                    <td>25$/</td>
                                    <td></td>
                                    <td class="text-danger">341 665</td>
                                    <td class="text-danger">311 810</td>
                                    <td class="text-danger">298 856</td>
                                    <td class="orange">292 922</td>
                                    <td class="yellow">287 919</td>
                                    <td class="green">270 708</td>
                                    <td class="yellow">257 633</td>
                                </tr>
                                <tr>
                                    <td>20$/</td>
                                    <td></td>
                                    <td class="text-danger">323 957</td>
                                    <td class="text-danger">294 305</td>
                                    <td class="text-danger">281 747</td>
                                    <td class="text-danger">276 038</td>
                                    <td class="orange">271 223</td>
                                    <td class="yellow">254 709</td>
                                    <td class="green">242 416</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="tr-subsubtitle">
                                    <td rowspan="2">Цена на нефть</td>
                                    <td colspan="7">Расходы, млн. тенге</td>
                                </tr>
                                <tr class="tr-subsubtitle">
                                    <td></td>
                                    <td>60$/барр.</td>
                                    <td>50$/барр.</td>
                                    <td>40$/барр.</td>
                                    <td>35$/барр.</td>
                                    <td>30$/барр.</td>
                                    <td>25$/барр.</td>
                                    <td>20$/барр.</td>
                                </tr>
                                <tr>
                                    <td>60$/</td>
                                    <td class="light-green"><b>39 042</b></td>
                                    <td class="green"><b>128 572</b></td>
                                    <td class="light-green"><b>127 973</b></td>
                                    <td class="light-green"><b>128 207</b></td>
                                    <td class="light-green"><b>137 089</b></td>
                                    <td class="light-green"><b>158 380</b></td>
                                    <td class="light-green"><b>179 407</b></td>
                                    <td class="light-green"><b>193 902</b></td>
                                </tr>
                                <tr>
                                    <td>50$/</td>
                                    <td class="yellow"><b>-3 334</b></td>
                                    <td class="light-green"><b>78 966</b></td>
                                    <td class="green"><b>79 383</b></td>
                                    <td class="light-green"><b>80 813</b></td>
                                    <td class="light-green"><b>90 319</b></td>
                                    <td class="light-green"><b>112 131</b></td>
                                    <td class="light-green"><b>135 089</b></td>
                                    <td class="light-green"><b>151 752</b></td>
                                </tr>
                                <tr>
                                    <td>40$/</td>
                                    <td class="orange"><b>-43 461</b></td>
                                    <td class="light-green"><b>32 980</b></td>
                                    <td class="light-green"><b>34 432</b></td>
                                    <td class="green"><b>36 879</b></td>
                                    <td class="light-green"><b>46 963</b></td>
                                    <td class="light-green"><b>69 258</b></td>
                                    <td class="light-green"><b>94 006</b></td>
                                    <td class="light-green"><b>112 677</b></td>
                                </tr>
                                <tr>
                                    <td>35$/</td>
                                    <td class="red"><b>-78 838</b></td>
                                    <td class="yellow"><b>-6 226</b></td>
                                    <td class="yellow"><b>-3 892</b></td>
                                    <td class="yellow"><b>-578</b></td>
                                    <td class="green"><b>9 999</b></td>
                                    <td class="light-green"><b>32 705</b></td>
                                    <td class="light-green"><b>58 979</b></td>
                                    <td class="light-green"><b>79 364</b></td>
                                </tr>
                                <tr>
                                    <td>30$/</td>
                                    <td class="red"><b>-104 781</b></td>
                                    <td class="orange"><b>-32 017</b></td>
                                    <td class="orange"><b>-29 102</b></td>
                                    <td class="orange"><b>-25 219</b></td>
                                    <td class="yellow"><b>-14 317</b></td>
                                    <td class="green"><b>8 660</b></td>
                                    <td class="light-green"><b>35 937</b></td>
                                    <td class="light-green"><b>57 449</b></td>
                                </tr>
                                <tr>
                                    <td>25$/</td>
                                    <td class="red"><b>-137 480</b></td>
                                    <td class="red"><b>-64 512</b></td>
                                    <td class="red"><b>-60 866</b></td>
                                    <td class="red"><b>-56 264</b></td>
                                    <td class="orange"><b>-44 954</b></td>
                                    <td class="yellow"><b>-21 636</b></td>
                                    <td class="green"><b>6 907</b></td>
                                    <td class="light-green"><b>29 839</b></td>
                                </tr>
                                <tr>
                                    <td>20$/</td>
                                    <td class="red"><b>-170 179</b></td>
                                    <td class="red"><b>-96 806</b></td>
                                    <td class="red"><b>-92 433</b></td>
                                    <td class="red"><b>-87 118</b></td>
                                    <td class="red"><b>-75 401</b></td>
                                    <td class="red"><b>-51 744</b></td>
                                    <td class="yellow"><b>-21 945</b></td>
                                    <td class="green"><b>2 398</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-side2 flex-grow-1 pl-1">
            <div class="first-string">
                <div class="table-responsive">
                    <table class="table table1-2">
                        <tr>
                            <td colspan="2">
                                <div class="txt2">Фонд добывающих скважин</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table-wells">
                                    <tr>
                                        <td></td>
                                        <td>Базовый</td>
                                        <td>Выбранный</td>
                                    </tr>
                                    <tr>
                                        <td>Рентабельные</td>
                                        <td class="text-center">1 044</td>
                                        <td class="text-center">1 044</td>
                                    </tr>
                                    <tr>
                                        <td>Условно-рентабельные</td>
                                        <td class="text-center">709</td>
                                        <td class="text-center">709</td>
                                    </tr>
                                    <tr>
                                        <td>Нерентабельные, в т.ч.</td>
                                        <td class="text-center">1 830</td>
                                        <td class="text-center">709</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;Категория 1 - 1120 скв.</td>
                                        <td class="text-center">1 120</td>
                                        <td class="text-center">0</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;Категория 2 - 710 скв.</td>
                                        <td class="text-center">710</td>
                                        <td class="text-center">0</td>
                                    </tr>
                                    <tr>
                                        <td>Новые скважины</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">53</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="first-string first-string2">
                    <div class="table-responsive">
                        <table class="table table1-2">
                            <tr>
                                <td class="w-50">
                                    <div class="d-flex align-items-center">
                                        <div class="txt4 text-nowrap">4 905</div>
                                        <div class="unit-vc ml-2" style="line-height: 1">тыс. тонн</div>
                                    </div>
                                    <div class="in-work">Базовый</div>
                                </td>
                                <td class="w-50">
                                    <div class="d-flex align-items-center">
                                        <div class="txt4 text-nowrap">4 378</div>
                                        <div class="unit-vc ml-2" style="line-height: 1">тыс. тонн</div>
                                    </div>
                                    <div class="in-idle">Выбранный</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="txt2">Добыча нефти</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="first-string first-string2">
                    <div class="table-responsive">
                        <table class="table table1-2">
                            <tr>
                                <td class="w-50">
                                    <div class="d-flex align-items-center">
                                        <div class="txt4 text-nowrap">16 944</div>
                                        <div class="unit-vc ml-2" style="line-height: 1">ед</div>
                                    </div>
                                    <div class="in-work">Базовый</div>
                                    <div class="txt2 mt-2 float-none">4,7</div>
                                    <div class="in-work">Удельно ПРС на скв</div>
                                </td>
                                <td class="w-50">
                                    <div class="d-flex align-items-center">
                                        <div class="txt4 text-nowrap">6 130</div>
                                        <div class="unit-vc ml-2" style="line-height: 1">ед</div>
                                    </div>
                                    <div class="in-idle">Выбранный</div>
                                    <div class="txt2 mt-2 float-none">3,5</div>
                                    <div class="in-idle clear">Удельно ПРС на скв</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="txt2">Общее количество ПРС</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="first-string first-string2">
                    <div class="table-responsive">
                        <table class="table table1-2">
                            <tr>
                                <td class="w-50">
                                    <div class="d-flex align-items-center">
                                        <div class="txt4">
                                            4,0
                                        </div>
                                        <div class="unit-vc ml-2">тонн/сутки</div>
                                    </div>
                                    <div class="in-work">Базовый</div>
                                </td>
                                <td class="w-50">
                                    <div class="d-flex align-items-center">
                                        <div class="txt4">
                                            7,2
                                        </div>
                                        <div class="unit-vc ml-2">тонн/сутки</div>
                                    </div>
                                    <div class="in-idle">Выбранный</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="txt2">Средний дебит нефти</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="first-string2 form-export">
                    <div class="txt2">Выбор сценария оптимизации</div>
                    <form action="">
                        <div class="field">
                            <select class="form-control">
                                <option value="">Выберите компанию</option>
                            </select>
                        </div>
                        <div class="field">
                            <select class="form-control">
                                <option value="">Цена на нефть</option>
                            </select>
                        </div>
                        <div class="field">
                            <select class="form-control">
                                <option value="">Процент оптимизации заработной платы</option>
                            </select>
                        </div>
                        <div class="field">
                            <select class="form-control">
                                <option value="">Процент остановки нерентабельного фонда</option>
                            </select>
                        </div>
                        <button type="button">
                            <svg width="17" height="20" viewBox="0 0 17 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.6145 5.72608L11.1298 1.24092C10.9393 1.05045 10.6809 0.943298 10.4118 0.943298H2.70447C2.14337 0.943298 1.68848 1.39833 1.68848 1.95943V18.2157C1.68848 18.7767 2.14337 19.2317 2.70447 19.2317H14.8961C15.4571 19.2317 15.9121 18.7767 15.9121 18.2157V6.44446C15.9121 6.17488 15.8051 5.91655 15.6145 5.72608V5.72608Z"
                                      stroke="white" stroke-width="1.4" stroke-miterlimit="22.9256"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path d="M9.9353 0.943298V6.04745C9.9353 6.60856 10.3903 7.0636 10.9513 7.0636H15.9116"
                                      stroke="white" stroke-width="1.4" stroke-miterlimit="22.9256"
                                      stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M5.11598 13.3323C5.41401 13.3323 5.65631 13.4287 5.84325 13.6211C6.0302 13.8107 6.12404 14.0585 6.12404 14.3645C6.12404 14.4244 6.12403 14.4786 6.11048 14.5274H4.7449C4.7449 14.6383 4.78281 14.7332 4.85868 14.8119C4.93454 14.8876 5.02802 14.9255 5.13897 14.9255C5.29069 14.9255 5.39779 14.8646 5.4601 14.7428H6.09411C6.02638 14.946 5.91275 15.1084 5.75263 15.2305C5.59278 15.3522 5.38439 15.4132 5.12673 15.4132C4.83683 15.4132 4.59029 15.3173 4.38722 15.1249C4.18673 14.9324 4.08643 14.6791 4.08643 14.3645C4.08643 14.0665 4.1758 13.8199 4.35448 13.6249C4.53614 13.4298 4.78798 13.3323 5.11052 13.3323H5.11598ZM5.10242 13.7755C5.00218 13.7755 4.92069 13.8065 4.85851 13.8687C4.7962 13.9287 4.75971 14.0032 4.74887 14.0922H5.4558C5.44226 14.0005 5.40706 13.9244 5.34203 13.8649C5.27972 13.8055 5.20012 13.7755 5.10259 13.7755H5.10242ZM6.18291 15.3441L6.88174 14.3729L6.21946 13.3976H6.97517L7.16633 13.7429C7.19884 13.8023 7.2287 13.8731 7.25579 13.9545H7.272C7.30993 13.8404 7.33442 13.7728 7.34525 13.7509L7.52037 13.3976H8.27179L7.61347 14.3607L8.29213 15.3441H7.50797L7.32094 14.9985C7.27489 14.9094 7.24914 14.8361 7.24372 14.7792H7.22751C7.21126 14.8388 7.1814 14.9133 7.13805 15.0027L6.95119 15.3441H6.18308H6.18291ZM9.37741 13.3323C9.63737 13.3323 9.85165 13.4122 10.0194 13.5723C10.1872 13.7293 10.2879 13.9149 10.3201 14.1291H9.6577C9.64416 14.0612 9.61035 14.007 9.55617 13.9663C9.50469 13.9256 9.44243 13.9057 9.36914 13.9057C9.24993 13.9057 9.16179 13.9486 9.10489 14.0355C9.0507 14.1222 9.0237 14.2333 9.0237 14.3687C9.0237 14.5043 9.05339 14.6168 9.11299 14.7059C9.1726 14.7928 9.26197 14.8361 9.38105 14.8361C9.45691 14.8361 9.52073 14.8146 9.57221 14.7712C9.6264 14.7252 9.66305 14.6668 9.68201 14.5965H10.3564C10.2968 14.843 10.1831 15.0408 10.0149 15.1898C9.84975 15.3387 9.63452 15.4132 9.36914 15.4132C9.07924 15.4132 8.83253 15.3173 8.62947 15.1249C8.42898 14.9324 8.32834 14.6791 8.32834 14.3645C8.32834 14.0719 8.42331 13.8269 8.6131 13.6292C8.80275 13.4314 9.05727 13.3323 9.37724 13.3323H9.37741ZM11.5992 13.3323C11.8977 13.3323 12.1395 13.4287 12.3262 13.6211C12.5131 13.8107 12.6068 14.0585 12.6068 14.3645C12.6068 14.4244 12.6068 14.4786 12.5932 14.5274H11.2285C11.2285 14.6383 11.2664 14.7332 11.3423 14.8119C11.4181 14.8876 11.5118 14.9255 11.6227 14.9255C11.7743 14.9255 11.8815 14.8646 11.9434 14.7428H12.5774C12.511 14.946 12.3964 15.1084 12.2359 15.2305C12.0764 15.3522 11.868 15.4132 11.6103 15.4132C11.3208 15.4132 11.0739 15.3173 10.8708 15.1249C10.6703 14.9324 10.5702 14.6791 10.5702 14.3645C10.5702 14.0665 10.6594 13.8199 10.8384 13.6249C11.0197 13.4298 11.2721 13.3323 11.5943 13.3323H11.5992ZM11.5857 13.7755C11.4854 13.7755 11.4042 13.8065 11.3419 13.8687C11.2796 13.9287 11.243 14.0032 11.2321 14.0922H11.9391C11.9255 14.0005 11.8902 13.9244 11.8251 13.8649C11.7628 13.8055 11.6831 13.7755 11.5855 13.7755H11.5857ZM12.962 15.3441V12.418H13.6489V15.3441H12.962Z"
                                      fill="white"/>
                            </svg>
                            <span>Выгрузить в excel</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_css')
    <link href="{{ asset('css/anticrisis.css')}}" rel="stylesheet">
@endsection
@section('custom_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
            integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
            crossorigin="anonymous"></script>
    <script>
        $(function () {
            var options = {
                annotations: {
                    points:
                        [
                            {
                                x: 3753,
                                y: 160840,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1735'
                                }
                            },
                            {
                                x: 3808,
                                y: 159680,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1819'
                                }
                            },
                            {
                                x: 3838,
                                y: 157134,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1903'
                                }
                            },
                            {
                                x: 3866,
                                y: 154459,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1987'
                                }
                            },
                            {
                                x: 3895,
                                y: 151275,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2071'
                                }
                            },
                            {
                                x: 3921,
                                y: 148279,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2155'
                                }
                            },
                            {
                                x: 3946,
                                y: 145012,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2239'
                                }
                            },
                            {
                                x: 3967,
                                y: 141648,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2323'
                                }
                            },
                            {
                                x: 3986,
                                y: 138079,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2406'
                                }
                            },
                            {
                                x: 4005,
                                y: 134441,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2489'
                                }
                            },
                            {
                                x: 4021,
                                y: 130540,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2572'
                                }
                            },
                            {
                                x: 4035,
                                y: 126272,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2660'
                                }
                            },
                            {
                                x: 4046,
                                y: 121945,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2745'
                                }
                            },
                            {
                                x: 4056,
                                y: 117345,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2896'
                                }
                            },
                            {
                                x: 4063,
                                y: 112284,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2947'
                                }
                            },
                            {
                                x: 4064,
                                y: 107632,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '3000'
                                }
                            },
                        ]
                },
                series: [{
                    name: "0% c ГТМ",
                    data: [[3753, 160840], [3808, 159680], [3838, 157134], [3866, 154459], [3895, 151275], [3921, 148279], [3946, 145012], [3967, 141648], [3986, 138079],
                        [4005, 134441], [4021, 130540], [4035, 126272], [4046, 121945], [4056, 117345], [4063, 112284], [4064, 107632]]
                }, {
                    name: "0%",
                    data: [[3578, 147828], [3633, 146984], [3682, 145847], [3728, 144423], [3772, 142727], [3812, 140821], [3851, 138684], [3886, 136323], [3919, 133774], [3949, 130992], [3976, 127992], [4001, 124553], [4021, 120948], [4040, 117056], [4056, 112727], [4064, 107632]]
                }, {
                    name: "10%",
                    data: [[3578, 143455], [3633, 142898], [3682, 142033], [3728, 140885], [3772, 139473], [3812, 137851], [3851, 136002], [3886, 133925], [3919, 131662], [3949, 129165], [3976, 126453], [4001, 123320], [4021, 120009], [4040, 116420], [4056, 112404], [4064, 107632]]
                }, {
                    name: "20%",
                    data: [[3578, 139082], [3633, 138802], [3682, 138218], [3728, 137346], [3772, 136219], [3812, 134881], [3851, 133320], [3886, 131527], [3919, 129549], [3949, 127339], [3976, 124913], [4001, 122086], [4021, 119070], [4040, 115785], [4056, 112080], [4064, 107632]]
                }, {
                    name: "30%",
                    data: [[3578, 134709], [3633, 134711], [3682, 134404], [3728, 133808], [3772, 132965], [3812, 131912], [3851, 130638], [3886, 129129], [3919, 127437], [3949, 125513], [3976, 123374], [4001, 120852], [4021, 118131], [4040, 115149], [4056, 111757], [4064, 107632]]
                }, {
                    name: "40%",
                    data: [[3578, 130336], [3633, 130620], [3682, 130589], [3728, 130270], [3772, 129711], [3812, 128942], [3851, 127955], [3886, 126732], [3919, 125324], [3949, 123686], [3976, 121835], [4001, 119618], [4021, 117192], [4040, 114514], [4056, 111434], [4064, 107632]]
                }, {
                    name: "50%",
                    data: [[3578, 125963], [3633, 126528], [3682, 126774], [3728, 126732], [3772, 126457], [3812, 125972], [3851, 125273], [3886, 124334], [3919, 123211], [3949, 121860], [3976, 120296], [4001, 118385], [4021, 116253], [4040, 113879], [4056, 111111], [4064, 107632]]
                }, {
                    name: "60%",
                    data: [[3578, 121590], [3633, 122437], [3682, 122960], [3728, 123194], [3772, 123203], [3812, 123003], [3851, 122591], [3886, 121936], [3919, 121099], [3949, 120034], [3976, 118757], [4001, 117151], [4021, 115314], [4040, 113243], [4056, 110788], [4064, 107632]]
                }, {
                    name: "70%",
                    data: [[3578, 117217], [3633, 118346], [3682, 119145], [3728, 119656], [3772, 119949], [3812, 120033], [3851, 119909], [3886, 119538], [3919, 118986], [3949, 118207], [3976, 117218], [4001, 115917], [4021, 114376], [4040, 112608], [4056, 110465], [4064, 107632]]
                }, {
                    name: "80%",
                    data: [[3578, 112844], [3633, 114255], [3682, 115331], [3728, 116118], [3772, 116696], [3812, 117063], [3851, 117227], [3886, 117141], [3919, 116874], [3949, 116381], [3976, 115678], [4001, 114683], [4021, 113437], [4040, 111972], [4056, 110142], [4064, 107632]]
                }, {
                    name: "90%",
                    data: [[3578, 108472], [3633, 110164], [3682, 111516], [3728, 112579], [3772, 113442], [3812, 114094], [3851, 114545], [3886, 114743], [3919, 114761], [3949, 114555], [3976, 114139], [4001, 113450], [4021, 112498], [4040, 111337], [4056, 109818], [4064, 107632]]
                }, {
                    name: "100%",
                    data: [[3578, 104099], [3633, 106073], [3682, 107702], [3728, 109041], [3772, 110188], [3812, 111124], [3851, 111863], [3886, 112345], [3919, 112649], [3949, 112729], [3976, 112600], [4001, 112216], [4021, 111559], [4040, 110702], [4056, 109495], [4064, 107632]]
                }],
                chart: {
                    height: 320,
                    width: 1000,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    animations: {
                        enabled: false,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    curve: 'straight',
                    colors: ['#656A8A', '#33548B', '#9C7300', '#454D7D', '#A2480D', '#374AB4', '#78B44E', '#81B9FE', '#FFC607', '#A8A8A8', '#F27E31', '#426DB0'],
                    dashArray: [5, 0]
                },
                markers: {
                    size: 4,
                    strokeWidth: 0,
                    colors: ['#656A8A', '#33548B', '#9C7300', '#454D7D', '#A2480D', '#374AB4', '#78B44E', '#81B9FE', '#FFC607', '#A8A8A8', '#F27E31', '#426DB0']
                },
                tooltip: {
                    enabled: false
                },
                grid: {
                    row: {
                        colors: ['transparent'],
                        opacity: 0.5
                    },
                    borderColor: '#353565',
                },
                xaxis: {
                    title: {
                        text: 'Годовая добыча нефти, тыс. тонн',
                        style: {
                            color: '#fff'
                        }
                    },
                    labels: {
                        style: {
                            colors: ['#fff']
                        }
                    },
                    min: 3500,
                    max: 4100,
                    tickAmount: 6,
                    axisBorder: {
                        show: true,
                        color: '#81B9FE',
                        offsetX: 0,
                        offsetY: 0
                    },
                },
                yaxis: {
                    title: {
                        text: 'Доход/убыток предприятия, млрд. тг',
                        style: {
                            color: '#fff'
                        }
                    },
                    labels: {
                        style: {
                            colors: ['#fff']
                        },
                        formatter: function (seriesName, opts) {
                            return Math.round(parseInt(seriesName / 1000))
                        }
                    },
                    min: 80000,
                    max: 170000,
                    axisBorder: {
                        show: true,
                        color: '#81B9FE',
                        offsetX: 0,
                        offsetY: 0
                    },
                },
                legend: {
                    position: 'left',
                    labels: {
                        colors: ['#fff']
                    },
                    markers: {
                        fillColors: ['#656A8A', '#33548B', '#9C7300', '#454D7D', '#A2480D', '#374AB4', '#78B44E', '#81B9FE', '#FFC607', '#A8A8A8', '#F27E31', '#426DB0']
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#main_chart"), options);
            chart.render();


            var options = {
                annotations: {
                    points:
                        [
                            {
                                x: 3753,
                                y: 160840,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1735'
                                }
                            },
                            {
                                x: 3808,
                                y: 159680,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1819'
                                }
                            },
                            {
                                x: 3838,
                                y: 157134,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1903'
                                }
                            },
                            {
                                x: 3866,
                                y: 154459,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '1987'
                                }
                            },
                            {
                                x: 3895,
                                y: 151275,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2071'
                                }
                            },
                            {
                                x: 3921,
                                y: 148279,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2155'
                                }
                            },
                            {
                                x: 3946,
                                y: 145012,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2239'
                                }
                            },
                            {
                                x: 3967,
                                y: 141648,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2323'
                                }
                            },
                            {
                                x: 3986,
                                y: 138079,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2406'
                                }
                            },
                            {
                                x: 4005,
                                y: 134441,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2489'
                                }
                            },
                            {
                                x: 4021,
                                y: 130540,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2572'
                                }
                            },
                            {
                                x: 4035,
                                y: 126272,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2660'
                                }
                            },
                            {
                                x: 4046,
                                y: 121945,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2745'
                                }
                            },
                            {
                                x: 4056,
                                y: 117345,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2896'
                                }
                            },
                            {
                                x: 4063,
                                y: 112284,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '2947'
                                }
                            },
                            {
                                x: 4064,
                                y: 107632,
                                marker: {
                                    size: 0,
                                },
                                label: {
                                    borderColor: 'transparent',
                                    style: {
                                        background: 'transparent',
                                        color: '#ffffff',
                                    },
                                    text: '3000'
                                }
                            },
                        ]
                },
                series: [{
                    name: "0% c ГТМ",
                    data: [[3753, 160840], [3808, 159680], [3838, 157134], [3866, 154459], [3895, 151275], [3921, 148279], [3946, 145012], [3967, 141648], [3986, 138079],
                        [4005, 134441], [4021, 130540], [4035, 126272], [4046, 121945], [4056, 117345], [4063, 112284], [4064, 107632]]
                }, {
                    name: "0%",
                    data: [[3578, 147828], [3633, 146984], [3682, 145847], [3728, 144423], [3772, 142727], [3812, 140821], [3851, 138684], [3886, 136323], [3919, 133774], [3949, 130992], [3976, 127992], [4001, 124553], [4021, 120948], [4040, 117056], [4056, 112727], [4064, 107632]]
                }, {
                    name: "10%",
                    data: [[3578, 143455], [3633, 142898], [3682, 142033], [3728, 140885], [3772, 139473], [3812, 137851], [3851, 136002], [3886, 133925], [3919, 131662], [3949, 129165], [3976, 126453], [4001, 123320], [4021, 120009], [4040, 116420], [4056, 112404], [4064, 107632]]
                }, {
                    name: "20%",
                    data: [[3578, 139082], [3633, 138802], [3682, 138218], [3728, 137346], [3772, 136219], [3812, 134881], [3851, 133320], [3886, 131527], [3919, 129549], [3949, 127339], [3976, 124913], [4001, 122086], [4021, 119070], [4040, 115785], [4056, 112080], [4064, 107632]]
                }, {
                    name: "30%",
                    data: [[3578, 134709], [3633, 134711], [3682, 134404], [3728, 133808], [3772, 132965], [3812, 131912], [3851, 130638], [3886, 129129], [3919, 127437], [3949, 125513], [3976, 123374], [4001, 120852], [4021, 118131], [4040, 115149], [4056, 111757], [4064, 107632]]
                }, {
                    name: "40%",
                    data: [[3578, 130336], [3633, 130620], [3682, 130589], [3728, 130270], [3772, 129711], [3812, 128942], [3851, 127955], [3886, 126732], [3919, 125324], [3949, 123686], [3976, 121835], [4001, 119618], [4021, 117192], [4040, 114514], [4056, 111434], [4064, 107632]]
                }, {
                    name: "50%",
                    data: [[3578, 125963], [3633, 126528], [3682, 126774], [3728, 126732], [3772, 126457], [3812, 125972], [3851, 125273], [3886, 124334], [3919, 123211], [3949, 121860], [3976, 120296], [4001, 118385], [4021, 116253], [4040, 113879], [4056, 111111], [4064, 107632]]
                }, {
                    name: "60%",
                    data: [[3578, 121590], [3633, 122437], [3682, 122960], [3728, 123194], [3772, 123203], [3812, 123003], [3851, 122591], [3886, 121936], [3919, 121099], [3949, 120034], [3976, 118757], [4001, 117151], [4021, 115314], [4040, 113243], [4056, 110788], [4064, 107632]]
                }, {
                    name: "70%",
                    data: [[3578, 117217], [3633, 118346], [3682, 119145], [3728, 119656], [3772, 119949], [3812, 120033], [3851, 119909], [3886, 119538], [3919, 118986], [3949, 118207], [3976, 117218], [4001, 115917], [4021, 114376], [4040, 112608], [4056, 110465], [4064, 107632]]
                }, {
                    name: "80%",
                    data: [[3578, 112844], [3633, 114255], [3682, 115331], [3728, 116118], [3772, 116696], [3812, 117063], [3851, 117227], [3886, 117141], [3919, 116874], [3949, 116381], [3976, 115678], [4001, 114683], [4021, 113437], [4040, 111972], [4056, 110142], [4064, 107632]]
                }, {
                    name: "90%",
                    data: [[3578, 108472], [3633, 110164], [3682, 111516], [3728, 112579], [3772, 113442], [3812, 114094], [3851, 114545], [3886, 114743], [3919, 114761], [3949, 114555], [3976, 114139], [4001, 113450], [4021, 112498], [4040, 111337], [4056, 109818], [4064, 107632]]
                }, {
                    name: "100%",
                    data: [[3578, 104099], [3633, 106073], [3682, 107702], [3728, 109041], [3772, 110188], [3812, 111124], [3851, 111863], [3886, 112345], [3919, 112649], [3949, 112729], [3976, 112600], [4001, 112216], [4021, 111559], [4040, 110702], [4056, 109495], [4064, 107632]]
                }],
                chart: {
                    height: 700,
                    width: 1300,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    animations: {
                        enabled: false,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 1,
                    curve: 'straight',
                    colors: ['#656A8A', '#33548B', '#9C7300', '#454D7D', '#A2480D', '#374AB4', '#78B44E', '#81B9FE', '#FFC607', '#A8A8A8', '#F27E31', '#426DB0'],
                    dashArray: [5, 0]
                },
                markers: {
                    size: 4,
                    strokeWidth: 0,
                    colors: ['#656A8A', '#33548B', '#9C7300', '#454D7D', '#A2480D', '#374AB4', '#78B44E', '#81B9FE', '#FFC607', '#A8A8A8', '#F27E31', '#426DB0']
                },
                tooltip: {
                    enabled: false
                },
                grid: {
                    row: {
                        colors: ['transparent'],
                        opacity: 0.5
                    },
                    borderColor: '#353565',
                },
                xaxis: {
                    title: {
                        text: 'Годовая добыча нефти, тыс. тонн',
                        style: {
                            color: '#fff'
                        }
                    },
                    labels: {
                        style: {
                            colors: ['#fff']
                        }
                    },
                    min: 3500,
                    max: 4100,
                    tickAmount: 6,
                    axisBorder: {
                        show: true,
                        color: '#81B9FE',
                        offsetX: 0,
                        offsetY: 0
                    },
                },
                yaxis: {
                    title: {
                        text: 'Доход/убыток предприятия, млрд. тг',
                        style: {
                            color: '#fff'
                        }
                    },
                    labels: {
                        style: {
                            colors: ['#fff']
                        },
                        formatter: function (seriesName, opts) {
                            return Math.round(parseInt(seriesName / 1000))
                        }
                    },
                    min: 90000,
                    max: 170000,
                    axisBorder: {
                        show: true,
                        color: '#81B9FE',
                        offsetX: 0,
                        offsetY: 0
                    },
                },
                legend: {
                    position: 'left',
                    labels: {
                        colors: ['#fff']
                    },
                    markers: {
                        fillColors: ['#656A8A', '#33548B', '#9C7300', '#454D7D', '#A2480D', '#374AB4', '#78B44E', '#81B9FE', '#FFC607', '#A8A8A8', '#F27E31', '#426DB0']
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#hedgehog_chart"), options);
            chart.render();

            var options = {
                series: [{
                    name: 'Операционная прибыль / убыток до оптимизации',
                    type: 'bar',
                    data: [-48, -16, 16, 42, 80, 102, 131]
                }, {
                    name: 'Операционная прибыль / убыток после оптимизации',
                    type: 'bar',
                    data: [18, 48, 74, 99, 135, 157, 183]
                }, {
                    name: '',
                    type: 'line',
                    data: [156, 164, 178, 183, 195, 199, 208]
                }, {
                    name: '',
                    type: 'line',
                    data: [174, 210, 252, 282, 330, 355, 391]
                }, {
                    name: 'Валовый доход до оптимизации',
                    type: 'line',
                    data: [198, 230, 262, 289, 327, 349, 377]
                }, {
                    name: 'Валовый доход после оптимизации',
                    type: 'line',
                    data: [246, 246, 246, 246, 246, 246, 246]
                }],
                chart: {
                    height: 354,
                    width: 566,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    animations: {
                        enabled: false,
                    }
                },
                stroke: {
                    width: [0, 0, 3, 3, 3, 3],
                    curve: 'straight',
                    colors: ['#c4c4c4', '#147050', '#F27E31', '#F27E31', '#82BAFF', '#82BAFF'],
                    dashArray: [0, 0, 5, 0, 0, 5]
                },
                fill: {
                    opacity: 1,
                    colors: ['#c4c4c4', '#147050', '#F27E31', '#F27E31', '#82BAFF', '#82BAFF']
                },
                markers: {
                    size: 4,
                    strokeWidth: 0,
                    colors: ['#c4c4c4', '#147050', '#F27E31', '#F27E31', '#82BAFF', '#82BAFF']
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [0, 1],
                    background: {
                        enabled: false
                    },
                    style: {
                        colors: ['#fff']
                    },
                    offsetY: -10
                },
                yaxis: {
                    title: {
                        text: 'млрд. тенге',
                        style: {
                            color: '#fff'
                        }
                    },
                    labels: {
                        style: {
                            colors: ['#fff']
                        }
                    },
                    min: -50,
                    max: 400,
                    axisBorder: {
                        show: false
                    }
                },
                grid: {
                    row: {
                        colors: ['transparent'],
                        opacity: 0.5
                    },
                    borderColor: '#353565',
                },
                tooltip: {
                    enabled: false
                },
                labels: ['20$/bbl', '25$/bbl', '30$/bbl', '35$/bbl', '40$/bbl', '50$/bbl', '60$/bbl'],
                legend: {
                    position: 'bottom',
                    labels: {
                        colors: ['#fff']
                    },
                    markers: {
                        fillColors: ['#C4C4C4', '#147050', '#F27E31', '#F27E31', '#82BAFF', '#82BAFF']
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#small_chart"), options);
            chart.render();


            $('.button1').click(function () {
                $('.button1').removeClass('active')
                $(this).addClass('active')

                $('#' + $(this).data('tab')).addClass('active').siblings().removeClass('active');
            })

        })
    </script>
@endsection