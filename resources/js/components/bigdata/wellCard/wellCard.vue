<template>
  <div class="all-contents">
    <div class="well-card_tab-head d-flex" :style="{ width: tabWidth + 'px' }">
      <div
        v-for="(well, index) in wellsHistory"
        :key="index"
        :class="
          wellUwi === well.wellUwi
            ? 'well-card_tab-head__item selected-well col-2'
            : 'well-card_tab-head__item col-2'
        "
      >
        <div @click="handleSelectHistoryWell(well)">
          {{ well.wellUwi }}
          {{ well.lastFormInfo ? " | " + well.lastFormInfo.name : "" }}
        </div>
        <span
          class="well-card_tab-head__item--close"
          @click="handleDeleteWell(index)"
          v-if="wellsHistory.length > 1"
        ></span>
      </div>
    </div>
    <div class="well-card__wrapper">
      <div
        :class="{ 'left-column_folded': isLeftColumnFolded }"
        class="left-column"
      >
        <div class="well-deal__header">
          {{ this.trans("well.case_well") }}
        </div>
        <div class="directory text-white bg-dark">
          <ul id="myUL">
            <well-card-tree
              v-for="(item, index) in formsStructure"
              :key="index"
              :active-form-code="activeForm ? activeForm.code : null"
              :data="item"
              :switch-form-by-code="switchFormByCode"
            >
            </well-card-tree>
          </ul>
        </div>
        <div v-if="isLeftColumnFolded" class="left-text">
          <div class="rotate" style="color: white">
            {{ this.trans("well.well_passport") }}
          </div>
        </div>
        <div class="icon-all" @click="onColumnFoldingEvent('left')">
          <svg
            width="7"
            height="13"
            viewBox="0 0 7 13"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6 12L1.03149 6.58081C0.989503 6.53506 0.989503 6.46488 1.03149 6.41881L6 1"
              stroke="white"
              stroke-width="2"
              stroke-miterlimit="22.9256"
              stroke-linecap="round"
            />
          </svg>
        </div>
      </div>
      <div
        :class="{
          'right-column_folded': isRightColumnFolded,
          'both-pressed_folded':
            isBothColumnFolded &&
            !isInjectionWellsHistoricalVisible &&
            !isProductionWellsHistoricalVisible,
        }"
        class="right-column__inner bg-dark"
        style="display: none"
      ></div>
      <div
        :class="[
          isInjectionWellsHistoricalVisible ||
          isProductionWellsHistoricalVisible
            ? 'fixed-mid-col'
            : 'mid-col',
          'col-md-6',
        ]"
      >
        <div
          class="row mid-col__main"
          ref="tableResize"
          :class="{
            min_history_table: isLeftColumnFolded || isRightColumnFolded,
            small_history_table: isBothColumnFolded,
          }"
        >
          <div class="col-md-12 mid-col__main-inner bg-dark-transparent">
            <div
              :class="[
                getWidthByColumns(),
                'middle-block-head d-flex well-info_header bg-dark-transparent',
              ]"
            >
              <div class="transparent-select">
                {{ this.trans("well.well") }}:
                <span v-if="wellUwi">{{ wellUwi }}</span>
                <svg
                  data-v-5d3113ed=""
                  fill="none"
                  height="8"
                  viewBox="0 0 14 8"
                  width="14"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    data-v-5d3113ed=""
                    d="M1 1L7 7L13 1"
                    stroke="white"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.6"
                  ></path>
                </svg>
              </div>
              <form class="search-form d-flex align-items-center">
                <select
                  class="select-dzo mr-2"
                  v-if="dzoSelectOptions.length > 0"
                  @change="dzoSelectChange($event)"
                >
                  <option value="0" selected>
                    {{ this.trans("well.all_dzo") }}
                  </option>
                  <option
                    v-for="(dzoSelectOption, index) in dzoSelectOptions"
                    :key="index"
                    :value="dzoSelectOption['id']"
                  >
                    {{ dzoSelectOption["name"] }}
                  </option>
                </select>
                <v-select
                  class="flex-fill"
                  :filterable="false"
                  :options="options"
                  :placeholder="this.trans('well.number_well')"
                  @input="selectWell"
                  @search="onSearch"
                >
                  <template slot="option" slot-scope="option">
                    <span>{{ option.name }}</span>
                  </template>
                </v-select>
              </form>
              <div
                v-if="
                  measurementScheduleForms.includes(activeFormComponentName)
                "
                class="button-block mr-3"
              >
                <div
                  class="p-1 ml-2 d-flex align-items-center"
                  @mouseover="isOpen = true"
                  @mouseleave="isOpen = false"
                >
                  <img class="pr-1" src="/img/icons/help.svg" alt="" />
                  <a class="text-white cursor-pointer">Легенда</a>
                </div>
                <div class="p-1 ml-2 d-flex align-items-center">
                  <img class="pr-1" src="/img/icons/chart.svg" alt="" />
                  <a
                    class="text-white cursor-pointer"
                    @click="$refs.childForm.switchChartVisibility()"
                    >Показать график
                  </a>
                </div>
<<<<<<< HEAD
                <div
                  class="modal-show"
                  v-show="isOpen === true"
                  @mouseover="isOpen = true"
                >
                  <div class="modal_show_item">
                    <img
                      class="modal_show_img"
                      src="/img/bd/orange-circle-icon.png"
                    />
                    <span class="legenda_text">Отклонение от тех. режима</span>
                  </div>
                  <div class="modal_show_item">
                    <img class="modal_show_img" src="/img/bd/circle-red.png" />
                    <span class="legenda_text">В простое</span>
                  </div>
=======
                <div class="modal-show" v-show="isOpen === true" @mouseleave="isOpen = false">
                      <div class="modal_show_item">
                        <img class="modal_show_img" src="/img/bd/orange-circle-icon.png"/>
                          <span class="legenda_text">Отклонение от тех. режима</span>
                      </div>
                      <div class="modal_show_item">
                        <img class="modal_show_img" src="/img/bd/circle-red.png">
                          <span class="legenda_text">В простое</span>
                      </div>
