<template>
  <div class="w-100">
    <div
      class="row justify-content-between farowjustcontbet"
      style="box-sizing: border box; flex-grow: 1; padding-right: 0; margin-right: 0; margin-left: 0; paddng-left: 0; line-height: 31px;"
    >
      <a href="tr" class="col but-nav__link but faheadhight"
        ><i style="margin-right: 10px"
          ><svg
            width="14"
            height="17"
            viewBox="0 0 14 17"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.75 16.905L0 11.655L1.215 10.71L6.7425 15.0075L12.2775 10.7032L13.5 11.655L6.75 16.905ZM6.75 13.7025L0 8.45249L1.215 7.50749L6.7425 11.805L12.2775 7.49999L13.5 8.45249L6.75 13.7025ZM6.75 10.5L1.2225 6.2025L0 5.25L6.75 0L13.5 5.25L12.27 6.2025L6.75 10.5Z"
              fill="white"
            /></svg
        ></i>
        Технологический режим</a
      >

      <div class="col dropdown" style="padding: 0px; margin: 0 13px">
        <button
          class="col-md-12 but-nav__link but faheadhight"
          href="#"
          role="button"
          id="dropdownMenuLink"
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
          Выберите даты
        </button>

        <div
          class="dropdown-menu fadropmenu"
          style="background: #40467E; margin-top: 4px;"
          aria-labelledby="dropdownMenuLink"
        >
          <!-- <form class="form-group but-nav__link"> -->
          <label for="inputDate" style="margin-left: 8px;">Введите опорную дату:</label>
          <input type="date" class="form-control" v-model="date1" />
          <!-- <form class="form-group but-nav__link"> -->
          <label for="inputDate" style="margin-left: 8px;">Введите дату для сравнения:</label>
          <input type="date" class="form-control" v-model="date2" />
          <a href="#" class="btn btn-sm button_form" @click.prevent="chooseDt"
            >Сформировать</a
          >
        </div>
      </div>
      <!-- <button type="button" class="btn btn-primary">Главный</button> -->

      <!-- <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" v-model="date1">
                </form>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Выбор даты 2:</label>
                        <input type="date" class="form-control" v-model="date2">
                </form>
                <a href="#" class="but-nav__link but" @click.prevent="chooseDt">Сформировать</a> -->
      <!-- <a href="#" class="but-nav__link but">Редактировать</a> -->
      <!-- <a class="but-nav__link but " @click="pushBign('chart')">Графики</a> -->
      <!-- <a href="http://172.20.103.51:7576/api/techregime/factor/download" download="Факторный анализ.xlsx" class="but-nav__link but">Экспорт</a> -->
      <!-- <div class="col">
        <div class="input-group input-group-sm fasearch">
          <input
            type="text"
            placeholder="Поиск"
            class="form-control fix-rounded-right"
            required
          />
          <div class="input-group-prepend fainputgr">
            <button class="input-group-text" style="font-size: 14px">
              Поиск
            </button>
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
    <div
      class="tech tr-table-header"
      style="display: flex; background: #272953; margin-left: 0px !important"
    >
      <h5 style="margin-left: 14px">Факторный анализ</h5>
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
      <a
        class="but-nav__link but"
        href="trfa"
        @click="pushBign('chart')"
        style="background: #272953"
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
          /></svg
      ></a>
    </div>
    <div style="position: relative">
      <!-- <div class="fadee" v-if="isloading">
        <fade-loader :loading="isloading"></fade-loader>
      </div> -->
      <table
        class="table table-bordered table-dark table-responsive fakrtableborderedtable"
        style="
          background: #0d1e63;
          margin-bottom: 0;
        "
      >
        <tr class="headerColumn">
          <td rowspan="3" style="background: #12135c"><span>Скважина</span></td>
          <td rowspan="3" style="background: #12135c; min-width: 120px;">
            <span>Месторождение</span>
          </td>
          <td rowspan="3" style="background: #12135c"><span>Горизонт</span></td>
          <td rowspan="3" style="background: #12135c"><span>Объект</span></td>
          <td rowspan="3" style="background: #12135c">
            <span>Способ Эксплуатации</span>
          </td>
          <td class="colspan" colspan="6" style="background: #2c3379">
            Фактические данные на {{ dt }}
          </td>
          <td class="colspan" colspan="6" style="background: #1a2370">
            Фактические данные на {{ dt2 }}
          </td>
          <td class="colspan" colspan="1" style="background: #12135C">
            Отклон. Qн
          </td>
          <td class="colspan" colspan="1" style="background: #12135C">
            Технологические
          </td>
          <td class="colspan" colspan="3" style="background: #12135C">
            Геологические
          </td>
          <td rowspan="3" style="background: #12135C
