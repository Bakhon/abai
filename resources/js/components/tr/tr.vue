<template>
  <div class="w-100">
    <div class="col-md-12 row trcolmd12">
      <div
        class="col-md-12 row justify-content-between"
        style="
          box-sizing: border box;
          flex-grow: 1;
          padding-right: 0;
          margin-right: 0;
          margin-left: 0;
          padding-left: 0;
        "
      >
        <a
          href="fa"
          class="col but-nav__link but trheadhight"
          style="min-width: 330px; line-height: 31px"
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
        <div class="col dropdown" style="padding: 0 13px">
          <button
            class="col-md-12 but-nav__link but faheadhight"
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
            class="dropdown-menu fadropmenu"
            style="
              background: #40467e;
              height: 117px;
              flex-direction: column;
              width: calc(100% - 26px);
              margin-top: 4px;
            "
            aria-labelledby="dropdownMenuButton"
            data-toggle="dropdown"
            @click.prevent.stop="() => {}"
          >
            <div>
              <select
                v-model="month"
                style="
                  background-color: #40467e;
                  border-color: #40467e;
                  color: white;
                  width: 100%;
                  padding: 8px;
                "
                class="form-controll"
                id="companySelect"
                @change="onChangeMonth($event)"
              >
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
                v-model="selectYear"
                style="
                  background-color: #40467E ;
                  border-color: #40467E;
                  color: white;
                  width: 100%;
                  padding: 8px;
                  border: none
                  height: 35px !important;
                  color: white !important;
                "
                class="form-controll"
                id="companySelect"
                @change="onChangeYear($event)"
              >
                <option value="2020">2020</option>
                <option value="2019">2019</option>
                <option value="2018">2018</option>
                <option value="2017">2017</option>
                <option value="2016">2016</option>
                <option value="2015">2015</option>
                <option value="2014">2014</option>
              </select>
            </div>
            <a href="#" @click.prevent="chooseDt" class="btn btn-sm button_form"
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
        <!-- <a
          @click="editable()"
          v-if="!edit"
          class="col but-nav__link but trheadhight"
          style="margin-right: 13px; line-height: 31px;"
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
        > -->
        <!-- <a
          @click="savetable()"
          v-if="edit"
          style="margin-right: 15px; line-height: 31px;"
          class="col but-nav__link but trheadhight"
          >Сохранить</a
        > -->

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
            :clear="searched"
          />
        </div>
      </div>
    </div>

    <div>
      <!-- <input type="text" placeholder="Enter Name" v-model="searchText"> -->
    </div>
    <div class="col-md-12 maintable tablecont">
      <div class="maintable-level2" style="position: relative">
        <!-- <div class="fadee" v-if="isloading">
          <fade-loader :loading="isloading"></fade-loader>
        </div> -->
        <div class="techbt1 tr-table-header">
          <div class="tech" style="margin-left: 14px; color: white">
            <h5>Технологический режим на {{ dt }}</h5>
          </div>
          <select
            name="Company"
            class="form-control tr-field-filter"
            id="companySelect"
            v-model="filter"
            @change="chooseField"
          >
            <option value="Все месторождения">Все месторождения</option>
            <option value="Акшабулак Центральный">Акшабулак Центральный</option>
            <option value="Акшабулак Южный">Акшабулак Южный</option>
            <option value="Акшабулак Восточный">Акшабулак Восточный</option>
            <option value="Нуралы">Нуралы</option>
            <option value="Аксай">Аксай</option>
            <option value="Аксай Южный">Аксай Южный</option>
          </select>
          <a v-show="false" v-if="edit"></a>
          <a
            v-if="edit"
            title="Сохранить"
            style="margin-left: 13px"
            @click="savetable()"
            ><svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M15.4735 5C15.7387 5 15.9931 5.10536 16.1806 5.29289L18.9985 8.11077L18.9985 17.9985C18.9985 18.5508 18.5508 18.9985 17.9985 18.9985L6 18.9985C5.44772 18.9985 5 18.5508 5 17.9985L5 6C5 5.44772 5.44771 5 6 5L15.4735 5Z"
                stroke="white"
                stroke-width="1.2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <rect
                x="8.109"
                y="12.778"
                width="7.77693"
                height="6.22155"
                stroke="white"
                stroke-width="1.2"
                stroke-linejoin="round"
              />
              <rect
                x="8.88917"
                y="5"
                width="6.22155"
                height="3.88847"
                stroke="white"
                stroke-width="1.2"
                stroke-linejoin="round"
              />
            </svg>
          </a>

          <!-- <a
          @click="savetable()"
          v-if="edit"
          style="margin-right: 15px; line-height: 31px;"
          class="col but-nav__link but trheadhight"
          >Сохранить</a
        > -->

          <a
            v-if="edit"
            class="trgraph"
            title="Отмена"
            data-toggle="tooltip"
            data-placement="top"
            @click="cancelEdit"
            ><svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M17.6574 17.6575L6.34367 6.34383"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
              <path
                d="M17.6563 6.34383L6.34262 17.6575"
                stroke="white"
                stroke-width="1.4"
                stroke-linecap="round"
              />
            </svg>
          </a>

          <a
            v-if="!edit"
            class="trgraph"
            title="Показать графики"
            data-toggle="tooltip"
            data-placement="top"
            href="tr_charts"
           
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

          <a
            v-if="!edit"
            title="Редактировать"
            data-toggle="tooltip"
            data-placement="top"
            @click="editable()"
            ><svg
              width="18"
              height="18"
              viewBox="0 0 18 18"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M3 11.5L1.55336 16.3221C1.53048 16.3984 1.6016 16.4695 1.67788 16.4466L6.5 15M3 11.5C3 11.5 11.0603 3.43942 12.7227 1.7772C12.8789 1.62104 13.1257 1.62572 13.2819 1.78189C13.8372 2.33714 15.1144 3.61434 16.2171 4.71709C16.3733 4.87334 16.3788 5.12115 16.2226 5.27738C14.5597 6.94002 6.5 15 6.5 15M3 11.5L3.64727 10.8527L7.14727 14.3527L6.5 15"
                stroke="white"
                stroke-width="1.4"
              />
            </svg>
          </a>

          <button
            v-if="!edit"
            class="trgraph"
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
              width="24"
              height="24"
              viewBox="0 0 24 24"
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
              width="24"
              height="24"
              viewBox="0 0 24 24"
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

        <div class="table-outer">
          <div class="table-inner">
            <TrTable :wells="wells" @onSort="sortBy" v-if="show_first" />
            <!-- <TrFullTable :wells="wells" :edit="edit" @onSort="sortBy" v-show="show_second"/> -->
            <table
              v-if="show_second"
              class="table table-bordered table-dark table-responsive trtable"
              style="margin-bottom: 0; background: #0d1e63"
            >
              <thead>
                <tr class="headerColumn sticky" style="background: #333975">
                  <td rowspan="4" class="th">№</td>
                  <td rowspan="4" class="th">НГДУ/месторождение</td>
                  <td rowspan="4" class="th">№ скв</td>
                  <td rowspan="4" class="th">Тип скважины</td>
                  <td rowspan="4" class="th">Горизонт</td>
                  <td rowspan="4" class="th">Блок</td>
                  <td rowspan="4" class="th">R контура питания</td>
                  <td rowspan="4" class="th">Наружный диаметр э/к</td>
                  <td rowspan="4" class="th">Внутренний диаметр э/к</td>
                  <td rowspan="4" class="th">Наружный диаметр НКТ</td>
                  <td rowspan="4" class="th">Внутренний диаметр НКТ</td>
                  <td rowspan="4" class="th">Диаметр штуцера</td>
                  <td rowspan="4" class="th">Нвдп</td>
                  <td rowspan="4" class="th">Удлинение(Нвдп)</td>
                  <td rowspan="4" class="th">Способ эксплуатации</td>
                  <td rowspan="4" class="th">Тип Насоса</td>
                  <td rowspan="4" class="th">Тип СК</td>
                  <td rowspan="4" class="th">Число качаний</td>
                  <td rowspan="4" class="th">Длина хода</td>
                  <td rowspan="4" class="th">Q теор</td>
                  <td rowspan="4" class="th">
                    Частота работы насоса или число оборотов
                  </td>
                  <td rowspan="4" class="th">Н сп насоса</td>
                  <td rowspan="4" class="th">P буф</td>
                  <td rowspan="4" class="th">P лин</td>
                  <td rowspan="4" class="th">P пл</td>
                  <td rowspan="4" class="th">Н дин</td>
                  <td rowspan="4" class="th">Р затр</td>
                  <td rowspan="4" class="th">Р на приеме</td>
                  <td class="colspan th" colspan="5">
                    Данные за предыдущий месяц
                  </td>
                  <td class="colspan th" colspan="4">Фактический режим</td>
                  <td rowspan="4" class="th">
                    <span>Состояние на конец месяца</span>
                  </td>
                  <td rowspan="4" class="th">P нас</td>
                  <td rowspan="4" class="th">ГФ</td>
                  <td rowspan="4" class="th">Т пл</td>
                  <td rowspan="4" class="th">Т уст</td>
                  <td class="colspan th" colspan="4">ГРП</td>
                  <td rowspan="4" class="th">
                    <span>Вязкость нефти в пластовых условиях</span>
                  </td>
                  <td rowspan="4" class="th">
                    <span>Вязкость воды в пластовых условиях</span>
                  </td>
                  <td rowspan="4" class="th">Вязкость жидкости</td>
                  <td rowspan="4" class="th">Объемный коэффициент</td>
                  <td rowspan="4" class="th">Плотность нефти</td>
                  <td rowspan="4" class="th">Плотность воды</td>
                  <td rowspan="4" class="th">Н перф</td>
                  <td rowspan="4" class="th">k</td>
                  <td rowspan="4" class="th">КН</td>
                  <td rowspan="4" class="th">К пр</td>
                  <td class="colspan th" colspan="14">
                    Расчет технологического потенциала от ИДН
                  </td>
                  <td class="colspan th" colspan="11">
                    Расчёт геологического потенциала
                  </td>
                  <td class="colspan th" colspan="4">Проверка</td>
                  <td rowspan="4" class="th">
                    <span>Максимальная глубина спуска насоса при ИДН</span>
                  </td>
                  <td rowspan="4" class="th">Дата остановки</td>
                  <td rowspan="4" class="th">Расчлененность</td>
                  <td rowspan="4" class="th">Зона</td>
                  <td rowspan="4" class="th">Цех</td>
                  <td rowspan="4" class="th">
                    <span>Фонтан через насос</span>
                  </td>
                  <td rowspan="4" class="th">Нерентабельная</td>
                  <td rowspan="4" class="th">Неустановившийся режим</td>
                  <td rowspan="4" class="th">Дата ввода в эксплуатацию</td>
                  <td rowspan="4" class="th">Назначение по проекту</td>
                  <td rowspan="4" class="th">Р заб замерное</td>
                  <td rowspan="4" class="th">Нефтенасыщенная толщина</td>
                  <td rowspan="4" class="th">Накопленная Q н</td>
                  <td rowspan="4" class="th">
                    <span>Максимальный Q ж за всю историю работы</span>
                  </td>
                  <td rowspan="4" class="th">Расстояние до нагн скважины</td>
                  <td rowspan="4" class="th">Расстояние до ВНК</td>
                  <td rowspan="4" class="th">Текущий забой по скважине, м</td>
                  <td rowspan="4" class="th">Кподачи насоса</td>
                  <td rowspan="4" class="th">Тип ГЗУ</td>
                  <td rowspan="4" class="th">Рпл начальное</td>
                  <td rowspan="4" class="th">
                    <span>Qr характеристический дебит жидкости</span>
                  </td>
                  <td class="colspan th" colspan="2">АПВ</td>
                  <td class="colspan th" colspan="3">
                    Планируемые мероприятия
                  </td>
                  <td rowspan="4" class="th"><span>Мероприятия</span></td>
                  <td rowspan="4" class="th">
                    <span>Сведения о тех.состоянии э/к</span>
                  </td>
                  <td rowspan="4" class="th"><span>Комментарии</span></td>
                  <td rowspan="4" class="th">
                    <span>Дата последнего ГТМ</span>
                  </td>
                  <td rowspan="4" class="th">
                    <span>Вид последнего ГТМ</span>
                  </td>
                  <td class="colspan th" colspan="12">Намечаемый режим</td>
                </tr>
                <tr class="headerColumn notsticky" style="background: #333975">
                  <td rowspan="3" class="th"><span>P заб</span></td>
                  <td rowspan="3" class="th"><span>Q ж</span></td>
                  <td rowspan="3" class="th"><span>Обводненность</span></td>
                  <td rowspan="3" class="th"><span>Hдин</span></td>
                  <td rowspan="3" class="th"><span>Kпрод</span></td>
                  <td rowspan="3" class="th"><span>P заб</span></td>
                  <td rowspan="3" class="th"><span>Q н</span></td>
                  <td rowspan="3" class="th"><span>Q ж</span></td>
                  <td rowspan="3" class="th"><span>Обводненность</span></td>
                  <td rowspan="3" class="th"><span>Скин</span></td>
                  <td rowspan="3" class="th"><span>JD факт</span></td>
                  <td rowspan="3" class="th"><span>Дата проведения</span></td>
                  <td rowspan="3" class="th"><span>Фирма</span></td>
                  <td rowspan="3" class="th"><span>Р заб</span></td>
                  <td class="colspan th" colspan="4">ИДН</td>
                  <td rowspan="3" class="th"><span>JD опт</span></td>
                  <td rowspan="3" class="th"><span>Skin</span></td>
                  <td rowspan="3" class="th">
                    <span>К пр от стимуляции</span>
                  </td>
                  <td class="colspan th" colspan="4">ГРП</td>
                  <td rowspan="3" class="th"><span>% прироста Q н</span></td>
                  <td rowspan="3" class="th"><span>Общий прирост Q н</span></td>
                  <td rowspan="3" class="th"><span>Р заб</span></td>
                  <td class="colspan th" colspan="4">ИДН</td>
                  <td class="colspan th" colspan="4">ГРП</td>
                  <td rowspan="3" class="th"><span>% прироста Q н</span></td>
                  <td rowspan="3" class="th"><span>Общий прирост Q н</span></td>
                  <td class="colspan th" colspan="2">Ошибки</td>
                  <td class="colspan th" colspan="2">Предупреждения</td>
                  <td rowspan="3" class="th"><span>Траб</span></td>
                  <td rowspan="3" class="th"><span>Тнак</span></td>
                  <td class="colspan th" colspan="3">Изоляционные работы</td>
                  <td rowspan="3" class="th"><span>Диаметр штуцера</span></td>
                  <td rowspan="3" class="th"><span>Qн</span></td>
                  <td rowspan="3" class="th"><span>Qж</span></td>
                  <td rowspan="3" class="th"><span>Обводненность</span></td>
                  <td rowspan="3" class="th"><span>Число дней работы</span></td>
                  <td rowspan="3" class="th">
                    <span>Добыча нефти за месяц</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>Добыча газа за месяц</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>Добыча жидкость за месяц</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>Добыча воды за месяц</span>
                  </td>
                  <td class="colspan th" colspan="2">
                    <span>Изменения к режиму</span>
                  </td>
                  <td rowspan="3" class="th">
                    <span>Мероприятия по обеспечению техрежима</span>
                  </td>
                </tr>
                <tr class="headerColumn notsticky" style="background: #333975">
                  <td rowspan="2" class="th"><span>Q ж</span></td>
                  <td rowspan="2" class="th">
                    <span>Q ж с поправкой на D э/к</span>
                  </td>
                  <td rowspan="2" class="th"><span>Q н</span></td>
                  <td rowspan="2" class="th"><span>Прирост Q н</span></td>
                  <td rowspan="2" class="th"><span>Q ж</span></td>
                  <td rowspan="2" class="th">
                    <span>Q ж с поправкой на D э/к</span>
                  </td>
                  <td rowspan="2" class="th"><span>Q н</span></td>
                  <td rowspan="2" class="th"><span>Прирост Q н</span></td>
                  <td rowspan="2" class="th"><span>Q ж</span></td>
                  <td rowspan="2" class="th">
                    <span>Q ж с поправкой на D э/к</span>
                  </td>
                  <td rowspan="2" class="th"><span>Q н</span></td>
                  <td rowspan="2" class="th"><span>Прирост Q н</span></td>
                  <td rowspan="2" class="th"><span>Q ж</span></td>
                  <td rowspan="2" class="th">
                    <span>Q ж с поправкой на D э/к</span>
                  </td>
                  <td rowspan="2" class="th"><span>Q н</span></td>
                  <td rowspan="2" class="th"><span>Прирост Q н</span></td>
                  <td rowspan="2" class="th"><span>Число ошибок</span></td>
                  <td rowspan="2" class="th"><span>Первая ошибка</span></td>
                  <td rowspan="2" class="th">
                    <span>Число предупреждений</span>
                  </td>
                  <td rowspan="2" class="th">
                    <span>Первое предупреждение</span>
                  </td>
                  <td rowspan="2" class="th"><span>Проводить</span></td>
                  <td rowspan="2" class="th"><span>Q ж</span></td>
                  <td rowspan="2" class="th"><span>Обводненность</span></td>
                  <td rowspan="2" class="th"><span>Q н</span></td>
                  <td rowspan="2" class="th"><span>Q ж</span></td>
                </tr>
                <tr></tr>
                <tr
                  class="subHeaderColumn"
                  style="background: #333975; cursor: pointer"
                >
                  <td @click="sortBy('gu')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('field')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('well')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('well_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('horizon')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('block')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('r_con')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('cas_OD')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('cas_ID')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('tub_OD')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('tub_ID')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('choke_d')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('h_up_perf_md')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('h_up_perf_ext')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('exp_meth')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('pump_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('type_sr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('spm')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('stroke_len')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('q_theor')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('freq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>Гц, об/мин
                  </td>
                  <td @click="sortBy('h_pump_set')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('whp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('line_p')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('p_res')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('h_dyn')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('p_annular')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('p_intake')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('bhp_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('q_l_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('wct_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('h_dyn_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('pi_prev_m')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут/атм
                  </td>
                  <td @click="sortBy('bhp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('q_o')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('q_l')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('wct')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('well_status_last_day')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('P_bubble_point')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('gor')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/т
                  </td>
                  <td @click="sortBy('t_res')" class="th">
                    <i class="fa fa-fw fa-sort"></i>ºC
                  </td>
                  <td @click="sortBy('wht')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('grp_skin')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('grp_jd')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('grp_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>д/м/г
                  </td>
                  <td @click="sortBy('grp_contractor')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('visc_oil_rc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>сПз
                  </td>
                  <td @click="sortBy('visc_wat_rc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>сПз
                  </td>
                  <td @click="sortBy('visc_liq_rc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>сПз
                  </td>
                  <td @click="sortBy('bo')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/м3
                  </td>
                  <td @click="sortBy('dens_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>г/см3
                  </td>
                  <td @click="sortBy('dens_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>г/см3
                  </td>
                  <td @click="sortBy('h_perf')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('k')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мД
                  </td>
                  <td @click="sortBy('kh')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мДм
                  </td>
                  <td @click="sortBy('pi')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут/атм
                  </td>
                  <td @click="sortBy('tp_idn_bhp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('tp_idn_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('tp_idn_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('tp_idn_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('tp_idn_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('tp_idn_jd')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('tp_idn_skin')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('tp_idn_pi_after')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут/атм
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('tp_idn_grp_q_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('tp_idn_q_oil_inc_perc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('gt_total_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>

                  <td @click="sortBy('gp_idn_bhp')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('gp_idn_q_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('gp_idn_q_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('gp_idn_q_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('gp_idn_q_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('gp_grp_q_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('gp_grp_q_liq_cas_d_corr')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('gp_grp_q_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('gp_grp_q_oil_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('gp_total_inc_perc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('gp_total_inc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('error_count')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('error_first')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('error_warning')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('error_first_warning')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('idn_pump_depth_max')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('stop_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>д/м/г
                  </td>
                  <td @click="sortBy('layers_count')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('zone')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('tseh')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('semi_free_flow')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('non_profit')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('unsteady_state')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('start_up_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>д/м/г
                  </td>
                  <td @click="sortBy('well_project_purpose')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('bhp_meter')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('oil_net_pay')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('oil_cumulative')" class="th">
                    <i class="fa fa-fw fa-sort"></i>тыс.т
                  </td>
                  <td @click="sortBy('max_q_liq_hist')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('dist_to_inj_well')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('dist_to_woc')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м
                  </td>
                  <td @click="sortBy('curr_bh')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('pump_fillage')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('gzu_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('p_res_init')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('q_liq_charac')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('APV_t_rab')" class="th">
                    <i class="fa fa-fw fa-sort"></i>час
                  </td>
                  <td @click="sortBy('APV_t_nak')" class="th">
                    <i class="fa fa-fw fa-sort"></i>час
                  </td>
                  <td @click="sortBy('plan_izo_work')" class="th">
                    <i class="fa fa-fw fa-sort"></i>атм
                  </td>
                  <td @click="sortBy('plan_act_q_l')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('plan_act_wct')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('plan_activities')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('plan_casing_info')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('plan_comment')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('last_gtm_date')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                  <td @click="sortBy('last_gtm_type')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>

                  <td @click="sortBy('planned_choke')" class="th">
                    <i class="fa fa-fw fa-sort"></i>мм
                  </td>
                  <td @click="sortBy('planned_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('planned_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('planned_wct')" class="th">
                    <i class="fa fa-fw fa-sort"></i>%
                  </td>
                  <td @click="sortBy('planned_month_days')" class="th">
                    <i class="fa fa-fw fa-sort"></i>сут
                  </td>
                  <td @click="sortBy('planned_monthly_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>тонн
                  </td>
                  <td @click="sortBy('planned_monthly_gas')" class="th">
                    <i class="fa fa-fw fa-sort"></i>тыс.м3
                  </td>
                  <td @click="sortBy('planned_monthly_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3
                  </td>
                  <td @click="sortBy('planned_monthly_water')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3
                  </td>
                  <td @click="sortBy('planned_diff_oil')" class="th">
                    <i class="fa fa-fw fa-sort"></i>т/сут
                  </td>
                  <td @click="sortBy('planned_diff_liq')" class="th">
                    <i class="fa fa-fw fa-sort"></i>м3/сут
                  </td>
                  <td @click="sortBy('planned_events')" class="th">
                    <i class="fa fa-fw fa-sort"></i>
                  </td>
                </tr>
              </thead>
              <tbody>
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
                      :style="`background :${getColor(
                        wells[row_index].block[1][0]
                      )}`"
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
                      :style="`background :${getColor(
                        wells[row_index].block[1][0]
                      )}`"
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
                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].r_con[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].r_con[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.r_con[0] != null">{{
                      Math.round(row.r_con[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].r_con[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].r_con[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].r_con[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].r_con[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      @change="editrow(row, row_index)"
                      class="input_edit"
                      v-model="row.r_con[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.r_con[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].r_con[1][1] }}
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
                    <span v-if="row.cas_OD[0] != null">{{
                      Math.round(row.cas_OD[0] * 10) / 10
                    }}</span>
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

                  <td v-if="!edit">
                    <span v-if="row.cas_ID != null">{{
                      Math.round(row.cas_ID * 10) / 10
                    }}</span>
                  </td>
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
                    <span v-if="row.tub_OD[0] != null">{{
                      Math.round(row.tub_OD[0] * 10) / 10
                    }}</span>
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

                  <td v-if="!edit">
                    <span v-if="row.tub_ID != null">{{
                      Math.round(row.tub_ID * 10) / 10
                    }}</span>
                  </td>
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
                    <span v-if="row.choke_d[0] != null">{{
                      Math.round(row.choke_d[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.h_up_perf_md[0] != null">
                      {{ Math.round(row.h_up_perf_md[0] * 10) / 10 }}
                    </span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.h_up_perf_md * 10) / 10 }}
                  </td>

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
                    <span v-if="row.h_up_perf_ext[0] != null">{{
                      Math.round(row.h_up_perf_ext[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.h_up_perf_ext[0] * 10) / 10
                    }}</span>
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

                  <td v-if="!edit">{{ row.type_sr }}</td>
                  <td v-if="edit">{{ row.type_sr }}</td>

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
                      :style="`background :${getColor(
                        wells[row_index].spm[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.spm[0] != null">{{
                      Math.round(row.spm[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].spm[1][0]
                      )}`"
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
                    <span v-if="row.stroke_len[0] != null">{{
                      Math.round(row.stroke_len[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].freq[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.freq[0] != null">{{
                      Math.round(row.freq[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].freq[1][0]
                      )}`"
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
                    <span v-if="row.h_pump_set[0] != null">{{
                      Math.round(row.h_pump_set[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
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
                      :style="`background :${getColor(
                        wells[row_index].whp[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.whp[0] != null">{{
                      Math.round(row.whp[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].whp[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
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
                    <span v-if="row.line_p[0] != null">{{
                      Math.round(row.line_p[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
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
                      :style="`background :${getColor(
                        wells[row_index].p_res[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.p_res[0] != null">{{
                      Math.round(row.p_res[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].p_res[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
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
                      :style="`background :${getColor(
                        wells[row_index].h_dyn[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.h_dyn[0] != null">{{
                      Math.round(row.h_dyn[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].h_dyn[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
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
                    <span v-if="row.p_annular[0] != null">{{
                      Math.round(row.p_annular[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
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
                    <span v-if="row.p_intake[0] != null">{{
                      Math.round(row.p_intake[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.p_intake[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{Math.round(row.p_intake[0]*10)/10}}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].p_intake[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.bhp_prev_m != null">{{
                      Math.round(row.bhp_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.bhp_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.q_l_prev_m != null">{{
                      Math.round(row.q_l_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.q_l_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.wct_prev_m != null">{{
                      Math.round(row.wct_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.wct_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.h_dyn_prev_m != null">{{
                      Math.round(row.h_dyn_prev_m * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.h_dyn_prev_m * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.pi_prev_m != null">{{
                      Math.round(row.pi_prev_m * 10) / 10
                    }}</span>
                  </td>
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
                      :style="`background :${getColor(
                        wells[row_index].bhp[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.bhp[0] != null">{{
                      Math.round(row.bhp[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].bhp[1][0]
                      )}`"
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
                      :style="`background :${getColor(
                        wells[row_index].q_o[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.q_o[0] != null">{{
                      Math.round(row.q_o[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].q_o[1][0]
                      )}`"
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
                      :style="`background :${getColor(
                        wells[row_index].q_l[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.q_l[0] != null">{{
                      Math.round(row.q_l[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].q_l[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
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
                      :style="`background :${getColor(
                        wells[row_index].wct[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.wct[0] != null">{{
                      Math.round(row.wct[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].wct[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
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
                    <span v-if="row.P_bubble_point[0] != null">{{
                      Math.round(row.P_bubble_point[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.P_bubble_point[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].gor[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gor[0] != null">{{
                      Math.round(row.gor[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].gor[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
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
                      :style="`background :${getColor(
                        wells[row_index].t_res[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.t_res[0] != null">{{
                      Math.round(row.t_res[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].t_res[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.t_res[0]" :disabled="!edit"> -->
                    <span>{{ Math.round(row.t_res[0] * 10) / 10 }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].t_res[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.wht != null">{{
                      Math.round(row.wht * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">{{ Math.round(row.wht * 10) / 10 }}</td>

                  <td
                    v-if="!edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_skin[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_skin[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_skin[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.grp_skin[0] != null">{{
                      Math.round(row.grp_skin[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_skin[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].grp_skin[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].grp_skin[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].grp_skin[1][0]
                      )}`"
                    >
                    </span>
                    <input
                      class="input_edit"
                      @change="editrow(row, row_index)"
                      v-model="row.grp_skin[0]"
                      :disabled="!edit"
                    />
                    <!-- <span>{{ Math.round(row.grp_skin[0] * 10) / 10 }}</span> -->
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].grp_skin[1][1] }}
                    </span>
                  </td>
                  <td v-if="!edit">
                    <span v-if="row.grp_jd != null">{{
                      Math.round(row.grp_jd * 100) / 100
                    }}</span>
                  </td>
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
                    <span v-if="row.visc_oil_rc[0] != null">{{
                      Math.round(row.visc_oil_rc[0] * 100) / 100
                    }}</span>
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
                    <span v-if="row.visc_wat_rc[0] != null">{{
                      Math.round(row.visc_wat_rc[0] * 100) / 100
                    }}</span>
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
                    <span v-if="row.visc_liq_rc[0] != null">{{
                      Math.round(row.visc_liq_rc[0] * 100) / 100
                    }}</span>
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
                    <span>{{
                      Math.round(row.visc_liq_rc[0] * 100) / 100
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].bo[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.bo[0] != null">{{
                      Math.round(row.bo[0] * 100) / 100
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].bo[1][0]
                      )}`"
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
                    <span v-if="row.dens_oil[0] != null">{{
                      Math.round(row.dens_oil[0] * 100) / 100
                    }}</span>
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
                    <span v-if="row.dens_liq[0] != null">{{
                      Math.round(row.dens_liq[0] * 100) / 100
                    }}</span>
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
                    <span v-if="row.h_perf[0] != null">{{
                      Math.round(row.h_perf[0] * 10) / 10
                    }}</span>
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
                        wells &&
                        wells[row_index] &&
                        wells[row_index].k[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].k[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].k[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.k[0] != null">{{
                      Math.round(row.k[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].k[1][1] }}
                    </span>
                  </td>
                  <td
                    v-if="edit"
                    :class="{
                      'cell-with-comment':
                        wells &&
                        wells[row_index] &&
                        wells[row_index].k[1][0] !== '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].k[1][0] !== '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].k[1][0]
                      )}`"
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
                      :style="`background :${getColor(
                        wells[row_index].kh[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.kh[0] != null">{{
                      Math.round(row.kh[0] * 10) / 10
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].kh[1][0]
                      )}`"
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
                      :style="`background :${getColor(
                        wells[row_index].pi[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.pi[0] != null">{{
                      Math.round(row.pi[0] * 100) / 100
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].pi[1][0]
                      )}`"
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
                    <span v-if="row.tp_idn_bhp[0] != null">{{
                      Math.round(row.tp_idn_bhp[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_liq[0] != null">{{
                      Math.round(row.tp_idn_liq[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_liq_cas_d_corr[0] != null">{{
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
                    <span v-if="row.tp_idn_oil[0] != null">{{
                      Math.round(row.tp_idn_oil[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_oil_inc[0] != null">{{
                      Math.round(row.tp_idn_oil_inc[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.tp_idn_oil_inc[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_jd[0] != null">{{
                      Math.round(row.tp_idn_jd[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_skin[0] != null">{{
                      Math.round(row.tp_idn_skin[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_pi_after[0] != null">{{
                      Math.round(row.tp_idn_pi_after[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.tp_idn_pi_after[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_grp_q_liq[0] != null">{{
                      Math.round(row.tp_idn_grp_q_liq[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.tp_idn_grp_q_liq[0] * 10) / 10
                    }}</span>
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
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                          '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tp_idn_grp_q_liq_cas_d_corr[0] != null">{{
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
                        wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                          '0',
                    }"
                  >
                    <span
                      :class="{
                        'circle-err':
                          wells &&
                          wells[row_index] &&
                          wells[row_index].tp_idn_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
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
                    <span v-if="row.tp_idn_grp_q_oil[0] != null">{{
                      Math.round(row.tp_idn_grp_q_oil[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.tp_idn_grp_q_oil[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.tp_idn_grp_q_oil_inc[0] != null">{{
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
                    <span v-if="row.tp_idn_q_oil_inc_perc != null">
                      {{ Math.round(row.tp_idn_q_oil_inc_perc * 10) / 10 }}
                    </span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.tp_idn_q_oil_inc_perc * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.gt_total_inc != null">{{
                      Math.round(row.gt_total_inc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.gt_total_inc * 10) / 10 }}
                  </td>

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
                    <span v-if="row.gp_idn_bhp[0] != null">{{
                      Math.round(row.gp_idn_bhp[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.gp_idn_q_liq[0] != null">{{
                      Math.round(row.gp_idn_q_liq[0] * 10) / 10
                    }}</span>
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
                          wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_idn_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_idn_q_liq_cas_d_corr[0] != null">{{
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
                          wells[row_index].gp_idn_q_liq_cas_d_corr[1][0] !==
                            '0',
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
                    <span v-if="row.gp_idn_q_oil[0] != null">{{
                      Math.round(row.gp_idn_q_oil[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.gp_idn_q_oil_inc[0] != null">{{
                      Math.round(row.gp_idn_q_oil_inc[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.gp_idn_q_oil_inc[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.gp_grp_q_liq[0] != null">{{
                      Math.round(row.gp_grp_q_liq[0] * 10) / 10
                    }}</span>
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
                          wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
                      }"
                      :style="`background :${getColor(
                        wells[row_index].gp_grp_q_liq_cas_d_corr[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.gp_grp_q_liq_cas_d_corr[0] != null">{{
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
                          wells[row_index].gp_grp_q_liq_cas_d_corr[1][0] !==
                            '0',
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
                    <span v-if="row.gp_grp_q_oil[0] != null">{{
                      Math.round(row.gp_grp_q_oil[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.gp_grp_q_oil_inc[0] != null">{{
                      Math.round(row.gp_grp_q_oil_inc[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.gp_grp_q_oil_inc[0] * 10) / 10
                    }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].gp_grp_q_oil_inc[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.gp_total_inc_perc != null">{{
                      Math.round(row.gp_total_inc_perc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.gp_total_inc_perc * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.gp_total_inc != null">{{
                      Math.round(row.gp_total_inc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.gp_total_inc * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.error_count != null">{{
                      row.error_count
                    }}</span>
                  </td>
                  <td v-if="edit">{{ row.error_count }}</td>

                  <td v-if="!edit">{{ row.error_first }}</td>
                  <td v-if="edit">{{ row.error_first }}</td>

                  <td v-if="!edit">
                    <span v-if="row.error_warning != null">{{
                      row.error_warning
                    }}</span>
                  </td>
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
                    <span v-if="row.idn_pump_depth_max[0] != null">{{
                      Math.round(row.idn_pump_depth_max[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
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
                    <span v-if="row.stop_date[0] != null">{{
                      row.stop_date[0]
                    }}</span>
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
                    <span v-if="row.layers_count[0] != null">{{
                      row.layers_count[0]
                    }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].zone[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.zone[0] != null">{{ row.zone[0] }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].zone[1][0]
                      )}`"
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
                      :style="`background :${getColor(
                        wells[row_index].tseh[1][0]
                      )}`"
                    >
                    </span>
                    <span v-if="row.tseh[0] != null">{{ row.tseh[0] }}</span>
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
                      :style="`background :${getColor(
                        wells[row_index].tseh[1][0]
                      )}`"
                    >
                    </span>
                    <!-- <input @change="editrow(row, row_index)" v-model="row.tseh[0]" :disabled="!edit"> -->
                    <span>{{ row.tseh[0] }}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                      {{ wells[row_index].tseh[1][1] }}
                    </span>
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.semi_free_flow[0] != null">{{
                      row.semi_free_flow[0]
                    }}</span>
                  </td>
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
                    <span v-if="row.non_profit[0] != null">{{
                      row.non_profit[0]
                    }}</span>
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
                    <span v-if="row.unsteady_state[0] != null">{{
                      row.unsteady_state[0]
                    }}</span>
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
                    <span v-if="row.start_up_date[0] != null">{{
                      row.start_up_date[0]
                    }}</span>
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
                    <span v-if="row.well_project_purpose[0] != null">{{
                      row.well_project_purpose[0]
                    }}</span>
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
                    <span v-if="row.bhp_meter[0] != null">{{
                      Math.round(row.bhp_meter[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
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
                    <span v-if="row.oil_net_pay[0] != null">{{
                      Math.round(row.oil_net_pay[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.oil_cumulative[0] != null">{{
                      Math.round(row.oil_cumulative[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.oil_cumulative[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.max_q_liq_hist[0] != null">{{
                      Math.round(row.max_q_liq_hist[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.max_q_liq_hist[0] * 10) / 10
                    }}</span>
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

                  <td v-if="!edit">
                    <span v-if="row.dist_to_woc != null">{{
                      Math.round(row.dist_to_woc * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.dist_to_woc * 10) / 10 }}
                  </td>

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
                    <span v-if="row.curr_bh[0] != null">{{
                      Math.round(row.curr_bh[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.pump_fillage[0] != null">{{
                      Math.round(row.pump_fillage[0] * 10) / 10
                    }}</span>
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

                  <td v-if="!edit">
                    <span v-if="row.p_res_init != null">{{
                      Math.round(row.p_res_init * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.p_res_init * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.q_liq_charac != null">{{
                      Math.round(row.q_liq_charac * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.q_liq_charac * 10) / 10 }}
                  </td>

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
                    <span v-if="row.APV_t_rab[0] != null">{{
                      row.APV_t_rab[0]
                    }}</span>
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
                    <span v-if="row.APV_t_nak != null">{{
                      row.APV_t_nak[0]
                    }}</span>
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

                  <td v-if="!edit">
                    <span v-if="row.plan_izo_work != null">{{
                      row.plan_izo_work
                    }}</span>
                  </td>
                  <td v-if="edit">{{ row.plan_izo_work }}</td>

                  <td v-if="!edit">
                    <span v-if="row.plan_act_q_l != null">{{
                      Math.round(row.plan_act_q_l * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.plan_act_q_l * 10) / 10 }}
                  </td>

                  <td v-if="!edit">
                    <span v-if="row.plan_act_wct != null">{{
                      Math.round(row.plan_act_wct * 10) / 10
                    }}</span>
                  </td>
                  <td v-if="edit">
                    {{ Math.round(row.plan_act_wct * 10) / 10 }}
                  </td>

                  <td v-if="!edit">{{ row.plan_activities }}</td>
                  <td v-if="edit">{{ row.plan_activities }}</td>

                  <td v-if="!edit">{{ row.plan_casing_info }}</td>
                  <td v-if="edit">{{ row.plan_casing_info }}</td>

                  <td v-if="!edit">{{ row.plan_comment }}</td>
                  <td v-if="edit">{{ row.plan_comment }}</td>

                  <td v-if="!edit">{{ row.last_gtm_date }}</td>
                  <td v-if="edit">{{ row.last_gtm_date }}</td>

                  <td v-if="!edit">{{ row.last_gtm_type }}</td>
                  <td v-if="edit">{{ row.last_gtm_type }}</td>

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
                    <span v-if="row.planned_choke[0] != null">{{
                      row.planned_choke[0]
                    }}</span>
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
                      class="input_edit"
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
                    <span v-if="row.planned_oil[0] != null">{{
                      Math.round(row.planned_oil[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.planned_liq[0] != null">{{
                      Math.round(row.planned_liq[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
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
                    <span v-if="row.planned_wct[0] != null">{{
                      Math.round(row.planned_wct[0] * 10) / 10
                    }}</span>
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
                      class="input_edit"
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
                      class="input_edit"
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
                    <span v-if="row.planned_monthly_oil[0] != null">{{
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
                    <span v-if="row.planned_monthly_gas[0] != null">{{
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
                    <span v-if="row.planned_monthly_liq[0] != null">{{
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
                    <span v-if="row.planned_monthly_water[0] != null">{{
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
                    <span v-if="row.planned_diff_oil[0] != null">{{
                      Math.round(row.planned_diff_oil[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.planned_diff_oil[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.planned_diff_liq[0] != null">{{
                      Math.round(row.planned_diff_liq[0] * 10) / 10
                    }}</span>
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
                    <span>{{
                      Math.round(row.planned_diff_liq[0] * 10) / 10
                    }}</span>
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
                    <span v-if="row.planned_events[0] != null">{{
                      row.planned_events[0]
                    }}</span>
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
                      class="input_edit"
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
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TrTable from "./table";
import TrFullTable from "./tablefull";
import SearchFormRefresh from "../ui-kit/SearchFormRefresh.vue";
// import FadeLoader from "vue-spinner/src/FadeLoader.vue";

export default {
  name: "TrPage",
  components: {
    TrTable,
    TrFullTable,
    SearchFormRefresh,
    // FadeLoader,
  },
  beforeCreate: function () {},
  created() {
    this.$store.commit("globalloading/SET_LOADING", true);
    this.$store.commit("tr/SET_SORTPARAM", this.sortParam);
    this.$store.commit("tr/SET_SEARCH", this.searchString);
    this.$store.commit("tr/SET_FILTER", this.filter);
    var today = new Date();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    this.$store.commit("tr/SET_MONTH", mm);
    this.$store.commit("tr/SET_YEAR", yyyy);
    this.axios
      .get("http://172.20.103.187:7576/api/techregime/" + yyyy + "/" + mm + "/")
      .then((response) => {
        let data = response.data;
        this.year = yyyy;
        this.selectYear = yyyy;
        this.month = mm;
        this.$store.commit("globalloading/SET_LOADING", false);
        // this.isloading = false;
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
  },
  data: function () {
    return {
      wells: [],
      searchString: "",
      searched: false,
      sortParam: "",
      sortType: "asc",
      filter: "Все месторождения",
      dt: null,
      fullWells: [],
      editedWells: [],
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
      // isloading: true,
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
      console.log("row = ", row);
      console.log("rowId = ", rowId);
      row["index"] = 0;
      this.axios
        .post(
          "http://172.20.103.187:7576/api/techregime/edit/" +
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
            // this.wells = this.wells.map((currentRow, index) => {
            //   // console.log('norm', index, rowId)
            //   return index === rowId ? response.data.data[0] :   currentRow;
            // });

            this.wells = [
              ...this.wells.slice(0, rowId),
              response.data.data[0],
              ...this.wells.slice(rowId + 1),
            ];
            this.editedWells = this.editedWells.filter(
              (item) => item.well !== response.data.data[0].well
            );
            this.editedWells = [...this.editedWells, response.data.data[0]];
          } else {
            console.log("No data");
          }
        });
    },
    savetable() {
      this.edit = false;
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      const searchParam = this.searchString ? `${this.searchString}/` : "";
      this.axios
        .post(
          "http://172.20.103.187:7576/api/techregime/save/" +
            this.year +
            "/" +
            this.month +
            "/" +
            searchParam,
          {
            well: this.editedWells,
          }
        )
        .then((response) => {
          console.log(response.data);
          this.fullWells = response.data;
          this.editedWells = [];
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          this.searched = searchParam ? true : false;
        })
        .catch((error) => {
          console.log(error.data);
          this.editedWells = [];
          this.searchWell();
          this.searched = searchParam ? true : false;
        });
    },
    cancelEdit() {
      this.edit = false;
      this.editedWells = [];
      this.searchWell();
    },
    editable() {
      this.edit = true;
      this.show_second = true;
      this.show_first = false;
    },
    sortBy(type) {
      this.sortParam = type;
      this.$store.commit("tr/SET_SORTTYPE", this.sortType);
      this.$store.commit("tr/SET_SORTPARAM", type);
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
      this.$store.commit("tr/SET_MONTH", event.target.value);
    },
    onChangeYear(event) {
      this.year = event.target.value;
      this.$store.commit("tr/SET_YEAR", event.target.value);
    },

    chooseDt() {
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/" +
            this.selectYear +
            "/" +
            this.month +
            "/"
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          let data = response.data;
          if (data) {
            this.searched = false;
            this.$store.commit("tr/SET_SORTPARAM", "");
            this.$store.commit("tr/SET_SEARCH", "");
            this.sortParam = "";
            this.searchString = "";
            console.log(data);
            // this.wells = data.data;
            this.fullWells = data.data;
          } else {
            console.log("No data");
          }
          if (this.month < 10) {
            this.dt = "01" + ".0" + this.month + "." + this.selectYear;
          } else {
            this.dt = "01" + "." + this.month + "." + this.selectYear;
          }
        });
    },
    chooseField() {
      const { filter, fullWells } = this;
      console.log(filter);
      console.log(fullWells);
      // if (!filter || filter == "Казгермунай") {
      this.$store.commit("tr/SET_FILTER", filter);
      if (!filter || filter == "Все месторождения") {
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
      console.log("search = ", this.searchString);
      this.$store.commit("tr/SET_SORTPARAM", "");
      this.sortParam = "";
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      const searchParam = this.searchString
        ? `search/${this.searchString}/`
        : "";
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/" +
            this.selectYear +
            "/" +
            this.month +
            "/" +
            searchParam
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          this.searched = searchParam ? true : false;
          this.$store.commit("tr/SET_SEARCH", this.searchString);
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
          this.searched = searchParam ? true : false;
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
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
  padding: 0;
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
.trtable {
  font-size: 9px;
  padding: unset;
}

.trcolmd12 {
  margin: 0;
  padding: 0;
  margin-bottom: 13px;
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
  margin: 0 10px;
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
  height: calc(100vh - 205px);
}
.trkrtableborderedtabledarktableresponsive {
  font-size: 9px;
  padding: unset;
}
.butcancel.butcancel {
  flex-grow: 0;
  width: 200px;
}

.table .th {
  position: sticky;
  background: rgb(51, 57, 117);
}
.table tr:first-child .th {
  top: -1px;
  z-index: 3000;
}
.table tr:nth-child(2) .th {
  top: 24px;
  z-index: 3000;
}
.table tr:nth-child(3) .th {
  top: 49px;
  z-index: 3000;
}
.table tr:nth-child(4) .th {
  top: 80px;
  z-index: 3000;
}
.table tr:nth-child(5) .th {
  top: 97px;
  z-index: 3000;
}
tr td:first-child {
  color: #fff;
  position: sticky;
  left: 0;
  width: 100px;
}
.table-outer {
  position: relative;
}
.table-inner {
  overflow-y: visible;
}
tr:not(.notsticky) td:nth-child(-n + 3) {
  position: sticky;
  left: -1px;
  width: 27px;
  z-index: 3009;
}
tr:not(.notsticky) td:nth-child(2) {
  left: 23px;
  width: 100px;
}
tr:not(.notsticky) td:nth-child(3) {
  left: 121px;
  width: 55;
}

tr:nth-child(odd) td {
  background-color: #454d7d;
}
tr:nth-child(even) td {
  background-color: #26336f;
}

.table.table tr:not(.notsticky) .th:nth-child(-n + 3) {
  z-index: 3010;
}

.input_edit {
  background: #7879a6;
}

/* width */
table::-webkit-scrollbar {
  width: 10px;
}

/* Track */
table::-webkit-scrollbar-track {
  background: #333975;
}

/* Handle */
table::-webkit-scrollbar-thumb {
  background: #656a8a;
}

/* Handle on hover */
table::-webkit-scrollbar-thumb:hover {
  background: #272953;
}

table::-webkit-scrollbar-corner {
  background: #333975;
}
</style>
<style>
.tr-field-filter.tr-field-filter {
  margin: 0 0 0 auto;
  flex-grow: 0;
  width: 230px;
}
.tr-table-header {
  justify-content: space-between;
  height: 48px;
  align-items: center;
}
.trheadhight {
  height: 40px;
}
.fadropmenu.fadropmenu {
  background: #333975;
  /* width: 246px; */
  z-index: 4001 !important;
}
.faheadhight {
  height: 40px;
}

.button_form.button_form {
  background: #333975;
  border: 0px;
  color: #fff;
  align-self: center;
  width: 150px;
  margin-top: 5px;
  /* display: flex;  */
  /* justify-content: center */
}
.dropdown-menu.show {
  display: flex;
  flex-direction: column;
}
</style>