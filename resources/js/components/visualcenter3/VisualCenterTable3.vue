<template>
  <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100 all-height">
    <div class="left-side flex-grow-1 pr-3">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1">
            <tr>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ new Intl.NumberFormat("ru-RU").format(oil_factDay) }}
                    </div>
                    <div class="unit-vc">тонн</div>
                  </div>
                  <div class="txt1">Добыча нефти</div>
                  <br />
                  <div class="progress">
                    <br />
                    <div
                      class="progress-bar"
                      role="progressbar"
                      :style="{
                        width: oil_factDayProgressBar + '%',
                      }"
                      :aria-valuenow="oil_planDay"
                      aria-valuemin="0"
                      :aria-valuemax="oil_factDay"
                    ></div>
                  </div>
                  <div class="percent-header" v-if="oil_factDay">
                    {{
                      (
                        100 -
                        (oil_factDayPercent / oil_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_planDay) }}
                  </div>
                  <br />
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 > 0"
                    class="arrow2"
                  ></div>
                  <div
                    v-if="(oil_factDayPercent / oil_factDay - 1) * 100 < 0"
                    class="arrow3"
                  ></div>

                  <div class="txt2" v-if="oil_factDay">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        Math.abs(
                          (oil_factDayPercent / oil_factDay - 1) * 100
                        ).toFixed(2)
                      )
                    }}%
                  </div>
                  <div class="txt3">vs прошлый период</div>
                </div>
                <div class="second-td-header">
                  <div class="vert-line"></div>
                </div>
              </td>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{
                        new Intl.NumberFormat("ru-RU").format(oil_dlv_factDay)
                      }}
                    </div>
                    <div class="unit-vc">тонн</div>
                  </div>
                  <div class="txt1">Сдача нефти</div>
                  <br />
                  <div class="progress">
                    <br />
                    <div
                      class="progress-bar"
                      role="progressbar"
                      :style="{
                        width: oil_dlv_factDayProgressBar + '%',
                      }"
                      :aria-valuenow="oil_dlv_factDay"
                      aria-valuemin="0"
                      :aria-valuemax="oil_dlv_planDay"
                    ></div>
                  </div>

                  <div class="percent-header" v-if="oil_dlv_factDay">
                    {{
                      (
                        100 -
                        (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_dlv_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(oil_dlv_planDay) }}
                  </div>
                  <br />
                  <div
                    v-if="
                      (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100 > 0
                    "
                    class="arrow2"
                  ></div>
                  <div
                    v-if="
                      (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100 < 0
                    "
                    class="arrow3"
                  ></div>

                  <div class="txt2" v-if="oil_dlv_factDay">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        Math.abs(
                          (oil_dlv_factDayPercent / oil_dlv_factDay - 1) * 100
                        ).toFixed(2)
                      )
                    }}%
                  </div>
                  <div class="txt3">vs прошлый период</div>
                </div>
                <div class="second-td-header">
                  <div class="vert-line"></div>
                </div>
              </td>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ new Intl.NumberFormat("ru-RU").format(gas_factDay) }}
                    </div>
                    <div class="unit-vc">
                      <!--млрд.-->
                      млн. м³
                    </div>
                  </div>
                  <div class="txt1">Добыча газа</div>
                  <br />
                  <div class="progress">
                    <br />

                    <div
                      class="progress-bar"
                      role="progressbar"
                      :style="{
                        width: gas_factDayProgressBar + '%',
                      }"
                      :aria-valuenow="gas_factDay"
                      aria-valuemin="0"
                      :aria-valuemax="gas_planDay"
                    ></div>
                  </div>

                  <div class="percent-header" v-if="gas_factDay">
                    {{
                      (
                        100 -
                        (gas_factDayPercent / gas_factDay - 1) * 100
                      ).toFixed(2)
                    }}%
                  </div>
                  <div class="plan-header" v-if="gas_planDay">
                    {{ new Intl.NumberFormat("ru-RU").format(gas_planDay) }}
                  </div>

                  <br />
                  <div
                    v-if="(gas_factDayPercent / gas_factDay - 1) * 100 > 0"
                    class="arrow2"
                  ></div>
                  <div
                    v-if="(gas_factDayPercent / gas_factDay - 1) * 100 < 0"
                    class="arrow3"
                  ></div>

                  <div class="txt2" v-if="gas_factDay">
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        Math.abs(
                          (gas_factDayPercent / gas_factDay - 1) * 100
                        ).toFixed(2)
                      )
                    }}%
                  </div>
                  <div class="txt3">vs прошлый период</div>
                </div>
                <div class="second-td-header"></div>
              </td>
              <td
                style="width: 200px; border-left: 10px solid #0f1430"
                @click="changeTable('2')"
                :style="`${tableHover2}`"
              >
                <div class="nu">
                  <div class="number">{{ oilNow }}</div>
                  <div class="unit-vc">$ / bbl</div>
                </div>
                <br />
                <div class="txt1">Цена на нефть</div>
                <br />
                <div class="percent-currency">
                  <div class="arrow"></div>
                  <div class="txt2">5,2%</div>
                  <div class="txt3">vs сентябрь</div>
                </div>
              </td>
              <td
                style="width: 200px; border-left: 10px solid #0f1430"
                @click="changeTable('3')"
                :style="`${tableHover3}`"
              >
                <div class="nu">
                  <div class="number">{{ currencyNow }}</div>
                  <div class="unit-vc">kzt / $</div>
                </div>
                <br />
                <div class="txt1">Курс доллара</div>
                <br />
                <div class="percent-currency">
                  <div class="arrow"></div>
                  <div class="txt2">5,2%</div>
                  <div class="txt3">vs сентябрь</div>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="first-table big-area" :style="`${Table1}`">
        <div class="first-string first-string2">
          <!--<div class="container-fluid">
            class="table-responsive"-->
          <!--<table class="table table2">
              <tr>-->
          <div class="row px-4 mt-3">
            <div class="col dropdown3">
              <input type="checkbox" id="menu" />

              <div
                class="button1"
                :style="`${buttonHover1}`"
                @click="
                  getProduction(
                    'oil_plan',
                    'oil_fact',
                    `${oilChartHeadName}`,
                    'тн',
                    'Добыча нефти'
                  )
                "
              >
                <!-- <label for="menu">-->
                <div class="icon-all icons1"></div>
                <div class="txt5">Добыча нефти</div>
                <div class="txt6">тыс. тн</div>
                <!--   </label>-->
              </div>

              <!-- <div class="dropdown">-->

              <ul>
                <li class="center-li row px-4" @click="changeMenu('101')">
                  <a class="col-10">С учётом доли участия КМГ</a>
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton1}`">
                      &#10003;
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col dropdown3">
              <div
                class="button1"
                :style="`${buttonHover2}`"
                @click="
                  getProduction(
                    'oil_dlv_plan',
                    'oil_dlv_fact',
                    'Динамика сдачи нефти',
                    'тыс. тн',
                    'Сдача нефти'
                  )
                "
              >
                <div class="icon-all icons2"></div>
                <div class="txt5">Сдача нефти</div>
                <div class="txt6">тыс. тонн</div>
              </div>

              <ul>
                <li class="center-li row px-4" @click="changeMenu('102')">
                  <a class="col-10">Сдача нефти по узлам учёта</a>
                  <div class="col-2"><div class="square-small2"   :style="`${changeMenuButton2}`">✓</div></div>
                </li>
                <li class="center-li row px-4" @click="changeMenu('103')">
                  <a class="col-10">Товарный остаток нефти</a>
                  <div class="col-2"><div class="square-small2" :style="`${changeMenuButton3}`">✓</div></div>
                </li>

                <!-- <li class="center-li" @click="changeMenu('102')">
                      <a>Сдача нефти по узлам учёта</a>
                      <div
                        class="square-small2"
                        :style="`${changeMenuButton2}`"
                      >
                        &#10003;
                      </div>
                    </li>

                    <li class="center-li" @click="changeMenu('103')">
                      <a>Товарный остаток нефти</a>
                      <div
                        class="square-small2"
                        :style="`${changeMenuButton3}`"
                      >
                        &#10003;
                      </div>
                    </li>-->
              </ul>
            </div>
            <div class="col dropdown3">
              <div
                class="button1"
                :style="`${buttonHover3}`"
                @click="
                  getProduction(
                    'gas_plan',
                    'gas_fact',
                    'Динамика добычи газа',
                    'тыс м³',
                    'Добыча газа'
                  )
                "
              >
                <div class="icon-all icons3"></div>
                <div class="txt5">Добыча газа</div>
                <div class="txt6">тыс м³</div>
              </div>
              <ul>
                <li class="center-li">
                  <a href> Сдача природного газа</a>
                </li>
                <li class="center-li">
                  <a href>Расход природного газа на собственные нужды </a>
                </li>
                <li class="center-li">
                  <a href>Переработка природного газа</a>
                </li>
                <li class="center-li"><a href>Сдача попутного газа </a></li>
                <li class="center-li">
                  <a href>Расход попутного газа на собственные нужды </a>
                </li>
                <li class="center-li">
                  <a href> Переработка попутного газа </a>
                </li>
              </ul>
            </div>
            <div class="col dropdown3">
              <div
                class="button1"
                :style="`${buttonHover5}`"
                @click="
                  getProduction(
                    'gk_plan',
                    'gk_fact',
                    'Динамика добычи конденсата',
                    'тыс. тн',
                    'Добыча конденсата'
                  )
                "
              >
                <div class="icon-all icons4"></div>
                <div class="txt5">Добыча конденсата</div>
                <div class="txt6">тыс. тонн</div>
              </div>
              <ul>
                <li class="center-li">
                  <a href>С учётом доли участия КМГ</a>
                </li>
              </ul>
            </div>
            <div class="col dropdown3">
              <div
                class="button1"
                :style="`${buttonHover6}`"
                @click="
                  getProduction(
                    'liq_plan',
                    'liq_fact',
                    'Динамика объёма закачки воды',
                    'м³',
                    'Закачка воды'
                  )
                "
              >
                <div class="icon-all icons5"></div>
                <div class="txt5">Закачка воды</div>
                <div class="txt6">тыс. м³</div>
              </div>
              <ul>
                <li class="center-li"><a href> Закачка морской воды</a></li>
                <li class="center-li"><a href>Закачка сточной воды</a></li>
                <li class="center-li"><a href>Закачка альбсен. воды</a></li>
              </ul>
            </div>
          </div>
          <!--  </tr>
            </table>
          </div>-->

          <div class="row px-4 mt-3">
            <div class="col">
              <div
                class="button2"
                :style="`${buttonHover7}`"
                @click="changeMenu2(1)"
              >
                Суточная
              </div>
            </div>
            <div class="col">
              <div
                class="button2"
                :style="`${buttonHover8}`"
                @click="changeMenu2(2)"
              >
                С начала месяца
              </div>
            </div>
            <div class="col">
              <div
                class="button2"
                :style="`${buttonHover9}`"
                @click="changeMenu2(3)"
              >
                С начала года
              </div>
            </div>
            <div class="col">
              <div class="dropdown3">
                <div
                  class="button2"
                  :style="`${buttonHover10}`"
                  @click="changeMenu2(4)"
                >
                  Календарь
                </div>
                <ul class="center-menu2 right-indent">
                  <li class="center-li">
                    <br /><br />

                    <div class="month-day">
                      <div class="calendar-day">
                        <date-picker
                          v-if="selectedDMY == 0"
                          mode="range"
                          v-model="range"
                          is-range
                          class="m-auto"
                          :model-config="modelConfig"
                          @input="changeDate"
                        />
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!--   <div class="container-fluid">
            <table class="table table2">
                        <tr>
                <td>-->

          <div class="row mt-3">
            <div
              class="col assets4"
              :style="`${buttonHover11}`"
              @click="changeAssets('b11')"
            >
              Операционные активы
            </div>

            <div
              class="col assets4"
              :style="`${buttonHover12}`"
              @click="changeAssets('b12')"
            >
              Неоперационные активы
            </div>

            <div
              class="col assets4"
              :style="`${buttonHover13}`"
              @click="changeAssets('b13')"
            >
              Все активы КМГ
            </div>

            <!-- </tr>
           
       </div>-->
          </div>

          <div class="row container-fluid" :style="`${displayTable}`">
            <div class="col-6 px-3">
              <table class="table4-2 w-100" v-if="isEnableSpeedometers">
                <tbody>
                  <tr>
                    <td class="big-table-hidtd small-td"></td>

                    <td class="small-td">
                      <div class="center2">план ({{ item4 }})</div>
                    </td>
                    <td class="small-td">
                      <div class="center2">факт ({{ item4 }})</div>
                    </td>
                    <td class="small-td">
                      <div class="center2">+/- ({{ item4 }})</div>
                    </td>
                    <td class="small-td"><div class="center2">%</div></td>
                  </tr>

                  <tr v-for="(item, index) in tables">
                    <td
                      @click="saveCompany('all')"
                      :class="index % 2 === 0 ? 'tdStyle' : 'tdNone first-td'"
                    >
                      <div class="first-td">{{ getNameDzoFull(item.dzo) }}</div>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <!--old date-->
                      <div v-if="item.productionPlanForMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            item.productionPlanForMonth
                          )
                        }}
                      </div>

                      <div v-if="item.planYear">
                        {{
                          new Intl.NumberFormat("ru-RU").format(item.planYear)
                        }}
                      </div>
                      <!--old date-->

                      <div class="font" v-if="item.plan">
                        {{ new Intl.NumberFormat("ru-RU").format(item.plan) }}
                       <!-- <div class="right">{{ item4 }}</div>-->
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <!--old date-->
                      <div v-if="item.productionFactForMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            item.productionFactForMonth
                          )
                        }}
                      </div>

                      <div v-if="item.factYear">
                        {{
                          new Intl.NumberFormat("ru-RU").format(item.factYear)
                        }}
                      </div>
                      <!--old date-->

                      <div class="font" v-if="item.fact">
                        {{ new Intl.NumberFormat("ru-RU").format(item.fact) }}
                        <!--<div class="right">{{ item4 }}</div>-->
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div
                        v-if="item.productionFactForMonth"
                        class="triangle2"
                        :style="`${getColor2(
                          item.productionFactForMonth -
                            item.productionPlanForMonth
                        )}`"
                      ></div>
                      <div
                        class="percent2 font"
                        v-if="item.productionFactForMonth"
                      >
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(
                              item.productionFactForMonth -
                                item.productionPlanForMonth
                            )
                          )
                        }}
                       <!-- <div class="right">{{ item4 }}</div>-->
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div
                        v-if="item.productionFactForMonth"
                        class="triangle2"
                        :style="`${getColor2(
                          ((item.productionFactForMonth -
                            item.productionPlanForMonth) /
                            item.productionPlanForMonth) *
                            100
                        )}`"
                      ></div>
                      <div class="percent2 font">
                        <!--                                       
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(
                              (productionFactPercentOneDzo /
                                item.productionFactForMonth -
                                1) *
                                100
                            ).toFixed(2)
                          )
                        }}-->
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            (Math.abs(
                              item.productionFactForMonth -
                                item.productionPlanForMonth
                            ) /
                              item.productionPlanForMonth) *
                              100
                          )
                        }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
                 <div class="text-center p-3" v-else>
                        <div class="box">
                            <div class="cat">
                                <div class="cat__body"></div>
                                <div class="cat__body"></div>
                                <div class="cat__tail"></div>
                                <div class="cat__head"></div>
                            </div>
                        </div>
                    </div>

              
            </div>

            <div class="col-6 pl-5">
              <div class="name-chart-left">{{ nameChartLeft }}</div>
              <div class="name-chart-head">{{ item3 }}</div>
              <vc-chart v-if="company != 'all'"> </vc-chart>
            </div>
          </div>
          <div   class="row container-fluid" :style="`${displayHeadTables}`">
            <div class="col-6 px-3">
              <table class="table4 w-100" v-if="isEnableSpeedometers">
                <tbody>
                  <tr>
                    <td class="big-table-hidtd small-td"></td>

                    <td class="small-td">
                      <div class="center">план</div>
                    </td>
                    <td class="small-td">
                      <div class="center">факт</div>
                    </td>
                    <td class="small-td">
                      <div class="center">+/-</div>
                    </td>
                    <td class="small-td"><div class="center">%</div></td>
                  </tr>

                  <tr v-for="(item, index) in bigTable">
                    <td
                      @click="saveCompany(item.dzoMonth)"
                      :class="index % 2 === 0 ? 'tdStyle' : 'tdNone first-td'"
                    >
                      <div class="first-td">
                        {{ getNameDzoFull(item.dzoMonth) }}
                      </div>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div class="font" v-if="item.planMonth">
                        <!-- {{
                          new Intl.NumberFormat("ru-RU").format(item.planDay)
                        }}-->

                        {{
                          new Intl.NumberFormat("ru-RU").format(item.planMonth)
                        }}

                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div class="font" v-if="item.factMonth">
                        <!--  {{
                          new Intl.NumberFormat("ru-RU").format(item.factDay)
                        }}-->

                        {{
                          new Intl.NumberFormat("ru-RU").format(item.factMonth)
                        }}

                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div
                        v-if="item.factMonth"
                        class="triangle"
                        :style="`${getColor(item.factMonth - item.planMonth)}`"
                      ></div>
                      <div class="percent font" v-if="item.factMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(item.factMonth - item.planMonth)
                          )
                        }}
                        <!-- <div class="right">{{ item4 }}</div>-->
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div
                        v-if="item.factMonth"
                        class="triangle"
                        :style="`${getColor(
                          ((item.factMonth - item.planMonth) / item.planMonth) *
                            100
                        )}`"
                      ></div>
                      <div class="percent font" v-if="item.factMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(
                              ((item.factMonth - item.planMonth) /
                                item.planMonth) *
                                100
                            ).toFixed(2)
                          )
                        }}
                        %
                      </div>
                    </td>
                  </tr>

                  <!--  <tr>
                <td colspan="13">1</td>
              </tr>

              <tr>
                <td>2</td>
              </tr>

              <tr>
                <td colspan="13">3</td>
              </tr>-->

                  <tr>
                    <td :class="index % 2 === 0 ? 'tdStyle3-total' : 'tdNone'">
                      <div class="">{{ NameDzoFull[0] }}</div>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'
                      "
                    >
                      <div class="font">
                        <!--{{ new Intl.NumberFormat("ru-RU").format(planDaySumm) }}-->

                        {{
                          new Intl.NumberFormat("ru-RU").format(planMonthSumm)
                        }}

                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                      <div class="font">
                        <!-- {{ new Intl.NumberFormat("ru-RU").format(factDaySumm) }}-->
                        {{
                          new Intl.NumberFormat("ru-RU").format(factMonthSumm)
                        }}
                        <div class="right">{{ item4 }}</div>
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight3' : 'tdStyleLight2'
                      "
                    >
                      <div
                        v-if="factMonthSumm"
                        class="triangle"
                        :style="`${getColor(factMonthSumm - planMonthSumm)}`"
                      ></div>
                      <div class="percent font">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(factMonthSumm - planMonthSumm)
                          )
                        }}

                        <!--<div class="right">{{ item4 }}</div>-->
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                      <div
                        v-if="factMonthSumm"
                        class="triangle"
                        :style="`${getColor(
                          ((factMonthSumm - planMonthSumm) / planMonthSumm) *
                            100
                        )}`"
                      ></div>
                      <div class="percent font" v-if="factMonthSumm">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(
                              ((factMonthSumm - planMonthSumm) /
                                planMonthSumm) *
                                100
                            ).toFixed(2)
                          )
                        }}
                        %
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="text-center p-3" v-else>
                        <div class="box">
                            <div class="cat">
                                <div class="cat__body"></div>
                                <div class="cat__body"></div>
                                <div class="cat__tail"></div>
                                <div class="cat__head"></div>
                            </div>
                        </div>
                    </div>
              
            </div>
            

            <div class="col-6 pl-5">
              <div class="name-chart-left">{{ nameChartLeft }}</div>
              <div class="name-chart-head">{{ item3 }}</div>
              <vc-chart v-if="company == 'all'"> </vc-chart>
            </div>
          </div>

             
          
        </div>
          
      </div>
      

      

      <div class="second-table big-area " :style="`${Table2}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="container-fluid">
            <br />

            <div
              @click="selectedDMY = menuDMY.id"
              class="period"
              v-for="(menuDMY, index) in periodSelectFunc()"
              :style="{
                color: menuDMY.current,
              }"
              v-on:click="periodSelect"
            >
              <div>{{ menuDMY.DMY }}</div>
            </div>
            <visual-center-chart-area-oil3></visual-center-chart-area-oil3>
          </div>
        </div>
      </div>

      <div class="third-table big-area" :style="`${Table3}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="container-fluid">
            <br />

            <div
              @click="selectedDMY2 = menuDMY.id"
              class="period"
              v-for="(menuDMY, index) in periodSelectFunc()"
              :style="{
                color: menuDMY.current2,
              }"
              v-on:click="periodSelectUSD"
            >
              <div>{{ menuDMY.DMY }}</div>
            </div>
            <visual-center-chart-area-usd3></visual-center-chart-area-usd3>
          </div>
        </div>
      </div>

      <div class="third-table big-area" :style="`${Table5}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <div class="area-6-name row mt-3 mb-3 px-2">
              <div class="col">
                <div class="ml-4 bold">                    Фонд нагнетательных скважин
                </div>
              </div>
              <div class="col px-4">
                <div class="close2" @click="changeTable('1')">Закрыть</div>
              </div>
            </div>

            <div class="row px-4">
              <div class="w-25 pr-2">
                <div
                  class="button2"
                  :style="`${buttonHover7}`"
                  @click="changeMenu2(1)"
                >
                  Суточная
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                  class="button2"
                  :style="`${buttonHover8}`"
                  @click="changeMenu2(2)"
                >
                  С начала месяца
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                  class="button2"
                  :style="`${buttonHover9}`"
                  @click="changeMenu2(3)"
                >
                  С начала года
                </div>
              </div>
              <div class="w-25 px-2">
                <div class="dropdown3">
                  <div
                    class="button2"
                    :style="`${buttonHover10}`"
                    @click="changeMenu2(4)"
                  >
                    Календарь
                  </div>
                  <ul class="center-menu2 right-indent">
                    <li class="center-li">
                      <br /><br />

                      <div class="month-day">
                        <div class="calendar-day">
                          <date-picker
                            v-if="selectedDMY == 0"
                            mode="range"
                            v-model="range"
                            is-range
                            class="m-auto"
                            :model-config="modelConfig"
                            @input="changeDate"
                          />
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <br />
            <div class="">
              <div class="row px-4">
                <div class="w-50 pr-2">
                  <select
                    style="
                      background-color: #333975;
                      border-color: #20274e;
                      color: white;
                    "
                    class="form-control w-100"
                    id="companySelect"
                    @change="onChange($event)"
                  >
                    <option value="">
                      <div class="float">Компания</div>
                    </option>
                    <option value="АО ОМГ">АО «ОзенМунайГаз»</option>
                    <option value="КБМ">АО «Каражанбасмунай»</option>
                    <option value="КазГерМунай">ТОО «КазГерМунай»</option>
                    <option value="АО ЭМГ">АО «ЭмбаМунайГаз»</option>
                    <option value="ММГ">АО «Мангистаумунайгаз»</option>
                  </select>
                </div>

                <div class="w-50 pl-2 pr-1">
                  <select
                    style="
                      background-color: #333975;
                      border-color: #20274e;
                      color: white;
                    "
                    class="form-control w-100"
                    id="companySelect"
                    @change="onChange($event)"
                  >
                    <option value="work">
                      <div class="float">В работе</div>
                    </option>
                    <option value="notWork">В простое</option>
                  </select>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
              <div class="col-6">
                <table class="table4">
                  <tr v-for="(item, index) in prod_wells_workAll">
                    <!-- @click="saveCompany('all')"-->
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyle wells-td' : 'tdNone wells-td'
                      "
                    >
                      <div class="first-td">
                        {{ item.name }}
                      </div>
                      <!--{{ getNameDzoFull(item.name) }}-->
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyle wells-td' : 'tdNone wells-td'
                      "
                    >
                      <div class="font">
                        {{ item.value }}
                      </div>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyle wells-td' : 'tdNone wells-td'
                      "
                    >
                      <div class="font">
                       
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="col-6 px-2">
                <visual-center3-wells></visual-center3-wells>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--
      <div class="third-table" :style="`${Table4}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="big-area container-fluid">Фонд добывающих скважин</div>
        </div>
      </div>-->

      <div class="third-table big-area" :style="`${Table4}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="container-fluid">
        Фонд добывающих скважин
          </div>
        </div>
      </div>

      <div class="third-table big-area" :style="`${Table6}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class=" container-fluid">ОТМ</div>
        </div>
      </div>

      <div class="third-table big-area" :style="`${Table7}`">
        <div class="first-string first-string2">
          <div class="close2" @click="changeTable('1')">Закрыть</div>
          <div class="container-fluid">Химизация</div>
        </div>
      </div>
    </div>
    <div class="right-side2 flex-grow-1">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1-2">
            <tr>
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4">
                  <!--v-if="wells2[0].prod_wells_work"  wells2[0].prod_wells_work-->
                  {{ new Intl.NumberFormat("ru-RU").format(prod_wells_work) }}
                </div>
                <div class="in-work">В работе</div>
                <div class="arrow"></div>
                <div class="txt2">48</div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4">
                  <!--v-if="wells2[0].prod_wells_idle"-->
                  {{
                    new Intl.NumberFormat("ru-RU").format(
                      // wells2[0].prod_wells_idle
                      prod_wells_idle
                    )
                  }}
                </div>
                <div class="in-idle">В простое</div>
                <div class="arrow"></div>
                <div class="txt2">200</div>
                <br />
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt2">Фонд добывающих скважин</div>
              </td>
            </tr>
          </table>
          <!-- <div class="line-bottom"></div>-->
        </div>
        <div class="first-string first-string2">
          <div class="table-responsive">
            <table class="table table1-2">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4">
                    <!--v-if="wells[0].inj_wells_work"-->
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        //wells[0].inj_wells_work
                        inj_wells_work
                      )
                    }}
                  </div>
                  <div class="in-work">В работе</div>
                  <div class="arrow"></div>
                  <div class="txt2">48</div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4">
                    <!-- v-if="wells[0].inj_wells_idle"-->
                    {{
                      new Intl.NumberFormat("ru-RU").format(
                        // wells[0].inj_wells_idle
                        inj_wells_idle
                      )
                    }}
                  </div>
                  <div class="in-idle">В простое</div>
                  <div class="arrow"></div>
                  <div class="txt2">200</div>
                  <br />
                </td>
              </tr>
              <tr>
                <td
                  colspan="2"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt2">Фонд нагнетательных скважин</div>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="first-string first-string2">
          <div class="table-responsive">
            <table class="table table5">
              <tr>
                <td
                  class="w-50"
                  @click="changeTable('6')"
                  :style="`${tableHover6}`"
                >
                  <div class="otm"></div>
                  <div class="txt2">ОТМ</div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('7')"
                  :style="`${tableHover7}`"
                >
                  <div class="him"></div>
                  <div class="txt2">Химизация</div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">908</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">7</div>
                </div>
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Численность персонала</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">24</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">11</div>
                </div>
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">COVID-19</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table table1-2">
            <tr>
              <td>
                <div class="number">11</div>
                <div class="near-number">
                  <!-- <div class="column-1">
                    <div class="arrow"></div>
                    <div class="txt2">7</div>
                  </div>-->
                  <div class="column-1">
                    <!-- <div class="in-idle">Прирост</div>-->
                    <div class="in-idle">с начала</div>
                    <div class="in-idle">месяца</div>
                  </div>
                </div>
              </td>

              <td>
                <div class="number">11</div>
                <div class="near-number">
                  <!--  <div class="column-1">
                    <div class="arrow"></div>
                    <div class="txt2">7</div>
                  </div>-->
                  <div class="column-1">
                    <!--<div class="in-idle">Прирост</div>-->
                    <div class="in-idle">с начала</div>
                    <div class="in-idle">года</div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Несчастные случаи</div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">2</div>
              </td>

              <td class="w-65">
                <!--  <div class="column-1">
                  <div class="arrow"></div>
                  <div class="txt2">1</div>
                </div>-->
                <div class="column-1">
                  <div class="in-idle">Прирост</div>
                  <div class="in-idle">с начала месяца</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">Смертельные случаи</div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script src="./VisualCenterTable3.js"></script>