; min-width:248px;">
            <span>Основное отклонение в ТР</span>
          </td>
        </tr>
        <tr class="headerColumn">
          <td rowspan="2" style="background: #2c3379"><span>Qж</span></td>
          <td rowspan="2" style="background: #2c3379"><span>Qн</span></td>
          <td rowspan="2" style="background: #2c3379">
            <span>Обводненность</span>
          </td>
          <td rowspan="2" style="background: #2c3379"><span>Pзаб</span></td>
          <td rowspan="2" style="background: #2c3379"><span>Pпл</span></td>
          <td rowspan="2" style="background: #2c3379"><span>Кпрод</span></td>
          <td rowspan="2" style="background: #1a2370"><span>Qж</span></td>
          <td rowspan="2" style="background: #1a2370"><span>Qн</span></td>
          <td rowspan="2" style="background: #1a2370">
            <span>Обводненность</span>
          </td>
          <td rowspan="2" style="background: #1a2370"><span>Pзаб</span></td>
          <td rowspan="2" style="background: #1a2370"><span>Pпл</span></td>
          <td rowspan="2" style="background: #1a2370"><span>Кпрод</span></td>
          <td rowspan="2" style="background: #12135C"><span>dQн</span></td>
          <td rowspan="2" style="background: #12135C">
            <span>Недостижение режимного Pзаб</span>
          </td>
          <td rowspan="2" style="background: #12135C">
            <span>Рост обводненности</span>
          </td>
          <td rowspan="2" style="background: #12135C">
            <span>Снижение Pпл</span>
          </td>
          <td rowspan="2" style="background: #12135C">
            <span>Снижение Kпрод</span>
          </td>
        </tr>
        <tr></tr>
        <tr class="subHeaderColumn" style="cursor: pointer">
          <!-- <td @click="sortBy('well')" style="background: #12135c">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('field')" style="background: #12135c">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('horizon')" style="background: #12135c">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('exp_meth')" style="background: #12135c">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('q_l_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>м3/сут
          </td>
          <td @click="sortBy('q_o_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>м3/сут
          </td>
          <td @click="sortBy('wct_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('bhp_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>ат
          </td>
          <td @click="sortBy('p_res_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>ат
          </td>
          <td @click="sortBy('pi_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>м3/сут/ат
          </td>
          <td @click="sortBy('q_l_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>м3/сут
          </td>
          <td @click="sortBy('q_o_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>м3/сут
          </td>
          <td @click="sortBy('wct_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('bhp_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>ат
          </td>
          <td @click="sortBy('p_res_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>ат
          </td>
          <td @click="sortBy('pi_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>м3/сут/ат
          </td>
          <td @click="sortBy('dqn')" style="background: #e50303">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('Pbh')" style="background: #f08143">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('wct')" style="background: #4fb26a">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('p_res')" style="background: #4fb26a">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('PI')" style="background: #4fb26a">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('Main_problem')" style="background: #272953">
            <i class="fa fa-fw fa-sort"></i>
          </td> -->
          <td @click="sortBy('well')"  style="background: #12135c" class="sortik">
            <!-- <i class="fas fa-sort-down" v-if="issorttobig"></i>
            <i class="fas fa-sort-up" v-if="!issorttobig"></i> -->
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('field')" style="background: #12135c; min-width: 120px;">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('horizon')" style="background: #12135c">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('object')" style="background: #12135c">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('exp_meth')" style="background: #12135c">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td @click="sortBy('q_l_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>м3/сут
          </td>
          <td @click="sortBy('q_o_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('wct_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>%
          </td>
          <td @click="sortBy('bhp_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td @click="sortBy('p_res_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td @click="sortBy('pi_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>т/сут/атм
          </td>
          <td @click="sortBy('q_l_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>м3/сут
          </td>
          <td @click="sortBy('q_o_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('wct_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>%
          </td>
          <td @click="sortBy('bhp_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td @click="sortBy('p_res_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td @click="sortBy('pi_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>т/сут/атм
          </td>
          <td @click="sortBy('dqn')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('Pbh')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('wct')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('p_res')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('PI')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>т/сут
          </td>
          <td @click="sortBy('Main_problem')" style="background: #12135C; min-width:248px;">
            <i class="fa fa-fw fa-sort"></i>
          </td>
        </tr>
        <tr v-for="(row, row_index) in wells" :key="row.well">
          <td style="background: #12135c">{{ row.well }}</td>
          <td style="background: #12135c; min-width: 120px;">{{ row.field }}</td>
          <td style="background: #12135c">{{ row.horizon }}</td>
          <td style="background: #12135c">{{ row.object }}</td>
          <td style="background: #12135c">{{ row.exp_meth }}</td>

          <td
            style="background: #2c3379"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].q_l_1[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_l_1[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].q_l_1[1][0]
              )}`"
            >
            </span>
            <span v-if="row.q_l_1[0] != null">{{
              Math.round(row.q_l_1[0] * 10) / 10
            }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].q_l_1[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.q_o_1*10)/10}}</td> -->
          <td
            style="background: #2c3379"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].q_o_1[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_o_1[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].q_o_1[1][0]
              )}`"
            >
            </span>
            <span v-if="row.q_o_1[0] != null">{{ Math.round(row.q_o_1[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].q_o_1[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.wct_1*10)/10}}</td> -->
          <td
            style="background: #2c3379"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].wct_1[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].wct_1[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].wct_1[1][0]
              )}`"
            >
            </span>
            <span v-if="row.wct_1[0] != null">{{ Math.round(row.wct_1[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].wct_1[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.bhp_1*10)/10}}</td> -->
          <td
            style="background: #2c3379"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].bhp_1[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bhp_1[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].bhp_1[1][0]
              )}`"
            >
            </span>
            <span  v-if="row.bhp_1[0] != null">{{ Math.round(row.bhp_1[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].bhp_1[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.p_res_1*10)/10}}</td> -->
          <td
            style="background: #2c3379"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].p_res_1[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_res_1[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].p_res_1[1][0]
              )}`"
            >
            </span>
            <span v-if="row.p_res_1[0] != null">{{ Math.round(row.p_res_1[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].p_res_1[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.pi_1*10)/10}}</td> -->
          <td
            style="background: #2c3379"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].pi_1[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pi_1[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].pi_1[1][0])}`"
            >
            </span>
            <span v-if="row.pi_1[0] != null">{{ Math.round(row.pi_1[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].pi_1[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.q_l_2*10)/10}}</td> -->
          <td
            style="background: #1a2370"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].q_l_2[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_l_2[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].q_l_2[1][0]
              )}`"
            >
            </span>
            <span v-if="row.q_l_2[0] != null">{{ Math.round(row.q_l_2[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].q_l_2[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.q_o_2*10)/10}}</td> -->
          <td
            style="background: #1a2370"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].q_o_2[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].q_o_2[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].q_o_2[1][0]
              )}`"
            >
            </span>
            <span v-if="row.q_o_2[0] != null">{{ Math.round(row.q_o_2[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].q_o_2[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.wct_2*10)/10}}</td> -->
          <td
            style="background: #1a2370"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].wct_2[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].wct_2[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].wct_2[1][0]
              )}`"
            >
            </span>
            <span v-if="row.wct_2[0] != null">{{ Math.round(row.wct_2[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].wct_2[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.bhp_2*10)/10}}</td> -->
          <td
            style="background: #1a2370"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].bhp_2[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].bhp_2[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].bhp_2[1][0]
              )}`"
            >
            </span>
            <span v-if="row.bhp_2[0] != null">{{ Math.round(row.bhp_2[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].bhp_2[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.p_res_2*10)/10}}</td> -->
          <td
            style="background: #1a2370"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].p_res_2[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].p_res_2[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].p_res_2[1][0]
              )}`"
            >
            </span>
            <span v-if="row.p_res_2[0] != null">{{ Math.round(row.p_res_2[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].p_res_2[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.pi_2*10)/10}}</td> -->
          <td
            style="background: #1a2370"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].pi_2[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].pi_2[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].pi_2[1][0])}`"
            >
            </span>
            <span v-if="row.pi_2[0] != null">{{ Math.round(row.pi_2[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].pi_2[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.dqo*10)/10}}</td> -->
          <!-- :style="`background :${Two(Math.round(row.dqo*10)/10)}`" -->
          <!-- <td
                        :style="{
                            background: getColorone(Math.round(row.dqn*10)/10),
                        }"
                    >
                        <span> {{Math.round(row.dqn*10)/10}} </span>
                    </td> -->

          <td
            :style="{
              background: getColorone(Math.round(row.dqn[0] * 10) / 10),
            }"
            :class="{
              'cell-with-comment':
                wells && wells[row_index] && wells[row_index].dqn[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].dqn[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].dqn[1][0])}`"
            >
            </span>
            <span v-if="row.dqn[0] != null">{{ Math.round(row.dqn[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].dqn[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.Pbh*10)/10}}</td> -->
          <!-- <td :style="`background :${getColor(
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.wct*10)/10,
                        Math.round(row.p_res*10)/10,
                        Math.round(row.PI*10)/10)}`">
                        <span> {{Math.round(row.Pbh*10)/10}} </span>
                    </td> -->
          <td
            :style="`background :${getColor(
              Math.round(row.Pbh[0] * 10) / 10,
              Math.round(row.wct[0] * 10) / 10,
              Math.round(row.p_res[0] * 10) / 10,
              Math.round(row.PI[0] * 10) / 10
            )}`"
            :class="{
              'cell-with-comment':
                wells && wells[row_index] && wells[row_index].Pbh[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].Pbh[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].Pbh[1][0])}`"
            >
            </span>
            <span v-if="row.Pbh[0] != null">{{ Math.round(row.Pbh[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].Pbh[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
          <!-- <td :style="`background :${getColor(
                        Math.round(row.wct*10)/10,
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.p_res*10)/10,
                        Math.round(row.PI*10)/10)}`">
                        <span> {{Math.round(row.wct*10)/10}} </span>
                    </td> -->
          <td
            :style="`background :${getColor(
              Math.round(row.wct[0] * 10) / 10,
              Math.round(row.Pbh[0] * 10) / 10,
              Math.round(row.p_res[0] * 10) / 10,
              Math.round(row.PI[0] * 10) / 10
            )}`"
            :class="{
              'cell-with-comment':
                wells && wells[row_index] && wells[row_index].wct[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].wct[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].wct[1][0])}`"
            >
            </span>
            <span v-if="row.wct[0] != null">{{ Math.round(row.wct[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].wct[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.p_res*10)/10}}</td> -->
          <!-- <td :style="`background :${getColor(
                        Math.round(row.p_res*10)/10,
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.wct*10)/10,
                        Math.round(row.PI*10)/10)}`">
                        <span> {{Math.round(row.p_res*10)/10}} </span>
                    </td> -->
          <td
            :style="`background :${getColor(
              Math.round(row.p_res[0] * 10) / 10,
              Math.round(row.Pbh[0] * 10) / 10,
              Math.round(row.wct[0] * 10) / 10,
              Math.round(row.PI[0] * 10) / 10
            )}`"
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
              :style="`background :${getColorTwo(
                wells[row_index].p_res[1][0]
              )}`"
            >
            </span>
            <span v-if="row.p_res[0] != null">{{ Math.round(row.p_res[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].p_res[1][1] }}
            </span>
          </td>

          <!-- <td :style="`background :${getColor(
                        Math.round(row.PI*10)/10,
                        Math.round(row.Pbh*10)/10,
                        Math.round(row.wct*10)/10,
                        Math.round(row.p_res*10)/10)}`">
                        <span> {{Math.round(row.PI*10)/10}} </span>
                    </td> -->
          <td
            :style="`background :${getColor(
              Math.round(row.PI[0] * 10) / 10,
              Math.round(row.Pbh[0] * 10) / 10,
              Math.round(row.wct[0] * 10) / 10,
              Math.round(row.p_res[0] * 10) / 10
            )}`"
            :class="{
              'cell-with-comment':
                wells && wells[row_index] && wells[row_index].PI[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].PI[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].PI[1][0])}`"
            >
            </span>
            <span v-if="row.PI[0] != null">{{ Math.round(row.PI[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].PI[1][1] }}
            </span>
          </td>

          <!-- <td>{{Math.round(row.PI*10)/10}}</td> -->
          <!-- <td>{{row.Main_problem}}</td> -->
          <td
            style="background: #12135C; min-width:248px;"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].Main_problem[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].Main_problem[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].Main_problem[1][0]
              )}`"
            >
            </span>
            <span>{{ row.Main_problem[0] }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].Main_problem[1][1] }}
            </span>
          </td>
        </tr>
      </table>
    </div>
    <notifications position="top"></notifications>
  </div>
</template>
<script>
import NotifyPlugin from "vue-easy-notify";
import "vue-easy-notify/dist/vue-easy-notify.css";
import { VueMomentLib } from "vue-moment-lib";
import moment from "moment";
import Vue from "vue";
import SearchFormRefresh from "../ui-kit/SearchFormRefresh.vue";
import columnSortable from 'vue-column-sortable'
// import FadeLoader from "vue-spinner/src/FadeLoader.vue";

Vue.use(NotifyPlugin, VueMomentLib);
export default {
  name: "FaPage",
  components: {
    // FadeLoader,
    SearchFormRefresh,
  },
  data: function () {
    return {
      // issorttobig: false,
      pieChartRerender: true,
      wells: [],
      searchString: "",
      searched: false,
      sortParam: "",
      sortType: "asc",
      dt: null,
      dt2: null,
      date1: null,
      date2: null,
      fullWells: [],
      filter: "Все месторождения",
      editdtm: null,
      editdty: null,
      editdtprevm: null,
      editdtprevy: null,
      // isloading: true,
      chartBarOptions: {
        chart: {
          height: 350,
          type: "bar",
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: "bottom", // top, center, bottom
            },
          },
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: "12px",
            colors: ["#304758"],
          },
        },

        xaxis: {
          categories: [
            "Недостижение режимного Pзаб",
            "Рост обводненности",
            "Снижение Pпл",
            "Снижение Kпрод",
          ],
          position: "bottom",
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          crosshairs: {
            fill: {
              type: "gradient",
              gradient: {
                colorFrom: "#D8E3F0",
                colorTo: "#BED1E6",
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              },
            },
          },
          tooltip: {
            enabled: true,
          },
        },
        yaxis: {
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: true,
            formatter: function (val) {
              return val;
            },
          },
        },
      },
      chartOptions: {
        labels: [
          "Недостижение режимного Pзаб",
          "Рост обводненности",
          "Снижение Pпл",
          "Снижение Kпрод",
        ],
        chart: {
          type: "pie",
        },
        dataLabels: {
          enabled: false,
        } /*убирается подсветка процентов на круге*/,
        /*tooltip: {
        enabled: false},*/
        legend: {
          show: false,
        } /*убирается навигация рядом с кругом*/,
        colors: ["#330000", "#804d00", "#00004d", "#999900"],
        plotOptions: {
          pie: {
            expandOnClick: true,
          },
        },
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                width: 200,
              },
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
    };
  },
  watch: {
    fullWells() {
      this.chooseField();
    },
  },
  methods: {
    sortBy(type) {
      this.sortParam = type;
      this.$store.commit("fa/SET_SORTTYPE", this.sortType);
      this.$store.commit("fa/SET_SORTPARAM", this.sortParam);
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
    getColorTwo(status) {
      if (status === "1") return "#ff0000";
      return "#ff0000";
    },
    chooseDt() {
      // this.isloading = true;
      const { date1, date2 } = this;
      console.log("dt1-", date1, " dt2-", date2);
      var choosenDt = date1.split("-");
      var choosenSecDt = date2.split("-");
      const mm = choosenDt[1];
      const prMm = choosenSecDt[1];
      const yyyy = choosenDt[0];
      const pryyyy = choosenSecDt[0];
      //   this.$store.commit('fa/SET_MONTH', prMm);
      //   this.$store.commit('fa/SET_YEAR', yyyy);
      //   this.$store.commit('fa/SET_PR_MONTH', prPrMm);
      //   this.$store.commit('fa/SET_PR_YEAR', pryyyy);
      //   console.log('date1', prMm, yyyy, 'date2', prPrMm, pryyyy)
      if (choosenDt[1] <= choosenSecDt[1] && choosenDt[0] === choosenSecDt[0]) {
        Vue.prototype.$notifyError("Дата 2 должна быть меньше чем Дата 1");
      } else {
        this.$store.commit("globalloading/SET_LOADING", true);
        this.$store.commit("fa/SET_MONTH", mm);
        this.$store.commit("fa/SET_YEAR", yyyy);
        this.$store.commit("fa/SET_PR_MONTH", prMm);
        this.$store.commit("fa/SET_PR_YEAR", pryyyy);
        console.log("date1", mm, yyyy, "date2", prMm, pryyyy);
        this.axios
          .get(
            "http://172.20.103.187:7576/api/techregime/factor/" +
              yyyy +
              "/" +
              mm +
              "/" +
              pryyyy +
              "/" +
              prMm +
              "/"
          )
          .then((response) => {
            this.searched = false;
            this.$store.commit("globalloading/SET_LOADING", false);
            
            // this.isloading = false;
            let data = response.data;
            this.editdtm = choosenDt[1];
            this.editdty = choosenDt[0];
            this.editdtprevm = choosenSecDt[1];
            this.editdtprevy = choosenSecDt[0];

            if (data) {
              this.$store.commit("fa/SET_SORTPARAM", "");
              this.$store.commit("fa/SET_SEARCH", "");
              this.sortParam = "";
              this.searchString = "";
              console.log(data);
              this.wells = data.data;
              this.fullWells = data.data;
            } else {
              console.log("No data");
            }
            this.dt = "01" + "." + this.editdtm + "." + this.editdty;
            this.dt2 = "01" + "." + this.editdtprevm + "." + this.editdtprevy;
          });
      }
    },
    chooseField() {
      const { filter, fullWells } = this;
      console.log(filter);
      console.log(fullWells);
      // if (!filter || filter == "Казгермунай") {
      this.$store.commit("fa/SET_FILTER", filter);
      if (!filter || filter == "Все месторождения") {
        this.wells = fullWells;
      } else {
        this.wells = fullWells.filter((e) => e.field === filter);
      }
    },
    pushBign(bign) {
      switch (bign) {
        case "bign1":
          this.params.data = this.wellsList;
          break;
      }
      this.$modal.show(bign);
    },
    // swap() {
    //   this.issorttobig = !this.issorttobig;
    // },
    getColor(status, ...values) {
      if (status < "0" && status === Math.min(status, ...values))
        return "#CD5C5C";
      else {
        return "#12135C";
      }
    },
    getColorone(status) {
      if (status < "0") return "#ac3939";
      else {
        return "#12135C";
      }
    },
    handlerSearch(search) {
      this.searchString = search;
    },
    searchWell() {
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      this.$store.commit("fa/SET_SORTPARAM", "");
      this.sortParam = "";
      const mm = this.$store.getters["fa/month"];
      const prMm = this.$store.getters["fa/prmonth"];
      const yyyy = this.$store.getters["fa/year"];
      const pryyyy = this.$store.getters["fa/pryear"];
      const searchParam = this.searchString
        ? `search/${this.searchString}/`
        : "";
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/factor/" +
            yyyy +
            "/" +
            mm +
            "/" +
            pryyyy +
            "/" +
            prMm +
            "/" +
            searchParam
        )
        .then((response) => {
          this.searched = searchParam ? true : false;
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          console.log("search resp = ", response.data);
          this.$store.commit("fa/SET_SEARCH", this.searchString);
          let data = response.data;
          if (data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
          } else {
            this.wells = [];
            this.fullWells = [];
            console.log("No data");
          }
        })
        .catch((error) => {
          this.searched = searchParam ? true : false;
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isloading = false;
          this.wells = [];
          this.fullWells = [];
          console.log("search error = ", error);
        });
    },
  },
  created: function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    this.$store.commit("fa/SET_SORTTYPE", this.sortType);
    this.$store.commit("fa/SET_SORTPARAM", this.sortParam);
    this.$store.commit("fa/SET_SEARCH", this.searchString);
    this.$store.commit("fa/SET_FILTER", this.filter);
    console.log("dt1-month", this.$store.getters["tr/month"]);
    console.log("dt1-year", this.$store.getters["tr/year"]);
    var today = new Date();
    var dd = 1;
    const mm = this.$store.getters["tr/month"]
      ? this.$store.getters["tr/month"]
      : today.getMonth() + 1;
    var yyyy = this.$store.getters["tr/year"]
      ? this.$store.getters["tr/year"]
      : today.getFullYear();
    var prMm = mm;
    if (mm == 1) {
      var prMm = 12;
      var pryyyy = yyyy - 1;
    } else {
      var prMm = mm - 1;
      var pryyyy = yyyy;
    }
    this.$store.commit("fa/SET_MONTH", mm);
    this.$store.commit("fa/SET_YEAR", yyyy);
    this.$store.commit("fa/SET_PR_MONTH", prMm);
    this.$store.commit("fa/SET_PR_YEAR", pryyyy);
    this.axios
      .get(
        "http://172.20.103.187:7576/api/techregime/factor/" +
          yyyy +
          "/" +
          mm +
          "/" +
          pryyyy +
          "/" +
          prMm +
          "/"
      )
      .then((response) => {
        let data = response.data;
        this.editdtm = mm;
        console.log(this.editdtm);
        this.editdty = yyyy;
        console.log(this.editdty);
        this.editdtprevm = prMm;
        console.log(this.editdtprevm);
        this.editdtprevy = pryyyy;
        console.log(this.editdtprevy);
        this.$store.commit("globalloading/SET_LOADING", false);
        // this.isloading = false;
        if (data) {
          console.log(data);
          this.wells = data.data;
          this.fullWells = data.data;
        } else {
          console.log("No data");
        }
        if (this.editdtm < 10) {
          this.dt = "01" + ".0" + this.editdtm + "." + this.editdty;
        } else {
          this.dt = "01" + "." + this.editdtm + "." + this.editdty;
        }
        if (this.editdtprevm < 10) {
          this.dt2 = "01" + ".0" + this.editdtprevm + "." + this.editdtprevy;
        } else {
          this.dt2 = "01" + "." + this.editdtprevm + "." + this.editdtprevy;
        }
      });
  },
  mounted: function () {
    const mm =
      `${this.$store.getters["fa/month"]}`.length < 2
        ? `0${this.$store.getters["fa/month"]}`
        : `${this.$store.getters["fa/month"]}`;
    const prmm =
      `${this.$store.getters["fa/prmonth"]}`.length < 2
        ? `0${this.$store.getters["fa/prmonth"]}`
        : `${this.$store.getters["fa/prmonth"]}`;
    this.date1 = `${this.$store.getters["fa/year"]}-${mm}-01`;
    this.date2 = `${this.$store.getters["fa/pryear"]}-${prmm}-01`;
    this.dt = `01.${mm}.${this.$store.getters["fa/year"]}`;
    this.dt2 = `01.${prmm}.${this.$store.getters["fa/pryear"]}`;
  },
};
</script>
<style  scoped>
body {
  color: white !important;
}
.but-nav__link {
  font-weight: inherit;
  padding: 5px 15px;
  border-radius: 5px;
  font-family: "Harmonia-sans";
  font-style: normal;
  font-size: 17px;
  color: #ffffff;
  background: #333975;
  border: none !important;
  text-align: left !important;
  cursor: pointer;
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
}
.input-group-prepend {
  padding-top: 3px !important;
  margin-right: -3px !important;
}
.table th,
.table td {
  padding: 5px !important;
}

.farowjustcontbet {
  box-sizing: border box;
  padding-right: 0;
  margin-right: 0;
  margin-left: 0;
  padding-left: 0;
  display: flex;
  margin-bottom: 13px;
}

.fasearch {
  width: 367;
  margin-left: 1px;
}

.trcol {
  padding-right: 0;
}

.table {
  overflow: scroll;
  height: calc(100vh - 205px);
}
.table tr:nth-child(-n+4) td {
  position: sticky;
  background: rgb(51, 57, 117);
  top: 75px;
  z-index: 3000;
}
.table tr:first-child td {
  top: -1;
}
.table tr:nth-child(2) td {
  top: 37px;
}
.table tr:nth-child(3) td {
  top: 38px;
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
.faheadhight {
  height: 40px;
}


.fakrtableborderedtable {
  font-size: 9px;
  padding: unset;
}

/* width */
table::-webkit-scrollbar {
  width: 13px;
}

/* Track */
table::-webkit-scrollbar-track {
  background: #333975;
}

/* Handle */
table::-webkit-scrollbar-thumb {
  background: #656A8A;
}

/* Handle on hover */
table::-webkit-scrollbar-thumb:hover {
  background: #656A8A;

}
/* уголок скролла  */
table::-webkit-scrollbar-corner  {
  background: #333975;
}
.fadropmenu {
width: 70%;
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

/* .sortik[issorttobig="true"]::after {
	content: "▼"
}

.sortik[issorttobig="false"]::after {
	content: "▲"
} */
</style>