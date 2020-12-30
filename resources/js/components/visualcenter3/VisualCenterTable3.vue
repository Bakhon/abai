<template>
  <div
    class="d-flex flex-column flex-sm-row justify-content-between w-sm-100 all-height p-2"
  >
    <div class="left-side flex-grow-1 pr-2">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1">
            <tr>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          (oil_factDay / 1000).toFixed(0)
                        )
                      }}
                    </div>
                    <div class="unit-vc">тыс. тонн</div>
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
                        new Intl.NumberFormat("ru-RU").format(
                          (oil_dlv_factDay / 1000).toFixed(0)
                        )
                      }}
                    </div>
                    <div class="unit-vc">тыс. тонн</div>
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
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          (gas_factDay / 1000).toFixed(0)
                        )
                      }}
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

              <td class="vc-select-table"
                style="width: 200px; border-left: 10px solid #0f1430"
                @click="changeTable('2')"
                :style="`${tableHover2}`"
              >

<!--              <td class="vc-select-table"-->
<!--                  style="width: 200px; border-left: 10px solid #0f1430"-->
<!--                  :style="`${tableHover2}`"-->
<!--              >-->
                <div class="nu">
                  <div class="number d-flex justify-content-between">
                      <div>
                          {{ oilNow }}
                      </div>
                      <div class="mt-1">
                          <img src="/img/icons/link.svg">
                      </div>
                  </div>
                  <div class="unit-vc">$ / bbl</div>
                </div>
                <br />
                <div class="txt1">Цена на нефть (Brent)</div>

                <div class="percent-currency">
                  <div class="arrow"></div>
                  <div class="txt2">5,2%</div>
                  <div class="txt3">vs сентябрь</div>
                </div>
              </td>
              <td class="vc-select-table"
                style="width: 200px; border-left: 10px solid #0f1430"
                @click="changeTable('3')"
                :style="`${tableHover3}`"
              >
                <div class="nu">
                    <div class="number d-flex justify-content-between">
                        <div>
                            {{ currencyNow }}
                        </div>
                        <div class="mt-1">
                            <img src="/img/icons/link.svg">
                        </div>
                    </div>
                  <div class="unit-vc">kzt / $</div>
                </div>
                <br />
                <div class="txt1">Курс доллара</div>
                <br />
                <div class="percent-currency">
                  <div class="arrow" v-if="dailyCurrencyChangeIndexUsd === 'UP'"></div>
                  <div class="arrow2" v-if="dailyCurrencyChangeIndexUsd === 'DOWN'"></div>
                  <div class="txt2">{{ dailyCurrencyChangeUsd }}%</div>
                  <div class="txt3">vs вчера</div>
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
            <div class="col dropdown3 font-weight">
              <input type="checkbox" id="menu" />

              <div
                class="button1"
                :style="`${buttonHover1}`"
                @click="
                  getProduction(
                    'oil_plan',
                    'oil_fact',
                    `${oilChartHeadName}`,
                    'тыс. тонн',
                    'Добыча нефти'
                  )
                "
              >
                <!-- <label for="menu">-->
                <div class="icon-all icons1"></div>
                <div class="txt5">Добыча нефти</div>
                <div class="txt6">тыс. тонн</div>
                <!--   </label>-->
              </div>

              <!-- <div class="dropdown">-->

              <ul>
                <li class="center-li row px-4">
                  <a
                      class="col-10"
                      @click="
                        getProduction(
                          'oil_plan',
                          'oil_fact',
                          `${oilChartHeadName}`,
                          'тыс. тонн',
                          'С учётом доли участия КМГ'
                        )
                    "
                  >С учётом доли участия КМГ</a>
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton1}`">
                      &#10003;
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col dropdown3 font-weight">
              <div
                class="button1"
                :style="`${buttonHover2}`"
                @click="
                  getProduction(
                    'oil_dlv_plan',
                    'oil_dlv_fact',
                    'Динамика сдачи нефти',
                    'тыс. тонн',
                    'Сдача нефти'
                  )
                "
              >
                <div class="icon-all icons2"></div>
                <div class="txt5">Сдача нефти</div>
                <div class="txt6">тыс. тонн</div>
              </div>

              <ul>
                <li class="center-li row px-4">
                  <a
                      class="col-10"
                      @click="
                        getProduction(
                          'oil_dlv_plan',
                          'oil_dlv_fact',
                          'Динамика сдачи нефти',
                          'тыс. тонн',
                          'С учётом доли участия КМГ'
                        )
                      "
                  >С учётом доли участия КМГ</a>
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton2}`">
                      ✓
                    </div>
                  </div>
                </li>
                <li class="center-li row px-4">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'tovarnyi_ostatok_nefti_prev_day',
                        'tovarnyi_ostatok_nefti_today',
                        `${oilChartHeadName}`,
                        'тыс. тонн',
                        'Товарный остаток нефти'
                      )
                    "
                    >Товарный остаток нефти</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton3}`">
                      ✓
                    </div>
                  </div>
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
            <div class="col dropdown3 font-weight">
              <div
                class="button1"
                :style="`${buttonHover3}`"
                @click="
                  getProduction(
                    'gas_plan',
                    'gas_fact',
                    'Динамика добычи газа',
                    'тыс. м³',
                    'Добыча газа'
                  )
                "
              >
                <div class="icon-all icons3"></div>
                <div class="txt5">Добыча газа</div>
                <div class="txt6">тыс. м³</div>
              </div>
              <ul>
                <li class="center-li row px-4" @click="changeMenu('104')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'sdacha_gaza_prirod_plan',
                        'sdacha_gaza_prirod_fact',
                        'Динамика сдачи природного газа',
                        'тыс. м³',
                        'Сдача природного газа'
                      )
                    "
                    >Сдача природного газа</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton4}`">
                      ✓
                    </div>
                  </div>
                </li>

                <li class="center-li row px-4" @click="changeMenu('105')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'raskhod_prirod_plan',
                        'raskhod_prirod_fact',
                        'Динамика расхода природного газа',
                        'тыс. м³',
                        'Расход природного газа на собственные нужды'
                      )
                    "
                    >Расход природного газа на собственные нужды
                  </a>
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton5}`">
                      ✓
                    </div>
                  </div>
                </li>
                <li class="center-li row px-4" @click="changeMenu('106')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'pererabotka_gaza_prirod_plan',
                        'pererabotka_gaza_prirod_fact',
                        'Динамика переработки природного газа',
                        'тыс. м³',
                        'Переработка природного газа'
                      )
                    "
                    >Переработка природного газа</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton6}`">
                      ✓
                    </div>
                  </div>
                </li>

                <li class="center-li row px-4" @click="changeMenu('108')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'sdacha_gaza_poput_plan',
                        'sdacha_gaza_poput_fact',
                        'Динамика сдачи попутного газа',
                        'тыс. тонн',
                        'Сдача попутного газа'
                      )
                    "
                    >Сдача попутного газа</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton8}`">
                      ✓
                    </div>
                  </div>
                </li>

                <li class="center-li row px-4" @click="changeMenu('103')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'raskhod_poput_plan',
                        'raskhod_poput_fact',
                        'Динамика расхода попутного газа на собственные нужды',
                        'тыс. м³',
                        'Расход попутного газа на собственные нужды '
                      )
                    "
                    >Расход попутного газа на собственные нужды
                  </a>
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton3}`">
                      ✓
                    </div>
                  </div>
                </li>

                <li class="center-li row px-4" @click="changeMenu('107')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'pererabotka_gaza_poput_plan',
                        'pererabotka_gaza_poput_fact',
                        'Динамика переработки попутного газа',
                        'тыс. м³',
                        'Переработка попутного газа'
                      )
                    "
                    >Переработка попутного газа</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton7}`">
                      ✓
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col dropdown3 font-weight">
              <div
                class="button1"
                :style="`${buttonHover5}`"
                @click="
                  getProduction(
                    'gk_plan',
                    'gk_fact',
                    'Динамика добычи конденсата',
                    'тыс. тонн',
                    'Добыча конденсата'
                  )
                "
              >
                <div class="icon-all icons4"></div>
                <div class="txt5">Добыча конденсата</div>
                <div class="txt6">тыс. тонн</div>
              </div>
              <ul>
             <li class="center-li row px-4" @click="changeMenu('113')">
                  <a
                      class="col-10"
                      @click="
                        getProduction(
                          'gk_plan',
                          'gk_fact',
                          'Динамика добычи конденсата',
                          'тыс. тонн',
                          'С учётом доли участия КМГ'
                        )
                      "
                  >С учётом доли участия КМГ</a>
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton13}`">
                      &#10003;
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col dropdown3 font-weight">
              <div
                class="button1"
                :style="`${buttonHover6}`"
                @click="
                  getProduction(
                    'liq_plan',
                    'liq_fact',
                    'Динамика объёма закачки воды',
                    'тыс. м³',
                    'Закачка воды'
                  )
                "
              >
                <div class="icon-all icons5"></div>
                <div class="txt5">Закачка воды</div>
                <div class="txt6">тыс. м³</div>
              </div>
              <ul>
                <li class="center-li row px-4" @click="changeMenu('109')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'ppd_zakachka_morskoi_vody_plan',
                        'ppd_zakachka_morskoi_vody_fact',
                        'Динамика закачки морской воды',
                        'тыс. м³',
                        'Закачка морской воды'
                      )
                    "
                    >Закачка морской воды</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton9}`">
                      ✓
                    </div>
                  </div>
                </li>

                <li class="center-li row px-4" @click="changeMenu('110')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'ppd_zakachka_stochnoi_vody_plan',
                        'ppd_zakachka_stochnoi_vody_fact',
                        'Динамика закачки сточной воды',
                        'тыс. м³',
                        'Закачка сточной воды'
                      )
                    "
                    >Закачка сточной воды</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton10}`">
                      ✓
                    </div>
                  </div>
                </li>

                <li class="center-li row px-4" @click="changeMenu('111')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'ppd_zakachka_albsen_vody_plan',
                        'ppd_zakachka_albsen_vody_fact',
                        'Динамика закачки альбсен. воды',
                        'тыс. м³',
                        'Закачка альбсен. воды'
                      )
                    "
                    >Закачка альбсен. воды</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton11}`">
                      ✓
                    </div>
                  </div>
                </li>
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
                          v-if="selectedOilPeriod == 0"
                          mode="range"
                          v-model="range"
                          is-range
                          class="m-auto"
                          :model-config="modelConfig"
                          @dayclick="dayClicked"
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
            <h5
              class="col assets4"
              :style="`${buttonHover11}`"
              @click="changeAssets('b11')"
            >
              Операционные активы
            </h5>

            <h5
              class="col assets4"
              :style="`${buttonHover12}`"
              @click="changeAssets('b12')"
            >
              Неоперационные активы
            </h5>

            <h5
              class="col assets4"
              :style="`${buttonHover13}`"
              @click="changeAssets('b13')"
            >
              Все активы КМГ
            </h5>

            <!-- </tr>

       </div>-->
          </div>

          <div class="row container-fluid" :style="`${displayTable}`">
            <div class="vis-table px-3">
              <table class="table4 w-100">
                <tbody>
                  <tr v-for="(item, index) in tables">
                    <td
                      @click="saveCompany('all')"
                      :class="index % 2 === 0 ? 'tdStyle' : 'tdNone first-td'"
                      style="cursor: pointer"
                    >
                      <span>{{ getNameDzoFull(item.dzo) }}</span>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div v-if="index === 0" class="center">план</div>
                      <!--old date-->
                      <div class="font" v-if="item.productionPlanForMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            item.productionPlanForMonth
                          )
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>

                      <div class="font" v-if="item.planYear">
                        {{
                          new Intl.NumberFormat("ru-RU").format(item.planYear)
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                      <!--old date-->

                      <div class="font" v-if="item.plan">
                        {{ new Intl.NumberFormat("ru-RU").format(item.plan) }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div v-if="index === 0" class="center">факт</div>
                      <div class="font" v-if="item.productionFactForMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            item.productionFactForMonth
                          )
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>

                      <div class="font" v-if="item.factYear">
                        {{
                          new Intl.NumberFormat("ru-RU").format(item.factYear)
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                      <!--old date-->

                      <div class="font" v-if="item.fact">
                        {{ new Intl.NumberFormat("ru-RU").format(item.fact) }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div v-if="index === 0" class="center">+/-</div>
                      <div
                        v-if="item.productionFactForMonth"
                        class="triangle"
                        :style="`${getColor(
                          item.productionFactForMonth -
                            item.productionPlanForMonth
                        )}`"
                      ></div>
                      <div
                        class="dynamic font"
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
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div v-if="index === 0" class="center">%</div>
                      <div
                        v-if="item.productionFactForMonth"
                        class="triangle"
                        :style="`${getColor(
                          ((item.productionFactForMonth -
                            item.productionPlanForMonth) /
                            item.productionPlanForMonth) *
                            100
                        )}`"
                      ></div>
                      <div class="dynamic font">
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
            </div>

            <div class="vis-chart pl-3">
              <div class="name-chart-left">{{ nameChartLeft }}</div>
              <div class="name-chart-head">{{ item3 }}</div>
              <vc-chart v-if="company != 'all'"> </vc-chart>
            </div>
          </div>
          <div class="row container-fluid" :style="`${displayHeadTables}`">
            <div class="vis-table px-3">
              <table v-if="bigTable.length" class="table4 w-100">
                <tbody>
                  <tr v-for="(item, index) in bigTable">
                    <td
                        @click="saveCompany(item.dzoMonth)"
                        :class="index % 2 === 0 ? 'tdStyle' : ''"
                        style="cursor: pointer"
                    >
                        <span>
                          {{ getNameDzoFull(item.dzoMonth) }}
                          <img src="/img/icons/link.svg"/>
                        </span>
                    </td>

                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div v-if="index === 0" class="center">план</div>
                      <div class="font" v-if="item.planMonth">
                        {{
                          formatVisTableNumber(item.planMonth)
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div v-if="index === 0" class="center">факт</div>
                      <div class="font" v-if="item.factMonth">
                        {{
                          formatVisTableNumber(item.factMonth)
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                    </td>
                    <td
                      :class="
                        index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                      "
                    >
                      <div v-if="index === 0" class="center">+/-</div>
                      <div
                        v-if="item.factMonth"
                        class="triangle"
                        :style="`${getColor(item.factMonth - item.planMonth)}`"
                      ></div>
                      <div class="font dynamic" v-if="item.factMonth">
                        {{
                          formatVisTableNumber(Math.abs(item.factMonth - item.planMonth))
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle' : 'tdNone'">
                      <div v-if="index === 0" class="center">%</div>
                      <div
                        v-if="item.factMonth"
                        class="triangle"
                        :style="`${getColor(
                          ((item.factMonth - item.planMonth) / item.planMonth) *
                            100
                        )}`"
                      ></div>
                      <div class="font dynamic" v-if="item.factMonth">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(
                              ((item.factMonth - item.planMonth) /
                                item.planMonth) *
                                100
                            ).toFixed(1)
                          )
                        }}
                        %
                      </div>
                    </td>
                  </tr>
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
                        {{
                          formatVisTableNumber(planMonthSumm)
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
                      </div>
                    </td>
                    <td :class="index % 2 === 0 ? 'tdStyle3' : 'tdNone'">
                      <div class="font">
                        {{
                          formatVisTableNumber(factMonthSumm)
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
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
                      <div class="font dynamic">
                        {{
                          formatVisTableNumber(Math.abs(factMonthSumm - planMonthSumm))
                        }}
                        <div class="right" style="font-family: 'Harmonia-sans', sans-serif; opacity: 0.6;">{{ item4 }}</div>
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
                      <div class="font dynamic" v-if="factMonthSumm">
                        {{
                          new Intl.NumberFormat("ru-RU").format(
                            Math.abs(
                              ((factMonthSumm - planMonthSumm) /
                                planMonthSumm) *
                                100
                            ).toFixed(1)
                          )
                        }}
                        %
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="vis-chart pl-3">
              <div class="name-chart-left">{{ nameChartLeft }}, {{ item4 }}</div>
              <div class="name-chart-head">{{ item3 }}</div>
              <vc-chart :height="500" v-if="company == 'all'"> </vc-chart>
            </div>
          </div>
        </div>
      </div>
        <visual-center-usd-table
            :style="`${Table2}`"
            :selected-usd-period.sync="selectedOilPeriod"
            :usd-rates-data.sync="oilRatesData"
            @period-select-usd="getOilNow(timeSelect, periodSelect(selectedOilPeriod))"
            :period-select-func.sync="periodSelectFunc"
            :currency-chart-data.sync="currencyChartData"
            :usd-chart-is-loading.sync="usdChartIsLoading"
            @change-table="changeTable('1')"
            :main-title="'Динамика цены на нефть'"
            :second-title="''"
        />

      <visual-center-usd-table
          :style="`${Table3}`"
          :selected-usd-period.sync="selectedUsdPeriod"
          :usd-rates-data.sync="usdRatesData"
          @period-select-usd="periodUSD = periodSelect(selectedUsdPeriod)"
          :period-select-func.sync="periodSelectFunc"
          :currency-chart-data.sync="currencyChartData"
          :usd-chart-is-loading.sync="usdChartIsLoading"
          @change-table="changeTable('1')"
          :main-title="'Динамика курса доллара США к тенге (USD, НБ РК)'"
          :second-title="'USD НБ РК'"
      />

      <div class="third-table big-area" :style="`${Table5}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <div class="area-6-name row mt-3 mb-3 px-2">
              <div class="col">
                <div class="ml-4 bold">Фонд нагнетательных скважин</div>
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
                            v-if="selectedOilPeriod == 0"
                            mode="range"
                            v-model="range"
                            is-range
                            class="m-auto"
                            :model-config="modelConfig"
                            @input="changeDate"
                            @dayclick="dayClicked"
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
                    @change="innerWellsNagMetOnChange($event)"
                  >
                    <!--<option value="">
                      <div class="float">Компания</div>
                    </option>-->
                    <option value="all" v-if="company!='all'"> {{ getNameDzoFull(company) }}</option>
                     <option v-else>Все компании</option>
                   <!-- <option value="all"></option>-->
                    <option value="ОМГ">АО «ОзенМунайГаз»</option>
                    <option value="ММГ">АО «Мангистаумунайгаз»</option>
                    <option value="КГМ">ТОО «КазГерМунай»</option>
                    <option value="КОА">ТОО "Казахойл Актобе</option>
                    <option value="КГМ">ТОО "Казгермунай"</option>
                    <option value="КБМ">АО «Каражанбасмунай»</option>
                    <option value="ЭМГ">АО «ЭмбаМунайГаз»</option>
                  </select>
                </div>

                <div class="w-50 pl-2 pr-1">
                  <div class="col">
                    <div
                      class="button2"
                      :style="`${buttonHoverNagInnerWells}`"
                      @click="buttonInnerWellsNag()"
                    >
                      В простое
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
                <div class="vis-table vis-table-small px-3">
                    <table v-if="innerWells.length" class="table4 w-100">
                        <tbody>
                        <tr v-for="(item, index) in innerWells">
                            <td
                                class="w-50"
                                :class="index % 2 === 0 ? 'tdStyle' : ''"
                                style="cursor: pointer"
                            >
                                <span>
                                  {{ item.name }}
                                </span>
                            </td>
                            <td
                                class="w-25"
                                :class="index % 2 === 0 ? 'tdStyle' : ''"
                                style="cursor: pointer"
                            >
                                {{ item.value }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <visual-center3-wells></visual-center3-wells>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="third-table big-area" :style="`${Table4}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <div class="area-6-name row mt-3 mb-3 px-2">
              <div class="col">
                <div class="ml-4 bold">Фонд добывающих скважин</div>
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
                            @dayclick="dayClicked"
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
                    @change="innerWellsProdMetOnChange($event)"
                  >
                    <!--<option value="">
                      <div class="float">Компания</div>
                    </option>-->
                    <option value="all" v-if="company!='all'"> {{ getNameDzoFull(company) }}</option>
                     <option v-else>Все компании</option>
                   <!-- <option value="all"></option>-->
                    <option value="ОМГ">АО «ОзенМунайГаз»</option>
                    <option value="ММГ">АО «Мангистаумунайгаз»</option>
                    <option value="КГМ">ТОО «КазГерМунай»</option>
                    <option value="КОА">ТОО "Казахойл Актобе</option>
                    <option value="КГМ">ТОО "Казгермунай"</option>
                    <option value="КБМ">АО «Каражанбасмунай»</option>
                    <option value="ЭМГ">АО «ЭмбаМунайГаз»</option>
                  </select>
                </div>

                <div class="w-50 pl-2 pr-1">
                  <div class="col">
                    <div
                      class="button2"
                      :style="`${buttonHoverProdInnerWells}`"
                      @click="buttonInnerWellsProd()"
                    >
                      В простое
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
                <div class="vis-table vis-table-small px-3">
                    <table v-if="innerWells2.length" class="table4 w-100">
                        <tbody>
                        <tr v-for="(item, index) in innerWells2">
                            <td
                                class="w-50"
                                :class="index % 2 === 0 ? 'tdStyle' : ''"
                                style="cursor: pointer"
                            >
                                <span>
                                  {{ item.name }}
                                </span>
                            </td>
                            <td
                                class="w-25"
                                :class="index % 2 === 0 ? 'tdStyle' : ''"
                                style="cursor: pointer"
                            >
                                {{ item.value }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <visual-center3-wells></visual-center3-wells>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="third-table big-area" :style="`${Table6}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <div class="area-6-name row mt-3 mb-3 px-2">
              <div class="col">
                <div class="ml-4 bold">ОТМ</div>
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
                              @dayclick="dayClicked"
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
                <div class="w-100 pr-2">
                  <select
                      style="
                      background-color: #333975;
                      border-color: #20274e;
                      color: white;
                    "
                      class="form-control w-100"
                      id="OTMcompanySelect"
                      @change="innerWellsProdMetOnChange($event)"
                  >
                    <option value="all" v-if="company!='all'"> {{ getNameDzoFull(company) }}</option>
                    <option v-else>Все компании</option>
                    <option value="ОМГ">АО «ОзенМунайГаз»</option>
                    <option value="ММГ">АО «Мангистаумунайгаз»</option>
                    <option value="КГМ">ТОО «КазГерМунай»</option>
                    <option value="КОА">ТОО "Казахойл Актобе</option>
                    <option value="КГМ">ТОО "Казгермунай"</option>
                    <option value="КБМ">АО «Каражанбасмунай»</option>
                    <option value="ЭМГ">АО «ЭмбаМунайГаз»</option>
                  </select>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
              <div class="vis-table vis-table-small px-3">
                <table v-if="otmData.length" class="table4 w-100" style="height: calc(100% - 20px)">
                  <tbody>
                  <tr v-for="(item, index) in otmData" @click="otmSelectedRow = item.code">
                    <td @click="otmSelectedRow = item.code"
                        class="w-50"
                        :class="{
                          'tdStyle': index % 2 === 0,
                          'selected': otmSelectedRow === item.code
                        }"
                        style="cursor: pointer"
                    >
                                <span>
                                  {{ item.name }}
                                </span>
                    </td>
                    <td @click="otmSelectedRow = item.code"
                        class="w-25 text-center"
                        :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                        style="cursor: pointer; font-size: 30px"
                    >
                      <div v-if="index === 0" class="center" style="font-size: 12px; line-height: 1.2">План</div>
                      {{ item.fact }}
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <div class="col">
                <visual-center3-wells v-if="otmDataForChart" :chartData="otmDataForChart"></visual-center3-wells>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="third-table big-area" :style="`${Table7}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <div class="area-6-name row mt-3 mb-3 px-2">
              <div class="col">
                <div class="ml-4 bold">Химизация</div>
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
                              @dayclick="dayClicked"
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
                <div class="w-100 pr-2">
                  <select
                      style="
                      background-color: #333975;
                      border-color: #20274e;
                      color: white;
                    "
                      class="form-control w-100"
                      id="ChemistryCompanySelect"
                      @change="innerWellsProdMetOnChange($event)"
                  >
                    <option value="all" v-if="company!='all'"> {{ getNameDzoFull(company) }}</option>
                    <option v-else>Все компании</option>
                    <option value="ОМГ">АО «ОзенМунайГаз»</option>
                    <option value="ММГ">АО «Мангистаумунайгаз»</option>
                    <option value="КГМ">ТОО «КазГерМунай»</option>
                    <option value="КОА">ТОО "Казахойл Актобе</option>
                    <option value="КГМ">ТОО "Казгермунай"</option>
                    <option value="КБМ">АО «Каражанбасмунай»</option>
                    <option value="ЭМГ">АО «ЭмбаМунайГаз»</option>
                  </select>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
              <div class="vis-table vis-table-small px-3">
                <table v-if="chemistryData.length" class="table4 w-100" style="height: calc(100% - 20px)">
                  <tbody>
                  <tr v-for="(item, index) in chemistryData" @click="chemistrySelectedRow = item.code">
                    <td @click="chemistrySelectedRow = item.code"
                        class="w-50"
                        :class="{
                          'tdStyle': index % 2 === 0,
                          'selected': chemistrySelectedRow === item.code
                        }"
                        style="cursor: pointer"
                    >
                      {{item.name}}
                    </td>
                    <td @click="chemistrySelectedRow = item.code"
                        class="w-25 text-center"
                        :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                        style="cursor: pointer; font-size: 30px"
                    >
                      <div v-if="index === 0" class="center" style="font-size: 12px; line-height: 1.2">План</div>
                      {{ item.fact }}
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <div class="col">
                <visual-center3-wells v-if="chemistryDataForChart" :chartData="chemistryDataForChart"></visual-center3-wells>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="right-side2 flex-grow-1 pl-1">
      <div class="first-string">
        <div class="table-responsive">
          <table class="table table1-2">
            <tr class="cursor-pointer">
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
                <div class="txt4 d-flex justify-content-between">
                    <div>
                      {{
                        new Intl.NumberFormat("ru-RU").format(
                          // wells2[0].prod_wells_idle
                          prod_wells_idle
                        )
                      }}
                    </div>
                    <div class="mt-1">
                        <img src="/img/icons/link.svg">
                    </div>
                </div>
                <div class="in-idle">В простое</div>
                <div class="arrow"></div>
                <div class="txt2">200</div>
                <br />
              </td>
            </tr>
            <tr class="cursor-pointer">
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
              <tr class="cursor-pointer">
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
                    <div class="txt4 d-flex justify-content-between">
                        <div>
                            <!-- v-if="wells[0].inj_wells_idle"-->
                            {{
                                new Intl.NumberFormat("ru-RU").format(
                                    // wells[0].inj_wells_idle
                                    inj_wells_idle
                                )
                            }}
                        </div>
                        <div class="mt-1">
                            <img src="/img/icons/link.svg">
                        </div>
                    </div>
                  <div class="in-idle">В простое</div>
                  <div class="arrow"></div>
                  <div class="txt2">200</div>
                  <br />
                </td>
              </tr>
              <tr class="cursor-pointer">
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
                  <div class="mt-1 float-right"><img data-v-3712f8d4="" src="/img/icons/link.svg"></div>
                  <div class="otm"></div>
                  <div class="txt2">ОТМ</div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('7')"
                  :style="`${tableHover7}`"
                >
                  <div class="mt-1 float-right"><img data-v-3712f8d4="" src="/img/icons/link.svg"></div>
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
                <div class="number">0</div>
              </td>

              <td class="w-65">
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
<style scoped lang="scss">
    .vis-table{
      flex: 0 0 56%;
      height: 535px;
      max-width: 56%;
      overflow-y: auto;
      &::-webkit-scrollbar {
        width: 3px;
      }

      &::-webkit-scrollbar-track {
        background: #333975;
      }

      &::-webkit-scrollbar-thumb {
        background: #1f213e;
      }

      &::-webkit-scrollbar-thumb:hover {
        background: #1f213e;
      }

      &::-webkit-scrollbar-corner {
        background: #333975;
      }

      .table4{
        tr{
          td{
            padding: 5px 5px 5px 10px;
            position: relative;
            vertical-align: middle;
            &:first-child{
              height: 56px;
              white-space: normal;
              width: 215px;
              span{
                font-weight: bold;
                img{
                  width: 9px;
                }
              }
            }
            &.selected{
              background: #2e47c0!important;
            }
            .font{
              align-items: baseline;
              display: flex;
              justify-content: space-between;
              font-size: 24px;
              margin-left: 0;
              &.dynamic{
                padding-left: 17px;
              }
              .right{
                font-size: 10px;
                margin-right: 0;
              }
            }
            .center{
              font-size: 0.63em;
              font-weight: bold;
              left: 0;
              margin: 0;
              position: absolute;
              text-align: center;
              top: 4px;
              width: 100%;
            }
            .triangle{
              border: 6px solid transparent;
              height: 6px;
              margin-right: 5px;
              position: absolute;
              width: 6px;
            }
          }
        }
      }
    }
    .vis-table-small {
        max-width: 48% !important;
        tr {
            line-height: 4.2rem !important;
            font-size: 1.2rem !important;
            font-family: Bold !important;
        }
    }
    .vis-chart{
      flex: 0 0 44%;
      max-width: 44%;
    }
</style>