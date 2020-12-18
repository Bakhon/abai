<template>
  <div class="container-fluid">
    <div class="col-md-12 row trcolmd12">
      <div
        class="col-md-12 row justify-content-between"
        style="
          box-sizing: border box;
          flex-grow: 1;
          padding-right: 0;
          margin-right: 0;
          margin-left: 0;
          paddng-left: 0;
        "
      >
        <a href="fa" class="col but-nav__link but" style="margin-left: -17px"
          ><i style="margin-right: 10px"
            ><svg
              width="24"
              height="14"
              viewBox="0 0 24 14"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z"
                fill="white"
              />
            </svg> </i
          >Факторный анализ отклонений ТР</a
        >
        <!-- <form class="form-group but-nav__link">
                    <label for="inputDate">Введите дату:</label>
                    <input type="date" value = "01.06.2020" class="form-control" v-model="dt">
            </form> -->
        <div class="col dropdown">
          <button
            class="col-md-12 but-nav__link but"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i style="margin-right: 10px">
              <svg
                width="18"
                height="20"
                viewBox="0 0 18 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M15.6583 19.4286H2.33239C1.281 19.4286 0.42868 18.5843 0.42868 17.5429V4.34285C0.42868 3.3014 1.281 2.45714 2.33239 2.45714H4.23609V0.571426H6.1398V2.45714H11.8509V0.571426H13.7546V2.45714H15.6583C16.7098 2.45714 17.562 3.3014 17.562 4.34285V17.5429C17.562 18.5843 16.7098 19.4286 15.6583 19.4286ZM2.33239 8.11428V17.5429H15.6583V8.11428H2.33239ZM2.33239 4.34285V6.22857H15.6583V4.34285H2.33239ZM8.04351 16.0475L4.51499 12.5523L5.86091 11.2191L8.04351 13.3811L12.1298 9.3334L13.4757 10.6666L8.04351 16.0465V16.0475Z"
                  fill="white"
                />
              </svg>
            </i>
            Выберите месяц
          </button>

          <div
            class="dropdown-menu trdropdown"
            aria-labelledby="dropdownMenuButton"
            data-toggle="dropdown"
            @click.prevent.stop="() => {}"
          >
            <div>
              <select
                style="
                  background-color: #20274e;
                  border-color: #20274e;
                  color: white;
                "
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
              <select
                style="
                  background-color: #20274e;
                  border-color: #20274e;
                  color: white;
                "
                class="form-control"
                id="companySelect"
                @change="onChangeYear($event)"
              >
                <option value="">Выберите год</option>
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
                <option value="2015">2015</option>
                <option value="2014">2014</option>
              </select>
            </div>
            <a
              href="#"
              @click.prevent="chooseDt"
              class="but-nav__link but trbutnav"
              >Сформировать</a
            >
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
        <a @click="editable()" v-if="!edit" class="col but-nav__link but" style="margin-right: 11px;"
          ><i style="margin-right: 10px">
            <svg
              width="19"
              height="19"
              viewBox="0 0 19 19"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M1.10481 18.579C0.824148 18.5785 0.55658 18.4602 0.367405 18.253C0.174748 18.0475 0.0790152 17.7695 0.104259 17.489L0.349395 14.795L11.6737 3.481L15.2126 7.017L3.89136 18.33L1.19586 18.575C1.16485 18.578 1.13383 18.579 1.10481 18.579ZM15.919 6.31L12.3811 2.774L14.5032 0.653001C14.691 0.465221 14.9456 0.359711 15.2111 0.359711C15.4767 0.359711 15.7313 0.465221 15.919 0.653001L18.0412 2.774C18.2291 2.96157 18.3347 3.21609 18.3347 3.4815C18.3347 3.74691 18.2291 4.00143 18.0412 4.189L15.92 6.309L15.919 6.31Z"
                fill="white"
              />
            </svg>
          </i>
          Редактировать</a
        >
        <a @click="savetable()" v-if="edit" class="col but-nav__link but"
          >Сохранить</a
        >

        <!-- <a href="http://172.20.103.51:7576/api/techregime/factor/download" download="Тех Режим.xlsx" class="but-nav__link but">Экспорт</a> -->

        <!-- <div class="col trcol">
          <div
            class="input-group input-group-sm"
            style="width: 422px !important"
          >
            <input
              type="text"
              placeholder="Поиск"
              class="form-control fix-rounded-right"
              required
            />
            <div class="input-group-prepend">
              <button class="input-group-text">Поиск</button>
            </div>
          </div>
        </div> -->
        <div class="big-data-input-container">
          <search-form-refresh
            @input="handlerSearch"
            @start-search="searchWell()"
          />
        </div>
      </div>
    </div>

    <div>
      <!-- <input type="text" placeholder="Enter Name" v-model="searchText"> -->
    </div>
    <div class="col-md-12 maintable">
      <div class="maintable-level2" style="position: relative">
        <div class="fadee" v-if="isloading">
          <fade-loader :loading="isloading"></fade-loader>
        </div>
        <div class="techbt1 tr-table-header">
          <div class="tech" style="margin-left: 4px; color: white">
            <h3 style="color: white; width: 475px">
              Технологический режим на {{ dt }}
            </h3>
          </div>
          <select name="Company" class="form-control tr-field-filter" id="companySelect"
              v-model="filter" @change="chooseField">
              <option value="Выберите месторождение">Выберите месторождение</option>
              <option value="Акшабулак Центральный">Акшабулак Центральный</option>
              <option value="Акшабулак Южный">Акшабулак Южный</option>
              <option value="Акшабулак Восточный">Акшабулак Восточный</option>
              <option value="Нуралы">Нуралы</option>
              <option value="Аксай">Аксай</option>
              <option value="Аксай Южный">Аксай Южный</option>
          </select>

          <a
            class="but-nav__link but trgraph"
            title="Показать графики"
            data-toggle="tooltip"
            data-placement="top"
            href="tr_charts"
            @click="pushBign('chart')"
            ><svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M15 5H5C4.44771 5 4 5.44772 4 6V18C4 18.5523 4.44772 19 5 19H17C17.5523 19 18 18.5523 18 18V11.6923M18 5V7M18 7H20M18 7V9M18 7H16M7.5 16V12.7692M11 16V8.46154M14.5 16V11.6923"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>
          </a>

          <button
            id="bt1"
            @click="swap"
            style="
              background: #272953;
              color: white;

              border: none;
            "
            title="Длинная версия"
            data-toggle="tooltip"
            data-placement="top"
          >
            <svg
              width="25"
              height="24"
              viewBox="0 0 25 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              v-if="isfulltable"
            >
              <path
                d="M9.23235 6H6.18359C5.63131 6 5.18359 6.44772 5.18359 7V18C5.18359 18.5523 5.63131 19 6.18359 19H17.342C17.8943 19 18.342 18.5523 18.342 18V15"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
              <path
                d="M18 6L12 12M12 12V7.6M12 12H16.4"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>

            <svg
              width="19"
              style="margin-right: 10px"
              height="19"
              viewBox="0 0 19 19"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              v-if="!isfulltable"
            >
              <path
                d="M9 6H6C5.44772 6 5 6.44772 5 7V18C5 18.5523 5.44772 19 6 19H17C17.5523 19 18 18.5523 18 18V15M11.5 12.5L19 5M19 5V10.5M19 5H13.5"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>
          </button>
        </div>

        <TrTable :wells="wells" @onSort="sortBy" v-if="show_first" />
        <!-- <TrFullTable :wells="wells" :edit="edit" @onSort="sortBy" v-show="show_second"/> -->
        <table
          v-if="show_second"
          class="table table-bordered table-dark table-responsive ce trtable"
          style="
            position: sticky;
            left: 5.31%;
            right: 2.4%;
            top: 48.21%;
            bottom: 66.58%;
            background: #0d1e63;
          "
        >
          <tr class="headerColumn sticky" style="background: #333975">
            <td rowspan="4">Раб. Группа</td>
            <td rowspan="4">НГДУ/месторождение</td>
            <td rowspan="4">№ скв</td>
            <td rowspan="4">Тип скважины</td>
            <td rowspan="4">Горизонт</td>
            <td rowspan="4">Блок</td>
            <td rowspan="4">R контура питания</td>
            <td rowspan="4">Наружный диаметр э/к</td>
            <td rowspan="4">Внутренний диаметр э/к</td>
            <td rowspan="4">Наружный диаметр НКТ</td>
            <td rowspan="4">Внутренний диаметр НКТ</td>
            <td rowspan="4">Диаметр штуцера</td>
            <td rowspan="4">Нвдп</td>
            <td rowspan="4">Удлинение(Нвдп)</td>
            <td rowspan="4">Способ эксплуатации</td>
            <td rowspan="4">Тип Насоса</td>
            <td rowspan="4">Тип СК</td>
            <td rowspan="4">Число качаний</td>
            <td rowspan="4">Длина хода</td>
            <td rowspan="4">Q теор</td>
            <td rowspan="4">Частота работы насоса или число оборотов</td>
            <td rowspan="4">Н сп насоса</td>
            <td rowspan="4">P буф</td>
            <td rowspan="4">P лин</td>
            <td rowspan="4">P пл</td>
            <td rowspan="4">Н дин</td>
            <td rowspan="4">Р затр</td>
            <td rowspan="4">Р на приеме</td>
            <td class="colspan" colspan="5">Данные за предыдущий месяц</td>
            <td class="colspan" colspan="4">Фактический режим</td>
            <td rowspan="4"><span>Состояние на конец месяца</span></td>
            <td rowspan="4">P нас</td>
            <td rowspan="4">ГФ</td>
            <td rowspan="4">Т пл</td>
            <td rowspan="4">Т уст</td>
            <td class="colspan" colspan="4">ГРП</td>
            <td rowspan="4">
              <span>Вязкость нефти в пластовых условиях</span>
            </td>
            <td rowspan="4">
              <span>Вязкость воды в пластовых условиях</span>
            </td>
            <td rowspan="4">Вязкость жидкости</td>
            <td rowspan="4">Объемный коэффициент</td>
            <td rowspan="4">Плотность нефти</td>
            <td rowspan="4">Плотность воды</td>
            <td rowspan="4">Н перф</td>
            <td rowspan="4">k</td>
            <td rowspan="4">КН</td>
            <td rowspan="4">К пр</td>
            <td class="colspan" colspan="14">
              Расчет технологического потенциала от ИДН
            </td>
            <td class="colspan" colspan="11">
              Расчёт геологического потенциала
            </td>
            <td class="colspan" colspan="4">Проверка</td>
            <td rowspan="4">
              <span>Максимальная глубина спуска насоса при ИДН</span>
            </td>
            <td rowspan="4">Дата остановки</td>
            <td rowspan="4">Расчлененность</td>
            <td rowspan="4">Зона</td>
            <td rowspan="4">Цех</td>
            <td rowspan="4"><span>Фонтан через насос</span></td>
            <td rowspan="4">Нерентабельная</td>
            <td rowspan="4">Неустановившийся режим</td>
            <td rowspan="4">Дата ввода в эксплуатацию</td>
            <td rowspan="4">Назначение по проекту</td>
            <td rowspan="4">Р заб замерное</td>
            <td rowspan="4">Нефтенасыщенная толщина</td>
            <td rowspan="4">Накопленная добыча нефти</td>
            <td rowspan="4">
              <span>Максимальный дебит жидкости за всю историю работы</span>
            </td>
            <td rowspan="4">Расстояние до нагн скважины</td>
            <td rowspan="4">Расстояние до ВНК</td>
            <td rowspan="4">Текущий забой по скважине, м</td>
            <td rowspan="4">Кподачи насоса</td>
            <td rowspan="4">Тип ГЗУ</td>
            <td rowspan="4">Рпл начальное</td>
            <td rowspan="4">
              <span>Qr характеристический дебит жидкости</span>
            </td>
            <td class="colspan" colspan="2">АПВ</td>
            <td class="colspan" colspan="3">Планируемые мероприятия</td>
            <td rowspan="4"><span>Мероприятия</span></td>
            <td rowspan="4">
              <span>Сведения о тех.состоянии экс.колонны</span>
            </td>
            <td rowspan="4"><span>Комментарии</span></td>
            <td rowspan="4"><span>Дата последнего ГТМ</span></td>
            <td rowspan="4"><span>Вид последнего ГТМ</span></td>
            <td class="colspan" colspan="12">Намечаемый режим</td>
          </tr>
          <tr class="headerColumn" style="background: #333975">
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
            <td rowspan="3"><span>Общий прирост Q н</span></td>
            <td rowspan="3"><span>Р заб</span></td>
            <td class="colspan" colspan="4">ИДН</td>
            <td class="colspan" colspan="4">ГРП</td>
            <td rowspan="3"><span>% прироста Q н</span></td>
            <td rowspan="3"><span>Общий прирост Q н</span></td>
            <td class="colspan" colspan="2">Ошибки</td>
            <td class="colspan" colspan="2">Предупреждения</td>
            <td rowspan="3"><span>Траб</span></td>
            <td rowspan="3"><span>Тнак</span></td>
            <td class="colspan" colspan="3">Изоляционные работы</td>
            <td rowspan="3"><span>Диаметр штуцера</span></td>
            <td rowspan="3"><span>Qн</span></td>
            <td rowspan="3"><span>Qж</span></td>
            <td rowspan="3"><span>Обводненность</span></td>
            <td rowspan="3"><span>Число дней работы</span></td>
            <td rowspan="3"><span>Добыча нефти за месяц</span></td>
            <td rowspan="3"><span>Добыча газа за месяц</span></td>
            <td rowspan="3"><span>Добыча жидкость за месяц</span></td>
            <td rowspan="3"><span>Добыча воды за месяц</span></td>
            <td class="colspan" colspan="2"><span>Изменения к режиму</span></td>
            <td rowspan="3">
              <span>Мероприятия по обеспечению техрежима</span>
            </td>
          </tr>
          <tr class="headerColumn" style="background: #333975">
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>
            <td rowspan="2"><span>Число ошибок</span></td>
            <td rowspan="2"><span>Первая ошибка</span></td>
            <td rowspan="2"><span>Число предупреждений</span></td>
            <td rowspan="2"><span>Первое предупреждение</span></td>
            <td rowspan="2"><span>Проводить</span></td>
            <td rowspan="2"><span>Дебит жидкости</span></td>
            <td rowspan="2"><span>Обводненность</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Q ж</span></td>
          </tr>
          <tr></tr>
          <tr class="subHeaderColumn" style="background: #333975">
            <td @click="sortBy('gu')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('field')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('well')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('well_type')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('horizon')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('block')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('r_con')"><i class="fa fa-fw fa-sort"></i>м</td>
            <td @click="sortBy('cas_OD')">
              <i class="fa fa-fw fa-sort"></i>мм
            </td>
            <td @click="sortBy('cas_ID')">
              <i class="fa fa-fw fa-sort"></i>мм
            </td>
            <td @click="sortBy('tub_OD')">
              <i class="fa fa-fw fa-sort"></i>мм
            </td>
            <td @click="sortBy('tub_ID')">
              <i class="fa fa-fw fa-sort"></i>мм
            </td>
            <td @click="sortBy('choke_d')">
              <i class="fa fa-fw fa-sort"></i>мм
            </td>
            <td @click="sortBy('h_up_perf_md')">
              <i class="fa fa-fw fa-sort"></i>м
            </td>
            <td @click="sortBy('h_up_perf_ext')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('exp_meth')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('pump_type')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('type_sr')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('spm')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('stroke_len')">
              <i class="fa fa-fw fa-sort"></i>м
            </td>
            <td @click="sortBy('q_theor')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('freq')">
              <i class="fa fa-fw fa-sort"></i>Гц, об/мин
            </td>
            <td @click="sortBy('h_pump_set')">
              <i class="fa fa-fw fa-sort"></i>м
            </td>
            <td @click="sortBy('whp')"><i class="fa fa-fw fa-sort"></i>атм</td>
            <td @click="sortBy('line_p')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('p_res')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('h_dyn')"><i class="fa fa-fw fa-sort"></i>м</td>
            <td @click="sortBy('p_annular')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('p_intake')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('bhp_prev_m')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('q_l_prev_m')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('wct_prev_m')">
              <i class="fa fa-fw fa-sort"></i>%
            </td>
            <td @click="sortBy('h_dyn_prev_m')">
              <i class="fa fa-fw fa-sort"></i>м
            </td>
            <td @click="sortBy('pi_prev_m')">
              <i class="fa fa-fw fa-sort"></i>м3/сут/атм
            </td>
            <td @click="sortBy('bhp')"><i class="fa fa-fw fa-sort"></i>атм</td>
            <td @click="sortBy('q_o')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('q_l')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('wct')"><i class="fa fa-fw fa-sort"></i>%</td>
            <td @click="sortBy('well_status_last_day')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('P_bubble_point')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('gor')"><i class="fa fa-fw fa-sort"></i>м3/т</td>
            <td @click="sortBy('t_res')"><i class="fa fa-fw fa-sort"></i>ºC</td>
            <td @click="sortBy('wht')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('grp_skin')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('grp_jd')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('grp_date')">
              <i class="fa fa-fw fa-sort"></i>д/м/г
            </td>
            <td @click="sortBy('grp_contractor')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('visc_oil_rc')">
              <i class="fa fa-fw fa-sort"></i>сПз
            </td>
            <td @click="sortBy('visc_wat_rc')">
              <i class="fa fa-fw fa-sort"></i>сПз
            </td>
            <td @click="sortBy('visc_liq_rc')">
              <i class="fa fa-fw fa-sort"></i>сПз
            </td>
            <td @click="sortBy('bo')"><i class="fa fa-fw fa-sort"></i>м3/м3</td>
            <td @click="sortBy('dens_oil')">
              <i class="fa fa-fw fa-sort"></i>г/см3
            </td>
            <td @click="sortBy('dens_liq')">
              <i class="fa fa-fw fa-sort"></i>г/см3
            </td>
            <td @click="sortBy('h_perf')"><i class="fa fa-fw fa-sort"></i>м</td>
            <td @click="sortBy('k')"><i class="fa fa-fw fa-sort"></i>мД</td>
            <td @click="sortBy('kh')"><i class="fa fa-fw fa-sort"></i>мДм</td>
            <td @click="sortBy('pi')">
              <i class="fa fa-fw fa-sort"></i>м3/сут/атм
            </td>
            <td @click="sortBy('tp_idn_bhp')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('tp_idn_liq')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('tp_idn_liq_cas_d_corr')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('tp_idn_oil')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('tp_idn_oil_inc')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('tp_idn_jd')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('tp_idn_skin')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('tp_idn_pi_after')">
              <i class="fa fa-fw fa-sort"></i>м3/сут/атм
            </td>
            <td @click="sortBy('tp_idn_grp_q_liq')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('tp_idn_grp_q_liq_cas_d_corr')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('tp_idn_grp_q_oil')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('tp_idn_grp_q_oil_inc')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('tp_idn_q_oil_inc_perc')">
              <i class="fa fa-fw fa-sort"></i>%
            </td>
            <td @click="sortBy('gt_total_inc')"><i class="fa fa-fw fa-sort"></i>т/сут</td>
            
            <td @click="sortBy('gp_idn_bhp')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('gp_idn_q_liq')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('gp_idn_q_liq_cas_d_corr')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('gp_idn_q_oil')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('gp_idn_q_oil_inc')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('gp_grp_q_liq')">
              <i class="fa fa-fw fa-sort"></i>%
            </td>
            <td @click="sortBy('gp_grp_q_liq_cas_d_corr')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('gp_grp_q_oil')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('gp_grp_q_oil_inc')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('gp_total_inc_perc')"><i class="fa fa-fw fa-sort"></i>%</td>
            <td @click="sortBy('gp_total_inc')"><i class="fa fa-fw fa-sort"></i>т/сут</td>
            <td @click="sortBy('error_count')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('error_first')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('error_warning')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('error_first_warning')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('idn_pump_depth_max')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('stop_date')">
              <i class="fa fa-fw fa-sort"></i>д/м/г
            </td>
            <td @click="sortBy('layers_count')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('zone')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('tseh')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('semi_free_flow')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('non_profit')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('unsteady_state')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('start_up_date')">
              <i class="fa fa-fw fa-sort"></i>д/м/г
            </td>
            <td @click="sortBy('well_project_purpose')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('bhp_meter')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('oil_net_pay')">
              <i class="fa fa-fw fa-sort"></i>м
            </td>
            <td @click="sortBy('oil_cumulative')">
              <i class="fa fa-fw fa-sort"></i>тыс.т
            </td>
            <td @click="sortBy('max_q_liq_hist')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('dist_to_inj_well')">
              <i class="fa fa-fw fa-sort"></i>м
            </td>
            <td @click="sortBy('dist_to_woc')">
              <i class="fa fa-fw fa-sort"></i>м
            </td>
            <td @click="sortBy('curr_bh')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('pump_fillage')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('gzu_type')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('p_res_init')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('q_liq_charac')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('APV_t_rab')">
              <i class="fa fa-fw fa-sort"></i>час
            </td>
            <td @click="sortBy('APV_t_nak')">
              <i class="fa fa-fw fa-sort"></i>час
            </td>
            <td @click="sortBy('plan_izo_work')">
              <i class="fa fa-fw fa-sort"></i>атм
            </td>
            <td @click="sortBy('plan_act_q_l')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('plan_act_wct')">
              <i class="fa fa-fw fa-sort"></i>%
            </td>
            <td @click="sortBy('plan_activities')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('plan_casing_info')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('plan_comment')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
            <td @click="sortBy('EMPTY')"><i class="fa fa-fw fa-sort"></i></td>
            <td @click="sortBy('EMPTY')"><i class="fa fa-fw fa-sort"></i></td>

            <td @click="sortBy('planned_choke')">
              <i class="fa fa-fw fa-sort"></i>мм
            </td>
            <td @click="sortBy('planned_oil')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('planned_liq')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('planned_wct')">
              <i class="fa fa-fw fa-sort"></i>%
            </td>
            <td @click="sortBy('planned_month_days')">
              <i class="fa fa-fw fa-sort"></i>сут
            </td>
            <td @click="sortBy('planned_monthly_oil')">
              <i class="fa fa-fw fa-sort"></i>тонн
            </td>
            <td @click="sortBy('planned_monthly_gas')">
              <i class="fa fa-fw fa-sort"></i>тыс.м3
            </td>
            <td @click="sortBy('planned_monthly_liq')">
              <i class="fa fa-fw fa-sort"></i>м3
            </td>
            <td @click="sortBy('planned_monthly_water')">
              <i class="fa fa-fw fa-sort"></i>м3
            </td>
            <td @click="sortBy('planned_diff_oil')">
              <i class="fa fa-fw fa-sort"></i>т/сут
            </td>
            <td @click="sortBy('planned_diff_liq')">
              <i class="fa fa-fw fa-sort"></i>м3/сут
            </td>
            <td @click="sortBy('planned_events')">
              <i class="fa fa-fw fa-sort"></i>
            </td>
          </tr>
          <tr v-for="(row, row_index) in wells" :key="row_index">
            <td v-if="!edit">{{ row_index + 1 }}</td>
            <td v-if="edit">{{ row_index + 1 }}</td>

            <td v-if="!edit">{{ row.field }}</td>
            <td v-if="edit">{{ row.field }}</td>

            <td v-if="!edit">{{ row.well }}</td>
            <td v-if="edit">{{ row.well }}</td>
            <!-- <td>{{row.well_type}}</td> -->

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].well_type[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].well_type[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].well_type[1][0]
                )}`"
              >
              </span>
              <span>{{ row.well_type[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].well_type[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].well_type[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].well_type[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].well_type[1][0]
                )}`"
              >
              </span>
              <!-- <input
                  @change="editrow(row, row_index)"
                  v-model="row.well_type[0]"
                  :disabled="!edit"
                /> -->
              <span>{{ row.well_type[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].well_type[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.horizon}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].horizon[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].horizon[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].horizon[1][0]
                )}`"
              >
              </span>
              <span>{{ row.horizon[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].horizon[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].horizon[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].horizon[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].horizon[1][0]
                )}`"
              >
              </span>
              <!-- <input
                  @change="editrow(row, row_index)"
                  v-model="row.horizon[0]"
                  :disabled="!edit"
                /> -->
              <span>{{ row.horizon[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].horizon[1][1] }}
              </span>
            </td>

            <!-- <td v-if="!edit">{{row.block}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.block" :disabled="!edit"></td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].block[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].block[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].block[1][0])}`"
              >
              </span>
              <span>{{ row.block[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].block[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].block[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].block[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].block[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.block[0]" :disabled="!edit"> -->
              <span>{{ row.block[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].block[1][1] }}
              </span>
            </td>

            <!-- <td v-if="!edit">{{ Math.round(row.r_con * 10) / 10 }}</td>
            <td v-if="edit" contenteditable="true">
              <input
                @change="editrow(row, row_index)"
                v-model="row.r_con"
                :disabled="!edit"
              />
            </td> -->
            <td v-if="!edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].r_con[1][0])}`"> </span>
                            <span>{{Math.round(row.r_con[0]*10)/10}}</span>
                            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].r_con[1][1]}}
                            </span>
                        </td>
                        <td v-if="edit" :class="{'cell-with-comment': wells && wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0'}">
                            <span :class="{'circle-err': wells && wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0'}" :style="`background :${getColor(
                        wells[row_index].r_con[1][0])}`"> </span>
            <input @change="editrow(row, row_index)" v-model="row.r_con[0]" :disabled="!edit">
            <!-- <span>{{Math.round(row.r_con[0]*10)/10}}</span> -->
            <span v-if="wells && wells[row_index]" class="cell-comment">
                                {{ wells[row_index].r_con[1][1]}}
                            </span>
                        </td>

            <!-- <td>{{Math.round(row.cas_OD*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].cas_OD[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].cas_OD[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].cas_OD[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.cas_OD[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].cas_OD[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].cas_OD[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].cas_OD[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].cas_OD[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.cas_OD[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.cas_OD[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].cas_OD[1][1] }}
              </span>
            </td>

            <td v-if="!edit">{{ Math.round(row.cas_ID * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.cas_ID * 10) / 10 }}</td>

            <!-- <td>{{Math.round(row.tub_OD*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tub_OD[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tub_OD[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tub_OD[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tub_OD[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tub_OD[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tub_OD[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tub_OD[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tub_OD[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tub_OD[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tub_OD[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tub_OD[1][1] }}
              </span>
            </td>

            <td v-if="!edit">{{ Math.round(row.tub_ID * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.tub_ID * 10) / 10 }}</td>

            <!-- <td>{{Math.round(row.choke_d*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].choke_d[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].choke_d[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].choke_d[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.choke_d[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].choke_d[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].choke_d[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].choke_d[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].choke_d[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.choke_d[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.choke_d[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].choke_d[1][1] }}
              </span>
            </td>

            <td v-if="!edit">
              {{ Math.round(row.h_up_perf_md[0] * 10) / 10 }}
            </td>
            <td v-if="edit">{{ Math.round(row.h_up_perf_md * 10) / 10 }}</td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_up_perf_ext[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_up_perf_ext[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].h_up_perf_ext[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.h_up_perf_ext[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_up_perf_ext[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_up_perf_ext[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_up_perf_ext[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].h_up_perf_ext[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.h_up_perf_ext[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.h_up_perf_ext[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_up_perf_ext[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.exp_meth}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].exp_meth[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].exp_meth[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].exp_meth[1][0]
                )}`"
              >
              </span>
              <span>{{ row.exp_meth[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].exp_meth[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].exp_meth[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].exp_meth[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].exp_meth[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.exp_meth[0]" :disabled="!edit"> -->
              <span>{{ row.exp_meth[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].exp_meth[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.pump_type}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pump_type[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].pump_type[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].pump_type[1][0]
                )}`"
              >
              </span>
              <span>{{ row.pump_type[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].pump_type[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pump_type[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].pump_type[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].pump_type[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.pump_type[0]" :disabled="!edit"> -->
              <span>{{ row.pump_type[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].pump_type[1][1] }}
              </span>
            </td>


            <td v-if="!edit">{{ row.type_sr}}</td>
            <td v-if="edit">{{ row.type_sr}}</td>

            <!-- <td>{{Math.round(row.spm*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].spm[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].spm[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].spm[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.spm[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].spm[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].spm[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].spm[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].spm[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.spm[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.spm[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].spm[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.stroke_len*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].stroke_len[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].stroke_len[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].stroke_len[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.stroke_len[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].stroke_len[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].stroke_len[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].stroke_len[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].stroke_len[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.stroke_len[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.stroke_len[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].stroke_len[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.q_theor*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_theor[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].q_theor[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].q_theor[1][0]
                )}`"
              >
              </span>
              <span v-if="Math.round(row.q_theor[0] * 10) / 10 != '0'">{{
                Math.round(row.q_theor[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].q_theor[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_theor[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].q_theor[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].q_theor[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.q_theor[0]" :disabled="!edit"> -->
              <span v-if="Math.round(row.q_theor[0] * 10) / 10 != '0'">{{
                Math.round(row.q_theor[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].q_theor[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.freq*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].freq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].freq[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].freq[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.freq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].freq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              contenteditable="true"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].freq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].freq[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].freq[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.freq[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.freq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].freq[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.h_pump_set*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_pump_set[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_pump_set[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].h_pump_set[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.h_pump_set[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_pump_set[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_pump_set[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_pump_set[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].h_pump_set[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.h_pump_set[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.h_pump_set[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_pump_set[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.whp*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].whp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].whp[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].whp[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.whp[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].whp[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].whp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].whp[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].whp[1][0])}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.whp[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.whp[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].whp[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.line_p*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].line_p[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].line_p[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].line_p[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.line_p[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].line_p[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].line_p[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].line_p[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].line_p[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.line_p[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.line_p[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].line_p[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_res[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].p_res[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].p_res[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.p_res[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].p_res[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_res[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].p_res[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].p_res[1][0])}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.p_res[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.p_res[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].p_res[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.h_dyn*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_dyn[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_dyn[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].h_dyn[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.h_dyn[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_dyn[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_dyn[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_dyn[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].h_dyn[1][0])}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.h_dyn[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.h_dyn[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_dyn[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.p_annular*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_annular[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].p_annular[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].p_annular[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.p_annular[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].p_annular[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_annular[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].p_annular[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].p_annular[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.p_annular[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.p_annular[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].p_annular[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.p_intake*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_intake[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].p_intake[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].p_intake[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.p_intake[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].p_intake[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_intake[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].p_intake[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].p_intake[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.p_intake[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.p_intake[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].p_intake[1][1] }}
              </span>
            </td>

            <td v-if="!edit">{{ Math.round(row.bhp_prev_m * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.bhp_prev_m * 10) / 10 }}</td>

            <td v-if="!edit">{{ Math.round(row.q_l_prev_m * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.q_l_prev_m * 10) / 10 }}</td>

            <td v-if="!edit">{{ Math.round(row.wct_prev_m * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.wct_prev_m * 10) / 10 }}</td>

            <td v-if="!edit">{{ Math.round(row.h_dyn_prev_m * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.h_dyn_prev_m * 10) / 10 }}</td>

            <td v-if="!edit">{{ Math.round(row.pi_prev_m * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.pi_prev_m * 10) / 10 }}</td>

            <!-- <td>{{Math.round(row.bhp*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bhp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].bhp[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].bhp[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.bhp[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].bhp[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bhp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].bhp[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].bhp[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.bhp[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.bhp[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].bhp[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.q_o*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_o[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].q_o[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].q_o[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.q_o[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].q_o[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_o[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].q_o[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].q_o[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.q_o[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.q_o[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].q_o[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.q_l*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_l[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].q_l[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].q_l[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.q_l[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].q_l[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_l[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].q_l[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].q_l[1][0])}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.q_l[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.q_l[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].q_l[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].wct[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].wct[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].wct[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.wct[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].wct[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].wct[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].wct[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].wct[1][0])}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.wct[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.wct[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].wct[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.well_status_last_day}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].well_status_last_day[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].well_status_last_day[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].well_status_last_day[1][0]
                )}`"
              >
              </span>
              <span>{{ row.well_status_last_day[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].well_status_last_day[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].well_status_last_day[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].well_status_last_day[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].well_status_last_day[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.well_status_last_day[0]" :disabled="!edit"> -->
              <span>{{ row.well_status_last_day[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].well_status_last_day[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.P_bubble_point*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].P_bubble_point[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].P_bubble_point[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].P_bubble_point[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.P_bubble_point[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].P_bubble_point[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].P_bubble_point[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].P_bubble_point[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].P_bubble_point[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.P_bubble_point[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.P_bubble_point[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].P_bubble_point[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gor*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gor[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gor[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].gor[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.gor[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gor[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gor[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gor[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].gor[1][0])}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.gor[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.gor[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gor[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.t_res*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].t_res[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].t_res[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].t_res[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.t_res[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].t_res[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].t_res[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].t_res[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].t_res[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.t_res[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.t_res[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].t_res[1][1] }}
              </span>
            </td>

            <td v-if="!edit">{{ Math.round(row.wht * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.wht * 10) / 10 }}</td>

            <td v-if="!edit">{{ Math.round(row.grp_skin[0] * 10) / 10 }}</td>
            <td v-if="edit" contenteditable="true">
              <input
                @change="editrow(row, row_index)"
                v-model="row.grp_skin"
                :disabled="!edit"
              />
            </td>

            <td v-if="!edit">{{ Math.round(row.grp_jd * 100) / 100 }}</td>
            <td v-if="edit">{{ Math.round(row.grp_jd * 10) / 10 }}</td>

            <!-- <td>{{row.grp_date}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].grp_date[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].grp_date[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].grp_date[1][0]
                )}`"
              >
              </span>
              <span>{{ row.grp_date[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].grp_date[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].grp_date[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].grp_date[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].grp_date[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.grp_date[0]" :disabled="!edit"> -->
              <span>{{ row.grp_date[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].grp_date[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.grp_contractor}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].grp_contractor[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].grp_contractor[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].grp_contractor[1][0]
                )}`"
              >
              </span>
              <span>{{ row.grp_contractor[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].grp_contractor[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].grp_contractor[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].grp_contractor[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].grp_contractor[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.grp_contractor[0]" :disabled="!edit"> -->
              <span>{{ row.grp_contractor[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].grp_contractor[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.visc_oil_rc*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].visc_oil_rc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].visc_oil_rc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].visc_oil_rc[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.visc_oil_rc[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].visc_oil_rc[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].visc_oil_rc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].visc_oil_rc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].visc_oil_rc[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.visc_oil_rc[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.visc_oil_rc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].visc_oil_rc[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.visc_wat_rc*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].visc_wat_rc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].visc_wat_rc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].visc_wat_rc[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.visc_wat_rc[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].visc_wat_rc[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].visc_wat_rc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].visc_wat_rc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].visc_wat_rc[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.visc_wat_rc[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.visc_wat_rc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].visc_wat_rc[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.visc_liq_rc*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].visc_liq_rc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].visc_liq_rc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].visc_liq_rc[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.visc_liq_rc[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].visc_liq_rc[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].visc_liq_rc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].visc_liq_rc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].visc_liq_rc[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.visc_liq_rc[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.visc_liq_rc[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].visc_liq_rc[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.bo*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bo[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].bo[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].bo[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.bo[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].bo[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bo[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].bo[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].bo[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.bo[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.bo[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].bo[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.dens_oil*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].dens_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].dens_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].dens_oil[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.dens_oil[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].dens_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].dens_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].dens_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].dens_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.dens_oil[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.dens_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].dens_oil[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.dens_liq*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].dens_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].dens_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].dens_liq[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.dens_liq[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].dens_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].dens_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].dens_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].dens_liq[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.dens_liq[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.dens_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].dens_liq[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.h_perf*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_perf[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_perf[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].h_perf[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.h_perf[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_perf[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].h_perf[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].h_perf[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].h_perf[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.h_perf[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.h_perf[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].h_perf[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.k*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells && wells[row_index] && wells[row_index].k[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].k[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].k[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.k[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].k[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells && wells[row_index] && wells[row_index].k[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].k[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].k[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.k[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.k[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].k[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.kh*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].kh[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].kh[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].kh[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.kh[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].kh[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].kh[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].kh[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].kh[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.kh[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.kh[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].kh[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.pi*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pi[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].pi[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].pi[1][0])}`"
              >
              </span>
              <span>{{ Math.round(row.pi[0] * 100) / 100 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].pi[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pi[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].pi[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].pi[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.pi[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.pi[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].pi[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_bhp*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_bhp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_bhp[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_bhp[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_bhp[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_bhp[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_bhp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_bhp[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_bhp[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_bhp[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_bhp[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_bhp[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_liq*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_liq[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_liq[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_liq[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_liq[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_liq_cas_d_corr*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.tp_idn_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_liq_cas_d_corr[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_liq_cas_d_corr[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.tp_idn_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_liq_cas_d_corr[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_oil*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_oil[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_oil[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_oil[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_oil_inc*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_oil_inc[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_oil_inc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_oil_inc[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_oil_inc[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_oil_inc[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_oil_inc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_oil_inc[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_jd*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_jd[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_jd[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_jd[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_jd[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_jd[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_jd[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_jd[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_jd[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_jd[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_jd[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_jd[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_skin*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_skin[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_skin[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_skin[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_skin[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_skin[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_skin[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_skin[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_skin[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_skin[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_skin[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_skin[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_pi_after*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_pi_after[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_pi_after[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_pi_after[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_pi_after[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_pi_after[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_pi_after[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_pi_after[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_pi_after[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_pi_after[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_pi_after[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_pi_after[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_liq*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_liq[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_grp_q_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_liq[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_liq[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_grp_q_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_liq[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_liq_cas_d_corr*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.tp_idn_grp_q_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.tp_idn_grp_q_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_oil*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_oil[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.tp_idn_grp_q_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_oil[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.tp_idn_grp_q_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_oil[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_oil_inc*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_oil_inc[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.tp_idn_grp_q_oil_inc[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].tp_idn_grp_q_oil_inc[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tp_idn_grp_q_oil_inc[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.tp_idn_grp_q_oil_inc[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1] }}
              </span>
            </td>

            <td v-if="!edit">
              {{ Math.round(row.tp_idn_q_oil_inc_perc * 10) / 10 }}
            </td>
            <td v-if="edit">
              {{ Math.round(row.tp_idn_q_oil_inc_perc * 10) / 10 }}
            </td>

            <td v-if="!edit">{{Math.round(row.gt_total_inc*10)/10}}</td>
            <td v-if="edit">{{Math.round(row.gt_total_inc*10)/10}}</td>

            <!-- <td>{{Math.round(row.gp_idn_bhp*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_bhp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_bhp[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_bhp[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.gp_idn_bhp[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_bhp[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_bhp[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_bhp[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_bhp[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_bhp[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.gp_idn_bhp[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_bhp[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_liq*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_liq[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.gp_idn_q_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_liq[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_liq[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.gp_idn_q_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_liq[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_liq_cas_d_corr*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.gp_idn_q_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_liq_cas_d_corr[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.gp_idn_q_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_liq_cas_d_corr[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_oil*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_oil[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.gp_idn_q_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_oil[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.gp_idn_q_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_oil[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_idn_q_oil_inc*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_oil_inc[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.gp_idn_q_oil_inc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_oil_inc[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_idn_q_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_idn_q_oil_inc[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_idn_q_oil_inc[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.gp_idn_q_oil_inc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_idn_q_oil_inc[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_liq*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_liq[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.gp_grp_q_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_liq[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_liq[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.gp_grp_q_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_liq[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_liq_cas_d_corr*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.gp_grp_q_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_liq_cas_d_corr[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_liq_cas_d_corr[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_liq_cas_d_corr[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.gp_grp_q_liq_cas_d_corr[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_liq_cas_d_corr[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_oil*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_oil[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.gp_grp_q_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_oil[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.gp_grp_q_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_oil[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.gp_grp_q_oil_inc*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_oil_inc[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.gp_grp_q_oil_inc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_oil_inc[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].gp_grp_q_oil_inc[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].gp_grp_q_oil_inc[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.gp_grp_q_oil_inc[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.gp_grp_q_oil_inc[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].gp_grp_q_oil_inc[1][1] }}
              </span>
            </td>


            <td v-if="!edit">{{Math.round(row.gp_total_inc_perc*10)/10}}</td>
            <td v-if="edit">{{Math.round(row.gp_total_inc_perc*10)/10}}</td>

            <td v-if="!edit">{{Math.round(row.gp_total_inc*10)/10}}</td>
            <td v-if="edit">{{Math.round(row.gp_total_inc*10)/10}}</td>


            <td v-if="!edit">{{ row.error_count }}</td>
            <td v-if="edit">{{ row.error_count }}</td>

            <td v-if="!edit">{{ row.error_first }}</td>
            <td v-if="edit">{{ row.error_first }}</td>

            <td v-if="!edit">{{ row.error_warning }}</td>
            <td v-if="edit">{{ row.error_warning }}</td>

            <td v-if="!edit">{{ row.error_first_warning }}</td>
            <td v-if="edit">{{ row.error_first_warning }}</td>

            <!-- <td>{{Math.round(row.idn_pump_depth_max*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].idn_pump_depth_max[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].idn_pump_depth_max[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].idn_pump_depth_max[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.idn_pump_depth_max[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].idn_pump_depth_max[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].idn_pump_depth_max[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].idn_pump_depth_max[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].idn_pump_depth_max[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.idn_pump_depth_max[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.idn_pump_depth_max[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].idn_pump_depth_max[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.stop_date}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].stop_date[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].stop_date[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].stop_date[1][0]
                )}`"
              >
              </span>
              <span>{{ row.stop_date[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].stop_date[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].stop_date[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].stop_date[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].stop_date[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.stop_date[0]" :disabled="!edit"> -->
              <span>{{ row.stop_date[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].stop_date[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.layers_count}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].layers_count[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].layers_count[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].layers_count[1][0]
                )}`"
              >
              </span>
              <span>{{ row.layers_count[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].layers_count[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].layers_count[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].layers_count[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].layers_count[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.layers_count[0]" :disabled="!edit"> -->
              <span>{{ row.layers_count[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].layers_count[1][1] }}
              </span>
            </td>

            <!-- <td v-if="!edit">{{row.zone}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.zone" :disabled="!edit"></td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].zone[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].zone[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].zone[1][0])}`"
              >
              </span>
              <span>{{ row.zone[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].zone[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].zone[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].zone[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].zone[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.zone[0]" :disabled="!edit"> -->
              <span>{{ row.zone[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].zone[1][1] }}
              </span>
            </td>

            <!-- <td v-if="!edit">{{row.tseh}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.tseh" :disabled="!edit"></td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tseh[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tseh[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].tseh[1][0])}`"
              >
              </span>
              <span>{{ row.tseh[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tseh[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].tseh[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].tseh[1][0] !== '0',
                }"
                :style="`background :${getColor(wells[row_index].tseh[1][0])}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.tseh[0]" :disabled="!edit"> -->
              <span>{{ row.tseh[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].tseh[1][1] }}
              </span>
            </td>

            <td v-if="!edit">{{ row.semi_free_flow[0] }}</td>
            <td v-if="edit">{{ row.semi_free_flow[0] }}</td>

            <!-- <td>{{row.non_profit[0]}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].non_profit[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].non_profit[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].non_profit[1][0]
                )}`"
              >
              </span>
              <span>{{ row.non_profit[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].non_profit[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].non_profit[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].non_profit[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].non_profit[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.non_profit[0]" :disabled="!edit"> -->
              <span>{{ row.non_profit[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].non_profit[1][1] }}
              </span>
            </td>

            <!-- <td v-if="!edit">{{row.unsteady_state}}</td>
                        <td v-if="edit" contenteditable='true'><input @change="editrow(row, row_index)" v-model="row.unsteady_state" :disabled="!edit"></td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].unsteady_state[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].unsteady_state[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].unsteady_state[1][0]
                )}`"
              >
              </span>
              <span>{{ row.unsteady_state[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].unsteady_state[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].unsteady_state[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].unsteady_state[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].unsteady_state[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.unsteady_state[0]" :disabled="!edit"> -->
              <span>{{ row.unsteady_state[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].unsteady_state[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.start_up_date}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].start_up_date[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].start_up_date[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].start_up_date[1][0]
                )}`"
              >
              </span>
              <span>{{ row.start_up_date[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].start_up_date[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].start_up_date[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].start_up_date[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].start_up_date[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.start_up_date[0]" :disabled="!edit"> -->
              <span>{{ row.start_up_date[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].start_up_date[1][1] }}
              </span>
            </td>

            <!-- <td>{{row.well_project_purpose}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].well_project_purpose[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].well_project_purpose[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].well_project_purpose[1][0]
                )}`"
              >
              </span>
              <span>{{ row.well_project_purpose[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].well_project_purpose[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].well_project_purpose[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].well_project_purpose[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].well_project_purpose[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.well_project_purpose[0]" :disabled="!edit"> -->
              <span>{{ row.well_project_purpose[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].well_project_purpose[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.bhp_meter*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bhp_meter[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].bhp_meter[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].bhp_meter[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.bhp_meter[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].bhp_meter[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bhp_meter[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].bhp_meter[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].bhp_meter[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.bhp_meter[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.bhp_meter[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].bhp_meter[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.oil_net_pay*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].oil_net_pay[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].oil_net_pay[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].oil_net_pay[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.oil_net_pay[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].oil_net_pay[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].oil_net_pay[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].oil_net_pay[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].oil_net_pay[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.oil_net_pay[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.oil_net_pay[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].oil_net_pay[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.oil_cumulative*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].oil_cumulative[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].oil_cumulative[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].oil_cumulative[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.oil_cumulative[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].oil_cumulative[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].oil_cumulative[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].oil_cumulative[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].oil_cumulative[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.oil_cumulative[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.oil_cumulative[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].oil_cumulative[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.max_q_liq_hist*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].max_q_liq_hist[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].max_q_liq_hist[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].max_q_liq_hist[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.max_q_liq_hist[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].max_q_liq_hist[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].max_q_liq_hist[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].max_q_liq_hist[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].max_q_liq_hist[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.max_q_liq_hist[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.max_q_liq_hist[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].max_q_liq_hist[1][1] }}
              </span>
            </td>

            <td v-if="!edit">
              {{ Math.round(row.dist_to_inj_well * 10) / 10 }}
            </td>
            <td v-if="edit">
              {{ Math.round(row.dist_to_inj_well * 10) / 10 }}
            </td>

            <td v-if="!edit">{{ Math.round(row.dist_to_woc * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.dist_to_woc * 10) / 10 }}</td>

            <!-- <td>{{Math.round(row.curr_bh*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].curr_bh[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].curr_bh[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].curr_bh[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.curr_bh[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].curr_bh[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].curr_bh[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].curr_bh[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].curr_bh[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.curr_bh[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.curr_bh[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].curr_bh[1][1] }}
              </span>
            </td>

            <!-- <td>{{Math.round(row.pump_fillage*10)/10}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pump_fillage[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].pump_fillage[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].pump_fillage[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.pump_fillage[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].pump_fillage[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pump_fillage[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].pump_fillage[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].pump_fillage[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.pump_fillage[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.pump_fillage[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].pump_fillage[1][1] }}
              </span>
            </td>

            <td v-if="!edit">{{ row.gzu_type }}</td>
            <td v-if="edit">{{ row.gzu_type }}</td>

            <td v-if="!edit">{{ Math.round(row.p_res_init * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.p_res_init * 10) / 10 }}</td>

            <td v-if="!edit">{{ Math.round(row.q_liq_charac * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.q_liq_charac * 10) / 10 }}</td>

            <!-- <td v-if="!edit">{{row.APV_t_rab}}</td>
                        <td v-if="edit">{{row.APV_t_rab}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].APV_t_rab[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].APV_t_rab[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].APV_t_rab[1][0]
                )}`"
              >
              </span>
              <span>{{ row.APV_t_rab[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].APV_t_rab[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].APV_t_rab[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].APV_t_rab[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].APV_t_rab[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.APV_t_rab[0]" :disabled="!edit"> -->
              <span>{{ row.APV_t_rab[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].APV_t_rab[1][1] }}
              </span>
            </td>

            <!-- <td v-if="!edit">{{row.APV_t_nak}}</td>
                        <td v-if="edit">{{row.APV_t_nak}}</td> -->
            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].APV_t_nak[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].APV_t_nak[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].APV_t_nak[1][0]
                )}`"
              >
              </span>
              <span>{{ row.APV_t_nak[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].APV_t_nak[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].APV_t_nak[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].APV_t_nak[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].APV_t_nak[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.APV_t_nak[0]" :disabled="!edit"> -->
              <span>{{ row.APV_t_nak[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].APV_t_nak[1][1] }}
              </span>
            </td>

            <td v-if="!edit">{{ row.plan_izo_work }}</td>
            <td v-if="edit">{{ row.plan_izo_work }}</td>

            <td v-if="!edit">{{ Math.round(row.plan_act_q_l * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.plan_act_q_l * 10) / 10 }}</td>

            <td v-if="!edit">{{ Math.round(row.plan_act_wct * 10) / 10 }}</td>
            <td v-if="edit">{{ Math.round(row.plan_act_wct * 10) / 10 }}</td>

            <td v-if="!edit">{{ row.plan_activities }}</td>
            <td v-if="edit">{{ row.plan_activities }}</td>

            <td v-if="!edit">{{ row.plan_casing_info }}</td>
            <td v-if="edit">{{ row.plan_casing_info }}</td>

            <td v-if="!edit">{{ row.plan_comment }}</td>
            <td v-if="edit">{{ row.plan_comment }}</td>

            <td v-if="!edit">{{ row.EMPTY }}</td>
            <td v-if="edit">{{ row.EMPTY }}</td>

            <td v-if="!edit">{{ row.EMPTY }}</td>
            <td v-if="edit">{{ row.EMPTY }}</td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_choke[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_choke[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_choke[1][0]
                )}`"
              >
              </span>
              <span>{{ row.planned_choke[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_choke[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_choke[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_choke[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_choke[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.planned_choke[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_choke[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_oil[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.planned_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.planned_oil[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.planned_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_oil[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_liq[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.planned_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_liq[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.planned_liq[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_liq[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_wct[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_wct[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_wct[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.planned_wct[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_wct[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_wct[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_wct[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_wct[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.planned_wct[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_wct[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_month_days[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_month_days[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_month_days[1][0]
                )}`"
              >
              </span>
              <span>{{ row.planned_month_days[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_month_days[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_month_days[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_month_days[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_month_days[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.planned_month_days[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_month_days[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_oil[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.planned_monthly_oil[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_oil[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.planned_monthly_oil[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_oil[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_gas[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_gas[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_gas[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.planned_monthly_gas[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_gas[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_gas[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_gas[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_gas[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_gas[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.planned_monthly_gas[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_gas[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_liq[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.planned_monthly_liq[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_liq[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_liq[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.planned_monthly_liq[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_liq[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_water[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_water[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_water[1][0]
                )}`"
              >
              </span>
              <span>{{
                Math.round(row.planned_monthly_water[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_water[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_monthly_water[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_monthly_water[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_monthly_water[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.planned_monthly_water[0]" :disabled="!edit"> -->
              <span>{{
                Math.round(row.planned_monthly_water[0] * 10) / 10
              }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_monthly_water[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_diff_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_diff_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_diff_oil[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.planned_diff_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_diff_oil[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_diff_oil[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_diff_oil[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_diff_oil[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.planned_diff_oil[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.planned_diff_oil[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_diff_oil[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_diff_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_diff_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_diff_liq[1][0]
                )}`"
              >
              </span>
              <span>{{ Math.round(row.planned_diff_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_diff_liq[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_diff_liq[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_diff_liq[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_diff_liq[1][0]
                )}`"
              >
              </span>
              <!-- <input @change="editrow(row, row_index)" v-model="row.planned_diff_liq[0]" :disabled="!edit"> -->
              <span>{{ Math.round(row.planned_diff_liq[0] * 10) / 10 }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_diff_liq[1][1] }}
              </span>
            </td>

            <td
              v-if="!edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_events[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_events[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_events[1][0]
                )}`"
              >
              </span>
              <span>{{ row.planned_events[0] }}</span>
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_events[1][1] }}
              </span>
            </td>
            <td
              v-if="edit"
              :class="{
                'cell-with-comment':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].planned_events[1][0] !== '0',
              }"
            >
              <span
                :class="{
                  'circle-err':
                    wells &&
                    wells[row_index] &&
                    wells[row_index].planned_events[1][0] !== '0',
                }"
                :style="`background :${getColor(
                  wells[row_index].planned_events[1][0]
                )}`"
              >
              </span>
              <input
                @change="editrow(row, row_index)"
                v-model="row.planned_events[0]"
                :disabled="!edit"
              />
              <!-- <span>{{Math.round(row.APV_t_rab[0]*10)/10}}</span> -->
              <span v-if="wells && wells[row_index]" class="cell-comment">
                {{ wells[row_index].planned_events[1][1] }}
              </span>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import TrTable from "./table";
import TrFullTable from "./tablefull";
import SearchFormRefresh from "../ui-kit/SearchFormRefresh.vue";
import FadeLoader from "vue-spinner/src/FadeLoader.vue";

export default {
  name: "TrPage",
  components: {
    TrTable,
    TrFullTable,
    SearchFormRefresh,
    FadeLoader,
  },
  beforeCreate: function () {},
  created() {
    var today = new Date();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    this.$store.commit("tr/SET_MONTH", mm);
    this.$store.commit("tr/SET_YEAR", yyyy);
    this.axios
      .get(
        "http://172.20.103.51:7576/api/techregime/" + yyyy + "/" + mm + "/"
      )
      .then((response) => {
        let data = response.data;
        this.year = yyyy;
        this.selectYear = yyyy;
        this.month = mm;
        this.isloading = false;
        if (data) {
          console.log(data);
          this.wells = data.data;
          this.fullWells = data.data;
        } else {
          console.log("No data");
        }
        if (mm < 10) {
          this.dt = "01" + ".0" + mm + "." + yyyy;
        } else {
          this.dt = "01" + "." + mm + "." + yyyy;
        }
      });
    console.log("isloading", this.isloading);
    //   this.isloading = false;
  },
  data: function () {
    return {
      wells: [],
      searchString: "",
      sortType: "asc",
      filter: "Выберите месторождение",
      dt: null,
      fullWells: [],
      show_first: true,
      show_second: false,
      edit: false,
      editdtm: null,
      editdty: null,
      // sortField: null,
      // currentSortDir: 'asc',
      year: null,
      selectYear: null,
      month: null,
      isloading: true,
      isfulltable: false,
    };
  },
  watch: {
    fullWells() {
      this.chooseField();
    },
  },
  methods: {
    editrow(row, rowId) {
      // console.log(row);
      row["index"] = 0;
      this.axios
        .post(
          "http://172.20.103.51:7576/api/techregime/edit/" +
            this.year +
            "/" +
            this.month +
            "/",
          {
            row: row,
          }
        )
        .then((response) => {
          if (response.data) {
            // console.log('EDIT_RESPONSE', response.data.data[0])
            this.wells = this.wells.map((currentRow, index) => {
              // console.log('norm', index, rowId)
              return index === rowId ? response.data.data[0] : currentRow;
            });
          } else {
            console.log("No data");
          }
        });
    },
    savetable() {
      this.edit = false;
      this.isloading = true;
      this.axios
        .post(
          "http://172.20.103.51:7576/api/techregime/" +
            this.year +
            "/" +
            this.month +
            "/",
          {
            well: this.wells,
          }
        )
        .then((response) => {
          console.log(response.data);
          this.isloading = false;
        })
        .catch((error) => {
          console.log(error.data);
          this.isloading = false;
        });
    },
    editable() {
      this.edit = true;
      this.show_second = true;
      this.show_first = false;
    },
    sortBy(type) {
      let { wells, sortType } = this;
      console.log(type, sortType);
      if (sortType === "asc") {
        this.wells = wells.sort((a, b) => {
          let aVal = a[type];
          let bVal = b[type];
          if (Array.isArray(aVal)) {
            if (typeof aVal[0] === "string") {
              return aVal[0].localeCompare(bVal[0]);
            } else {
              if (Number(aVal[0]) > Number(bVal[0])) return 1;
              else if (Number(aVal[0]) < Number(bVal[0])) return -1;
              else return 0;
            }
          } else {
            if (typeof aVal === "string") {
              return aVal.localeCompare(bVal);
            } else {
              if (Number(aVal) > Number(bVal)) return 1;
              else if (Number(aVal) < Number(bVal)) return -1;
              else return 0;
            }
          }
        });
        this.sortType = "desc";
      } else {
        this.wells = wells.sort((a, b) => {
          let aVal = a[type];
          let bVal = b[type];
          if (Array.isArray(aVal)) {
            if (typeof aVal[0] === "string" && isNaN(Number(aVal[0]))) {
              return bVal[0].localeCompare(aVal[0]);
            } else {
              if (Number(aVal[0]) > Number(bVal[0])) return -1;
              else if (Number(aVal[0]) < Number(bVal[0])) return 1;
              else return 0;
            }
          } else {
            if (typeof aVal === "string" && isNaN(Number(aVal))) {
              return aVal.localeCompare(bVal);
            } else {
              if (Number(aVal) > Number(bVal)) return -1;
              else if (Number(aVal) < Number(bVal)) return 1;
              else return 0;
            }
          }
        });
        this.sortType = "asc";
      }
    },
    onChangeMonth(event) {
      this.month = event.target.value;
      this.$store.commit("tr/SET_MONTH", event.target.value);
    },
    onChangeYear(event) {
      this.selectYear = event.target.value;
      this.year = event.target.value;
      this.$store.commit("tr/SET_YEAR", event.target.value);
    },

    chooseDt() {
      this.axios
        .get(
          "http://172.20.103.51:7576/api/techregime/" +
            this.selectYear +
            "/" +
            this.month +
            "/"
        )
        .then((response) => {
          let data = response.data;
          if (data) {
            console.log(data)
            // this.wells = data.data;
            this.fullWells = data.data;
          } else {
            console.log("No data");
          }
          if (this.month < 10) {
            this.dt = "01" + ".0" + (this.month) + "." + this.selectYear;
          } else {
            this.dt = "01" + "." + (this.month) + "." + this.selectYear;
          }
        });
    },
    chooseField() {
      const { filter, fullWells } = this;
      console.log(filter);
      console.log(fullWells);
      // if (!filter || filter == "Казгермунай") {
      if (!filter || filter == "Выберите месторождение") {
        this.wells = fullWells;
      } else {
        this.wells = fullWells.filter((e) => e.field === filter);
      }
    },
    swap() {
      this.show_first = !this.show_first;
      this.show_second = !this.show_second;
      this.isfulltable = !this.isfulltable;
    },
    getColor(status) {
      if (status === "1") return "#ffff00";
      return "#ff0000";
    },
    handlerSearch(search) {
      this.searchString = search;
    },
    searchWell() {
      const searchParam = this.searchString ? `search/${this.searchString}/` : ''
      this.axios
        .get(
          "http://172.20.103.51:7576/api/techregime/" +
            this.selectYear +
            "/" +
            this.month +
            "/" +
            searchParam
        )
        .then((response) => {
          let data = response.data;
          if (data) {
            console.log(data);
            // this.wells = data.data;
            this.fullWells = data.data;
          } else {
            // this.wells = [];
            this.fullWells = [];
            console.log("No data");
          }
        })
        .catch((error) => {
          // this.wells = [];
          this.fullWells = [];
          console.log("search error = ", error);
        });
    },
  },
};
</script>
<style scoped>
/* @import "element-variables"; */

body {
  color: white !important;
}
.form-control,
.fix-rounded-right {
  background: #272953 !important;
  border: 1px solid #656a8a !important;
  height: 35px !important;
  color: white !important;
}
.input-group-text {
  background: #656a8a !important;
  color: white !important;
  border-radius: 6px !important;
  border: none !important;
  position: absolute !important;
  right: 0 !important;
  z-index: 9999;
  font-size: 14px;
  margin-right: 2px;
}
.input-group-prepend {
  padding-top: 3px !important;
  /* margin-right: 0px!important; */
}
a:hover {
  color: white !important;
  text-decoration: none !important;
}
.maintable {
  padding-top: 35px;
}
.maintable-level2 {
  background: #272953;
}

.trdropdown {
  padding: 3;
  background: transparent;
}

.trbutnav {
  background-color: #20274e;
  border-color: #20274e;
  color: white;
}
.bttr1 {
  background: #272953;
  color: white;
  margin-left: 1000px;
  border: none;
}
.techbt1 {
  display: flex;
}
.trheadercolumn {
  background: #333975;
}
.trsubheadercolumn {
  background: #333975;
}
tr:nth-child(odd) {
  background-color: #454d7d;
}
tr:nth-child(even) {
  background-color: #454d7d73;
}
.table th,
.table td {
  padding: 5px !important;
}
.trtable{
  font-size: 9px;
  padding: unset;
}

.trcolmd12 {
  margin-left: 0px;
}
.fadee {
  flex: 0 1 auto;
  flex-flow: row wrap;
  width: 100%;
  align-items: center;
  position: absolute;
  height: 100%;
  justify-content: center;
  display: flex;
  z-index: 5000;
  background: rgba(59, 46, 247, 0.1);
}
.trtable {
  height: 600;
}
.trcol {
  padding-right: 0;
}

.trgraph {
  margin-top: 4px;
  background: #272953;
}

.sticky {
  position: sticky;
  top: 0;
  min-height: 2em;
  background: lightpink;
}
.table {
    overflow: scroll;
    height: calc(100vh - 247px);
}
.trkrtableborderedtabledarktableresponsive {
    font-size: 9px;
    padding: unset;
}
</style>
<style>
.tr-field-filter.tr-field-filter {
  margin: 0 0 0 auto;
  width: 230px;
}
.tr-table-header {
  justify-content: space-between;
  height: 48px;
  align-items: center;
}

</style>