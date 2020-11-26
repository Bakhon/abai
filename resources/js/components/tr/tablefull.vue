<template>
    <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
        <tr class="headerColumn">
            <td rowspan="4" @click="sortBy('gu')">Раб. Группа</td>
            <td rowspan="4" @click="sortBy('field')">НГДУ/месторождение</td>
            <td rowspan="4" @click="sortBy('well')">№ скв</td>
            <td rowspan="4" @click="sortBy('well_type')">Тип скважины</td>
            <td rowspan="4" @click="sortBy('horizon')">Горизонт</td>
            <td rowspan="4" @click="sortBy('block')">Блок</td>
            <td rowspan="4" @click="sortBy('r_con')">R контура питания</td>
            <td rowspan="4" @click="sortBy('cas_OD')">Наружный диаметр э/к</td>
            <td rowspan="4" @click="sortBy('cas_ID')">Внутренний диаметр э/к</td>
            <td rowspan="4" @click="sortBy('tub_OD')">Наружный диаметр НТК</td>
            <td rowspan="4" @click="sortBy('tub_ID')">Внутренний диаметр НТК</td>
            <td rowspan="4" @click="sortBy('choke_d')">Диаметр штуцера</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Нвдп</td>
            <td rowspan="4" @click="sortBy('h_up_perf_md')">Удлинение(Нвдп)</td>
            <td rowspan="4" @click="sortBy('exp_meth')">Способ эксплуатации</td>
            <td rowspan="4" @click="sortBy('pump_type')">Тип Насоса</td>
            <td rowspan="4" @click="sortBy('EMPTY')">Тип СК</td>
            <td rowspan="4" @click="sortBy('spm')">Число качаний</td>
            <td rowspan="4" @click="sortBy('stroke_len')">Длина хода</td>
            <td rowspan="4" @click="sortBy('q_theor')">Q теор</td>
            <td rowspan="4" @click="sortBy('freq')">Частота работы насоса или число оборотов</td>
            <td rowspan="4" @click="sortBy('h_pump_set')">Н сп насоса</td>
            <td rowspan="4" @click="sortBy('whp')">P буф</td>
            <td rowspan="4" @click="sortBy('line_p')">P лин</td>
            <td rowspan="4" @click="sortBy('p_res')">P пл</td>
            <td rowspan="4" @click="sortBy('h_dyn')">Н дин</td>
            <td rowspan="4" @click="sortBy('p_annular')">Р затр</td>
            <td rowspan="4" @click="sortBy('p_intake')">Р на приеме</td>
            <td class="colspan" colspan="5">Данные за предыдущий месяц</td>
            <td class="colspan" colspan="4">Фактический режим</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Состояние на конец месяца</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">P нас</td>
            <td rowspan="4" @click="sortBy('p_annular')">ГФ</td>
            <td rowspan="4" @click="sortBy('p_annular')">Т пл</td>
            <td rowspan="4" @click="sortBy('p_annular')">Т уст</td>
            <td class="colspan" colspan="4">ГРП</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Вязкость нефти в пл. условиях"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Вязкость воды в пл. условиях"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">"Вязкость жидкости"</td>
            <td rowspan="4" @click="sortBy('p_annular')">"Объемный коэффициент"</td>
            <td rowspan="4" @click="sortBy('p_annular')">"Плотность нефти"</td>
            <td rowspan="4" @click="sortBy('p_annular')">"Плотность воды"</td>
            <td rowspan="4" @click="sortBy('p_annular')">Н перф</td>
            <td rowspan="4" @click="sortBy('p_annular')">k</td>
            <td rowspan="4" @click="sortBy('p_annular')">КН</td>
            <td rowspan="4" @click="sortBy('p_annular')">К пр</td>
            <td class="colspan" colspan="13">Расчет технологического потенциала от ИДН</td>
            <td class="colspan" colspan="9">Расчёт геологического потенциала</td>
            <td class="colspan" colspan="4">Проверка</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Максимальная глубина спуска насоса при ИДН</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">Дата остановки</td>
            <td rowspan="4" @click="sortBy('p_annular')">Расчлененность</td>
            <td rowspan="4" @click="sortBy('p_annular')">Зона</td>
            <td rowspan="4" @click="sortBy('p_annular')">Цех</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Фонтан через насос</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">Нерентабельная</td>
            <td rowspan="4" @click="sortBy('p_annular')">Неустановившийся режим</td>
            <td rowspan="4" @click="sortBy('p_annular')">Дата ввода в эксплуатацию</td>
            <td rowspan="4" @click="sortBy('p_annular')">Назначение по проекту</td>
            <td rowspan="4" @click="sortBy('p_annular')">Р заб замерное</td>
            <td rowspan="4" @click="sortBy('p_annular')">Нефтенасыщенная толщина</td>
            <td rowspan="4" @click="sortBy('p_annular')">Накопленная добыча нефти</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Максимальный дебит жидкости за всю историю работы</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">Расстояние до нагн скважины</td>
            <td rowspan="4" @click="sortBy('p_annular')">Расстояние до ВНК</td>
            <td rowspan="4" @click="sortBy('p_annular')">Текущий забой по скважине, м</td>
            <td rowspan="4" @click="sortBy('p_annular')">Кподачи насоса</td>
            <td rowspan="4" @click="sortBy('p_annular')">Тип ГЗУ</td>
            <td rowspan="4" @click="sortBy('p_annular')">Рпл начальное</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Qr характеристический дебит жидкости</span></td>
            <td class="colspan" colspan="2">АПВ</td>
            <td class="colspan" colspan="3">Планируемые мероприятия</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Мероприятия</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Сведения о тех.состоянии  экс.колонны</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Комментарии</span></td>
            <!-- <td rowspan="4" @click="sortBy('p_annular')"><span>Дата последнего ГТМ</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Вид последнего ГТМ</span></td> -->
        </tr>
        <tr class="headerColumn">
            <td rowspan="3"><span>P заб</span></td>
            <td rowspan="3"><span>Q ж</span></td>
            <td rowspan="3"><span>Обводненность</span></td>
            <td rowspan="3"><span>Hдин</span></td>
            <td rowspan="3"><span>Kпр</span></td>
            <td rowspan="3"><span>P заб</span></td>
            <td rowspan="3"><span>Q н</span></td>
            <td rowspan="3"><span>Q ж</span></td>
            <td rowspan="3"><span>Обводненность</span></td>
            <td rowspan="3"><span>Скин</span></td>
            <td rowspan="3"><span>JD факт</span></td>
            <td rowspan="3"><span>Дата проведения</span></td>
            <td rowspan="3"><span>Фирма</span></td>
            <td rowspan="3"><span>Р заб</span></td>
            <td class="colspan" colspan="4">ИДН</td>
            <td rowspan="3"><span>JD опт</span></td>
            <td rowspan="3"><span>Skin</span></td>
            <td rowspan="3"><span>К пр от стимуляции</span></td>
            <td class="colspan" colspan="4">ГРП</td>
            <td rowspan="3"><span>% прироста Q н</span></td>
            <td rowspan="3"><span>Р заб</span></td>
            <td class="colspan" colspan="4">ИДН</td>
            <td class="colspan" colspan="4">ГРП</td>
            <td class="colspan" colspan="2">Ошибки</td>
            <td class="colspan" colspan="2">Предупреждения</td>
            <td rowspan="3"><span>Траб</span></td>
            <td rowspan="3"><span>Тнак</span></td>
            <td class="colspan" colspan="3">Изоляционные работы</td>
        </tr>
        <tr class="headerColumn">
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Число ошибок</span></td>
            <td rowspan="2"><span>Первая ошибка</span></td>
            <td rowspan="2"><span>Число предупреждений</span></td>
            <td rowspan="2"><span>Первое предупреждение</span></td>
            <td rowspan="2"><span>Проводить</span></td>
            <td rowspan="2"><span>Дебит жидкости</span></td>
            <td rowspan="2"><span>Обводненность</span></td>
        </tr>
        <tr></tr>
        <tr class="subHeaderColumn">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>м</td>
            <td>мм</td>
            <td>мм</td>
            <td>мм</td>
            <td>мм</td>
            <td>м</td>
            <td>м</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>м</td>
            <td>м3/сут</td>
            <td>Гц, об/мин</td>
            <td>м</td>
            <td>атм</td>
            <td>атм</td>
            <td>атм</td>
            <td>м</td>
            <td>атм</td>
            <td>атм</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>%</td>
            <td>м</td>
            <td>м3/сут/атм</td>
            <td>атм</td>
            <td>т/сут</td>
            <td>м3/сут</td>
            <td>%</td>
            <td></td>
            <td>атм</td>
            <td>м3/т</td>
            <td>ºC</td>
            <td></td>
            <td></td>
            <td></td>
            <td>д/м/г</td>
            <td></td>
            <td>сПз</td>
            <td>сПз</td>
            <td>сПз</td>
            <td>м3/м3</td>
            <td>г/см3</td>
            <td>г/см3</td>
            <td>м</td>
            <td>мД</td>
            <td>мДм</td>
            <td>м3/сут/атм</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>т/сут</td>
            <td></td>
            <td></td>
            <td>м3/сут/атм</td>
            <td>м3/сут</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>т/сут</td>
            <td>%</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>т/сут</td>
            <td>%</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>д/м/г</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>д/м/г</td>
            <td></td>
            <td>атм</td>
            <td>м</td>
            <td>тыс.т</td>
            <td>м3/сут</td>
            <td>м</td>
            <td>м</td>
            <td></td>
            <td>м3/сут</td>
            <td></td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>час</td>
            <td>час</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>%</td>
            <td></td>
            <td></td>
            <td></td>
            <!-- <td></td>
            <td></td> -->
        </tr>
        <tr v-for="(row, row_index) in wells" :key="row_index">
            <td>{{row.gu}}</td>
            <td>{{row.field}}</td>
            <td>{{row.well}}</td>
            <!-- <td>{{row.well_type}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].well_type[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].well_type[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].well_type[1][0])}`"> </span>
                <span>{{row.well_type[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].well_type[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.horizon}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].horizon[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].horizon[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].horizon[1][0])}`"> </span>
                <span>{{row.horizon[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].horizon[1][1]}}
                </span>
            </td>

            <td>{{row.block}}</td>

            <td>{{Math.round(row.r_con*10)/10}}</td>

            <!-- <td>{{Math.round(row.cas_OD*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].cas_OD[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].cas_OD[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].cas_OD[1][0])}`"> </span>
                <span>{{Math.round(row.cas_OD[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].cas_OD[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.cas_ID*10)/10}}</td>

            <!-- <td>{{Math.round(row.tub_OD*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tub_OD[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tub_OD[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tub_OD[1][0])}`"> </span>
                <span>{{Math.round(row.tub_OD[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tub_OD[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.tub_ID*10)/10}}</td>

            <!-- <td>{{Math.round(row.choke_d*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].choke_d[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].choke_d[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].choke_d[1][0])}`"> </span>
                <span>{{Math.round(row.choke_d[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].choke_d[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.h_up_perf_vd*10)/10}}</td>

            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].h_up_perf_md[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].h_up_perf_md[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].h_up_perf_md[1][0])}`"> </span>
                <span>{{Math.round(row.h_up_perf_md[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].h_up_perf_md[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.exp_meth}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].exp_meth[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].exp_meth[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].exp_meth[1][0])}`"> </span>
                <span>{{row.exp_meth[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].exp_meth[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.pump_type}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].pump_type[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].pump_type[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].pump_type[1][0])}`"> </span>
                <span>{{row.pump_type[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].pump_type[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.EMPTY*10)/10}}</td>

            <!-- <td>{{Math.round(row.spm*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].spm[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].spm[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].spm[1][0])}`"> </span>
                <span>{{Math.round(row.spm[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].spm[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.stroke_len*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].stroke_len[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].stroke_len[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].stroke_len[1][0])}`"> </span>
                <span>{{Math.round(row.stroke_len[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].stroke_len[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.q_theor*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].q_theor[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].q_theor[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].q_theor[1][0])}`"> </span>
                <span>{{Math.round(row.q_theor[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].q_theor[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.freq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].freq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].freq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].freq[1][0])}`"> </span>
                <span>{{Math.round(row.freq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].freq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.h_pump_set*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].h_pump_set[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].h_pump_set[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].h_pump_set[1][0])}`"> </span>
                <span>{{Math.round(row.h_pump_set[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].h_pump_set[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.whp*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].whp[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].whp[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].whp[1][0])}`"> </span>
                <span>{{Math.round(row.whp[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].whp[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.line_p*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].line_p[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].line_p[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].line_p[1][0])}`"> </span>
                <span>{{Math.round(row.line_p[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].line_p[1][1]}}
                </span>
            </td>

            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].p_res[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].p_res[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].p_res[1][0])}`"> </span>
                <span>{{Math.round(row.p_res[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].p_res[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.h_dyn*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].h_dyn[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].h_dyn[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].h_dyn[1][0])}`"> </span>
                <span>{{Math.round(row.h_dyn[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].h_dyn[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.p_annular*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].p_annular[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].p_annular[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].p_annular[1][0])}`"> </span>
                <span>{{Math.round(row.p_annular[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].p_annular[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.p_intake*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].p_intake[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].p_intake[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].p_intake[1][0])}`"> </span>
                <span>{{Math.round(row.p_intake[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].p_intake[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.bhp_prev_m*10)/10}}</td>

            <td>{{Math.round(row.q_l_prev_m*10)/10}}</td>

            <td>{{Math.round(row.wct_prev_m*10)/10}}</td>

            <td>{{Math.round(row.h_dyn_prev_m*10)/10}}</td>

            <td>{{Math.round(row.pi_prev_m*10)/10}}</td>

            <!-- <td>{{Math.round(row.bhp*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].bhp[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].bhp[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].bhp[1][0])}`"> </span>
                <span>{{Math.round(row.bhp[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].bhp[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.q_o*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].q_o[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].q_o[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].q_o[1][0])}`"> </span>
                <span>{{Math.round(row.q_o[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].q_o[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.q_l*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].q_l[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].q_l[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].q_l[1][0])}`"> </span>
                <span>{{Math.round(row.q_l[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].q_l[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].wct[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].wct[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].wct[1][0])}`"> </span>
                <span>{{Math.round(row.wct[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].wct[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.well_status_last_day}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].well_status_last_day[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].well_status_last_day[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].well_status_last_day[1][0])}`"> </span>
                <span>{{row.well_status_last_day[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].well_status_last_day[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.P_bubble_point*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].P_bubble_point[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].P_bubble_point[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].P_bubble_point[1][0])}`"> </span>
                <span>{{Math.round(row.P_bubble_point[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].P_bubble_point[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gor*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gor[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gor[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gor[1][0])}`"> </span>
                <span>{{Math.round(row.gor[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gor[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.t_res*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].t_res[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].t_res[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].t_res[1][0])}`"> </span>
                <span>{{Math.round(row.t_res[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].t_res[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.wht*10)/10}}</td>

            <td>{{Math.round(row.grp_skin*10)/10}}</td>

            <td>{{Math.round(row.grp_jd*10)/10}}</td>

            <!-- <td>{{row.grp_date}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].grp_date[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].grp_date[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].grp_date[1][0])}`"> </span>
                <span>{{row.grp_date[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].grp_date[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.grp_contractor}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].grp_contractor[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].grp_contractor[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].grp_contractor[1][0])}`"> </span>
                <span>{{row.grp_contractor[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].grp_contractor[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.visc_oil_rc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].visc_oil_rc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].visc_oil_rc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].visc_oil_rc[1][0])}`"> </span>
                <span>{{Math.round(row.visc_oil_rc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].visc_oil_rc[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.visc_wat_rc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].visc_wat_rc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].visc_wat_rc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].visc_wat_rc[1][0])}`"> </span>
                <span>{{Math.round(row.visc_wat_rc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].visc_wat_rc[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.visc_liq_rc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].visc_liq_rc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].visc_liq_rc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].visc_liq_rc[1][0])}`"> </span>
                <span>{{Math.round(row.visc_liq_rc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].visc_liq_rc[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.bo*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].bo[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].bo[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].bo[1][0])}`"> </span>
                <span>{{Math.round(row.bo[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].bo[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.dens_oil*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].dens_oil[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].dens_oil[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].dens_oil[1][0])}`"> </span>
                <span>{{Math.round(row.dens_oil[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].dens_oil[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.dens_liq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].dens_liq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].dens_liq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].dens_liq[1][0])}`"> </span>
                <span>{{Math.round(row.dens_liq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].dens_liq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.h_perf*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].h_perf[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].h_perf[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].h_perf[1][0])}`"> </span>
                <span>{{Math.round(row.h_perf[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].h_perf[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.k*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].k[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].k[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].k[1][0])}`"> </span>
                <span>{{Math.round(row.k[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].k[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.kh*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].kh[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].kh[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].kh[1][0])}`"> </span>
                <span>{{Math.round(row.kh[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].kh[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.pi*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].pi[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].pi[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].pi[1][0])}`"> </span>
                <span>{{Math.round(row.pi[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].pi[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_bhp*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_bhp[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_bhp[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_bhp[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_bhp[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_liq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_liq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_liq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_liq[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_liq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_liq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_liq_cas_d_corr*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_liq_cas_d_corr[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_liq_cas_d_corr[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_liq_cas_d_corr[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_oil*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_oil[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_oil[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_oil[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_oil[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_oil[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_oil_inc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_oil_inc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_oil_inc[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_oil_inc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_oil_inc[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_jd*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_jd[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_jd[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_jd[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_jd[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_jd[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_skin*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_skin[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_skin[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_skin[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_skin[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_skin[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_pi_after*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_pi_after[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_pi_after[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_pi_after[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_pi_after[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_pi_after[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_liq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_grp_q_liq[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_grp_q_liq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_grp_q_liq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_liq_cas_d_corr*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_grp_q_liq_cas_d_corr[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_oil*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_oil[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_oil[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_grp_q_oil[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_grp_q_oil[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_grp_q_oil[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_oil_inc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_grp_q_oil_inc[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_grp_q_oil_inc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.tp_idn_q_oil_inc_perc*10)/10}}</td>

            <!-- <td>{{Math.round(row.gp_idn_bhp*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_idn_bhp[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_idn_bhp[1][0])}`"> </span>
                <span>{{Math.round(row.gp_idn_bhp[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_idn_bhp[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_liq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_liq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_liq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_idn_q_liq[1][0])}`"> </span>
                <span>{{Math.round(row.gp_idn_q_liq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_idn_q_liq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_liq_cas_d_corr*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_idn_q_liq_cas_d_corr[1][0])}`"> </span>
                <span>{{Math.round(row.gp_idn_q_liq_cas_d_corr[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_idn_q_liq_cas_d_corr[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_oil*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_oil[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_oil[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_idn_q_oil[1][0])}`"> </span>
                <span>{{Math.round(row.gp_idn_q_oil[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_idn_q_oil[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_oil_inc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_oil_inc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_idn_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_idn_q_oil_inc[1][0])}`"> </span>
                <span>{{Math.round(row.gp_idn_q_oil_inc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_idn_q_oil_inc[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_liq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_liq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_grp_q_liq[1][0])}`"> </span>
                <span>{{Math.round(row.gp_grp_q_liq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_grp_q_liq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_liq_cas_d_corr*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_grp_q_liq_cas_d_corr[1][0])}`"> </span>
                <span>{{Math.round(row.gp_grp_q_liq_cas_d_corr[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_grp_q_liq_cas_d_corr[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_oil*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_oil[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_oil[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_grp_q_oil[1][0])}`"> </span>
                <span>{{Math.round(row.gp_grp_q_oil[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_grp_q_oil[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_oil_inc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_oil_inc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gp_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gp_grp_q_oil_inc[1][0])}`"> </span>
                <span>{{Math.round(row.gp_grp_q_oil_inc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gp_grp_q_oil_inc[1][1]}}
                </span>
            </td>

            <td>{{row.error_count}}</td>
            <td>{{row.error_first}}</td>
            <td>{{row.error_warning}}</td>
            <td>{{row.error_first_warning}}</td>

            <!-- <td>{{Math.round(row.idn_pump_depth_max*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].idn_pump_depth_max[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].idn_pump_depth_max[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].idn_pump_depth_max[1][0])}`"> </span>
                <span>{{Math.round(row.idn_pump_depth_max[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].idn_pump_depth_max[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.stop_date}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].stop_date[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].stop_date[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].stop_date[1][0])}`"> </span>
                <span>{{row.stop_date[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].stop_date[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.layers_count}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].layers_count[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].layers_count[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].layers_count[1][0])}`"> </span>
                <span>{{row.layers_count[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].layers_count[1][1]}}
                </span>
            </td>

            <td>{{row.zone}}</td>
            <td>{{row.tseh}}</td>
            <td>{{row.semi_free_flow[0]}}</td>
            <!-- <td>{{row.non_profit[0]}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].non_profit[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].non_profit[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].non_profit[1][0])}`"> </span>
                <span>{{row.non_profit[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].non_profit[1][1]}}
                </span>
            </td>

            <td>{{row.unsteady_state}}</td>

            <!-- <td>{{row.start_up_date}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].start_up_date[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].start_up_date[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].start_up_date[1][0])}`"> </span>
                <span>{{row.start_up_date[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].start_up_date[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.well_project_purpose}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].well_project_purpose[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].well_project_purpose[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].well_project_purpose[1][0])}`"> </span>
                <span>{{row.well_project_purpose[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].well_project_purpose[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.bhp_meter*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].bhp_meter[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].bhp_meter[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].bhp_meter[1][0])}`"> </span>
                <span>{{Math.round(row.bhp_meter[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].bhp_meter[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.oil_net_pay*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].oil_net_pay[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].oil_net_pay[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].oil_net_pay[1][0])}`"> </span>
                <span>{{Math.round(row.oil_net_pay[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].oil_net_pay[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.oil_cumulative*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].oil_cumulative[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].oil_cumulative[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].oil_cumulative[1][0])}`"> </span>
                <span>{{Math.round(row.oil_cumulative[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].oil_cumulative[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.max_q_liq_hist*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].max_q_liq_hist[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].max_q_liq_hist[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].max_q_liq_hist[1][0])}`"> </span>
                <span>{{Math.round(row.max_q_liq_hist[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].max_q_liq_hist[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.dist_to_inj_well*10)/10}}</td>
            <td>{{Math.round(row.dist_to_woc*10)/10}}</td>

            <!-- <td>{{Math.round(row.curr_bh*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].curr_bh[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].curr_bh[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].curr_bh[1][0])}`"> </span>
                <span>{{Math.round(row.curr_bh[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].curr_bh[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.pump_fillage*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].pump_fillage[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].pump_fillage[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].pump_fillage[1][0])}`"> </span>
                <span>{{Math.round(row.pump_fillage[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].pump_fillage[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.gzu_type*10)/10}}</td>
            <td>{{Math.round(row.p_res_init*10)/10}}</td>
            <td>{{Math.round(row.q_liq_charac*10)/10}}</td>
            <td>{{row.APV_t_rab}}</td>
            <td>{{row.APV_t_nak}}</td>
            <td>{{row.plan_izo_work}}</td>
            <td>{{Math.round(row.plan_act_q_l*10)/10}}</td>
            <td>{{Math.round(row.plan_act_wct*10)/10}}</td>
            <td>{{row.plan_activities}}</td>
            <td>{{row.plan_casing_info}}</td>
            <td>{{row.plan_comment}}</td>
            <!-- <td>{{row.q_liq_charac}}</td>
            <td>{{row.q_liq_charac}}</td>-->
        </tr>
    </table>
</template>
<script>
export default {
    name: "TrFullTable",
    props: {
        wells: Array,
    },

    methods: {
        sortBy(type) {
            this.$emit('onSort', type);
        },
        getColor(status) {
            if (status === "1") return "#ffff00";
            return "#ff0000";
        },
    }
}
</script>



