<template>
    <div class="container-fluid">
        <div class="col-md-12 row">
        <div class="col-md-12 row justify-content-between">
            <a href="fa" class="col but-nav__link but"><i style=" margin-right: 10px; "><svg width="24" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z" fill="white"/>
</svg>
</i>Факторный анализ отклонений ТР</a>
            <!-- <form class="form-group but-nav__link">
                    <label for="inputDate">Введите дату:</label>
                    <input type="date" value = "01.06.2020" class="form-control" v-model="dt">
            </form> -->
            <div class="col dropdown">
                <button class="col-md-12 but-nav__link but " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i style=" margin-right: 10px; ">
                   <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M15.6583 19.4286H2.33239C1.281 19.4286 0.42868 18.5843 0.42868 17.5429V4.34285C0.42868 3.3014 1.281 2.45714 2.33239 2.45714H4.23609V0.571426H6.1398V2.45714H11.8509V0.571426H13.7546V2.45714H15.6583C16.7098 2.45714 17.562 3.3014 17.562 4.34285V17.5429C17.562 18.5843 16.7098 19.4286 15.6583 19.4286ZM2.33239 8.11428V17.5429H15.6583V8.11428H2.33239ZM2.33239 4.34285V6.22857H15.6583V4.34285H2.33239ZM8.04351 16.0475L4.51499 12.5523L5.86091 11.2191L8.04351 13.3811L12.1298 9.3334L13.4757 10.6666L8.04351 16.0465V16.0475Z" fill="white"/>
</svg>

               </i>
                   Выберите месяц
                </button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" data-toggle="dropdown">
               <div>
                    <label class="text-wrap" style="color:white;" for="companySelect">Выберите месяц</label>
                    <select
                        style="background-color:#20274e;border-color:#20274e;color:white;"
                        class="form-control"
                        id="companySelect"
                        @change="onChangeMonth($event)"
                    >
                    <option>Выберите месяц</option>
                        <option value="1">январь</option>
                        <option value="2">февраль</option>
                        <option value="3">март</option>
                        <option value="4">апрель</option>
                        <option value="5">май</option>
                        <option value="6">июнь</option>
                        <option value="7">июль</option>
                        <option value="8">август</option>
                        <option value="9">сентябрь</option>
                        <option value="10">октябрь</option>
                        <option value="11">ноябрь</option>
                        <option value="12">декабрь</option>
                    </select>
                </div>
                <div>
                    <label class="text-wrap" style="color:white;" for="companySelect">Выберите год</label>
                    <select
                        style="background-color:#20274e;border-color:#20274e;color:white;"
                        class="form-control"
                        id="companySelect"
                        @change="onChangeYear($event)"
                    >
                    <option value=''> Выберите год </option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>

                    </select>
                </div>
                <a href="#" @click.prevent="chooseDt" class="but-nav__link but">Сформировать</a>

            </div>

</div>
            <!-- <div>
                <div>
                    <label class="text-wrap" style="color:white;" for="companySelect">Выберите месяц</label>
                    <select
                        style="background-color:#20274e;border-color:#20274e;color:white;"
                        class="form-control"
                        id="companySelect"
                        @change="onChangeMonth($event)"
                    >
                    <option>Выберите месяц</option>
                        <option value="1">январь</option>
                        <option value="2">февраль</option>
                        <option value="3">март</option>
                        <option value="4">апрель</option>
                        <option value="5">май</option>
                        <option value="6">июнь</option>
                        <option value="7">июль</option>
                        <option value="8">август</option>
                        <option value="9">сентябрь</option>
                        <option value="10">октябрь</option>
                        <option value="11">ноябрь</option>
                        <option value="12">декабрь</option>
                    </select>
                </div>
                <div>
                    <label class="text-wrap" style="color:white;" for="companySelect">Выберите год</label>
                    <select
                        style="background-color:#20274e;border-color:#20274e;color:white;"
                        class="form-control"
                        id="companySelect"
                        @change="onChangeYear($event)"
                    >
                    <option value=''> Выберите год </option>
                        <option value="2020">2020</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>

                    </select>
                </div>

            </div> -->
            <!-- <a href="#" class="but-nav__link but">Выбор даты 2</a> -->
            <!-- <a href="#" @click.prevent="chooseDt" class="but-nav__link but">Сформировать</a> -->
            <a @click="editable()" v-if="!edit" class=" col but-nav__link but"><i style=" margin-right: 10px; ">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.10481 18.579C0.824148 18.5785 0.55658 18.4602 0.367405 18.253C0.174748 18.0475 0.0790152 17.7695 0.104259 17.489L0.349395 14.795L11.6737 3.481L15.2126 7.017L3.89136 18.33L1.19586 18.575C1.16485 18.578 1.13383 18.579 1.10481 18.579ZM15.919 6.31L12.3811 2.774L14.5032 0.653001C14.691 0.465221 14.9456 0.359711 15.2111 0.359711C15.4767 0.359711 15.7313 0.465221 15.919 0.653001L18.0412 2.774C18.2291 2.96157 18.3347 3.21609 18.3347 3.4815C18.3347 3.74691 18.2291 4.00143 18.0412 4.189L15.92 6.309L15.919 6.31Z" fill="white"/>