>>>>>>> 119239c72654aaad1a4f33b1dd72c747ba5447eb
                </div>
                <div
                  v-if="
                    !isProductionWellsHistoricalVisible &&
                    !isInjectionWellsHistoricalVisible
                  "
                  class="p-1 ml-2 d-flex align-items-center"
                >
                  <img class="pr-1" src="/img/bd/historical_icon.svg" alt="" />
                  <a
                    class="text-white cursor-pointer"
                    @click="
                      [
                        activeFormComponentName ===
                        'ProductionWellsScheduleMain'
                          ? SET_VISIBLE_PRODUCTION(true)
                          : SET_VISIBLE_INJECTION(true),
                        changeColumnsVisible(false),
                      ]
                    "
                  >
                    Исторические сведения
                  </a>
                </div>
                <button
                  type="button"
                  data-toggle="dropdown"
                  class="icon-filter"
                ></button>
                <div>
                  <ul
                    class="
                      dropdown-menu dropdown-menu-right dropdown-position
                      mt-1
                      p-1
                    "
                  >
                    <li class="p-1 ml-2 d-flex align-items-center">
                      <img class="pr-1" src="/img/bd/hide-column.svg" alt="" />
                      <a
                        class="text-white cursor-pointer ml-1"
                        @click="
                          $refs.childForm.switchColumnsVisibility(
                            'isHorizontalExpanded',
                            false
                          )
                        "
                        >Скрыть столбцы замеров
                      </a>
                    </li>
                    <li class="p-1 ml-2 d-flex align-items-center">
                      <img class="pr-1" src="/img/bd/hide-all.svg" alt="" />
                      <a
                        class="text-white cursor-pointer ml-1"
                        @click="
                          $refs.childForm.switchColumnsVisibility(
                            'isExpanded',
                            false
                          )
                        "
                        >Скрыть месяца замеров
                      </a>
                    </li>
                    <li class="p-1 ml-2 d-flex align-items-center">
                      <img class="pr-1" src="/img/bd/show-all.svg" alt="" />
                      <a
                        class="text-white cursor-pointer ml-1"
                        @click="
                          [
                            $refs.childForm.switchColumnsVisibility(
                              'isExpanded',
                              true
                            ),
                            $refs.childForm.switchColumnsVisibility(
                              'isHorizontalExpanded',
                              true
                            ),
                          ]
                        "
                        >Показать все
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div v-if="wellUwi" class="mid-col__main_row pt__40">
              <div v-if="activeFormComponentName">
                <div
                  :is="activeFormComponentName"
                  :well="well"
                  :changeColumnsVisible="(value) => changeColumnsVisible(value)"
                  :selectedDzo="selectedDzo"
                  ref="childForm"
                ></div>
              </div>
              <div
                v-else-if="activeForm && activeForm.code"
                class="col table-wrapper"
              >
                <BigDataPlainFormResult
                  v-if="activeForm.type === 'plain'"
                  :code="activeForm.code"
                  :params="activeForm"
                  :well-id="this.well.id"
                  type="well"
                ></BigDataPlainFormResult>
                <BigDataTableFormWrapper
                  v-else-if="activeForm.type === 'table'"
                  :id="this.well.id"
                  :params="activeForm"
                  type="well"
                ></BigDataTableFormWrapper>
              </div>
              <div v-else class="col graphics">
                <div class="row">
                  <div
                    class="col"
                    style="max-width: 64px; display: grid; padding: 0px"
                  >
                    <svg
                      fill="none"
                      height="42"
                      style="margin: 12px 0px 0px 24px"
                      viewBox="0 0 42 42"
                      width="42"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M20.9993 0.999999C25.0498 0.999999 31.5236 0.999999 36.0037 0.999999C38.7652 0.999999 41 3.23536 41 5.99678C41 10.9694 41 18.2449 41 21C41 24.4924 41 31.3063 41 36.0027C41 38.7641 38.7632 40.9999 36.0018 40.9999C31.2512 40.9999 24.3497 41 20.9993 41C17.1648 41 10.5605 41 5.99621 41C3.23481 41 1.00023 38.763 1.00018 36.0016C1.0001 31.1169 1 23.9922 1 21C1 17.6496 1.0001 10.7485 1.00018 5.99813C1.00022 3.23674 3.23602 0.999999 5.99741 0.999999C10.6937 0.999999 17.5075 0.999999 20.9993 0.999999Z"
                        stroke="#2E50E9"
                        stroke-miterlimit="22.9256"
                      />
                      <path
                        d="M20.9994 2.99996C24.7981 2.99996 30.9653 2.99996 35.0024 2.99996C37.2115 2.99996 39 4.79063 39 6.99977C39 11.4726 39 18.4269 39 21C39 24.2698 39 30.7748 39 35.0039C39 37.213 37.2127 38.9999 35.0036 38.9999C30.7266 39 24.135 39 20.9994 39C17.4055 39 11.1085 39 6.99658 39C4.78747 39 3.00021 37.2109 3.00017 35.0018C3.0001 30.6063 3 23.7971 3 21C3 17.8643 3.0001 11.2731 3.00017 6.9963C3.00021 4.78719 4.78713 2.99996 6.99624 2.99996C11.2252 2.99996 17.73 2.99996 20.9994 2.99996Z"
                        fill="#323370"
                      />
                      <path
                        d="M14.7029 25L13.5829 20.472C13.4656 19.96 13.3536 19.4053 13.2469 18.808H13.1829C13.0763 19.5333 12.9483 20.1947 12.7989 20.792L11.7749 25H10.1269L8.11094 17.336H9.39094L10.5909 22.392C10.7189 22.9573 10.8256 23.464 10.9109 23.912H10.9749C11.0283 23.624 11.1509 23.0907 11.3429 22.312L12.5429 17.336H13.9189L15.1669 22.376C15.2736 22.8133 15.3856 23.3253 15.5029 23.912H15.5509C15.6256 23.3787 15.7216 22.872 15.8389 22.392L17.0709 17.336H18.3349L16.3189 25H14.7029ZM22.9856 17.08C23.6469 17.08 24.2336 17.208 24.7456 17.464C25.2576 17.72 25.6522 18.0507 25.9296 18.456C26.2176 18.8613 26.4309 19.288 26.5696 19.736C26.7082 20.1733 26.7776 20.616 26.7776 21.064C26.7776 21.2667 26.7669 21.4213 26.7456 21.528H20.4896C20.4896 22.2213 20.7616 22.8347 21.3056 23.368C21.8496 23.8907 22.4842 24.152 23.2096 24.152C23.9989 24.152 24.6549 23.8427 25.1776 23.224H26.6336C26.3349 23.7893 25.8976 24.2747 25.3216 24.68C24.7562 25.0747 24.0629 25.272 23.2416 25.272C22.0362 25.272 21.0549 24.872 20.2976 24.072C19.5509 23.272 19.1776 22.2693 19.1776 21.064C19.1776 19.9653 19.5296 19.0267 20.2336 18.248C20.9376 17.4693 21.8549 17.08 22.9856 17.08ZM22.9856 18.184C22.2922 18.184 21.7216 18.4133 21.2736 18.872C20.8256 19.32 20.5696 19.8533 20.5056 20.472H25.4496C25.3856 19.8427 25.1242 19.304 24.6656 18.856C24.2176 18.408 23.6576 18.184 22.9856 18.184ZM28.4556 25V13.48H29.7196V25H28.4556ZM31.9243 25V13.48H33.1883V25H31.9243Z"
                        fill="white"
                      />
                    </svg>
                  </div>
                  <div class="col">
                    <div class="well-info">
                      <div class="title">{{ this.trans("well.general") }}</div>
                      <p>
                        {{ this.trans("well.number_well") }}:
                        <span v-if="wellUwi">
                          {{ wellUwi }}
                        </span>
                      </p>
                      <p>
                        {{ this.trans("well.category_well") }}:
                        <span v-if="well.category">
                          {{ well.category_last.name_ru }}
                        </span>
                      </p>
                      <div class="title">{{ this.trans("well.binding") }}</div>
                      <p>
                        {{ this.trans("well.org_struct") }}:
                        <span v-if="wellOrgName">{{ wellOrgName }}</span>
                      </p>
                      <div class="title">{{ this.trans("well.coord") }}</div>
                      <p>
                        {{ this.trans("well.coord_x") }}:
                        <span v-if="wellSaptialObjectX">{{
                          wellSaptialObjectX
                        }}</span>
                      </p>
                      <p>
                        {{ this.trans("well.coord_y") }}:
                        <span v-if="wellSaptialObjectY">
                          {{ wellSaptialObjectY }}
                        </span>
                      </p>
                      <div class="title">{{ this.trans("well.zaboi") }}</div>
                      <p>
                        {{ this.trans("well.zaboi_x") }}:
                        <span v-if="wellSaptialObjectBottomX">
                          {{ wellSaptialObjectBottomX }}
                        </span>
                      </p>
                      <p>
                        {{ this.trans("well.zaboi_y") }}:
                        <span v-if="wellSaptialObjectBottomY">
                          {{ wellSaptialObjectBottomY }}
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="
          !isInjectionWellsHistoricalVisible &&
          !isProductionWellsHistoricalVisible
        "
        :class="{ 'right-column_folded': isRightColumnFolded }"
        class="right-column__inner"
      >
        <div class="bg-dark-transparent doc-pasport">
          <template>
            <div v-if="wellUwi" class="doc-pasport-head">
              <div class="heading">
                <p v-if="wellUwi">{{ this.trans("well.well_passport") }}</p>
              </div>
              <div
                v-if="wellUwi"
                class="sheare-icon"
                @click="ExportToExcel('tbl_exporttable_to_xls', 'WellCard')"
              >
                <!-- @click="ExportToExcel('xlsx')" -->

                <svg
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M3 11.3848V15.5C3 15.7762 3.22386 16 3.5 16H16.5C16.7761 16 17 15.7762 17 15.5V11.3848"
                    stroke="white"
                    stroke-width="1.2"
                    stroke-linecap="round"
                  />
                  <path
                    d="M10 4V11.3844"
                    stroke="white"
                    stroke-width="1.2"
                    stroke-linecap="round"
                  />
                  <path
                    d="M7 9.53906L10 12.3082L13 9.53906"
                    stroke="white"
                    stroke-width="1.2"
                    stroke-linecap="round"
                  />
                </svg>
              </div>
            </div>
          </template>
          <div class="info">
            <div v-if="isRightColumnFolded" class="rotate">
              {{ this.trans("well.well_passport") }}
            </div>
            <div class="info-element">
              <table
                border="1"
                align="left"
                v-if="wellUwi"
                id="tbl_exporttable_to_xls"
              >
                <tr v-for="(item, index) in this.tableData" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.name }}</td>
                  <td>
                    <span>{{ item.data }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="icon-all" @click="onColumnFoldingEvent('right')">
            <svg
              width="7"
              height="13"
              viewBox="0 0 7 13"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M1 1L5.96851 6.41919C6.0105 6.46494 6.0105 6.53512 5.96851 6.58119L1 12"
                stroke="white"
                stroke-width="2"
                stroke-miterlimit="22.9256"
                stroke-linecap="round"
              />
            </svg>
          </div>
        </div>
      </div>
      <InjectionHistoricalData
        v-if="isInjectionWellsHistoricalVisible"
        :changeColumnsVisible="changeColumnsVisible()"
        :wellExplDate="this.well.date_expl.dbeg"
      ></InjectionHistoricalData>
      <ProductionHistoricalData
        v-if="isProductionWellsHistoricalVisible"
        :changeColumnsVisible="changeColumnsVisible()"
        :wellExplDate="this.well.date_expl.dbeg"
      ></ProductionHistoricalData>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import BigDataPlainFormResult from "../forms/PlainFormResults";
import BigDataTableFormWrapper from "../forms/TableFormWrapper";
import vSelect from "vue-select";
import axios from "axios";
import moment from "moment";
import WellCardTree from "./WellCardTree";
import upperFirst from "lodash/upperFirst";
import camelCase from "lodash/camelCase";
import {
  bigdatahistoricalVisibleMutations,
  bigdatahistoricalVisibleState,
  globalloadingMutations,
} from "@store/helpers";
import InjectionHistoricalData from "./InjectionHistoricalData";
import ProductionHistoricalData from "./ProductionHistoricalData";

const requireComponent = require.context(
  "../forms/CustomPlainForms",
  true,
  /\.vue$/i
);
requireComponent.keys().forEach((fileName) => {
  const componentConfig = requireComponent(fileName);
  const componentName = upperFirst(
    camelCase(
      fileName
        .split("/")
        .pop()
        .replace(/\.\w+$/, "")
    )
  );
  Vue.component(componentName, componentConfig.default || componentConfig);
});

export default {
  components: {
    BigDataPlainFormResult,
    BigDataTableFormWrapper,
    vSelect,
    WellCardTree,
    InjectionHistoricalData,
    ProductionHistoricalData,
  },
  data() {
    return {
      isOpen: false,
      well_all_data: null,
      well_type_category: null,
      well_passport: [],
      options: [],
      graph: null,
      activeForm: null,
      activeFormComponentName: null,
      loading: false,
      isLeftColumnFolded: false,
      isRightColumnFolded: false,
      isBothColumnFolded: false,
      popup: false,
      wellGeo: { name_ru: null },
      wellGeoFields: { name_ru: null },
      wellUwi: null,
      well: {
        id: null,
        depthLow: { value_double: null },
        measWaterCut: { water_cut: null },
        status: { name_ru: null },
        category: { name_ru: null },
        category_last: { name_ru: null },
        expl: { dbeg: null, name_ru: null },
        expl_right: { dbeg: null, name_ru: null },
        techs: null,
        tap: { tap: null },
        techsName: null,
        labResearchValue: { value_double: null },
        wellType: { name_ru: null },
        whc_alt: null,
        org: null,
        geo: { name_ru: null },
        tubeNom: { nd: null },
        measLiq: null,
        meas_water_inj: null,
        tech_mode_inj: null,
        techModeProdOil: null,
        techModeProdLiquid: null,
        injPressure: null,
        agentVol: null,
        krsWorkover: { dbeg: null, dend: null },
        prsWellWorkover: { dbeg: null, dend: null },
        treatmentDate: { treat_date: null },
        actualBottomHole: null,
        artificialBottomHole: null,
        perfActual: { top: null, base: null, perf_date: null },
        wellInfo: { rte: null },
        date_expl: { dbeg: null, name_ru: null },
        treatmentSko: { treat_date: null },
        dmart_daily_prod_oil: { oil: null },
        dinzamer: { value_double: null },
        gdisCurrent: { meas_date: null, note: null },
        gdisConclusion: { name_ru: null },
        gdisCurrentValue: { value_double: null },
        gdisCurrentValuePmpr: { value_double: null },
        gdisCurrentValueFlvl: { value_double: null },
        gdisCurrentValueStatic: { value_double: null },
        gdisCurrentValueRp: { value_double: null, meas_date: null },
        gdisComplex: { value_double: null, dbeg: null, value_string: null },
        techmode: { well: null, date: null, bhp: null, p_res: null },
        gis: { gis_date: null },
        gdisCurrentValueBhp: { value_double: null, meas_date: null },
        zone: { name_ru: null },
        wellReactInfl: { well_reacting: null, well_influencing: null },
        gtm: { dbeg: null },
        rzatrStat: { value_double: null },
        rzatrAtm: { value_double: null },
        gu: { name_ru: null },
        agms: { name_ru: null },
        well_equip_param: {
          value_double: null,
          value_string: null,
          equip_param: null,
        },
        pump_code: {
          value_double: null,
          value_string: null,
          equip_param: null,
          value_text: null,
        },
        diametr_pump: {
          value_double: null,
          value_string: null,
          equip_param: null,
        },
        depth_nkt: {
          value_double: null,
          value_string: null,
          equip_param: null,
        },
        depth_paker: {
          value_double: null,
        },
        pump_capacity: {
          value_double: null,
        },
        tubeNomDop: { od: null },
        type_sk: {
          value_double: null,
          value_string: null,
          equip_param: null,
          value_text: null,
        },
        wellDailyDrill: { dbeg: null, dend: null },
        meas_well: { dbeg: null, value_double: null },
        diametr_stuzer: { prm: null, value_double: null },
        value_text: null,
        dailyInjectionOil: {
          water_inj_val: null,
          pressure_inj: null,
          pump_stroke: null,
          choke: null,
          water_vol: null,
        },
        diameter_pump: { value_double: null },
        well_block: { name_ru: null },
      },
      wellParent: null,
      wellTechs: null,
      wellTechsName: null,
      wellTechsTap: null,
      wellOrgName: null,
      wellSaptialObjectX: null,
      wellSaptialObjectY: null,
      wellSaptialObjectBottomX: null,
      wellSaptialObjectBottomY: null,
      wellTransform: {
        name: "wellInfo.uwi",
        depthLow: "depthLow",
        wellInfo: "wellInfo",
        whc_alt: "whc_alt",
        measWaterCut: "meas_water_cut",
        status: "status",
        category: "category",
        category_last: "category_last",
        expl: "well_expl",
        expl_right: "well_expl_right",
        techs: "techs",
        tap: "tap",
        labResearchValue: "lab_research_value",
        wellType: "well_type",
        dmart_daily_prod_oil: "dmart_daily_prod_oil",
        org: "org",
        geo: "geo",
        tubeNom: "tubeNom",
        dinzamer: "dinzamer",
        date_expl: "date_expl",
        measLiq: "measLiq",
        pump_capacity: "pump_capacity",
        meas_water_inj: "meas_water_inj",
        tech_mode_inj: "tech_mode_inj",
        techModeProdOil: "techModeProdOil",
        techModeProdLiquid: "tech_mode_prod_oil.liquid",
        injPressure: "tech_mode_inj.inj_pressure",
        agentVol: "tech_mode_inj.agent_vol",
        krsWorkover: "krs_well_workover",
        prsWellWorkover: "prs_well_workover",
        treatmentDate: "well_treatment",
        actualBottomHole: "actual_bottom_hole",
        artificialBottomHole: "artificial_bottom_hole",
        perfActual: "well_perf_actual",
        treatmentSko: "well_treatment_sko",
        gdisCurrent: "gdisCurrent",
        gdisConclusion: "gdis_conclusion",
        gdisCurrentValue: "gdis_current_value",
        gdisCurrentValuePmpr: "gdis_current_value_pmpr",
        gdisCurrentValueFlvl: "gdis_current_value_flvl",
        gdisCurrentValueStatic: "gdis_current_value_static",
        gdisCurrentValueRp: "gdis_current_value_rp",
        gdisComplex: "gdis_complex",
        gis: "gis",
        gdisCurrentValueBhp: "gdis_current_value_bhp",
        zone: "zone",
        wellReactInfl: "well_react_infl",
        gtm: "gtm",
        rzatrAtm: "rzatr_atm",
        rzatrStat: "rzatr_stat",
        gu: "gu",
        agms: "agms",
        well_equip_param: "well_equip_param",
        pump_code: "pump_code",
        diametr_pump: "diametr_pump",
        depth_paker: "depth_paker",
        type_sk: "type_sk",
        wellDailyDrill: "wellDailyDrill",
        meas_well: "meas_well",
        techmode: "techmode",
        diametr_stuzer: "diametr_stuzer",
        dailyInjectionOil: "dailyInjectionOil",
        diameter_pump: "diameter_pump",
        well_block: "well_block",
        depth_nkt: "depth_nkt",
        tubeNomDop: "tubeNomDop",
      },
      formsStructure: {},
      dzoSelectOptions: [],
      selectedUserDzo: null,
      historyWellTemplate: {
        summary: {
          wellUwi: null,
          well_passport: [],
        },
        params: {
          category: null,
          wellOrgName: null,
          wellSaptialObjectX: null,
          wellSaptialObjectY: null,
          wellSaptialObjectBottomX: null,
          wellSaptialObjectBottomY: null,
        },
        lastForm: {
          code: null,
          componentName: null,
        },
      },
      wellsHistory: [],
      tabWidth: 0,
      measurementScheduleForms: [
        "ProductionWellsScheduleMain",
        "InjectionWellsScheduleMain",
      ],
      maximumWellsCount: 10,
      selectedDzo: null,
    };
  },
  mounted() {
    this.axios
      .get(this.localeUrl("api/bigdata/forms/tree"))
      .then(({ data }) => {
        this.formsStructure = data.tree;
      });
    this.axios
      .get(this.localeUrl("/user_organizations"), {
        params: { only_main: true },
      })
      .then(({ data }) => {
        if (
          typeof data !== "undefined" &&
          typeof data.organizations !== "undefined" &&
          data.organizations.length > 0
        ) {
          this.dzoSelectOptions = data.organizations;
        }
      });
    let urlParams = new URLSearchParams(window.location.search);
    let wellId = urlParams.get("wellId");
    let wellUwi = urlParams.get("wellName");
    if (wellId !== null && wellUwi !== null) {
      this.selectWell({ id: wellId, name: wellUwi });
    }
  },
  methods: {
    ...globalloadingMutations(["SET_LOADING"]),
    onColumnFoldingEvent(method) {
      if (method === "left") {
        this.isLeftColumnFolded = !this.isLeftColumnFolded;
      } else {
        this.isRightColumnFolded = !this.isRightColumnFolded;
      }
      if (
        this.isLeftColumnFolded === true &&
        this.isRightColumnFolded === true
      ) {
        this.isBothColumnFolded = true;
      } else {
        this.isBothColumnFolded = false;
      }
    },

    ExportToExcel(tbl_exporttable_to_xls, filename = "") {
      var downloadLink;
      var dataType = "application/vnd.ms-excel";
      var tableSelect = document.getElementById(tbl_exporttable_to_xls);
      var tableHTML = tableSelect.outerHTML.replace(/ /g, "%20");

      filename = filename ? filename + ".xls" : "excel_data.xls";
      downloadLink = document.createElement("a");
      document.body.appendChild(downloadLink);

      if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(["\ufeff", tableHTML], {
          type: dataType,
        });
        navigator.msSaveOrOpenBlob(blob, filename);
      } else {
        downloadLink.href = "data:" + dataType + ", " + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
      }
    },
    onSearch(search, loading) {
      if (search.length) {
        loading(true);
        this.search(loading, search, this);
      }
    },
    search: _.debounce((loading, search, vm) => {
      axios
        .get(vm.localeUrl("/api/bigdata/wells/search"), {
          params: {
            query: escape(search),
            selectedUserDzo: vm.selectedUserDzo,
          },
        })
        .then(({ data }) => {
          vm.options = data.items;
          loading(false);
        });
    }, 350),
    setWellPassport() {
      let well = this.wellUwi;
      let wellType = this.well.wellType ? this.well.wellType.name_ru : "";
      let wellGeoFields = this.wellGeoFields ? this.wellGeoFields.name_ru : "";
      let neighbors =
        this.wellGeo.name_ru && this.well.labResearchValue.value_double
          ? this.wellGeo.name_ru +
            "/ " +
            (this.well.labResearchValue.value_double * 9.869).toFixed(1)
          : this.wellGeo
          ? this.wellGeo.name_ru + " / " + "-"
          : this.well.labResearchValue
          ? this.well.labResearchValue
          : "";
      let wellInfo = this.well.wellInfo ? this.well.wellInfo.rte : "";
      let wellrot = this.getHrotor(well);
      let wellTechsName = this.wellTechsName ? this.wellTechsName : "";
      let tap = this.well.tap ? this.well.tap.tap : "";
      let gu_agsu =
        this.well.gu.name_ru && this.well.agms.name_ru
          ? this.well.gu.name_ru + "/" + this.well.agms.name_ru
          : this.well.gu.name_ru
          ? this.well.gu.name_ru
          : this.well.agms.name_ru
          ? this.well.agms.name_ru
          : "";
      let horizont = this.wellGeo.name_ru ? this.wellGeo.name_ru : "";
      let wellOrgName = this.wellOrgName ? this.wellOrgName : "";
      let well_zone = this.well.zone ? this.well.zone.name_ru : "";
      let wellReactReacting = this.well.wellReactInfl.well_reacting
        ? this.well.wellReactInfl.well_reacting
        : "";
      let wellReactInfl = this.well.wellReactInfl.well_influencing
        ? this.well.wellReactInfl.well_influencing
        : "";
      let wellSaptialObjectX = this.wellSaptialObjectX
        ? this.wellSaptialObjectX
        : "";
      let wellSaptialObjectY = this.wellSaptialObjectY
        ? this.wellSaptialObjectY
        : "";
      let wellSaptialObjectBottomX = this.wellSaptialObjectBottomX
        ? this.wellSaptialObjectBottomX
        : "";
      let wellSaptialObjectBottomY = this.wellSaptialObjectBottomY
        ? this.wellSaptialObjectBottomY
        : "";
      let well_category = this.well.category ? this.well.category.name_ru : "";
      let categoryLast = this.well.category_last
        ? this.well.category_last.name_ru
        : "";
      let period_bur =
        this.well.wellInfo.drill_start_date && this.well.wellInfo.drill_end_date
          ? this.getFormatedDate(this.well.wellInfo.drill_start_date) +
            " - " +
            this.getFormatedDate(this.well.wellInfo.drill_end_date)
          : this.well.wellInfo.drill_start_date
          ? this.getFormatedDate(this.well.wellInfo.drill_start_date)
          : this.well.wellInfo.drill_end_date
          ? this.getFormatedDate(this.well.wellInfo.drill_end_date)
          : "";
      let wellExpl = this.well.expl
        ? this.getFormatedDate(this.well.expl.dbeg)
        : "";
      let wellDateExpl = this.well.date_expl
        ? this.getFormatedDate(this.well.date_expl.dbeg)
        : "";
      let well_status = this.well.status ? this.well.status.name_ru : "";
      let well_expl_name = this.well.expl_right
        ? this.well.expl_right.name_ru
        : "";
      let actualBottomHole = this.well.actualBottomHole
        ? this.well.actualBottomHole.depth +
          " / (" +
          this.getFormatedDate(this.well.actualBottomHole.data) +
          ")"
        : "";
      let artificialBottomHole = this.well.artificialBottomHole
        ? this.well.artificialBottomHole.depth
        : "";
      let perfActual = this.perfActual ? this.perfActual : "";
      let techModeProdOil = this.getTechmodeLiqiud(well);
      let techModeProdOil_measWaterCut =
        this.well?.techModeProdOil?.wcut &&
        this.well?.dmart_daily_prod_oil?.wcut
          ? this.well.techModeProdOil.wcut +
            " / " +
            this.well.dmart_daily_prod_oil.wcut
          : this.well?.techModeProdOil?.wcut
          ? this.well.techModeProdOil.wcut
          : this.well?.dmart_daily_prod_oil?.wcut
          ? this.well.dmart_daily_prod_oil.wcut
          : "";
      let krsWorkover = this.well.krsWorkover.dbeg
        ? this.getFormatedDate(this.well.krsWorkover.dbeg)
        : "";
      let treatmentDate = this.well.treatmentDate.treat_date
        ? this.getFormatedDate(this.well.treatmentDate.treat_date)
        : "";
      let well_gtm = this.well.gtm.dbeg
        ? this.getFormatedDate(this.well.gtm.dbeg)
        : "";
      let treatmentSko = this.well.treatmentSko.treat_date
        ? this.getFormatedDate(this.well.treatmentSko.treat_date)
        : "";
      let well_gdisCurrent = this.well.gdisCurrent.meas_date
        ? this.getFormatedDate(this.well.gdisCurrent.meas_date)
        : "";
      let prsWellWorkover = this.well.prsWellWorkover.dbeg
        ? this.getFormatedDate(this.well.prsWellWorkover.dbeg)
        : "";
      let well_gis = this.well.gis.gis_date
        ? this.getFormatedDate(this.well.gis.gis_date)
        : "";
      let well_gdisCurrent2 = this.well.gis.gis_date
        ? this.getFormatedDate(this.well.gis.gis_date)
        : "";
      let gdisConclusion = this.well.gdisConclusion.name_ru
        ? this.well.gdisConclusion.name_ru
        : "";
      let gdisCurrentValue = this.well.gdisCurrentValue.value_double
        ? this.well.gdisCurrentValue.value_double
        : "";
      let gdisCurrentValuePmpr = this.well.gdisCurrentValuePmpr.value_double
        ? this.well.gdisCurrentValuePmpr.value_double
        : "";
      let gdisCurrentValueFlvl =
        this.well.dmart_daily_prod_oil.hdin &&
        this.well.dmart_daily_prod_oil.date
          ? this.well.dmart_daily_prod_oil.hdin +
            " / " +
            this.getFormatedDate(this.well.dmart_daily_prod_oil.date)
          : "";
      let gdisCurrentValueStatic =
        this.well.gdisCurrentValueStatic.value_double +
        this.well.gdisCurrentValueStatic.meas_date
          ? this.well.gdisCurrentValueStatic.value_double +
            this.getFormatedDate(this.well.gdisCurrentValueStatic.meas_date)
          : "";
      let gdisCurrentValueRp = this.well.gdisCurrentValueRp.value_double
        ? this.well.gdisCurrentValueRp.value_double +
          "/" +
          this.getFormatedDate(this.well.gdisCurrentValueRp.meas_date)
        : "";
      let gdisComplex =
        this.well.gdisComplex.value_double && this.well.gdisComplex.dbeg
          ? this.well.gdisComplex.value_double.toFixed(1) +
            " / " +
            this.getFormatedDate(this.well.gdisComplex.dbeg)
<<<<<<< HEAD
          : this.well.gdisComplex.value_double
          ? this.well.gdisComplex.value_double.toFixed(1)
          : this.well.gdisComplex.dbeg
          ? this.getFormatedDate(this.well.gdisComplex.dbeg)
          : "";
      let rzatrAtm = this.well.dmart_daily_prod_oil
        ? this.well.dmart_daily_prod_oil.pzat
        : "";
=======
            : this.well.gdisComplex.value_double
                ? this.well.gdisComplex.value_double.toFixed(1)
                : this.well.gdisComplex.dbeg
                    ? this.getFormatedDate(this.well.gdisComplex.dbeg)
                    : "";
      let rzatrAtm = this.well.dmart_daily_prod_oil ? this.well.dmart_daily_prod_oil.pzat : "";
>>>>>>> 119239c72654aaad1a4f33b1dd72c747ba5447eb
      let gdisCurrent_note = this.well.gdisCurrent.note
        ? this.well.gdisCurrent.note
        : "";
      let gdisCurrentValueBhp =
        this.well.techmode.value_string && this.well.techmode.dbeg
          ? this.well.techmode.value_string.toFixed(1) +
            " / " +
            this.getFormatedDate(this.well.techmode.dbeg)
          : "";
      let rzatrStat = this.well.rzatrStat.value_double
        ? this.well.rzatrStat.value_double
        : "";
      let injPressure = this.getInjPressure(well);
      let agentVol =
        (this.well.tech_mode_inj || this.well.dailyInjectionOil) &&
        this.well.dailyInjectionOil.water_inj_val
          ? this.well.tech_mode_inj.agent_vol +
            " / " +
            this.well.dailyInjectionOil.water_inj_val.toFixed(1)
          : "";
      let perfActualDate = this.perfActual
        ? this.getFormatedDate(this.perf_date)
        : "";
      let category_id = this.well.category_last.pivot
        ? this.well.category_last.pivot.category
        : "";
      let main_org_code = this.well_all_data.main_org_code;
      this.selectedDzo = this.well_all_data.main_org_code;
      let techModeProdOil_measWaterCut2 = this.getTechmodeOil(well);
      let well_equip_param = this.well.well_equip_param
        ? this.well.well_equip_param.value_string
        : "";
      let depthLow = this.well.depthLow ? this.well.depthLow.value_double : "";
      let pump_code = this.well.pump_code ? this.well.pump_code.value_text : "";
      let diameter_pump = this.well.diameter_pump
        ? this.well.diameter_pump.value_double
        : "";
      let depth_paker = this.well.depth_paker
        ? this.well.depth_paker.value_double
        : "";
      let type_sk = this.well.type_sk ? this.well.type_sk.value_text : "";
      let meas_well = this.well.meas_well
        ? this.well.meas_well.value_double
        : "";
      let diametr_stuzer = this.well.diametr_stuzer
        ? this.well.diametr_stuzer.value_text
        : "";
      let gas_production = this.well.dmart_daily_prod_oil.gas
        ? this.well.dmart_daily_prod_oil.gas.toFixed(1)
        : "";
      let tubeNomOd = this.getTubeNom(well);
      let well_block = this.well.well_block ? this.well.well_block.name_ru : "";
      let pump_capacity = this.well.pump_capacity
        ? this.well.pump_capacity.value_double
        : "";
      let depth_nkt = this.well.depth_nkt
        ? this.well.depth_nkt.value_double
        : "";
      this.well_passport = [
        {
          name: this.trans("well.well"),
          data: well,
          type: ["all"],
        },
        {
          name: this.trans("well.view_well"),
          data: wellType,
          type: ["all"],
        },
        {
          name: this.trans("well.well_field"),
          data: wellGeoFields,
          type: ["all"],
        },
        {
          name: this.trans("well.horizont_rnas"),
          data: neighbors,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.block"),
          data: well_block,
          type: ["all"],
          codes: ["KGM"],
        },
        {
          name: this.trans("well.horizont"),
          data: horizont,
          type: ["nag"],
        },
        {
          name: this.trans("well.h_rotor"),
          data: wellrot,
          type: ["all"],
        },
        {
          name: this.trans("well.tech_struct"),
          data: wellTechsName,
          type: ["all"],
        },
        {
          name: this.trans("well.otvod"),
          data: tap,
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.gu_zu"),
          data: gu_agsu,
          type: ["dob_oil"],
          codes: ["KTM"],
        },
        {
          name: this.trans("well.org_struct"),
          data: wellOrgName,
          type: ["all"],
        },
        {
          name: this.trans("well.zone_well"),
          data: well_zone,
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.reactive_wells"),
          data: wellReactReacting,
          type: ["nag"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.influence_well"),
          data: wellReactInfl,
          type: ["dob_oil"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.coord_x_outfall"),
          data: wellSaptialObjectX,
          type: ["all"],
        },
        {
          name: this.trans("well.coord_y_outfall"),
          data: wellSaptialObjectY,
          type: ["all"],
        },
        {
          name: this.trans("well.zaboi_x"),
          data: wellSaptialObjectBottomX,
          type: ["all"],
        },
        {
          name: this.trans("well.zaboi_y"),
          data: wellSaptialObjectBottomY,
          type: ["all"],
        },
        {
          name: this.trans("well.assign_well_project"),
          data: well_category,
          type: ["all"],
        },
        {
          name: this.trans("well.category"),
          data: categoryLast,
          type: ["all"],
        },
        {
          name: this.trans("well.period_bur"),
          data: period_bur,
          type: ["all"],
        },
        {
          name: this.trans("well.date_expluatation"),
          data: wellDateExpl,
          type: ["all"],
        },
        {
          name: this.trans("well.status"),
          data: well_status,
          type: ["all"],
        },
        {
          name: this.trans("well.way_expluatation"),
          data: well_expl_name,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.uo_bolt"),
          data: "",
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.diametr"),
          data: "",
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.diametr_exp"),
          data: tubeNomOd,
          type: ["all"],
        },
        {
          name: this.trans("well.type_gol"),
          data: "",
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.type_pump"),
          data: pump_code,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.diametr_stuzer"),
          data: diametr_stuzer,
          type: ["nag"],
        },
        {
          name: this.trans("well.diameter_pump"),
          data: diameter_pump,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.pump_capacity"),
          data: pump_capacity,
          type: ["dob_oil"],
          temp: 2,
          codes: ["KGM"],
        },
        {
          name: this.trans("well.pump_depth"),
          data: depthLow,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.packer_running_depth"),
          data: depth_paker,
          type: ["nag"],
        },
        {
          name: this.trans("well.sk"),
          data: type_sk,
          type: ["all"],
          exp: 1, // шгн
        },
        {
          name: this.trans("well.length_hod"),
          data: "",
          type: ["dob_oil"],
          exp: 1,
        },
        {
          name: this.trans("well.count_swaing"),
          data: "",
          type: ["dob_oil"],
          exp: 1,
        },
        {
          name: this.trans("well.fact_zaboi"),
          data: actualBottomHole,
          type: ["dob_oil"],
          codes: ["KGM"],
          exp: 0,
        },
        {
          name: this.trans("well.synthetic_zaboi"),
          data: artificialBottomHole,
          type: ["all"],
        },
        {
          name: this.trans("well.broken_zaboi"),
          data: "",
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.depth_down"),
          data: depth_nkt,
          type: ["nag"],
        },
        {
          name: this.trans("well.kshd"),
          data: "",
          type: ["nag"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.progress_interval_perforation"),
          data: perfActual,
          type: ["all"],
        },
        {
          name: this.trans("well.date_perforation"),
          data: perfActualDate,
          type: ["all"],
        },
        {
          name: this.trans("well.pickup"),
          data: agentVol,
          type: ["nag"],
        },
        {
          name: this.trans("well.injection_pressure"),
          data: injPressure,
          type: ["nag"],
        },
        {
          name: this.trans("well.debit_water"),
          data: techModeProdOil,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.water_cut"),
          data: techModeProdOil_measWaterCut,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.debit_oil"),
          data: techModeProdOil_measWaterCut2,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.gas_production"),
          data: gas_production,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.gaz_factor"),
          data: meas_well,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.date_krs"),
          data: krsWorkover,
          type: ["all"],
        },
        {
          name: this.trans("well.date_pfp"),
          data: treatmentDate,
          type: ["nag"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.date_krp"),
          data: well_gtm,
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.date_sko"),
          data: treatmentSko,
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.date_kpd"),
          data: well_gdisCurrent,
          type: ["nag"],
        },
        {
          name: this.trans("well.date_prc"),
          data: prsWellWorkover,
          type: ["all"],
        },
        {
          name: this.trans("well.date_last_gis"),
          data: well_gdisCurrent2,
          type: ["all"],
        },
        {
          name: this.trans("well.result_gdm"),
          data: gdisConclusion,
          type: ["dob_oil"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.length_hod_gdm"),
          data: gdisCurrentValue,
          type: ["dob_oil"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.count_swing"),
          data: gdisCurrentValuePmpr,
          type: ["dob_oil"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.dynamic_level"),
          data: gdisCurrentValueFlvl,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.static_level"),
          data: gdisCurrentValueStatic,
          type: ["dob_oil", "nabl"],
          codes: ["KGM"],
        },
        {
          name: this.trans("well.rpl_date"),
          data: gdisCurrentValueRp,
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.rpl_sl_gdis"),
          data: gdisComplex,
          type: ["all"],
        },
        {
          name: this.trans("well.rzab"),
          data: gdisCurrentValueBhp,
          type: ["all"],
        },
        {
          name: this.trans("well.rzatr"),
          data: rzatrAtm,
          type: ["dob_oil"],
        },
        {
          name: this.trans("well.rzatr_stat"),
          data: rzatrStat,
          type: ["dob_oil"],
          codes: ["KGM", "KTM"],
        },
        {
          name: this.trans("well.note"),
          data: gdisCurrent_note,
          type: ["all"],
          codes: ["KGM", "KTM"],
        },
      ];
      this.well_passport = this.rebuildRightSidebar(
        this.well_passport,
        category_id,
        well_expl_name,
        main_org_code
      );
    },
    rebuildRightSidebar(data, category_id, well_expl_name, main_org_code) {
      let well_passport_data = [];
      data.forEach(function (item) {
        let type = item.type;
        let exp = item.exp;
        let codes = item.codes;
        let temp = item.temp;
        let types = { 13: "dob_oil", 9: "nabl", 5: "nag" };
        if (
          type.indexOf(types[category_id]) != -1 ||
          type.indexOf("all") != -1
        ) {
          if (exp == 1 && well_expl_name != "УШГН") {
            return;
          }

          if (temp == 2 && well_expl_name != "УЭЦН") {
            return;
          }

          if (codes && codes.indexOf(main_org_code) != -1) {
            return;
          }
          well_passport_data.push(item);
        }
      });
      return well_passport_data;
    },
    selectWell(well) {
      this.activeFormComponentName = null;
      this.activeForm = null;
      this.SET_VISIBLE_PRODUCTION(false);
      if (well) {
        this.SET_LOADING(true);
        this.axios
          .get(this.localeUrl(`/api/bigdata/wells/${well.id}/wellInfo`))
          .then(({ data }) => {
            try {
              this.well_all_data = data;
              this.well.id = data.wellInfo.id;
              this.wellUwi = data.wellInfo.uwi;

              for (let j = 0; j < Object.keys(this.well).length; j++) {
                let keys = Object.keys(this.well)[j];
                if (keys != "id") {
                  this.well[keys] = " ";
                }
                this.wellOrgName = " ";
                this.wellTechsName = " ";
                this.wellSaptialObjectBottomX = " ";
                this.wellSaptialObjectBottomY = " ";
                this.wellGeoFields = " ";
                this.gas_production = " ";
                this.dmart_daily_prod_oil = " ";
                this.wellGeo.name_ru = "";
              }
              if (data.geo[Object.keys(data.geo).length - 1] != null) {
                this.wellGeoFields = data.geo[Object.keys(data.geo).length - 3];
              }
              if (data.geo[0] != null) {
                this.wellGeo = data.geo[0];
              }
              for (let i = 0; i < Object.keys(this.wellTransform).length; i++) {
                this.setWellObjectData(
                  Object.keys(this.wellTransform)[i],
                  Object.values(this.wellTransform)[i],
                  data
                );
              }
              if (data.spatial_object && data.spatial_object.coord_point) {
                let spatialObject;
                spatialObject = data.spatial_object.coord_point
                  .replace("(", "")
                  .replace(")", "");
                spatialObject = spatialObject.split(",");
                this.wellSaptialObjectX = spatialObject[0];
                this.wellSaptialObjectY = spatialObject[1];
              }
              if (
                data.spatial_object_bottom &&
                data.spatial_object_bottom.coord_point
              ) {
                let spatialObjectBottom;
                spatialObjectBottom = data.spatial_object_bottom.coord_point
                  .replace("(", "")
                  .replace(")", "");
                spatialObjectBottom = spatialObjectBottom.split(",");
                this.wellSaptialObjectBottomX = spatialObjectBottom[0];
                this.wellSaptialObjectBottomY = spatialObjectBottom[1];
              }
              this.wellTechsName = this.getMultipleValues(
                data.techs,
                "name_ru"
              );
              this.wellTechsTap = this.getMultipleValues(data.techs, "tap");
              this.perf_date =
                data.well_perf_actual.length > 0
                  ? data.well_perf_actual[0].perf_date
                  : "";
              this.perfActual =
                data.well_perf_actual.length > 0
                  ? this.getwellPerf(data.well_perf_actual, "top", "base")
                  : "";
              this.wellOrgName = this.getMultipleValues(
                data.org.reverse(),
                "name_ru"
              );
            } catch (e) {
              this.SET_LOADING(false);
            }
            this.setWellPassport();
            let historyRecord = _.find(this.wellsHistory, {
              wellUwi: this.wellUwi,
            });
            if (!historyRecord) {
              this.storeWellToHistory();
            } else {
              this.switchFormByCode(historyRecord.lastFormInfo);
            }
            this.SET_LOADING(false);
          });
      }
    },
    getMultipleValues(objectName, objectKey) {
      let value = "";
      for (let i = 0; i < Object.keys(objectName).length; i++) {
        if (i + 1 < Object.keys(objectName).length) {
          value += objectName[i][objectKey] + " / ";
        } else {
          value += objectName[i][objectKey];
        }
      }
      return value;
    },
    getwellPerf(objectName, objectKey, objectKey2) {
      let val = "";
      for (let i = 0; i < Object.keys(objectName).length; i++) {
        val +=
          objectName[i][objectKey] + " - " + objectName[i][objectKey2] + "\r\n";
      }
      return val;
    },
    getTubeNom(well) {
      if (this.well.tubeNom.od) {
        return this.well.tubeNom.od;
      }
      return "";
    },
    getTechmodeOil(well) {
      if (this.well.techModeProdOil && this.well.dmart_daily_prod_oil) {
        if (
          this.well.techModeProdOil.oil &&
          this.well.dmart_daily_prod_oil.oil
        ) {
          return (
            this.well.techModeProdOil.oil.toFixed(1) +
            " / " +
            this.well.dmart_daily_prod_oil.oil.toFixed(1)
          );
        }
        if (this.well.techModeProdOil.oil) {
          return this.well.techModeProdOil.oil.toFixed(1) + " / " + "-";
        }
        if (this.well.dmart_daily_prod_oil.oil) {
          return "-" + " / " + this.well.dmart_daily_prod_oil.oil.toFixed(1);
        }
      }
      return "";
    },
    getHrotor(well) {
      if (this.well.wellInfo) {
        if (this.well.wellInfo.whc_alt && this.well.wellInfo.whc_h) {
          return (
            this.well.wellInfo.whc_alt.toFixed(1) +
            " / " +
            this.well.wellInfo.whc_h.toFixed(1)
          );
        }
        if (this.well.wellInfo.whc_alt) {
          return this.well.wellInfo.whc_alt.toFixed(1) + " / " + "-";
        }
        if (this.well.wellInfo.whc_h) {
          return this.well.wellInfo.whc_h.toFixed(1) + " / " + "-";
        }
      }
      return "";
    },
    getTechmodeLiqiud(well) {
      if (this.well.techModeProdOil && this.well.dmart_daily_prod_oil) {
        if (
          this.well.techModeProdOil.liquid != null &&
          this.well.dmart_daily_prod_oil.liquid != null
        ) {
          return (
            this.well.techModeProdOil.liquid.toFixed(1) +
            " / " +
            this.well.dmart_daily_prod_oil.liquid.toFixed(1)
          );
        }
        if (this.well.techModeProdOil.liquid != null) {
          return this.well.techModeProdOil.liquid.toFixed(1) + " / " + "-";
        }
        if (this.well.dmart_daily_prod_oil.liquid != null) {
          return "-" + " / " + this.well.dmart_daily_prod_oil.liquid.toFixed(1);
        }
      }
      return "";
    },
    getInjPressure(well) {
      if (this.well.tech_mode_inj && this.well.dailyInjectionOil) {
        if (
          this.well.tech_mode_inj.inj_pressure != null &&
          this.well.dailyInjectionOil.pressure_inj != null
        ) {
          return (
            this.well.tech_mode_inj.inj_pressure +
            " / " +
            this.well.dailyInjectionOil.pressure_inj
          );
        }
        if (
          this.well.tech_mode_inj.inj_pressure === null &&
          this.well.dailyInjectionOil.pressure_inj === null
        ) {
          return "- / -";
        }
        if (this.well.tech_mode_inj.inj_pressure === null) {
          return "-" + " / " + this.well.dailyInjectionOil.pressure_inj;
        }
        if (this.well.dailyInjectionOil.pressure_inj === null) {
          return this.well.tech_mode_inj.inj_pressure + " / " + "-";
        }
        return "";
      }
      if (this.well.tech_mode_inj === null) {
        return "";
      }
      if (this.well.meas_water_inj === null) {
        return "";
      }
      if (this.well.tech_mode_inj.inj_pressure) {
        return this.well.tech_mode_inj.inj_pressure + " / " + "-";
      }
      if (this.well.meas_water_inj.pressure_inj) {
        return "-" + " / " + this.well.meas_water_inj.pressure_inj;
      }
      return "";
    },
    setWellObjectData(key, path, source) {
      try {
        if (source[path] != null) {
          this.well[key] = source[path];
        } else {
          variable = null;
        }
      } catch (e) {}
    },
    switchFormByCode(data) {
      if (data) {
        this.SET_VISIBLE_PRODUCTION(false);
        this.SET_VISIBLE_INJECTION(false);
        this.activeForm = data;
        let currentWellIndex = _.findIndex(
          this.wellsHistory,
          (e) => {
            return e.wellUwi == this.wellUwi;
          },
          0
        );
        this.wellsHistory[currentWellIndex]["lastFormInfo"] = data;
        this.activeFormComponentName = "";
        this.activeFormComponentName = data.component_name;
        this.activeFormComponentName
          ? this.activeFormComponentName
          : "ProductionWellsScheduleMain";
      }
      if (this.activeFormComponentName === "ProductionWellsScheduleMain") {
        this.SET_VISIBLE_PRODUCTION(true);
        this.changeColumnsVisible(false);
      } else if (
        this.activeFormComponentName === "InjectionWellsScheduleMain"
      ) {
        this.SET_VISIBLE_INJECTION(true);
        this.changeColumnsVisible(false);
      }
    },
    getFormatedDate(data) {
      if (data != null && data != "") {
        return moment(data).tz("Asia/Almaty").format("DD.MM.YYYY");
      }
    },
    changeColumnsVisible(value) {
      this.isLeftColumnFolded = !value;
      this.isRightColumnFolded = !value;
      this.isBothColumnFolded = !value;
    },
    dzoSelectChange(event) {
      this.selectedUserDzo = event.target.value;
      this.options = [];
      this.wellUwi = null;
    },
    storeWellToHistory() {
      let summaryWellInfo = {
        wellUwi: this.wellUwi,
        well_passport: this.tableData,
        id: this.well.id,
      };
      _.forEach(Object.keys(this.historyWellTemplate.params), (key) => {
        if (key === "category") {
          summaryWellInfo[key] = this.well.category;
        } else if (this[key]) {
          summaryWellInfo[key] = this[key];
        } else {
          summaryWellInfo[key] = null;
        }
      });
      summaryWellInfo["lastFormInfo"] = this.activeForm;
      this.wellsHistory.push(summaryWellInfo);
      if (this.wellsHistory.length > this.maximumWellsCount) {
        this.wellsHistory.shift();
      }
    },
    handleDeleteWell(index) {
      this.wellsHistory.splice(index, 1);
      if (this.wellsHistory.length === 0) {
        this.activeForm = null;
        this.activeFormComponentName = null;
        this.isBothColumnFolded = false;
        this.isLeftColumnFolded = false;
        this.isRightColumnFolded = false;
        this.wellUwi = null;
      } else {
        let lastWell = this.wellsHistory.at(-1);
        this.selectWell({ id: lastWell.id, name: lastWell.wellUwi });
      }
    },
    handleSelectHistoryWell(well) {
      this.activeForm = null;
      this.activeFormComponentName = null;
      _.forEach(Object.keys(well), (key) => {
        this[key] = well[key];
      });
      this.selectWell({ id: well.id, name: well.wellUwi });
      this.SET_VISIBLE_PRODUCTION(false);
      this.SET_VISIBLE_INJECTION(false);
      this.isBothColumnFolded = false;
      this.isLeftColumnFolded = false;
      this.isRightColumnFolded = false;
    },
    updateWidth() {
      this.tabWidth = window.innerWidth - 77;
    },
    ...bigdatahistoricalVisibleMutations([
      "SET_VISIBLE_INJECTION",
      "SET_VISIBLE_PRODUCTION",
    ]),
    getWidthByColumns() {
      if (
        (this.isRightColumnFolded || this.isLeftColumnFolded) &&
        !this.isBothColumnFolded
      ) {
        return "width__1469";
      }
      if (
        this.isProductionWellsHistoricalVisible ||
        this.isInjectionWellsHistoricalVisible
      ) {
        return "width__1159";
      }
      if (this.isBothColumnFolded) {
        return "width__1700";
      }
      return "width__1219";
    },
  },
  computed: {
    ...bigdatahistoricalVisibleState([
      "isInjectionWellsHistoricalVisible",
      "isProductionWellsHistoricalVisible",
    ]),
    tableData: function () {
      return this.well_passport;
    },
  },
  created() {
    window.addEventListener("resize", this.updateWidth);
    this.updateWidth();
  },
};
</script>
<style lang="scss" scoped>
$leftColumnWidth: 300px;
$leftColumnFoldedWidth: 50px;
$rightColumnWidth: 300px;
$rightColumnFoldedWidth: 50px;
.well-card_tab-head {
  display: flex;
  background: #272953;
  min-height: 28px;
  margin-bottom: 5px;
  overflow-y: auto;
  width: calc(100% - 70px);
  &::-webkit-scrollbar {
    width: 4px;
  }
  &::-webkit-scrollbar-track {
    background: #181837;
    height: 4px !important;
    width: 4px !important;
  }
  &::-webkit-scrollbar-thumb {
    background: #656a8a;
    border-radius: 10px;
    height: 2px !important;
    width: 2px !important;
    border: 3px solid #181837;
  }
  div:last-child {
    max-width: 16.1%;
  }
}
.well-card_tab-head__item {
  color: #fff;
  padding: 6px 25px 6px 7px;
  position: relative;
  margin-right: 2px;
  position: relative;
  background: #363b68;
  font-weight: bold;
  font-size: 11px;
  white-space: nowrap;
  & span {
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    background-image: url(/img/bd/close_tab.svg);
    width: 20px;
    background-repeat: no-repeat;
    background-position: center;
  }
  &.active,
  &:hover {
    background: #2e50e9;
    cursor: pointer;
  }
}
.info-element-head {
  font-size: 14px;
  font-weight: bold;
  padding: 8px 15px;
  text-align: center;
}
.doc-pasport-head {
  display: flex;
  padding: 6px 8px;
  align-items: center;
  border-bottom: 2px solid #363b68;
  display: flex;
  font-size: 14px;
  color: #fff;
}
.doc-pasport .bg-dark-transparent {
  padding-bottom: 0;
}
.doc-pasport {
  position: relative;
  .icon-all {
    left: 0;
    border-radius: 0px 5px 5px 0px;
  }
}
.search-input-bd {
  width: 100%;
  width: calc(100% - 30px);
  border: none;
  background: #0000;
  border-left: 0.6px solid #363b68;
  padding: 0 6px;
  outline: none;
  color: #fff;
}
.search-input-bd::placeholder {
  color: #fff;
}
.well-card {
  &__wrapper {
    height: calc(100vh - 135px);
    display: flex;
    justify-content: space-between;
    flex-wrap: nowrap;
    width: 100%;
  }
}
.fixed-mid-col {
  min-width: calc(100% - 350px - 300px - 24px);
  padding: 0 15px;
  height: calc(100vh - 135px);
  overflow-y: auto;
}

::-webkit-scrollbar {
  height: 10px;
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #40467e;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}

::-webkit-scrollbar-thumb:hover {
  background: #656a8a;
}

::-webkit-scrollbar-corner {
  background: #20274f;
}

.flex {
  display: flex;
}

.inline-table {
  display: inline-table;
}

.b-container {
  font-family: Roboto;
  width: 480px;
  margin: 200px auto auto auto;
  padding: 10px;
  font-size: 30px;
  color: #fff;
  border-radius: 30px;
  padding: 10px;

  h6 {
    color: #fefefe;
    font-weight: 400;
    font-size: 24px;
    padding-left: 20px;
    margin-bottom: auto;
    margin-top: auto;
  }

  p {
    text-align: center;
    width: 100%;
    color: #fefefe;
    font-weight: 400;
    font-size: 24px;
    padding-left: 20px;
    margin-top: 30px;
    margin-bottom: 20px;
  }

  .b-title-block {
    padding-top: 10px;
    padding-left: 40px;
    display: flex;
  }

  .search-form {
    .search-input {
      width: 100%;
      margin-bottom: 20px;
      background: url(/img/bd/search.svg) 1% no-repeat #4f5979;
      font-size: 16px;
      padding: 10px 0px 10px 30px;
      border-radius: 10px;
    }

    .b-date {
      height: 40px;
      font-size: 14px;
      flex-direction: row-reverse;
      background: #4f5979;
      width: 65%;
      border-radius: 10px;
      color: white;
      margin-right: 7px;
    }

    .b-time {
      height: 40px;
      font-size: 14px;
      flex-direction: row-reverse;
      background: #4f5979;
      border-radius: 10px;
      color: white;
      margin-left: auto;
    }
  }

  .b-button-container {
    display: flex;
    margin-left: auto;
    margin-right: auto;

    button {
      margin-top: 30px;
      height: 40px;
      font-size: 14px;
      flex-direction: row-reverse;
      background: #4f5979;
      width: 130px;
      border-radius: 10px;
      color: white;
      margin-right: 7px;
    }

    .accept {
      background: #2e50e9;
      margin-left: auto;
      margin-right: auto;
    }

    .cancel {
      margin-left: auto;
      margin-right: auto;
      background: #132152;
      color: #abadb8;
    }
  }
}

.b-popup {
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  overflow: hidden;
  position: fixed;
  top: 0;
  display: block;
  z-index: 800;

  button {
    margin-top: 30px;
    height: 40px;
    font-size: 14px;
    flex-direction: row-reverse;
    background: #4f5979;
    width: 130px;
    border-radius: 10px;
    color: white;
    margin-right: 7px;
  }
}

.b-popup .b-popup-content {
  margin: 40px auto 0 auto;
  width: 100px;
  height: 40px;
  padding: 10px;
  background-color: #c5c5c5;
  border-radius: 5px;
  box-shadow: 0 0 10px #000;
}

h4 {
  text-align: left;
  font-size: 16px;
  font-weight: 700;
  line-height: 20px;
  color: white;
  padding-right: 20px;
}

.well-deal {
  width: 100%;
  display: flex;
  padding: 15px 19px;

  &__header {
    font-size: 14px;
    line-height: 1.4;
    color: #ffffff;
    background: #272953;
    border: 1px solid #2e325c;
    padding: 6px 8px;
    margin-bottom: 2px;
  }

  h2 {
    font-size: 20px;
    line-height: 24px;
    margin: 0;
    padding: 10px 5px;
  }

  .icon-ierarchy {
    width: 10px;
    height: 100%;
    background: url(/img/bd/ierarhy.svg) 50% 50% no-repeat;
    padding: 0 15px 0 10px;
  }
}

.new-directory {
  color: whitesmoke;

  ul,
  li {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  ul {
    padding-left: 1em;
  }

  li {
    padding-left: 1em;
    border: 1px dotted white;
    border-width: 0 0 1px 1px;
  }

  li.container {
    border-bottom: 0;
  }

  li.empty {
    font-style: italic;
    color: silver;
    border-color: silver;
  }

  li p {
    margin: 0;
    position: relative;
    bottom: 1em;
    background: #20274f;
  }

  li ul {
    border-top: 1px dotted white;
    margin-left: -1em;
    padding-left: 2em;
  }

  ul li:last-child ul {
    border-left: 0 solid white;
    margin-left: -17px;
  }
}

.graphics {
  color: white;
  background: rgb(39, 41, 83);

  .select-button {
    background: #272953;
    width: 230px !important;
    margin-top: 14px;
    margin-left: 10px;
  }

  .title {
    font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
    font-weight: 700;
    font-size: 14px;
    line-height: 17px;
    border-bottom: 1px solid #2d43b4;
    padding-top: 8px;
  }

  p {
    font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
    font-weight: 400;
    font-size: 14px;
    line-height: 17px;
    margin: 0px;
  }

  span {
    font-weight: 600;
    color: #82baff;
  }

  .well-info {
    margin: 12px;

    :nth-child(1n) {
      margin: 4px 0px;
    }
  }
}

.directory {
  display: block;
  width: 100%;
  padding: 10px 17px 10px 7px;
  height: calc(100% - 38px);
  overflow-y: auto;
  ul {
    list-style: none;
  }

  col {
    display: flex;
  }

  h3 {
    font-size: 14px;
    font-weight: 700;
    line-height: 17px;
  }

  .names {
    color: #999dc0;
  }

  .icon-directory {
    width: 10px;
    height: 100%;
    background: url(/img/bd/folder.svg) no-repeat;
    padding: 0 15px 0 10px;
  }

  .border-pointer-solid {
    width: 10px;
    height: 100%;
    padding: 0 15px 0 10px;
    margin-top: 2px;
    border-top: 1px dashed #555ba6;
    border-left: 1px dashed #555ba6;
    border-bottom: 1px dashed #555ba6;
  }

  .pointer {
    position: absolute;
    width: 10px;
    margin-bottom: auto;
  }

  &:first-child {
    border-top: 1px solid #555ba6;
  }
}

.search-form {
  .v-select {
    background: url(/img/bd/search.svg) 15px 12px #121227 no-repeat !important;
    border: 1px solid #3b4a84;
    min-width: 0;
    border: 1px solid #363b68;
    border-radius: 0;
    background-size: 14px;
    width: 220px;
  }
}

.heading {
  p {
    margin: 0;
  }
}

.file-container {
  background: #313563;
  margin-left: auto;
  margin-right: auto;
  width: 200px;
  height: 250px;

  :first-child .col {
    height: 51.1px;
  }

  .file-icon-large {
    margin-left: auto;
    margin-right: auto;
    background: url(/img/bd/file-large.svg) no-repeat;
    height: 158.21px;
    width: 120px;

    .well-name {
      padding-right: 30.03px;
      margin-top: 114.67px;
      margin-left: 11.6px;
      background: none;
      font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
      font-weight: 400;
      font-size: 10px;
      line-height: 12px;

      p {
        background: none;
        font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
        font-weight: 400;
        font-size: 10px;
        line-height: 12px;
      }

      .well-own-name {
        font-weight: 700;
        font-size: 14px;
        line-height: 16.8px;
        color: #82baff;
      }
    }
  }

  p {
    margin-left: auto;
    color: white;
    background-color: #a18f47;
  }

  .icon-container {
    width: 100%;
    margin-top: 8.68px;
    margin-left: 12.82px;
    margin-right: 15.48px;
    margin-bottom: 9.64px;
  }
}

.txt5 {
  display: flex;
  padding-left: 5px;
  font-size: 12px;
  text-align: left;
  padding-left: 10px;
}

.dropdown {
  position: relative;

  :focus {
    background: #2e50e9;
  }
}

.small-select {
  width: 100%;
  max-width: 400px;
  height: 45px;
  margin-right: auto;
  margin-left: auto;
  margin-bottom: 1em;
  white-space: pre-line;

  .txt5 {
    padding-right: 15px;
    font-family: Roboto;
    font-weight: 700;
    font-size: 14px;
    line-height: 17px;
    margin-top: auto;
    margin-bottom: auto;
  }

  :focus {
    background: #2e50e9;
    border: 0;
  }

  :visited {
    background: #2e50e9;
    border: 0;
  }
}
.middle-block-head {
  display: flex;
  padding: 0 10px;
  align-items: center;
}
.transparent-select {
  padding: 5px 20px 5px 0;
  color: #fff;
  background: none;
  border: none;
  font-weight: bold;
  font-size: 11px;
  line-height: 13px;
  color: #ffffff;
  position: relative;
  margin-right: 10px;

  &:focus {
    color: white;
    background: #20274f;
  }
  svg {
    width: 10px;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
  }
}

.table-container {
  background-color: #272953;
  overflow-y: auto;
  overflow-x: auto;
  width: 100%;
  color: white;

  .table-container-header {
    text-align: center;
    padding: 14px 20px 0 20px;
    background-color: #32346c;
  }

  .table-container-column-header {
    text-align: center;
    background-color: #505684;
    height: 50px;

    .row {
      height: 100%;
    }
  }

  &-element {
    height: 340px;
    background-color: #272953;

    .table-container-svg {
      display: flex;
    }

    .svg-element {
      padding: 5px 13px 5px 23px;
      display: grid;

      svg {
        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;
      }
    }

    .element-position {
      padding: 5px 13px 5px 23px;
      display: flex;

      p {
        float: right;
        margin-top: auto;
        margin-bottom: auto;
        margin-left: auto;
      }

      .title {
        margin-left: unset !important;
        margin-right: auto !important;
      }

      svg {
        margin: auto;
      }
    }

    .row {
      flex-wrap: nowrap;
      min-height: 40px;

      &:nth-child(2n) {
        background-color: #31355e;
      }
    }
  }

  .row {
    margin-right: 0;
  }

  .table-border {
    border-top: hidden;
    border-left: 1px solid #464d7a;
    border-bottom: hidden;
    border-right: hidden;

    p {
      margin-top: auto;
      margin-bottom: auto;
    }
  }
}

.info {
  height: calc(100vh - 169px);
  margin-bottom: 0 !important;
  overflow-y: auto;
  overflow-x: hidden;

  table {
    background: #b5d9ed;
    color: #000;
    font-size: 14px;
  }

  td,
  th {
    border: 1px solid #454d7d;
    text-align: left;
    padding: 2px;
    font-size: 13px;
    white-space: pre-line;
  }

  .heading {
    padding: 11px 0 15px 13px;
    font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
    font-weight: 700;
  }

  .info-element {
    p {
      padding: 10px 10px 12px 14px;
      margin: 0;
      font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
      font-weight: 400;
      font-size: 16px;
    }
  }

  .rotate {
    transform: rotate(-90deg) translateY(-31px);
    display: flex;
    white-space: nowrap;
    font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
    font-weight: 700;
    font-size: 14px;
  }
}

.full-size-icon {
  width: 20px;
  margin-bottom: auto;
  padding-right: 5px;
}

.icon-all {
  position: absolute;
  top: 0;
  right: 0;
  width: 13px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #2b3384;
  border-radius: 5px 0px 0px 5px;
  top: 50%;
  transform: translateY(-50%);
  :hover {
    cursor: pointer;
  }
}

.button1-vc-inner {
  display: flex;
  float: left;
  width: 100%;
  height: 100%;

  .icon-all {
    height: 100%;

    .txt5 {
      margin-bottom: auto;
      margin-top: auto;
      width: 100%;
    }
  }

  .icon-pointer {
    margin-bottom: auto;
  }

  .text-wrapper {
    display: flex;
    width: 100%;
  }
}

.btn:not(:disabled):not(.disabled) {
  width: 100%;
}

.dropdown-menu.show {
  background: #40467e;
  color: white;
  border: 1px solid #2e50e9;
  border-radius: 8px;
  margin-top: 7px;

  ul:last-child li:last-child .bottom-border {
    border-bottom: 0;
  }

  .container {
    margin: 0;
  }

  li {
    display: flex;
    width: 100%;

    input[type="checkbox"] {
      width: 5%;
      margin-left: auto;
    }
  }

  .flag {
    margin-top: auto;
    margin-bottom: auto;
    padding-right: 10px;
    content: URL(/img/bd/check-marker.svg);
  }

  .bottom-border {
    border-bottom: 1px solid rgba(196, 222, 242, 0.3);
    padding-bottom: 15px;
    padding-top: 15px;
    width: 100%;
  }

  .container {
    padding: 0;
    display: flex;
    position: relative;
    cursor: pointer;
  }

  .container input {
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .checkmark {
    height: 20px;
    width: 20px;
    border-radius: 6px;
    border: 2px solid #237deb;
    margin-bottom: auto;
    margin-top: auto;
  }

  .container:hover input ~ .checkmark {
    background-color: #6a6d9c;
  }

  .container input:checked ~ .checkmark {
    background: #2196f3;
  }

  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  .container input:checked ~ .checkmark:after {
    display: block;
  }

  .container .checkmark:after {
    width: 5px;
    height: 10px;
    bottom: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    position: inherit;
    margin: auto;
  }
}

.dropdown-menu :last-child {
  border-bottom: 0;
}

.select-button {
  background: #656a8a;
  width: 100%;
  overflow: hidden;
  border-radius: 10px;
  cursor: pointer;
  padding: 0 7px;
  height: 40px;

  .icon-all {
    align-items: center;
    display: flex;
    height: 100%;
    width: auto;
  }
}

.icon-pointer {
  margin-left: 10px;
  width: 10px;
  height: 10px;
  white-space: nowrap;
  background: url(/img/bd/pointer.svg) 50% 100% no-repeat;
  margin-left: 0px;
  margin-top: auto;
  margin-bottom: auto;
  margin-right: auto;
}

.col {
  display: flex;
  margin-right: auto;
  margin-left: auto;
}

.sheare-icon {
  margin-left: auto;
  margin-top: auto;
  margin-bottom: auto;
  display: inline-flex;

  &:hover {
    cursor: pointer;
  }
}

.sheare-text {
  font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
  color: white;
  margin: auto 11.19px auto 0px;
  font-weight: 700;
  font-size: 12px;
  line-height: 14px;
}

.bg-dark {
  padding-bottom: 20px;
}

.center {
  margin-left: auto;
  margin-right: auto;

  h2 {
    margin: 0;
    padding: 22px 25px;
    font-size: 20px;
    font-weight: 400;
    line-height: 24px;
    font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
  }
}

.pointer-large-icon {
  padding: 20px;
}

.bg-dark-transparent {
  background-color: rgba(39, 41, 83, 0.85);

  .graphics {
    height: 333px;
    width: 100%;
  }
}

.blue-section {
  color: #82baff;
}

.scrollable {
  &::-webkit-scrollbar {
    height: 4px;
    width: 4px;
  }

  &::-webkit-scrollbar-track {
    background: #40467e;
  }

  &::-webkit-scrollbar-thumb {
    background: #656a8a;
  }

  &::-webkit-scrollbar-thumb:hover {
    background: #656a8a;
  }

  &::-webkit-scrollbar-corner {
    background: #20274f;
  }
}

.table-wrapper {
  margin: 10px 20px;
  max-height: calc(100vh - 175px);
  overflow: auto;
  padding: 0;
  width: auto;
}

.col-no-right-padding {
  padding-right: 0;
  width: 250px;
  max-width: 250px;
  min-width: 250px;
  margin-left: auto;
}

.passport {
  .bg-dark-transparent {
    padding-bottom: 0;
  }
}

.vertical-wrapper {
  width: 100%;
  margin-right: 0;
  margin-left: 0;
}

.both-pressed {
  min-width: $leftColumnWidth;
  width: $leftColumnWidth;
  padding: 0 15px;
  margin-bottom: 15px;

  &_folded {
    min-width: $leftColumnFoldedWidth;
    width: $leftColumnFoldedWidth;

    .icon-all {
      transform: rotate(180deg);
    }

    .well-deal__header {
      border: none;
    }

    .title,
    .directory {
      display: none;
    }

    & ~ .mid-col {
      min-width: calc(
        100% - #{$leftColumnFoldedWidth} - #{$rightColumnFoldedWidth} - 24px
      ) !important;
      max-width: none !important;
      min-width: none !important;
    }
  }

  &__inner {
    height: 100%;
  }
}

.left-column {
  min-width: $leftColumnWidth;
  width: $leftColumnWidth;
  position: relative;
  margin-bottom: 0;
  height: 100%;
  .rotate {
    color: white;
    white-space: nowrap;
    transform: rotate(-90deg) translateY(-40px);
    display: flex;
    font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
    font-weight: 500;
  }

  &_folded {
    min-width: $leftColumnFoldedWidth;
    width: $leftColumnFoldedWidth;
    background: #272953;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    .icon-all {
      transform: rotate(180deg);
    }

    .well-deal__header {
      border: none;
    }

    .title,
    .directory,
    .well-deal__header {
      display: none;
    }

    & ~ .mid-col {
      min-width: calc(
        100% - #{$leftColumnFoldedWidth} - #{$rightColumnWidth} - 24px
      );
    }

    .scrollable {
      height: 100%;
    }
  }

  &__inner {
    height: 100%;
  }
}

.title-container {
  display: flex;
}

.historical-data {
  height: 100%;
  margin-left: 15px;
  min-width: 440px;
  max-width: 440px;
}

.right-column {
  min-width: $rightColumnWidth;
  padding-left: 15px;
  flex: 0 0 5%;

  &__inner {
    height: 100%;
    background: rgba(39, 41, 83, 0.85);
    width: 300px;
  }

  &_folded {
    min-width: $leftColumnFoldedWidth;
    width: $leftColumnFoldedWidth;
    max-width: $leftColumnFoldedWidth;
    margin: 0px;
    background: #272953;
    & ~ .mid-col {
      min-width: calc(
        100% - #{$leftColumnWidth} - #{$rightColumnFoldedWidth} - 24px
      );
    }

    & .info[data-v-b1a5f7e2] {
      align-items: center;
      display: flex;
    }
    .icon-all {
      transform: rotate(180deg);
    }

    .small_history_table .historical-info-parent {
      width: 810px;
      /* overflow: hidden; */
    }
    p,
    .heading,
    .doc-pasport-head {
      display: none;
    }

    table {
      display: none;
    }

    .title-container {
      display: none;
    }
  }
}

.buttons-no-wrap {
  min-width: 150px !important;
}

.calc-width {
  flex: calc(100% - 250px);
  max-width: calc(100% - 250px);
}

.mid-col {
  min-width: calc(100% - #{$leftColumnWidth} - #{$rightColumnWidth} - 24px);
  padding: 0 15px;
  height: calc(100vh - 135px);
  overflow-y: auto;
  &__main {
    &-inner {
      margin-bottom: 0;
    }
  }

  .col-md-12 {
    height: 100%;
  }
}

.file-size {
  margin-left: auto;
  margin-bottom: auto;

  p {
    padding: 2.59px 5px 5px 5.55px;
    font-size: 14px;
    font-weight: 700;
    font-family: "Harmonia Sans Pro Cyr", "Harmonia-Sans", "Robato";
    line-height: 16px;
  }
}
.button-block__item {
  font-size: 14px;
  line-height: 17px;
  color: #ffffff;
  background: #334296;
  border-radius: 4px;
  white-space: nowrap;
  padding: 4px 20px;
  margin-left: 10px;
  &:hover {
    background-color: #121227;
  }
}
.button-block {
  display: flex;
  margin-left: auto;
  div:not(:last-child) {
    background: #293688;
    border: 1px solid #3366ff;
    border-radius: 5px;
  }
}
@media (max-width: 1640px) {
  .button-block__item[data-v-b1a5f7e2] {
    font-size: 10px;
    padding: 4px 10px;
    margin-left: 5px;
  }
}
</style>
<style lang="scss">
.search-form {
  .v-select {
    border-radius: 10px;
    .vs__search {
      font-family: Roboto, sans-serif;
      font-size: 14px;
      font-weight: 400;
      margin-top: 0;
      padding-left: 45px;
    }

    .vs__selected {
      font-family: Roboto, sans-serif;
      font-size: 14px;
      font-weight: 400;
      margin-top: 0;
      padding-left: 45px;
    }

    .vs__actions {
      padding: 0 5px;

      .vs__clear,
      .vs__open-indicator {
        display: none;
      }

      .vs__spinner,
      .vs__spinner:after {
        border-color: rgba(238, 238, 238, 0.7);
        border-left-color: rgba(170, 170, 170, 0.7);
      }
    }
  }
}

.block {
  display: block;
}

.directory {
  .file {
    br {
      display: none;
    }
  }
}

.select-dzo {
  background-color: #494aa5;
  color: #fff;
  outline: none;
  border: 1px solid #494aa5;
  border-radius: 5px;
  padding: 3px 10px;
  width: 170px;
}

.select-dzo:hover {
  border: 1px solid transparent;
  box-shadow: inset 0 0px 0px 1px #ccc;
}
.selected-well {
  background: #2e50e9 !important;
}
.wells-history-title {
  color: #fff;
  padding-top: 5px;
}
.well-info_header {
  position: fixed;
  z-index: 5;
  margin-left: -15px;
}
.pt__40 {
  padding-top: 40px;
}
.width__1219 {
  width: 1219px;
}
.width__1700 {
  width: 1720px;
}
.width__1469 {
  width: 1469px;
}
.width__1159 {
  width: 1159px;
}
.icon-filter {
  width: 20px;
  background: url(/img/bd/filter.svg) no-repeat;
  margin-left: 10px;
  margin-top: 5px;
  border: none;
}
.cursor-pointer {
  cursor: pointer;
}
.modal-show {
  z-index: 1000;
  position: absolute;
  top: 100%;
  color: #fff;
  margin-left: 9px;
}
.modal_show_item {
  display: flex;
  align-items: center;
  padding: 4px;
}
.modal_show_img {
  width: 24px;
}
.legenda_text {
  margin-left: 5px;
}
</style>
