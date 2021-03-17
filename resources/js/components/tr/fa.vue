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
        {{trans('tr.btr')}}</a
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
          {{trans('tr.fadt')}}
        </button>

        <div v-if="datepicker1"
          class="dropdown-menu fadropmenu"
          style="background: #40467E; margin-top: 4px;"
          aria-labelledby="dropdownMenuLink"
        >
          <td style="margin-left: 8px; color: white; font-size: large">{{trans('tr.weeklyfa')}}</td>
          <label for="inputDate" style="margin-left: 8px;">{{trans('tr.fadt1')}}:</label>
          <input type="date" class="form-control" v-model="date1" />
          <label for="inputDate" style="margin-left: 8px;">{{trans('tr.fadt2')}}:</label>
          <input type="date" class="form-control" v-model="date2" />
          <a href="#" class="btn btn-sm button_form" @click.prevent="chooseSecDt"
            >{{trans('tr.sf')}}</a
          >

          <a  @click="calendarDynamic" @click.prevent.stop="() => {}" style="padding-top: 5px; cursor: pointer;">
            <svg 
              width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.5 6C0.5 2.96243 2.96243 0.5 6 0.5H26C29.0376 0.5 31.5 2.96243 31.5 6V22C31.5 25.0376 29.0376 27.5 26 27.5H6C2.96243 27.5 0.5 25.0376 0.5 22V6Z" fill="#333975" stroke="#333975"/>
              <path d="M9 14.7282V13.3003C9 10.9807 10.8804 9.10034 13.2 9.10034H22.2999V9.10034" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
              <path d="M20.8997 7L22.9289 9.02927C22.968 9.06832 22.968 9.13164 22.9289 9.17069L20.8997 11.2" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
              <path d="M22.9996 13.2861V14.7141C22.9996 17.0336 21.1192 18.914 18.7996 18.914H9.69971V18.914" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
              <path d="M11.1 21L9.07071 18.9707C9.03166 18.9317 9.03166 18.8684 9.07071 18.8293L11.1 16.8" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
            </svg>

          </a>
        </div>


        <div v-if="datepicker2"
          class="dropdown-menu fadropmenu"
          style="background: #40467E; margin-top: 4px;"
          aria-labelledby="dropdownMenuLink"
        >
          <td style="margin-left: 8px; color: white; font-size: large">{{trans('tr.monthlyfa')}}</td>
          <label for="inputDate" style="margin-left: 8px;">{{trans('tr.fadt1')}}:</label>
          <input type="date" class="form-control" v-model="date1" />
          <label for="inputDate" style="margin-left: 8px;">{{trans('tr.fadt2')}}:</label>
          <input type="date" class="form-control" v-model="date2" />
          <a href="#" class="btn btn-sm button_form" @click.prevent="chooseDt"
            >{{trans('tr.sf')}}</a
          >
          <a  @click="calendarDynamic" @click.prevent.stop="() => {}" style="padding-top: 5px; cursor: pointer;">
            <svg 
              width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.5 6C0.5 2.96243 2.96243 0.5 6 0.5H26C29.0376 0.5 31.5 2.96243 31.5 6V22C31.5 25.0376 29.0376 27.5 26 27.5H6C2.96243 27.5 0.5 25.0376 0.5 22V6Z" fill="#333975" stroke="#333975"/>
              <path d="M9 14.7282V13.3003C9 10.9807 10.8804 9.10034 13.2 9.10034H22.2999V9.10034" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
              <path d="M20.8997 7L22.9289 9.02927C22.968 9.06832 22.968 9.13164 22.9289 9.17069L20.8997 11.2" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
              <path d="M22.9996 13.2861V14.7141C22.9996 17.0336 21.1192 18.914 18.7996 18.914H9.69971V18.914" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
              <path d="M11.1 21L9.07071 18.9707C9.03166 18.9317 9.03166 18.8684 9.07071 18.8293L11.1 16.8" stroke="#D6D7E3" stroke-width="1.4" stroke-linecap="round"/>
            </svg>

          </a>
        </div>
      </div>
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
      <h3 style="margin-left: 14px">{{trans('tr.hfa')}}</h3>
      <tr-multiselect
        :filter="filter"
        :selectedAllTag="true"
        :fieldFilterOptions="fieldFilterOptions"
        @change-filter="handlerFilter"
        filterName="месторождения"
      />
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
      <div v-if= gen_hide>
      <button
            class="trgraph"
            id="bt1"
            @click="swap"
            style="
              background: #272953;
              color: white;
              border: none;
            "
            :title="hide ? trans('tr.trtlp3') : trans('tr.trtlp4')"
            data-toggle="tooltip"
            data-placement="top"
          >
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              v-if="hide"
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
              v-if="!hide"
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
    </div>
    <div style="position: relative">
      <table
        class="table table-bordered table-dark table-responsive fakrtableborderedtable"
        style="background: #0d1e63"
      >
        <tr class="headerColumn">
          <td rowspan="3" style="background: #12135c"><span>{{trans('tr.fa1')}}</span></td>
          <td rowspan="3" style="background: #12135c; min-width: 120px;">
            <span>{{trans('tr.fa2')}}</span>
          </td>
          <td rowspan="3" style="background: #12135c"><span>{{trans('tr.tr3')}}</span></td>
          <td rowspan="3" style="background: #12135c"><span>{{trans('tr.tr4')}}</span></td>
          <td rowspan="3" style="background: #12135c">
            <span>{{trans('tr.tr10')}}</span>
          </td>
          <td v-show= hide class="colspan" :colspan= colsize7 style="background: #2c3379">
            {{trans('tr.fa3')}} {{ dt }}
          </td>
          <td v-show= hide class="colspan" :colspan= colsize7 style="background: #1a2370">
            {{trans('tr.fa3')}} {{ dt2 }}
          </td>
          <td class="colspan" colspan="1" style="background: #12135C">
            {{trans('tr.fa4')}}
          </td>
          <td class="colspan" :colspan= colsize2 style="background: #12135C">
            {{trans('tr.fa5')}}
          </td>
          <td class="colspan" colspan="3" style="background: #12135C">
            {{trans('tr.fa6')}}
          </td>
          <td rowspan="3" style="background: #12135C