</svg>

                </i>
                Редактировать</a>
            <a @click="savetable()" v-if="edit" class="col but-nav__link but">Сохранить</a>

            <!-- <a href="http://172.20.103.51:7576/api/techregime/factor/download" download="Тех Режим.xlsx" class="but-nav__link but">Экспорт</a> -->

        <div class="col">

                        <div class="input-group input-group-sm">
                            <input type="text" placeholder="Поиск" class="form-control fix-rounded-right" required>
                            <div class="input-group-prepend">
                                <button class="input-group-text" style="font-size: 14px;">Поиск</button>
                            </div>
                        </div>
        </div>
        </div>


    </div>

        <div>
            <!-- <input type="text" placeholder="Enter Name" v-model="searchText"> -->
        </div>
       <div class="col-md-12 maintable" >
           <div class="maintable-level2">
               <div class="techvers" style="display: flex;">
                    <div class="tech">
                        <h3> Технологический режим на {{dt}}</h3>
                    </div>





                    <!-- <div>
                        <select name="Company" class="from-control" id="companySelect"
                            v-model="filter" @change="chooseField">
                            <option value="Акшабулак Центральный">КазГер</option>
                            <option value="Акшабулак Центральный">Акшабулак Центральный</option>
                            <option value="Акшабулак Южный">Акшабулак Южный</option>
                            <option value="Акшабулак Восточный">Акшабулак Восточный</option>
                            <option value="Нуралы">Нуралы</option>
                            <option value="Аксай">Аксай</option>
                            <option value="Аксай Южный">Аксай Южный</option>
                        </select>
                    </div> -->
                    <button id="bt1"   @click="swap" style="background: #272953; color: white; margin-left: 1071px; border: none;"><svg width="19" style="margin-right:10px;" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">

<path d="M9 6H6C5.44772 6 5 6.44772 5 7V18C5 18.5523 5.44772 19 6 19H17C17.5523 19 18 18.5523 18 18V15M11.5 12.5L19 5M19 5V10.5M19 5H13.5" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
</svg>Версия для отображения</button>
                </div>
            <div >
                <TrTable :wells="wells" @onSort="sortField" v-show="show_first"/>
                <!-- <TrFullTable :wells="wells" :edit="edit" @onSort="sortBy" v-show="show_second"/> -->
                <table v-show="show_second" class="table table-bordered table-dark table-responsive ce">
                    <tr class="headerColumn">
                        <td rowspan="4" @click="sortField=wells.gu">Раб. Группа</td>
                        <td rowspan="4" @click="sortField=wells.field">НГДУ/месторождение</td>
                        <td rowspan="4" @click="sortBy('well')">№ скв</td>
                        <td rowspan="4" @click="sortBy('well_type')">Тип скважины</td>
                        <td rowspan="4" @click="sortBy('horizon')">Горизонт</td>
                        <td rowspan="4" @click="sortBy('block')">Блок</td>
                        <td rowspan="4" @click="sortBy('r_con')">R контура питания</td>
                        <td rowspan="4" @click="sortBy('cas_OD')">Наружный диаметр э/к</td>
                        <td rowspan="4" @click="sortBy('cas_ID')">Внутренний диаметр э/к</td>
                        <td rowspan="4" @click="sortBy('tub_OD')">Наружный диаметр НКТ</td>
                        <td rowspan="4" @click="sortBy('tub_ID')">Внутренний диаметр НКТ</td>
                        <td rowspan="4" @click="sortBy('choke_d')">Диаметр штуцера</td>
                        <td rowspan="4" @click="sortBy('h_up_perf_md')">Нвдп</td>
                        <td rowspan="4" @click="sortBy('h_up_perf_vd')">Удлинение(Нвдп)</td>
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
                        <td rowspan="4" @click="sortBy('p_annular')"><span>Вязкость нефти в пластовых условиях</span></td>
                        <td rowspan="4" @click="sortBy('p_annular')"><span>Вязкость воды в пластовых условиях</span></td>
                        <td rowspan="4" @click="sortBy('p_annular')">Вязкость жидкости</td>
                        <td rowspan="4" @click="sortBy('p_annular')">Объемный коэффициент</td>
                        <td rowspan="4" @click="sortBy('p_annular')">Плотность нефти</td>
                        <td rowspan="4" @click="sortBy('p_annular')">Плотность воды</td>
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
                        <td rowspan="4" @click="sortBy('p_annular')"><span>Дата последнего ГТМ</span></td>
                        <td rowspan="4" @click="sortBy('p_annular')"><span>Вид последнего ГТМ</span></td>
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
                    <tr class="subHeaderColumn" style="color: white">
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
                        <td>мм</td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="(row, row_index) in wells" :key="row_index">
                        <td v-if="!edit">{{row.gu}}</td>
                        <td v-if="edit">{{row.gu}}</td>

                        <td v-if="!edit">{{row.field}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.field" :disabled="!edit"></td>

                        <td v-if="!edit">{{row.well}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.well" :disabled="!edit"></td>
                        <!-- <td>{{row.well_type}}</td> -->

                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].well_type[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].well_type[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].well_type[1][0])}`"> </span>
                            <span>{{row.well_type[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].well_type[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].well_type[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].well_type[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].well_type[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.well_type[0]" :disabled="!edit">
                            <!-- <span>{{row.well_type[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].well_type[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.horizon}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].horizon[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].horizon[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].horizon[1][0])}`"> </span>
                            <span>{{row.horizon[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].horizon[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].horizon[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].horizon[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].horizon[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.horizon[0]" :disabled="!edit">
                            <!-- <span>{{row.horizon[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].horizon[1][1]}}
                            </span>
                        </td>

                        <!-- <td v-if="!edit">{{row.block}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.block" :disabled="!edit"></td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].block[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].block[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].block[1][0])}`"> </span>
                            <span>{{row.block[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].block[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].block[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].block[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].block[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.block[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.cas_OD[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].block[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.r_con*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.r_con" :disabled="!edit"></td>

                        <!-- <td>{{Math.round(row.cas_OD*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].cas_OD[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].cas_OD[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].cas_OD[1][0])}`"> </span>
                            <span>{{Math.round(row.cas_OD[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].cas_OD[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].cas_OD[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].cas_OD[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].cas_OD[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.cas_OD[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.cas_OD[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].cas_OD[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.cas_ID*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.cas_ID" :disabled="!edit"></td>

                        <!-- <td>{{Math.round(row.tub_OD*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tub_OD[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tub_OD[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tub_OD[1][0])}`"> </span>
                            <span>{{Math.round(row.tub_OD[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tub_OD[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tub_OD[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tub_OD[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tub_OD[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.tub_OD[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.tub_OD[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tub_OD[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.tub_ID*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.tub_ID" :disabled="!edit"></td>

                        <!-- <td>{{Math.round(row.choke_d*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].choke_d[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].choke_d[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].choke_d[1][0])}`"> </span>
                            <span>{{Math.round(row.choke_d[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].choke_d[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].choke_d[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].choke_d[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].choke_d[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.choke_d[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.choke_d[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].choke_d[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.h_up_perf_md[0]*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.h_up_perf_md[0]" :disabled="!edit"></td>

                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_up_perf_ext[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_up_perf_ext[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_up_perf_ext[1][0])}`"> </span>
                            <span>{{Math.round(row.h_up_perf_ext[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_up_perf_ext[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_up_perf_ext[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_up_perf_ext[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_up_perf_ext[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.h_up_perf_ext[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.h_up_perf_md[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_up_perf_ext[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.exp_meth}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].exp_meth[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].exp_meth[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].exp_meth[1][0])}`"> </span>
                            <span>{{row.exp_meth[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].exp_meth[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].exp_meth[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].exp_meth[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].exp_meth[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.exp_meth[0]" :disabled="!edit">
                            <!-- <span>{{row.exp_meth[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].exp_meth[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.pump_type}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].pump_type[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].pump_type[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].pump_type[1][0])}`"> </span>
                            <span>{{row.pump_type[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].pump_type[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].pump_type[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].pump_type[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].pump_type[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.pump_type[0]" :disabled="!edit">
                            <!-- <span>{{row.pump_type[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].pump_type[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.EMPTY*10)/10}}</td>
                        <td v-if="edit">{{Math.round(row.EMPTY*10)/10}}</td>

                        <!-- <td>{{Math.round(row.spm*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].spm[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].spm[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].spm[1][0])}`"> </span>
                            <span>{{Math.round(row.spm[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].spm[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].spm[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].spm[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].spm[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.spm[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.spm[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].spm[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.stroke_len*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].stroke_len[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].stroke_len[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].stroke_len[1][0])}`"> </span>
                            <span>{{Math.round(row.stroke_len[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].stroke_len[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].stroke_len[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].stroke_len[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].stroke_len[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.stroke_len[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.stroke_len[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].stroke_len[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.q_theor*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].q_theor[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].q_theor[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].q_theor[1][0])}`"> </span>
                            <span>{{Math.round(row.q_theor[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].q_theor[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].q_theor[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].q_theor[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].q_theor[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.q_theor[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.q_theor[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].q_theor[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.freq*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].freq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].freq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].freq[1][0])}`"> </span>
                            <span>{{Math.round(row.freq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].freq[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" contenteditable='true' :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].freq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].freq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].freq[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.freq[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.freq[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].freq[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.h_pump_set*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_pump_set[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_pump_set[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_pump_set[1][0])}`"> </span>
                            <span>{{Math.round(row.h_pump_set[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_pump_set[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_pump_set[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_pump_set[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_pump_set[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.h_pump_set[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.h_pump_set[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_pump_set[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.whp*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].whp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].whp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].whp[1][0])}`"> </span>
                            <span>{{Math.round(row.whp[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].whp[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].whp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].whp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].whp[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.whp[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.whp[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].whp[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.line_p*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].line_p[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].line_p[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].line_p[1][0])}`"> </span>
                            <span>{{Math.round(row.line_p[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].line_p[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].line_p[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].line_p[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].line_p[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.line_p[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.line_p[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].line_p[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].p_res[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].p_res[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].p_res[1][0])}`"> </span>
                            <span>{{Math.round(row.p_res[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].p_res[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].p_res[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].p_res[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].p_res[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.p_res[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.p_res[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].p_res[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.h_dyn*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_dyn[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_dyn[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_dyn[1][0])}`"> </span>
                            <span>{{Math.round(row.h_dyn[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_dyn[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_dyn[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_dyn[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_dyn[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.h_dyn[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.h_dyn[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_dyn[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.p_annular*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].p_annular[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].p_annular[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].p_annular[1][0])}`"> </span>
                            <span>{{Math.round(row.p_annular[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].p_annular[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].p_annular[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].p_annular[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].p_annular[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.p_annular[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.p_annular[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].p_annular[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.p_intake*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].p_intake[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].p_intake[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].p_intake[1][0])}`"> </span>
                            <span>{{Math.round(row.p_intake[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].p_intake[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].p_intake[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].p_intake[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].p_intake[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.p_intake[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.p_intake[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].p_intake[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.bhp_prev_m*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.bhp_prev_m" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.q_l_prev_m*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.q_l_prev_m" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.wct_prev_m*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.wct_prev_m" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.h_dyn_prev_m*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.h_dyn_prev_m" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.pi_prev_m*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.pi_prev_m" :disabled="!edit"></td>

                        <!-- <td>{{Math.round(row.bhp*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].bhp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].bhp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].bhp[1][0])}`"> </span>
                            <span>{{Math.round(row.bhp[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].bhp[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].bhp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].bhp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].bhp[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.bhp[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.bhp[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].bhp[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.q_o*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].q_o[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].q_o[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].q_o[1][0])}`"> </span>
                            <span>{{Math.round(row.q_o[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].q_o[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].q_o[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].q_o[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].q_o[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.q_o[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.q_o[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].q_o[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.q_l*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].q_l[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].q_l[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].q_l[1][0])}`"> </span>
                            <span>{{Math.round(row.q_l[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].q_l[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].q_l[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].q_l[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].q_l[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.q_l[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.q_l[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].q_l[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].wct[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].wct[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].wct[1][0])}`"> </span>
                            <span>{{Math.round(row.wct[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].wct[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].wct[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].wct[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].wct[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.wct[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.wct[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].wct[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.well_status_last_day}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].well_status_last_day[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].well_status_last_day[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].well_status_last_day[1][0])}`"> </span>
                            <span>{{row.well_status_last_day[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].well_status_last_day[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].well_status_last_day[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].well_status_last_day[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].well_status_last_day[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.well_status_last_day[0]" :disabled="!edit">
                            <!-- <span>{{row.well_status_last_day[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].well_status_last_day[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.P_bubble_point*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].P_bubble_point[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].P_bubble_point[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].P_bubble_point[1][0])}`"> </span>
                            <span>{{Math.round(row.P_bubble_point[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].P_bubble_point[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].P_bubble_point[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].P_bubble_point[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].P_bubble_point[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.P_bubble_point[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.P_bubble_point[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].P_bubble_point[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gor*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gor[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gor[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gor[1][0])}`"> </span>
                            <span>{{Math.round(row.gor[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gor[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gor[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gor[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gor[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.gor[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.gor[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gor[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.t_res*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].t_res[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].t_res[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].t_res[1][0])}`"> </span>
                            <span>{{Math.round(row.t_res[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].t_res[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].t_res[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].t_res[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].t_res[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.t_res[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.t_res[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].t_res[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.wht*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.wht" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.grp_skin[0]*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.grp_skin[0]" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.grp_jd*100)/100}}</td>
                        <td v-if="edit">{{Math.round(row.grp_jd*100)/100}}</td>

                        <!-- <td>{{row.grp_date}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].grp_date[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].grp_date[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].grp_date[1][0])}`"> </span>
                            <span>{{row.grp_date[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].grp_date[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].grp_date[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].grp_date[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].grp_date[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.grp_date[0]" :disabled="!edit">
                            <!-- <span>{{row.grp_date[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].grp_date[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.grp_contractor}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].grp_contractor[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].grp_contractor[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].grp_contractor[1][0])}`"> </span>
                            <span>{{row.grp_contractor[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].grp_contractor[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].grp_contractor[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].grp_contractor[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].grp_contractor[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.grp_contractor[0]" :disabled="!edit">
                            <!-- <span>{{row.grp_contractor[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].grp_contractor[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.visc_oil_rc*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].visc_oil_rc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].visc_oil_rc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].visc_oil_rc[1][0])}`"> </span>
                            <span>{{Math.round(row.visc_oil_rc[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].visc_oil_rc[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].visc_oil_rc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].visc_oil_rc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].visc_oil_rc[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.visc_oil_rc[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.visc_oil_rc[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].visc_oil_rc[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.visc_wat_rc*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].visc_wat_rc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].visc_wat_rc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].visc_wat_rc[1][0])}`"> </span>
                            <span>{{Math.round(row.visc_wat_rc[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].visc_wat_rc[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].visc_wat_rc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].visc_wat_rc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].visc_wat_rc[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.visc_wat_rc[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.visc_wat_rc[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].visc_wat_rc[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.visc_liq_rc*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].visc_liq_rc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].visc_liq_rc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].visc_liq_rc[1][0])}`"> </span>
                            <span>{{Math.round(row.visc_liq_rc[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].visc_liq_rc[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].visc_liq_rc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].visc_liq_rc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].visc_liq_rc[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.visc_liq_rc[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.visc_liq_rc[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].visc_liq_rc[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.bo*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].bo[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].bo[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].bo[1][0])}`"> </span>
                            <span>{{Math.round(row.bo[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].bo[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].bo[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].bo[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].bo[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.bo[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.bo[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].bo[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.dens_oil*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].dens_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].dens_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].dens_oil[1][0])}`"> </span>
                            <span>{{Math.round(row.dens_oil[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].dens_oil[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].dens_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].dens_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].dens_oil[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.dens_oil[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.dens_oil[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].dens_oil[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.dens_liq*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].dens_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].dens_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].dens_liq[1][0])}`"> </span>
                            <span>{{Math.round(row.dens_liq[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].dens_liq[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].dens_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].dens_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].dens_liq[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.dens_liq[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.dens_liq[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].dens_liq[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.h_perf*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_perf[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_perf[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_perf[1][0])}`"> </span>
                            <span>{{Math.round(row.h_perf[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_perf[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].h_perf[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].h_perf[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].h_perf[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.h_perf[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.h_perf[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].h_perf[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.k*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].k[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].k[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].k[1][0])}`"> </span>
                            <span>{{Math.round(row.k[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].k[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].k[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].k[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].k[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.k[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.k[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].k[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.kh*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].kh[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].kh[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].kh[1][0])}`"> </span>
                            <span>{{Math.round(row.kh[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].kh[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].kh[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].kh[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].kh[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.kh[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.kh[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].kh[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.pi*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].pi[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].pi[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].pi[1][0])}`"> </span>
                            <span>{{Math.round(row.pi[0]*100)/100}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].pi[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].pi[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].pi[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].pi[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.pi[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.pi[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].pi[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_bhp*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_bhp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_bhp[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_bhp[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_bhp[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_bhp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_bhp[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_bhp[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_bhp[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_bhp[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_liq*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_liq[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_liq[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_liq[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_liq[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_liq[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_liq_cas_d_corr*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_liq_cas_d_corr[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_liq_cas_d_corr[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_oil*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_oil[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_oil[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_oil[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_oil[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_oil[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_oil_inc*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_oil_inc[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_oil_inc[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_oil_inc[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_oil_inc[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_oil_inc[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_jd*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_jd[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_jd[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_jd[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_jd[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_jd[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_jd[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_jd[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_jd[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_jd[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_jd[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_jd[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_skin*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_skin[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_skin[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_skin[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_skin[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_skin[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_skin[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_skin[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_skin[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_skin[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_skin[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_skin[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_pi_after*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_pi_after[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_pi_after[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_pi_after[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_pi_after[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_pi_after[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_pi_after[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_pi_after[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_pi_after[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_pi_after[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_pi_after[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_pi_after[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_grp_q_liq*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_grp_q_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_liq[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_liq[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_grp_q_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_liq[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_grp_q_liq_cas_d_corr*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_grp_q_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_grp_q_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_grp_q_oil*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_grp_q_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_oil[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_oil[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_grp_q_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_oil[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.tp_idn_grp_q_oil_inc*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0])}`"> </span>
                            <span>{{Math.round(row.tp_idn_grp_q_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_oil_inc[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_oil_inc[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.tp_idn_grp_q_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.tp_idn_q_oil_inc_perc*10)/10}}</td>
                        <td v-if="edit">{{Math.round(row.tp_idn_q_oil_inc_perc*10)/10}}</td>

                        <!-- <td>{{Math.round(row.gp_idn_bhp*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_bhp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_bhp[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_idn_bhp[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_bhp[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_bhp[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_bhp[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_bhp[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_idn_bhp[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_bhp[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_idn_q_liq*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_idn_q_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_liq[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_liq[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_idn_q_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_liq[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_idn_q_liq_cas_d_corr*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_idn_q_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_idn_q_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_idn_q_oil*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_idn_q_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_oil[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_oil[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_idn_q_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_oil[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_idn_q_oil_inc*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil_inc[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_idn_q_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_oil_inc[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_idn_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_idn_q_oil_inc[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_oil_inc[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_idn_q_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_idn_q_oil_inc[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_grp_q_liq*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_grp_q_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_liq[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_liq[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_grp_q_liq[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_liq[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_grp_q_liq_cas_d_corr*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_grp_q_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_grp_q_liq_cas_d_corr[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_liq_cas_d_corr[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_grp_q_oil*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_grp_q_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_oil[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_oil[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_grp_q_oil[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_oil[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.gp_grp_q_oil_inc*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil_inc[1][0])}`"> </span>
                            <span>{{Math.round(row.gp_grp_q_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_oil_inc[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil_inc[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].gp_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].gp_grp_q_oil_inc[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_oil_inc[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.gp_grp_q_oil_inc[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].gp_grp_q_oil_inc[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{row.error_count}}</td>
                        <td v-if="edit">{{row.error_count}}</td>

                        <td v-if="!edit">{{row.error_first}}</td>
                        <td v-if="edit">{{row.error_first}}</td>

                        <td v-if="!edit">{{row.error_warning}}</td>
                        <td v-if="edit">{{row.error_warning}}</td>

                        <td v-if="!edit">{{row.error_first_warning}}</td>
                        <td v-if="edit">{{row.error_first_warning}}</td>

                        <!-- <td>{{Math.round(row.idn_pump_depth_max*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].idn_pump_depth_max[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].idn_pump_depth_max[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].idn_pump_depth_max[1][0])}`"> </span>
                            <span>{{Math.round(row.idn_pump_depth_max[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].idn_pump_depth_max[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].idn_pump_depth_max[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].idn_pump_depth_max[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].idn_pump_depth_max[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.idn_pump_depth_max[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.idn_pump_depth_max[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].idn_pump_depth_max[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.stop_date}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].stop_date[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].stop_date[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].stop_date[1][0])}`"> </span>
                            <span>{{row.stop_date[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].stop_date[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].stop_date[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].stop_date[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].stop_date[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.stop_date[0]" :disabled="!edit">
                            <!-- <span>{{row.stop_date[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].stop_date[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.layers_count}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].layers_count[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].layers_count[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].layers_count[1][0])}`"> </span>
                            <span>{{row.layers_count[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].layers_count[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].layers_count[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].layers_count[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].layers_count[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.layers_count[0]" :disabled="!edit">
                            <!-- <span>{{row.layers_count[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].layers_count[1][1]}}
                            </span>
                        </td>

                        <!-- <td v-if="!edit">{{row.zone}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.zone" :disabled="!edit"></td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].zone[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].zone[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].zone[1][0])}`"> </span>
                            <span>{{row.zone[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].zone[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].zone[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].zone[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].zone[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.zone[0]" :disabled="!edit">
                            <!-- <span>{{row.layers_count[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].zone[1][1]}}
                            </span>
                        </td>

                        <!-- <td v-if="!edit">{{row.tseh}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.tseh" :disabled="!edit"></td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tseh[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tseh[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tseh[1][0])}`"> </span>
                            <span>{{row.tseh[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tseh[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].tseh[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].tseh[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].tseh[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.tseh[0]" :disabled="!edit">
                            <!-- <span>{{row.layers_count[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].tseh[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{row.semi_free_flow[0]}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.semi_free_flow[0]" :disabled="!edit"></td>

                        <!-- <td>{{row.non_profit[0]}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].non_profit[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].non_profit[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].non_profit[1][0])}`"> </span>
                            <span>{{row.non_profit[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].non_profit[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].non_profit[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].non_profit[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].non_profit[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.non_profit[0]" :disabled="!edit">
                            <!-- <span>{{row.non_profit[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].non_profit[1][1]}}
                            </span>
                        </td>

                        <!-- <td v-if="!edit">{{row.unsteady_state}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.unsteady_state" :disabled="!edit"></td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].unsteady_state[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].unsteady_state[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].unsteady_state[1][0])}`"> </span>
                            <span>{{row.unsteady_state[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].unsteady_state[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].unsteady_state[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].unsteady_state[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].unsteady_state[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.unsteady_state[0]" :disabled="!edit">
                            <!-- <span>{{row.start_up_date[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].unsteady_state[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.start_up_date}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].start_up_date[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].start_up_date[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].start_up_date[1][0])}`"> </span>
                            <span>{{row.start_up_date[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].start_up_date[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].start_up_date[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].start_up_date[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].start_up_date[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.start_up_date[0]" :disabled="!edit">
                            <!-- <span>{{row.start_up_date[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].start_up_date[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{row.well_project_purpose}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].well_project_purpose[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].well_project_purpose[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].well_project_purpose[1][0])}`"> </span>
                            <span>{{row.well_project_purpose[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].well_project_purpose[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].well_project_purpose[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].well_project_purpose[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].well_project_purpose[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.well_project_purpose[0]" :disabled="!edit">
                            <!-- <span>{{row.well_project_purpose[0]}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].well_project_purpose[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.bhp_meter*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].bhp_meter[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].bhp_meter[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].bhp_meter[1][0])}`"> </span>
                            <span>{{Math.round(row.bhp_meter[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].bhp_meter[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].bhp_meter[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].bhp_meter[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].bhp_meter[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.bhp_meter[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.bhp_meter[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].bhp_meter[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.oil_net_pay*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].oil_net_pay[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].oil_net_pay[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].oil_net_pay[1][0])}`"> </span>
                            <span>{{Math.round(row.oil_net_pay[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].oil_net_pay[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].oil_net_pay[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].oil_net_pay[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].oil_net_pay[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.oil_net_pay[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.oil_net_pay[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].oil_net_pay[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.oil_cumulative*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].oil_cumulative[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].oil_cumulative[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].oil_cumulative[1][0])}`"> </span>
                            <span>{{Math.round(row.oil_cumulative[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].oil_cumulative[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].oil_cumulative[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].oil_cumulative[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].oil_cumulative[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.oil_cumulative[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.oil_cumulative[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].oil_cumulative[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.max_q_liq_hist*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].max_q_liq_hist[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].max_q_liq_hist[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].max_q_liq_hist[1][0])}`"> </span>
                            <span>{{Math.round(row.max_q_liq_hist[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].max_q_liq_hist[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].max_q_liq_hist[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].max_q_liq_hist[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].max_q_liq_hist[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.max_q_liq_hist[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.max_q_liq_hist[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].max_q_liq_hist[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{Math.round(row.dist_to_inj_well*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.dist_to_inj_well" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.dist_to_woc*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.dist_to_woc" :disabled="!edit"></td>

                        <!-- <td>{{Math.round(row.curr_bh*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].curr_bh[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].curr_bh[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].curr_bh[1][0])}`"> </span>
                            <span>{{Math.round(row.curr_bh[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].curr_bh[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].curr_bh[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].curr_bh[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].curr_bh[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.curr_bh[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.curr_bh[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].curr_bh[1][1]}}
                            </span>
                        </td>

                        <!-- <td>{{Math.round(row.pump_fillage*10)/10}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].pump_fillage[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].pump_fillage[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].pump_fillage[1][0])}`"> </span>
                            <span>{{Math.round(row.pump_fillage[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].pump_fillage[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].pump_fillage[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].pump_fillage[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].pump_fillage[1][0])}`"> </span>
                            <!-- <input @change="editrow(row, row_index)" v-model="row.pump_fillage[0]" :disabled="!edit"> -->
                            <span>{{Math.round(row.pump_fillage[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].pump_fillage[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{row.gzu_type}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.gzu_type" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.p_res_init*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.p_res_init" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.q_liq_charac*10)/10}}</td>
                        <td v-if="edit">{{Math.round(row.q_liq_charac*10)/10}}</td>

                        <!-- <td v-if="!edit">{{row.APV_t_rab}}</td>
                        <td v-if="edit">{{row.APV_t_rab}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].APV_t_rab[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].APV_t_rab[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].APV_t_rab[1][0])}`"> </span>
                            <span>{{row.APV_t_rab[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].APV_t_rab[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].APV_t_rab[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].APV_t_rab[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].APV_t_rab[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.APV_t_rab[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].APV_t_rab[1][1]}}
                            </span>
                        </td>

                        <!-- <td v-if="!edit">{{row.APV_t_nak}}</td>
                        <td v-if="edit">{{row.APV_t_nak}}</td> -->
                        <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].APV_t_nak[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].APV_t_nak[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].APV_t_nak[1][0])}`"> </span>
                            <span>{{row.APV_t_nak[0]}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].APV_t_nak[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].APV_t_nak[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].APV_t_nak[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].APV_t_nak[1][0])}`"> </span>
                            <input @change="editrow(row, row_index)" v-model="row.APV_t_nak[0]" :disabled="!edit">
                            <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].APV_t_nak[1][1]}}
                            </span>
                        </td>

                        <td v-if="!edit">{{row.plan_izo_work}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.plan_izo_work" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.plan_act_q_l*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.plan_act_q_l" :disabled="!edit"></td>

                        <td v-if="!edit">{{Math.round(row.plan_act_wct*10)/10}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.plan_act_wct" :disabled="!edit"></td>

                        <td v-if="!edit">{{row.plan_activities}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.plan_activities" :disabled="!edit"></td>

                        <td v-if="!edit">{{row.plan_casing_info}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.plan_casing_info" :disabled="!edit"></td>

                        <td v-if="!edit">{{row.plan_comment}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.plan_comment" :disabled="!edit"></td>

                        <td v-if="!edit">{{row.EMPTY}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.EMPTY" :disabled="!edit"></td>

                        <td v-if="!edit">{{row.EMPTY}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.EMPTY" :disabled="!edit"></td>
                    </tr>
                </table>

            </div>
        </div>
        </div>
    </div>
</template>
<script>
import TrTable from './table'
import TrFullTable from './tablefull'

export default {
  name: "TrPage",
  components: {
      TrTable, TrFullTable,
  },
  beforeCreate: function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        if(mm==0){
            var prMm = 12
        }
        else{
            var prMm = mm - 1
        }
        this.axios.get("http://172.20.103.51:7576/api/techregime/"+yyyy+"/"+prMm+"/").then((response) => {
        let data = response.data;
        this.editdtm = prMm;
        console.log(this.editdtm);
        this.editdty = yyyy;
        console.log(this.editdty);
        if(data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
        }
        else {
            console.log('No data');
        }
        if(prMm < 10) {
            this.dt = '01' + '.0' + prMm + '.' + yyyy;
        }
        else {
            this.dt = '01' + '.' + prMm + '.' + yyyy;
        }
    });
  },
  data: function () {
    return {
        wells: [],
        // sortKey: 'name',
        filter: null,
        dt: null,
        fullWells: [],
        show_first: true,
        show_second: false,
        edit: false,
        editdtm: null,
        editdty: null,
        sortField: null,
        currentSortDir: 'asc',
        year: null,
        month: null,
    }
  },
//   computed:{
//       sortedData() {
//         // //   let { wells, sortType } = this;
//         //   this.reverse = (this.sortKey == sortKey) ? !this.reverse : false;
//         //   this.sortKey = sortKey;

//         //   console.log(type, sortType);
//         //   if(sortType === 'asc') {
//         //     wells.sort((a, b) => a[type].localeCompare(b[type]))
//         //     this.sortType = 'desc';
//         //   } else {
//         //     wells.sort((a, b) => b[type].localeCompare(a[type]))
//         //     this.sortType = 'asc';
//         //   }
//           if (this.sortField === null) {
//               return this.wells;
//           }
//           return this.wells.sort((a, b) => {
//               let res;
//               if (typeof a[this.sortField] === 'string') {
//               res = a[this.sortField].localeCompare(b[this.sortField])
//               } else {
//               res = a[this.sortField] > b[this.sortField] ? 1 :
//                   a[this.sortField] < b[this.sortField] ? -1 : 0
//               }
//               if (this.currentSortDir !== 'asc') {
//               ret = ret * -1;
//               }
//               return ret
//           })
//       },

//   },
  methods: {
      editrow(row, rowId) {
          // console.log(row);
          row['index'] = 0;
          this.axios.post("http://172.20.103.51:7576/api/techregime/edit/"+this.year+"/"+this.month+"/", {
                row: row,
            }).then((response) => {
                if(response.data) {
                    // console.log('EDIT_RESPONSE', response.data.data[0])
                    this.wells = this.wells.map((currentRow, index) => {
                        // console.log('norm', index, rowId)
                        return (index === rowId) ? response.data.data[0] : currentRow;
                    })

                }
                else {
                    console.log('No data');
                }
            });
      },
      savetable(){
          this.edit = false;
          this.axios.post("http://172.20.103.51:7576/api/techregime/"+this.year+"/"+this.month+"/",{
              well: this.wells
          }).then((response) => {
              console.log(response.data)
          })
      },
      editable(){
          this.edit = true;
          this.show_second = true;
          this.show_first = false;
      },
    //   sortBy(sortKey) {
    //     //   let { wells, sortType } = this;
    //       this.reverse = (this.sortKey == sortKey) ? !this.reverse : false;
    //       this.sortKey = sortKey;

    //     //   console.log(type, sortType);
    //     //   if(sortType === 'asc') {
    //     //     wells.sort((a, b) => a[type].localeCompare(b[type]))
    //     //     this.sortType = 'desc';
    //     //   } else {
    //     //     wells.sort((a, b) => b[type].localeCompare(a[type]))
    //     //     this.sortType = 'asc';
    //     //   }
    //     //   if (this.sortField === null) {
    //     //       return this.wells;
    //     //   }
    //     //   return this.wells.sort((a, b) => {
    //     //       let res;
    //     //       if (typeof a[this.sortField] === 'string') {
    //     //       res = a[this.sortField].localeCompare(b[this.sortField])
    //     //       } else {
    //     //       res = a[this.sortField] > b[this.sortField] ? 1 :
    //     //           a[this.sortField] < b[this.sortField] ? -1 : 0
    //     //       }
    //     //       if (this.currentSortDir !== 'asc') {
    //     //       ret = ret * -1;
    //     //       }
    //     //       return ret
    //     //   })

    //   },
      onChangeMonth(event) {
          if(event.target.value == 1){
              this.month = 12;
          }
          else{
              this.month = event.target.value - 1;
          }
      },
      onChangeYear(event) {
              this.year = event.target.value;
      },

      chooseDt() {
        //   const { dt } = this;
        //   console.log(dt)
        //   var choosenDt = dt.split("-");
          if(this.month == 12){
              this.year = this.year - 1;
          }
          else{
              this.year = this.year;
          }
          this.axios.get("http://172.20.103.51:7576/api/techregime/"+this.year+"/"+this.month+"/").then((response) => {
                // this.editdtm = choosenDt[1];
                // this.editdty = choosenDt[0];
                console.log(this.year);
                console.log(this.month)
                let data = response.data;
                if(data) {
                    console.log(data);
                    this.wells = data.data;
                    this.fullWells = data.data;
                }
                else {
                    console.log('No data');
                }
                if(this.month < 9) {
                    this.dt = '01' + '.0' + (this.month + 1) + '.' + this.year;
                }
                else if(this.month == 12){
                    this.dt = '01' + '.01.' + (this.year + 1);
                }
                else {
                    this.dt = '01' + '.' + (this.month+1) + '.' + this.year;
                }
            });
      },
      chooseField() {
          const { filter, fullWells } = this;
          console.log(filter, fullWells);
          if(filter == 'Казгермунай'){
            this.wells = fullWells.filter(undefined);
          }
          else{
            this.wells = fullWells.filter(e => e.field === filter);
          }
      },
      swap() {
          this.show_first = !this.show_first;
          this.show_second = !this.show_second;
      },
      getColor(status) {
          if (status === "1") return "#ffff00";
          return "#ff0000";
      }

  }
}

</script>
<style scoped>
body {
  color: white !important;
}
.form-control, .fix-rounded-right{
    background: #272953!important;
    border: 1px solid #656A8A!important;
    height: 35px!important;
    color: white!important;
}
.input-group-text
{
    background: #656A8A!important;
    color: white!important;
    border-radius: 6px!important;
    border: none!important;
    position: absolute!important;
    right: 0!important;
    z-index: 9999;

}
.input-group-prepend{

    padding-top: 3px!important;
    margin-right: -3px!important;

}
a:hover{
    color: white!important;
    text-decoration: none!important;
}
.maintable{

    padding-top: 35px;

}
.maintable-level2{
    background: #272953;
}
.table th, .table td {
    padding: 5px !important; 
    /* vertical-align: top;
    border-top: 1px solid #dee2e6; */
}
table.table.table-bordered.table-dark.table-responsive.ce {
    position: sticky;
    inset: 48.21% 2.4% 66.58% 5.31%;
    background: rgb(13, 30, 99);
    font-size: 9px;
    padding: unset;
}

tr:nth-child(odd) {background-color:#454d7d;}
tr:nth-child(even) {background-color:#454d7d73;}
</style>