; min-width:248px;">
            <span>{{trans('tr.fa7')}}</span>
          </td>
          <td v-if= gen_hide rowspan="3" style="background: #12135C
; min-width:248px;">
            <span>Изменение штуцера</span>
          </td>
          <td v-if= gen_hide rowspan="3" style="background: #12135C
; min-width:248px;">
            <span>Изменения режима работы насоса</span>
          </td>
        </tr>
        <tr class="headerColumn">
          <td v-show= hide rowspan="2" style="background: #2c3379"><span>{{trans('tr.tr22')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #2c3379"><span>{{trans('tr.tr21')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #2c3379">
            <span>{{trans('tr.tr23')}}</span>
          </td>
          <td v-show= hide rowspan="2" style="background: #2c3379"><span>{{trans('tr.tr20')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #2c3379"><span>{{trans('tr.tr14')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #2c3379"><span>{{trans('tr.tr26')}}</span></td>
          <td v-if= gen_hide v-show= hide rowspan="2" style="background: #2c3379"><span>Отр. дни</span></td>
          <td v-show= hide rowspan="2" style="background: #1a2370"><span>{{trans('tr.tr22')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #1a2370"><span>{{trans('tr.tr21')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #1a2370">
            <span>{{trans('tr.tr23')}}</span>
          </td>
          <td v-show= hide rowspan="2" style="background: #1a2370"><span>{{trans('tr.tr20')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #1a2370"><span>{{trans('tr.tr14')}}</span></td>
          <td v-show= hide rowspan="2" style="background: #1a2370"><span>{{trans('tr.tr26')}}</span></td>
          <td v-if= gen_hide v-show= hide rowspan="2" style="background: #1a2370"><span>Отр. дни</span></td>
          <td rowspan="2" style="background: #12135C"><span>{{trans('tr.fa8')}}</span></td>
          <td rowspan="2" style="background: #12135C">
            <span>{{trans('tr.fa9')}}</span>
          </td>
          <td v-if= gen_hide rowspan="2" style="background: #12135C">
            <span>Коэффициент эксплуатации</span>
          </td>
          <td rowspan="2" style="background: #12135C">
            <span>{{trans('tr.fa10')}}</span>
          </td>
          <td rowspan="2" style="background: #12135C">
            <span>{{trans('tr.fa11')}}</span>
          </td>
          <td rowspan="2" style="background: #12135C">
            <span>{{trans('tr.trs58')}}</span>
          </td>

        </tr>
        <tr></tr>
        <tr class="subHeaderColumn" style="cursor: pointer">
           <td @click="sortBy('rus_wellname')"  style="background: #12135c" class="sortik">
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
          <td v-show= hide @click="sortBy('q_l_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
          </td>
          <td v-show= hide @click="sortBy('q_o_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td v-show= hide @click="sortBy('wct_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>%
          </td>
          <td v-show= hide @click="sortBy('bhp_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td v-show= hide @click="sortBy('p_res_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td v-show= hide @click="sortBy('pi_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtrfa1')}}
          </td>
          <td v-if= gen_hide v-show= hide @click="sortBy('prod_days_1')" style="background: #2c3379">
            <i class="fa fa-fw fa-sort"></i>сут
          </td>
          <td v-show= hide @click="sortBy('q_l_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr2')}}
          </td>
          <td v-show= hide @click="sortBy('q_o_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td v-show= hide @click="sortBy('wct_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>%
          </td>
          <td v-show= hide @click="sortBy('bhp_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td v-show= hide @click="sortBy('p_res_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>атм
          </td>
          <td v-show= hide @click="sortBy('pi_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtrfa1')}}
          </td>
          <td v-if= gen_hide v-show= hide @click="sortBy('prod_days_2')" style="background: #1a2370">
            <i class="fa fa-fw fa-sort"></i>сут
          </td>
          <td @click="sortBy('dqn')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td @click="sortBy('Pbh')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td v-if= gen_hide @click="sortBy('prod_days')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td @click="sortBy('wct')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td @click="sortBy('p_res')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td @click="sortBy('PI')" style="background: #12135C">
            <i class="fa fa-fw fa-sort"></i>{{trans('tr.mtr3')}}
          </td>
          <td @click="sortBy('Main_problem')" style="background: #12135C; min-width:248px;">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td v-if= gen_hide @click="sortBy('choke_d_diff')" style="background: #12135C; min-width:248px;">
            <i class="fa fa-fw fa-sort"></i>
          </td>
          <td v-if= gen_hide @click="sortBy('freq_diff')" style="background: #12135C; min-width:248px;">
            <i class="fa fa-fw fa-sort"></i>
          </td>
        </tr>
        <tr v-for="(row, row_index) in wells" :key="row.well">
          <td style="background: #12135c">{{ row.rus_wellname }}</td>
          <td style="background: #12135c; min-width: 120px;">{{ row.field }}</td>
          <td style="background: #12135c">{{ row.horizon }}</td>
          <td style="background: #12135c">{{ row.object }}</td>
          <td style="background: #12135c">{{ row.exp_meth }}</td>

          <td v-show= hide
            style="background: #2c3379;"
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

          <td v-show= hide
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

          <td v-show= hide
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

          <td v-show= hide
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

          <td v-show= hide
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

          <td v-show= hide
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

          <td v-if= gen_hide v-show= hide
            style="background: #2c3379"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].prod_days_1[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].prod_days_1[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].prod_days_1[1][0])}`"
            >
            </span>
            <span v-if="row.prod_days_1[0] != null">{{ Math.round(row.prod_days_1[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].prod_days_1[1][1] }}
            </span>
          </td>
          <td v-show= hide
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

          <td v-show= hide
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

          <td v-show= hide
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
          <td v-show= hide
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

          <td v-show= hide
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

          <td v-show= hide
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

          <td v-if= gen_hide v-show= hide
            style="background: #1a2370"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].prod_days_2[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].prod_days_2[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].prod_days_2[1][0])}`"
            >
            </span>
            <span v-if="row.prod_days_2[0] != null">{{ Math.round(row.prod_days_2[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].prod_days_2[1][1] }}
            </span>
          </td>

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

          <td
            :style="`background :${getColor(
              Math.round(row.Pbh[0] * 10) / 10,
              Math.round(row.prod_days[0] * 10) / 10,
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


          <td v-if= gen_hide
            :style="`background :${getColor(
              Math.round(row.prod_days[0] * 10) / 10,
              Math.round(row.Pbh[0] * 10) / 10,
              Math.round(row.wct[0] * 10) / 10,
              Math.round(row.p_res[0] * 10) / 10,
              Math.round(row.PI[0] * 10) / 10
            )}`"
            :class="{
              'cell-with-comment':
                wells && wells[row_index] && wells[row_index].prod_days[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].prod_days[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(wells[row_index].prod_days[1][0])}`"
            >
            </span>
            <span v-if="row.prod_days[0] != null">{{ Math.round(row.prod_days[0] * 10) / 10 }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].prod_days[1][1] }}
            </span>
          </td>


          <td
            :style="`background :${getColor(
              Math.round(row.wct[0] * 10) / 10,
              Math.round(row.prod_days[0] * 10) / 10,
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

          <td
            :style="`background :${getColor(
              Math.round(row.p_res[0] * 10) / 10,
              Math.round(row.prod_days[0] * 10) / 10,
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

          <td
            :style="`background :${getColor(
              Math.round(row.PI[0] * 10) / 10,
              Math.round(row.Pbh[0] * 10) / 10,
              Math.round(row.prod_days[0] * 10) / 10,
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


          <td v-if= gen_hide
            style="background: #12135C; min-width:248px;"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].choke_d_diff[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].choke_d_diff[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].choke_d_diff[1][0]
              )}`"
            >
            </span>
            <span>{{ row.choke_d_diff[0] }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].choke_d_diff[1][1] }}
            </span>
          </td>

          <td v-if= gen_hide
            style="background: #12135C; min-width:248px;"
            :class="{
              'cell-with-comment':
                wells &&
                wells[row_index] &&
                wells[row_index].freq_diff[1][0] !== '0',
            }"
          >
            <span
              :class="{
                'circle-err':
                  wells &&
                  wells[row_index] &&
                  wells[row_index].freq_diff[1][0] !== '0',
              }"
              :style="`background :${getColorTwo(
                wells[row_index].freq_diff[1][0]
              )}`"
            >
            </span>
            <span>{{ row.freq_diff[0] }}</span>
            <span v-if="wells && wells[row_index]" class="cell-comment">
              {{ wells[row_index].freq_diff[1][1] }}
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
import { fields } from "./constants.js";
import TrMultiselect from "./TrMultiselect.vue";

Vue.use(NotifyPlugin, VueMomentLib);
export default {
  name: "FaPage",
  components: {
    // FadeLoader,
    SearchFormRefresh,
    TrMultiselect,
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
      is_dynamic:true,
      colsize7: null,
      colsize2: null,
      filter: [...fields],
      fieldFilterOptions: [
        {
          group: "Все месторождения",
          fields: [...fields],
        },
      ],
      editdtm: null,
      editdty: null,
      editdtprevm: null,
      editdtprevy: null,
      hide: false,
      gen_hide: true,
      datepicker1: true,
      datepicker2: false,
      wdate2: null,
      wdate1: null,
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
    filter() {
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
    chooseSecDt() {
      const { date1, date2 } = this;
      var dynamic_date = date1.split("-");
      var prdynamic_date = date2.split("-");
      const dd = dynamic_date[2];
      const mm = dynamic_date[1];
      const yyyy = dynamic_date[0];
      const prdd = prdynamic_date[2];
      const prmm = prdynamic_date[1];
      const pryyyy = prdynamic_date[0];
      this.is_dynamic = true;
      this.gen_hide = true;
      this.$store.commit("fa/SET_IS_DYNAMIC", true);
      this.$store.commit("globalloading/SET_LOADING", true);
      this.$store.commit("fa/SET_MONTH", mm);
      this.$store.commit("fa/SET_YEAR", yyyy);
      this.$store.commit("fa/SET_PR_MONTH", prmm);
      this.$store.commit("fa/SET_PR_YEAR", pryyyy);
      this.$store.commit("fa/SET_DAY", dd);
      this.$store.commit("fa/SET_PR_DAY", prdd);
      this.$store.commit("fa/SET_GEN_HIDE", true);
      this.axios
      .get(
        "http://172.20.103.187:7576/api/techregime/factor_weekly/" +
          yyyy +
          "/" +
          mm +
          "/" +
          dd +
          "/" +
          pryyyy +
          "/" +
          prmm +
          "/" +
          prdd +
          "/"
        )
        .then((response) => {
          this.searched = false;
          this.$store.commit("globalloading/SET_LOADING", false);   
          let data = response.data;
          if (data) {
            this.$store.commit("fa/SET_SORTPARAM", "");
            this.$store.commit("fa/SET_SEARCH", "");
            this.sortParam = "";
            this.searchString = "";
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
            this.hide = false;
            this.gen_hide= true;
            this.colsize7= 7;
            this.colsize2= 2;
          } else {
            console.log("No data");
          }
            this.dt = dd + "." + mm + "." + yyyy;
            this.dt2 = prdd + "." + prmm + "." + pryyyy;
        });
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
      if (choosenDt[1] <= choosenSecDt[1] && choosenDt[0] === choosenSecDt[0]) {
        Vue.prototype.$notifyError("Дата 2 должна быть меньше чем Дата 1");
      } else {
        this.$store.commit("globalloading/SET_LOADING", true);
        this.$store.commit("fa/SET_MONTH", mm);
        this.$store.commit("fa/SET_YEAR", yyyy);
        this.$store.commit("fa/SET_PR_MONTH", prMm);
        this.$store.commit("fa/SET_PR_YEAR", pryyyy);
        this.$store.commit("fa/SET_IS_DYNAMIC", false);
        this.$store.commit("fa/SET_COLSIZE7", 6);
        this.$store.commit("fa/SET_COLSIZE2", 1);
        this.$store.commit("fa/SET_GEN_HIDE", false);
        this.$store.commit("fa/SET_HIDE", false);
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
            this.is_dynamic = false;
            this.gen_hide = false;
            this.hide = true;

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
            this.gen_hide= false;
            this.colsize7= 6;
            this.colsize2= 1;
          });
      }
    },
    chooseField() {
      const { filter, fullWells } = this;
      console.log("filter = ", filter);
      console.log(fullWells);
      this.$store.commit("fa/SET_FILTER", filter);
      if (!filter) {
        this.wells = fullWells;
      } else {
        this.wells = fullWells.filter((e) => filter.indexOf(e.field) !== -1);
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
    handlerFilter(filter) {
      this.filter = filter;
    },
    swap() {
      this.hide = !this.hide;

    },
    calendarDynamic() {
      this.is_dynamic_calendar = !this.is_dynamic_calendar
      this.datepicker1 = !this.datepicker1
      this.datepicker2 = !this.datepicker2
    },
    searchWell() {
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isloading = true;
      this.$store.commit("fa/SET_SORTPARAM", "");
      this.sortParam = "";
      const mm = this.$store.getters["fa/month"];
      const prMm = this.$store.getters["fa/prmonth"];
      const dd = this.$store.getters["fa/day"];
      const yyyy = this.$store.getters["fa/year"];
      const pryyyy = this.$store.getters["fa/pryear"];
      const prdd = this.$store.getters["fa/prday"];
      const dynamic = this.$store.getters["fa/is_dynamic"];
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
            dd + 
            "/" +
            pryyyy +
            "/" +
            prMm +
            "/" +
            prdd +
            "/" + 
            dynamic +
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
          if (dynamic == true){
            this.hide = false;
            this.gen_hide= true;
            this.colsize7= 7;
            this.colsize2= 2;
          }
          else {
            this.hide = true;
            this.gen_hide= false;
            this.colsize7= 6;
            this.colsize2= 1;          
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
    this.$store.commit("globalloading/SET_LOADING", false); //исправить на true
    this.$store.commit("fa/SET_SORTTYPE", this.sortType);
    this.$store.commit("fa/SET_SORTPARAM", this.sortParam);
    this.$store.commit("fa/SET_SEARCH", this.searchString);
    this.$store.commit("fa/SET_FILTER", this.filter);
    var wdate2 = new Date();
    this.wdate2 = wdate2.setDate(wdate2.getDate()-7);
    this.wdate2 = wdate2.toLocaleDateString();
    var dynamic_date2 = this.wdate2.split(".");
    const prdd = dynamic_date2[0];
    const prmm = dynamic_date2[1];
    const pryyyy = dynamic_date2[2];
    this.is_dynamic = true;
    var wdate1 = new Date();
    this.wdate1 = wdate1.setDate(wdate1.getDate());
    this.wdate1 = wdate1.toLocaleDateString();
    var dynamic_date1 = this.wdate1.split(".");
    const dd = dynamic_date1[0];
    const mm = dynamic_date1[1];
    const yyyy = dynamic_date1[2];
    this.gen_hide= true;
    this.colsize7 = 7
    this.colsize2 = 2;
    var weekd1 = yyyy + "-" + mm + "-" + dd;
    var weekd2 = pryyyy + "-" + prmm + "-" + prdd;
    this.$store.commit("fa/SET_IS_DYNAMIC", true);
    this.$store.commit("fa/SET_MONTH", mm);
    this.$store.commit("fa/SET_YEAR", yyyy);
    this.$store.commit("fa/SET_DAY", dd);
    this.$store.commit("fa/SET_PR_MONTH", prmm);
    this.$store.commit("fa/SET_PR_YEAR", pryyyy);
    this.$store.commit("fa/SET_PR_DAY", prdd);
    this.axios
      .get(
        "http://172.20.103.187:7576/api/techregime/factor_weekly/" +
          yyyy +
          "/" +
          mm +
          "/" +
          dd +
          "/" +
          pryyyy +
          "/" +
          prmm +
          "/" +
          prdd +
          "/"
      )
      .then((response) => {
        let data = response.data;
        this.$store.commit("globalloading/SET_LOADING", false);
        // this.isloading = false;
        if (data) {
          console.log(data);
          this.wells = data.data;
          this.fullWells = data.data;
          this.dt2 = this.wdate2;
          this.dt = this.wdate1;
          this.date1 = weekd1;
          this.date2 = weekd2;
        } else {
          console.log("No data");
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
#app .multiselect {
  max-width: 300px;
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
  margin: 0;
}
.table tr:nth-child(-n + 4) td {
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
table::-webkit-scrollbar-corner {
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

}


</style>