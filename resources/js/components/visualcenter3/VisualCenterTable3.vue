<template>
  <div
    class="d-flex flex-column flex-sm-row justify-content-between w-sm-100 all-height px-2"
  >
    <div class="left-side flex-grow-1 pr-2">
      <div class="first-string">
        <div>
          <table class="table table1">
            <tr>
              <td>
                <div class="first-td-header">
                  <div class="nu">
                    <div class="number">
                      {{ formatDigitToThousand(oil_factDay) }}
                    </div>
                    <div class="unit-vc">{{ thousand }} тонн</div>
                  </div>
                  <div class="txt1">
                    <!--Добыча нефти-->{{ trans("visualcenter.getoil") }}
                  </div>
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
                    {{ getDiffProcentLastBigN(oil_factDay, oil_planDay) }}%
                  </div>
                  <div class="plan-header" v-if="oil_planDay">
                    {{ formatDigitToThousand(oil_planDay) }}
                  </div>
                  <br />

                  <div
                    :class="`${getColor2(
                      getDiffProcentLastP(oil_factDay, oil_factDayPercent)
                    )}`"
                  ></div>

                  <div class="txt2-2">
                    {{
                      Math.abs(
                        getDiffProcentLastP(oil_factDayPercent, oil_factDay)
                      )
                    }}%
                  </div>
                  <div class="txt3">
                    vs
                    <span v-if="oneDate"> {{ lastDate2 }}</span>
                    <span v-else> {{ lastDate1 }} - {{ lastDate2 }}</span>
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
                      {{ formatDigitToThousand(oil_dlv_factDay) }}
                    </div>
                    <div class="unit-vc">{{ thousand }} тонн</div>
                  </div>
                  <div class="txt1">
                    <!--Сдача нефти-->{{ trans("visualcenter.oildlv") }}
                  </div>
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
                      getDiffProcentLastBigN(oil_dlv_factDay, oil_dlv_planDay)
                    }}%
                  </div>
                  <div class="plan-header" v-if="oil_dlv_planDay">
                    {{ formatDigitToThousand(oil_dlv_planDay) }}
                  </div>
                  <br />
                  <div
                    :class="`${getColor2(
                      getDiffProcentLastP(
                        oil_dlv_factDay,
                        oil_dlv_factDayPercent
                      )
                    )}`"
                  ></div>

                  <div class="txt2-2">
                    {{
                      Math.abs(
                        getDiffProcentLastP(
                          oil_dlv_factDayPercent,
                          oil_dlv_factDay
                        )
                      )
                    }}%
                  </div>
                  <div class="txt3">
                    vs
                    <span v-if="oneDate"> {{ lastDate2 }}</span>
                    <span v-else> {{ lastDate1 }} - {{ lastDate2 }}</span>
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
                      {{ formatDigitToThousand(gas_factDay) }}
                    </div>
                    <div class="unit-vc">
                      {{ thousand }} м³
                    </div>
                  </div>
                  <div class="txt1">
                    {{ trans("visualcenter.getgaz") }}
                  </div>
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
                    {{ getDiffProcentLastBigN(gas_factDay, gas_planDay) }}%
                  </div>
                  <div class="plan-header" v-if="gas_planDay">
                    {{ formatDigitToThousand(gas_planDay) }}
                  </div>

                  <br />

                  <div
                    :class="`${getColor2(
                      getDiffProcentLastP(gas_factDay, gas_factDayPercent)
                    )}`"
                  ></div>

                  <div class="txt2-2">
                    {{
                      Math.abs(
                        getDiffProcentLastP(gas_factDayPercent, gas_factDay)
                      )
                    }}%
                  </div>
                  <div class="txt3">
                    vs
                    <span v-if="oneDate"> {{ lastDate2 }}</span>
                    <span v-else> {{ lastDate1 }} - {{ lastDate2 }}</span>
                  </div>
                </div>
                <div class="second-td-header"></div>
              </td>

              <td
                class="vc-select-table"
                style="width: 200px; border-left: 10px solid #0f1430"
                @click="changeTable('2')"
                :style="`${tableHover2}`"
              >
                <div class="nu">
                  <div class="number d-flex justify-content-between">
                    <div>
                      {{ prices['oil']['current'] }}
                    </div>
                    <div class="mt-1">
                      <img src="/img/icons/link.svg" />
                    </div>
                  </div>
                  <div class="unit-vc">$ / bbl</div>
                </div>
                <br />
                <div class="txt1">
                  <!--Цена на нефть (Brent)-->{{
                    trans("visualcenter.oilPrice")
                  }}
                </div>

                <div class="percent-currency">
                  <div
                    class="arrow"
                    v-if="dailyOilPriceChange === 'UP'"
                  ></div>
                  <div
                    class="arrow2"
                    v-if="dailyOilPriceChange === 'DOWN'"
                  ></div>
                  <div
                    :class="`${
                      getDifferenceOilRate(prices['oil']['previous'], prices['oil']['current'])
                    }`"
                  ></div>
                  <div class="txt2-2">
                    {{ Math.abs(getDiffProcentLastP(prices['oil']['previous'], prices['oil']['current'])) }} %
                  </div>
                  <div class="txt3">
                    {{ trans("visualcenter.vsSeparator") }}
                    {{ new Date(prices['oil']['previousFetchDate']).toLocaleDateString() }}
                  </div>
                </div>
              </td>
              <td
                class="vc-select-table"
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
                      <img src="/img/icons/link.svg" />
                    </div>
                  </div>
                  <div class="unit-vc">kzt / $</div>
                </div>
                <br />
                <div class="txt1">
                  <!-- Курс доллара -->
                  {{ trans("visualcenter.usdKurs") }}
                </div>
                <br />
                <div class="percent-currency">
                  <div
                    class="arrow"
                    v-if="dailyCurrencyChangeIndexUsd === 'UP'"
                  ></div>
                  <div
                    class="arrow2"
                    v-if="dailyCurrencyChangeIndexUsd === 'DOWN'"
                  ></div>
                  <div class="txt2-2">{{ dailyCurrencyChangeUsd }}%</div>
                  <div class="txt3">
                    {{ trans("visualcenter.vsSeparator") }}
                    {{ new Date(prices['usd']['previousFetchDate']).toLocaleDateString() }}
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="first-table big-area" :style="`${Table1}`">
        <div class="first-string first-string2">
          <div class="row px-4 mt-3">
            <div class="col dropdown dropdown4 font-weight">
              <div class="button1" :style="`${buttonHover1}`">
                <div
                  class="button1-vc-inner col-10"
                  @click="
                    getProduction(
                      'oil_plan',
                      'oil_fact',
                      `${oilChartHeadName}`,
                      ' тонн',
                      trans('visualcenter.getoil')
                    )
                  "
                >
                  <div class="icon-all icons1"></div>
                  <div class="txt5">
                    <!-- Добыча нефти -->{{ trans("visualcenter.getoil") }}
                  </div>
                </div>
                <button
                  :style="`${buttonHover1}`"
                  type="button"
                  class="btn btn-primary dropdown-toggle position-button-vc col-2"
                  data-toggle="dropdown"
                ></button>

                <!-- <div class="dropdown">-->
                <div>
                  <ul
                    class="dropdown-menu-vc dropdown-menu dropdown-menu-right"
                  >
                    <li class="center-li row px-4" @click="changeMenu('101')">
                      <div
                        class="col-1 mt-2"
                        v-html="changeMenuButton1Flag"
                      ></div>

                      <a
                        class="col-9 px-2"
                        @click="
                          getProduction(
                            'oil_plan',
                            'oil_fact',
                            `${oilChartHeadName}`,
                            ' тонн',
                            trans('visualcenter.dolyaUchast')
                          )
                        "
                      >
                        <!-- С учётом доли участия КМГ -->{{
                          trans("visualcenter.dolyaUchast")
                        }}
                      </a>
                      <!--<div class="col-2 mt-2">
                    <div class="square-small2" :style="`${changeMenuButton1}`">
                      &#10003;
                    </div>
                  </div>-->
                    </li>

                    <!--<li class="center-li row px-4">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'tb_personal_fact',
                        'tb_personal_fact',
                        `${oilChartHeadName}`,
                        ' тонн',
                        'Численость персонала'
                      )
                    "
                    >Численость персонала</a
                  >
                  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton1}`">
                      &#10003;
                    </div>
                  </div>
                </li>-->
                  </ul>
                </div>

                <!--  <div class="txt6"> тонн</div>
                 </label>-->
              </div>
            </div>
            <div class="col dropdown dropdown4 font-weight">
              <div class="button1" :style="`${buttonHover2}`">
                <div
                  class="button1-vc-inner col-10"
                  @click="
                    getProduction(
                      'oil_dlv_plan',
                      'oil_dlv_fact',
                      trans('visualcenter.dlvoildynamic'),
                      ' тонн',
                      trans('visualcenter.oildlv')
                    )
                  "
                >
                  <div class="icon-all icons2"></div>
                  <div class="txt5">
                    <!-- Сдача нефти  -->{{ trans("visualcenter.oildlv") }}
                  </div>
                  <!--  <div class="txt6"> тонн</div>-->
                </div>
                <button
                  type="button"
                  class="btn btn-primary dropdown-toggle position-button-vc col-2"
                  data-toggle="dropdown"
                ></button>

                <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                  <li class="center-li row px-4" @click="changeMenu('102')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton2Flag"
                    ></div>

                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'oil_dlv_plan',
                          'oil_dlv_fact',
                          trans('visualcenter.dlvoildynamic'),
                          ' тонн',
                          trans('visualcenter.dolyaUchast')
                        )
                      "
                    >
                      <!-- С учётом доли участия КМГ -->{{
                        trans("visualcenter.dolyaUchast")
                      }}
                    </a>
                    <!--<div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton2}`">
                      ✓
                    </div>
                  </div>-->
                  </li>
                  <li class="center-li row px-4" @click="changeMenu('103')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton3Flag"
                    ></div>

                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'tovarnyi_ostatok_nefti_prev_day',
                          'tovarnyi_ostatok_nefti_today',
                          `${oilChartHeadName}`,
                          ' тонн',
                          trans('visualcenter.ostatokNefti')
                        )
                      "
                    >
                      <!-- Товарный остаток нефти -->{{
                        trans("visualcenter.ostatokNefti")
                      }}
                    </a>
                    <!-- <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton3}`">
                      ✓
                    </div>
                  </div>-->
                  </li>
                </ul>
              </div>
            </div>
            <div class="col dropdown dropdown4 font-weight">
              <div class="button1" :style="`${buttonHover3}`">
                <div
                  class="button1-vc-inner col-10"
                  @click="
                    getProduction(
                      'gas_plan',
                      'gas_fact',
                      trans('visualcenter.getgasdynamic'),
                      ' м³',
                      trans('visualcenter.getgaz')
                    )
                  "
                >
                  <div class="icon-all icons3"></div>
                  <div class="txt5">
                    <!-- Добыча газа -->{{ trans("visualcenter.getgaz") }}
                  </div>
                  <!--  <div class="txt6"> м³</div>-->
                </div>
                <button
                  type="button"
                  class="btn btn-primary dropdown-toggle position-button-vc col-2"
                  data-toggle="dropdown"
                ></button>
                <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                  <li class="center-li row px-4" @click="changeMenu('104')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton4Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'sdacha_gaza_prirod_plan',
                          'sdacha_gaza_prirod_fact',
                          trans('visualcenter.dlvPrirodGasldynamic'),
                          ' м³',
                          trans('visualcenter.prirodGazdlv')
                        )
                      "
                    >
                      <!-- Сдача природного газа -->{{
                        trans("visualcenter.prirodGazdlv")
                      }}
                    </a>
                    <!--<div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton4}`">
                      ✓
                    </div>
                  </div>-->
                  </li>

                  <li class="center-li row px-4" @click="changeMenu('105')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton5Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'raskhod_prirod_plan',
                          'raskhod_prirod_fact',
                          trans('visualcenter.raskhodprirodGazDynamic'),
                          ' м³',
                          trans('visualcenter.raskhodprirodGaz')
                        )
                      "
                    >
                      <!-- Расход природного газа на собственные нужды -->{{
                        trans("visualcenter.raskhodprirodGaz")
                      }}
                    </a>
                    <!--<div class="col-2 mt-2">
                    <div class="square-small2" :style="`${changeMenuButton5}`">
                      ✓
                    </div>
                  </div>-->
                  </li>
                  <!--<li class="center-li row px-4" @click="changeMenu('106')">
                  <a
                    class="col-10"
                    @click="
                      getProduction(
                        'pererabotka_gaza_prirod_plan',
                        'pererabotka_gaza_prirod_fact',
                        'Динамика переработки природного газа',
                        ' м³',
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
                </li>-->

                  <li class="center-li row px-4" @click="changeMenu('108')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton8Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'sdacha_gaza_poput_plan',
                          'sdacha_gaza_poput_fact',
                          trans('visualcenter.poputGazdlvDynamic'),
                          ' тонн',
                          trans('visualcenter.poputGazdlv')
                        )
                      "
                    >
                      <!-- Сдача попутного газа -->{{
                        trans("visualcenter.poputGazdlv")
                      }}
                    </a>
                    <!--<div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton8}`">
                      ✓
                    </div>
                  </div>-->
                  </li>

                  <li class="center-li row px-4" @click="changeMenu('103')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton3Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'raskhod_poput_plan',
                          'raskhod_poput_fact',
                          trans('visualcenter.raskhodpoputGazDynamic'),
                          ' м³',
                          trans('visualcenter.raskhodpoputGaz')
                        )
                      "
                    >
                      <!-- Расход попутного газа на собственные нужды -->{{
                        trans("visualcenter.raskhodpoputGaz")
                      }}
                    </a>
                    <!--<div class="col-2">
                   <div class="square-small2" :style="`${changeMenuButton3}`">
                      ✓
                    </div>
                  </div>-->
                  </li>

                  <li class="center-li row px-4" @click="changeMenu('107')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton7Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'pererabotka_gaza_poput_plan',
                          'pererabotka_gaza_poput_fact',
                          trans('visualcenter.pererabotkapoputGazDynamic'),
                          ' м³',
                          trans('visualcenter.pererabotkapoputGaz')
                        )
                      "
                    >
                      <!-- Переработка попутного газа -->{{
                        trans("visualcenter.pererabotkapoputGaz")
                      }}
                    </a>
                    <!--<div class="col-2">
                   <div class="square-small2" :style="`${changeMenuButton7}`">
                      ✓
                    </div>
                  </div>-->
                  </li>
                </ul>
              </div>
            </div>
            <div class="col dropdown dropdown4 font-weight">
              <div class="button1" :style="`${buttonHover5}`">
                <div
                  class="button1-vc-inner col-10"
                  @click="
                    getProduction(
                      'gk_plan',
                      'gk_fact',
                      trans('visualcenter.getgkDynamic'),
                      ' тонн',
                      trans('visualcenter.getgk')
                    )
                  "
                >
                  <div class="icon-all icons4"></div>
                  <div class="txt5">
                    <!-- Добыча конденсата -->{{ trans("visualcenter.getgk") }}
                  </div>
                  <!-- <div class="txt6"> тонн</div>-->
                </div>
                <button
                  type="button"
                  class="btn btn-primary dropdown-toggle position-button-vc col-2"
                  data-toggle="dropdown"
                ></button>
                <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                  <li class="center-li row px-4" @click="changeMenu('113')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton13Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'gk_plan',
                          'gk_fact',
                          trans('visualcenter.getgkDynamic'),
                          ' тонн',
                          trans('visualcenter.dolyaUchast')
                        )
                      "
                    >
                      <!-- С учётом доли участия КМГ -->{{
                        trans("visualcenter.dolyaUchast")
                      }}
                    </a>
                    <!--<div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton13}`">
                      &#10003;
                    </div>
                  </div>-->
                  </li>
                </ul>
              </div>
            </div>
            <div class="col dropdown dropdown4 font-weight">
              <div class="button1" :style="`${buttonHover6}`">
                <div
                  class="button1-vc-inner col-10"
                  @click="
                    getProduction(
                      'liq_plan',
                      'liq_fact',
                      trans('visualcenter.liqDynamic'),
                      ' м³',
                      trans('visualcenter.liq')
                    )
                  "
                >
                  <div class="icon-all icons5"></div>
                  <div class="txt5">
                    <!-- Закачка воды -->{{ trans("visualcenter.liq") }}
                  </div>
                  <!-- <div class="txt6"> м³</div>-->
                </div>
                <button
                  type="button"
                  class="btn btn-primary dropdown-toggle position-button-vc col-2"
                  data-toggle="dropdown"
                ></button>
                <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                  <li class="center-li row px-4" @click="changeMenu('109')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton9Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'ppd_zakachka_morskoi_vody_plan',
                          'ppd_zakachka_morskoi_vody_fact',
                          trans('visualcenter.liqOceanDynamic'),
                          ' м³',
                          trans('visualcenter.liqOcean')
                        )
                      "
                    >
                      <!-- Закачка морской воды -->{{
                        trans("visualcenter.liqOcean")
                      }}
                    </a>
                    <!--<div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton9}`">
                      ✓
                    </div>
                  </div>-->
                  </li>

                  <li class="center-li row px-4" @click="changeMenu('110')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton10Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'ppd_zakachka_stochnoi_vody_plan',
                          'ppd_zakachka_stochnoi_vody_fact',
                          trans('visualcenter.liqStochnayaDynamic'),
                          ' м³',
                          trans('visualcenter.liqStochnaya')
                        )
                      "
                    >
                      <!-- Закачка сточной воды -->{{
                        trans("visualcenter.liqStochnaya")
                      }}
                    </a>
                    <!--<div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton10}`">
                      ✓
                    </div>
                  </div>-->
                  </li>

                  <li class="center-li row px-4" @click="changeMenu('111')">
                    <div
                      class="col-1 mt-2"
                      v-html="changeMenuButton11Flag"
                    ></div>
                    <a
                      class="col-9 px-2"
                      @click="
                        getProduction(
                          'ppd_zakachka_albsen_vody_plan',
                          'ppd_zakachka_albsen_vody_fact',
                          trans('visualcenter.liqAlbsenDynamic'),
                          ' м³',
                          trans('visualcenter.liqAlbsen')
                        )
                      "
                    >
                      <!-- Закачка альбсен. воды -->{{
                        trans("visualcenter.liqAlbsen")
                      }}
                    </a>
                    <!--  <div class="col-2">
                    <div class="square-small2" :style="`${changeMenuButton11}`">
                      ✓
                    </div>
                  </div>-->
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row px-4 mt-3">
            <div
                    :class="[`${buttonDzoDropdown}`,'col dropdown dzo-company-list button2']"
            >
              {{ trans("visualcenter.dzoAllCompany") }}
              <div
                      class="arrow-down"
                      @click="`${changeDzoCompaniesVisibility()}`"
              ></div>
              <div>
                <ul
                        :class="dzoCompaniesVisibility === true ? 'show-company-list' : 'hide-company-list'"
                  >
                  <li
                          class="px-4"
                  >
                    <div>
                      <input
                              :disabled="dzoCompanyAllSelected"
                              :checked="dzoCompanyAllSelected"
                              type="checkbox"
                              @click="`${selectDzoCompanies()}`"
                      ></input>
                      {{trans("visualcenter.dzoAllCompany")}}
                    </div>
                  </li>
                  <li
                          v-for="(company) in dzoCompanies"
                          class="px-4"
                  >
                    <div>
                      <input
                              type="checkbox"
                              :checked="company.selected"
                              @change="`${selectDzoCompany(company.ticker)}`"
                      ></input>
                      {{trans(company.companyName)}}
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col">
              <div
                      :class="[`${buttonDailyTab}`,'button2']"
                      @click="changeMenu2(1)"
              >
                {{ trans("visualcenter.daily") }}
              </div>
            </div>
            <div class="col">
              <div
                      :class="[`${buttonMonthlyTab}`,'button2']"
                @click="changeMenu2(2)"
              >
                {{ trans("visualcenter.monthBegin") }}
              </div>
            </div>
            <div class="col">
              <div
                      :class="[`${buttonYearlyTab}`,'button2']"
                      @click="changeMenu2(3)"
              >
                {{ trans("visualcenter.yearBegin") }}
              </div>
            </div>
            <div class="col">
              <div class="dropdown3">
                <div
                        :class="[`${buttonPeriodTab}`,'button2']"
                        @click="changeMenu2(4)"
                >
                  <span v-if="oneDate">
                    <!-- Дата  -->{{ trans("visualcenter.date") }} [{{
                      timeSelect
                    }}]</span
                  >
                  <span v-else>
                    <!-- Период  -->{{ trans("visualcenter.period") }} [{{
                      timeSelect
                    }}
                    - {{ timeSelectOld }}]</span
                  >
                </div>
                <ul class="center-menu2 right-indent">
                  <li class="center-li">
                    <br /><br />

                    <div class="month-day">
                      <div class="">
                        <date-picker
                          v-if="selectedPeriod === 0"
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
              v-if="item2 == 'oil_fact'"
              class="col-3 assets4"
              :style="`${buttonHover14}`"
              @click="changeAssets('b14')"
            >
              <!-- С учётом ограничения ОПЕК+ -->
              {{ trans("visualcenter.opek") }}
            </h5>
            <h5
              v-if="company == 'all'"
              class="col assets4"
              :style="`${buttonHover11}`"
              @click="changeAssets('b11')"
            >
              <!-- Операционные активы -->{{ trans("visualcenter.operactive") }}
            </h5>

            <h5
              v-if="company == 'all'"
              class="col assets4"
              :style="`${buttonHover12}`"
              @click="changeAssets('b12')"
            >
              <!-- Неоперационные активы -->{{
                trans("visualcenter.neoperactive")
              }}
            </h5>

            <h5
              v-if="company == 'all'"
              class="col assets4"
              :style="`${buttonHover13}`"
              @click="changeAssets('b13')"
            >
              <!-- Все активы КМГ -->{{ trans("visualcenter.allkmg") }}
            </h5>

            <!-- </tr>

       </div>-->
          </div>


          <div class="row container-fluid mh-60">
            <div class="vis-table px-3" :style="scroll">
              <table v-if="bigTable.length" class="table4 w-100">
                <thead>
                  <tr>
                    <th>{{ trans("visualcenter.dzo") }}</th>
                    <th
                            v-if="buttonMonthlyTab"
                    >
                      {{ trans("visualcenter.dzoMonthlyPlan") }}
                      <div
                              v-if="currentDzoList !== 'daily'"
                      >
                        {{ trans("visualcenter.dzoThousandTon") }}
                      </div>
                      <div
                              v-if="currentDzoList === 'daily'"
                      >
                        {{ trans("visualcenter.chemistryMetricTon") }}
                      </div>
                    </th>
                    <th
                            v-if="buttonYearlyTab"
                    >
                      {{ trans("visualcenter.dzoYearlyPlan") }}
                      <div
                              v-if="currentDzoList !== 'daily'"
                      >
                        {{ trans("visualcenter.dzoThousandTon") }}
                      </div>
                      <div
                              v-if="currentDzoList === 'daily'"
                      >
                        {{ trans("visualcenter.chemistryMetricTon") }}
                      </div>
                    </th>
                    <th>
                      {{ trans("visualcenter.plan") }}
                      <div
                              v-if="currentDzoList !== 'daily'"
                      >
                        {{ trans("visualcenter.dzoThousandTon") }}
                      </div>
                      <div
                              v-if="currentDzoList === 'daily'"
                      >
                        {{ trans("visualcenter.chemistryMetricTon") }}
                      </div>
                    </th>
                    <th>
                      {{ trans("visualcenter.fact") }}
                      <div
                              v-if="currentDzoList !== 'daily'"
                      >
                        {{ trans("visualcenter.dzoThousandTon") }}
                      </div>
                      <div
                              v-if="currentDzoList === 'daily'"
                      >
                        {{ trans("visualcenter.chemistryMetricTon") }}
                      </div>
                    </th>
                    <th>
                      {{ trans("visualcenter.dzoDifference") }}
                      <div
                              v-if="currentDzoList !== 'daily'"
                      >
                        {{ trans("visualcenter.dzoThousandTon") }}
                      </div>
                      <div
                              v-if="currentDzoList === 'daily'"
                      >
                        {{ trans("visualcenter.chemistryMetricTon") }}
                      </div>
                    </th>
                    <th>
                      {{ trans("visualcenter.dzoPercent") }}
                    </th>
                    <th
                            v-if="exactDateSelected"
                    >
                      {{ trans("visualcenter.dzoOpec") }}
                    </th>
                    <th
                            v-if="exactDateSelected"
                    >
                      {{ trans("visualcenter.dzoImpulses") }}
                    </th>
                    <th
                            v-if="exactDateSelected"
                    >
                      {{ trans("visualcenter.dzoLanding") }}
                    </th>
                    <th
                            v-if="exactDateSelected"
                    >
                      {{ trans("visualcenter.dzoAlarmFirst") }}<br>
                      {{ trans("visualcenter.dzoAlarmSecond") }}
                    </th>
                    <th
                            v-if="exactDateSelected"
                    >
                      {{ trans("visualcenter.dzoRestrictions") }}
                    </th>
                    <th
                            v-if="exactDateSelected"
                    >
                      {{ trans("visualcenter.dzoOthers") }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in dzoCompanySummary">
                    <td
                            @click="dzoCompanyDecomposition === true ? `${selectOneDzoCompany(item.dzoMonth)}` : `${selectAllDzoCompanies()}`"
                            :class="index % 2 === 0 ? 'tdStyle' : ''"
                            style="cursor: pointer"
                    >
                      <span>
                        {{ getNameDzoFull(item.dzoMonth) }}
                        <img src="/img/icons/link.svg" />
                      </span>
                    </td>
                    <td
                      v-if="buttonYearlyTab"
                      :class="`${getDzoColumnsClass(index,'monthlyPlan')}`"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.periodPlan) }}
                      </div>
                    </td>

                    <td
                      v-if="buttonMonthlyTab"
                      :class="`${getDzoColumnsClass(index,'yearlyPlan')}`"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.periodPlan) }}
                      </div>
                    </td>

                    <td
                            :class="`${getDzoColumnsClass(index,'plan')}`"
                    >

                      <div class="font">
                        {{ formatDigitToThousand(item.planMonth) }}
                      </div>
                    </td>

                    <td
                            :class="[`${getDzoColumnsClass(index,'fact')}`,'fact']"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.factMonth) }}
                      </div>
                    </td>
                    <td
                            :class="`${getDzoColumnsClass(index,'difference')}`"
                    >
                      <div
                        v-if="item.factMonth"
                        :class="
                          item.factMonth - item.planMonth < 0 ?
                          'triangle fall-indicator-production-data' :
                          'triangle growth-indicator-production-data'
                        "
                      ></div>
                      <div class="font dynamic" >
                        {{
                        formatDigitToThousand(
                            Math.abs(item.factMonth - item.planMonth)
                          )
                        }}
                      </div>
                    </td>
                    <td
                            :class="`${getDzoColumnsClass(index,'percent')}`"
                    >
                      <div
                        v-if="item.factMonth"
                        :class="
                          ((item.factMonth - item.planMonth) /
                          item.planMonth) * 100 < 0 ?
                          'triangle fall-indicator-production-data' :
                          'triangle growth-indicator-production-data'
                        "
                      ></div>
                      <div class="font dynamic">
                        {{
                        formatVisTableNumber3 (item.factMonth , item.planMonth)
                        }}
                      </div>
                    </td>
                    <td
                      v-if="exactDateSelected"
                      :class="`${getLightColorClass(index)}`"
                    >
                      <div
                              :class="item.impulses ? 'accident-triangle triangle' : 'no-accident-triangle triangle'"
                      ></div>
                    </td>
                    <td
                      v-if="exactDateSelected"
                      :class="`${getDarkColorClass(index)}`"
                    >
                      <div
                              :class="item.impulses ? 'accident-triangle triangle' : 'no-accident-triangle triangle'"
                      ></div>
                    </td>

                    <td
                            v-if="exactDateSelected"
                            :class="`${getLightColorClass(index)}`"
                    >
                      <div
                              :class="item.landing ? 'accident-triangle triangle' : 'no-accident-triangle triangle'"
                      ></div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="`${getDarkColorClass(index)}`"
                    >
                      <div
                              :class="item.accident ? 'accident-triangle triangle' : 'no-accident-triangle triangle'"
                      ></div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="`${getLightColorClass(index)}`"
                    >
                      <div
                              :class="item.restrictions ? 'accident-triangle triangle' : 'no-accident-triangle triangle'"
                      ></div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="`${getDarkColorClass(index)}`"
                    >
                      <div
                              :class="item.otheraccidents ? 'accident-triangle triangle' : 'no-accident-triangle triangle'"
                      ></div>
                    </td>
                  </tr>
                  <tr
                          v-if="dzoCompanyDecomposition"
                  >
                    <td :class="index % 2 === 0 ? 'tdStyle3-total' : 'tdNone'">
                      <div class="">{{ NameDzoFull[0] }}</div>
                    </td>

                    <td
                      v-if="buttonYearlyTab"
                      :class="
                        index % 2 === 0 ? 'tdStyle3-total' : 'tdStyle3-total'
                      "
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.periodPlan}}
                      </div>
                    </td>

                    <td
                      v-if="buttonMonthlyTab"
                      :class="
                        index % 2 === 0 ? 'tdStyle3-total' : 'tdStyle3-total'
                      "
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.periodPlan}}
                      </div>
                    </td>

                    <td
                      :class="`${getLighterClass(index)}`"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.plan}}
                        <div
                          class="right"
                        >
                          {{ thousand }} {{ item4 }}
                        </div>
                      </div>
                    </td>

                    <td
                            :class="`${getDarkerClass(index)}`"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.fact}}
                        <div
                          class="right"
                        >
                          {{ thousand }} {{ item4 }}
                        </div>
                      </div>
                    </td>
                    <td
                            :class="`${getLighterClass(index)}`"
                    >
                      <div
                        v-if="factMonthSumm"
                        :class="
                          factMonthSumm - planMonthSumm < 0 ?
                          'triangle fall-indicator-production-data' :
                          'triangle growth-indicator-production-data'
                        "
                      ></div>
                      <div class="font dynamic">
                        {{dzoCompaniesSummary.difference}}
                        <div
                          class="right"
                        >
                          {{ thousand }}{{ item4 }}
                        </div>
                      </div>
                    </td>
                    <td :class="`${getDarkerClass(index)}`">
                      <div
                        v-if="factMonthSumm"
                        :class="
                          ((factMonthSumm - planMonthSumm) / planMonthSumm) *
                          100 < 0 ?
                          'triangle fall-indicator-production-data' :
                          'triangle growth-indicator-production-data'
                        "
                      ></div>
                      <div class="font dynamic" v-if="factMonthSumm">
                        {{dzoCompaniesSummary.percent}}
                      </div>
                    </td>
                    <td
                            :class="`${getLighterClass(index)}`"
                            v-if="exactDateSelected"
                    >
                    </td>
                    <td
                            :class="`${getDarkerClass(index)}`"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="`${getLighterClass(index)}`"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="`${getDarkerClass(index)}`"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="`${getLighterClass(index)}`"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="`${getDarkerClass(index)}`"
                            v-if="exactDateSelected"
                    ></td>
                  </tr>
                </tbody>
              </table>

              <div
                      v-if="!dzoCompanyDecomposition"
                      v-for="(item) in dzoCompanySummary"
                      colspan="5"
                      class="dzo-company-reason"
              >
                <div class="mt-3 text-center">Текст причины</div>
                <div class="ml-3">
                  <div class="mt-2" v-if="item.opec">{{ item.opec }}</div>
                  <div class="mt-2" v-if="item.impulses">
                    {{ item.impulses }}
                  </div>
                  <div class="mt-2" v-if="item.landing">{{ item.landing }}</div>
                  <div class="mt-2" v-if="item.accident">
                    {{ item.accident }}
                  </div>
                  <div class="mt-2" v-if="item.restrictions">
                    {{ item.restrictions }}
                  </div>
                  <div class="mt-2" v-if="item.otheraccidents">
                    {{ item.otheraccidents }}
                  </div>
                </div>
              </div>


            </div>
            <div
              class="vis-chart pl-3"
              v-if="
                (item != 'oil_plan' &&
                  item != 'oil_dlv_plan' &&
                  item != 'oil_opek_plan') ||
                oneDate != 1
              "
            >
              <div class="name-chart-left">
                {{ nameChartLeft }}, {{ thousand }} {{ item4 }}
              </div>
              <div class="name-chart-head">{{ item3 }}</div>
              <vc-chart :height="465"> </vc-chart>
            </div>
          </div>
        </div>
      </div>

      <visual-center-usd-table
        :style="`${Table2}`"
        :period.sync="period"
        :usd-rates-data.sync="oilRatesData"
        :period-select-func.sync="periodSelectFunc"
        :table-data.sync="oilRatesDataTableForCurrentPeriod"
        :usd-chart-is-loading.sync="isPricesChartLoading"
        @period-select-usd="
          updatePrices(periodSelect(selectedPeriod))
        "
        @change-table="changeTable('1')"
        :main-title="trans('visualcenter.oilPricedynamic')"
        :second-title="'USD Yandex quote'"
      />
      <!-- 'Динамика цены на нефть' -->
      <visual-center-usd-table
        :style="`${Table3}`"
        :period.sync="period"
        :usd-rates-data.sync="usdRatesData"
        :period-select-func.sync="periodSelectFunc"
        :table-data.sync="usdRatesDataTableForCurrentPeriod"
        :usd-chart-is-loading.sync="isPricesChartLoading"
        @period-select-usd="
          updatePrices(periodSelect(selectedPeriod))
        "
        @change-table="changeTable('1')"
        :main-title="trans('visualcenter.kursHeader')"
        :second-title="'USD НБ РК'"
      />
      <!-- 'Динамика курса доллара США к тенге (USD, НБ РК)' -->
      <div class="third-table big-area" :style="`${Table5}`">
        <div class="first-string first-string2">
          <div class="container-fluid">
            <div class="area-6-name row mt-3 mb-3 px-2">
              <div class="col">
                <div class="ml-4 bold">
                  <!--Фонд нагнетательных скважин-->{{
                    trans("visualcenter.idle_wells")
                  }}
                </div>
              </div>
              <div class="col px-4">
                <div class="close2" @click="changeTable('1')">
                  <!-- Закрыть -->{{ trans("visualcenter.close") }}
                </div>
              </div>
            </div>

            <div class="row px-4">
              <div class="w-25 pr-2">
                <div
                        :class="[`${buttonDailyTab}`,'button2']"
                        @click="changeMenu2(1)"
                >
                  <!-- Суточная -->{{ trans("visualcenter.daily") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                        :class="[`${buttonMonthlyTab}`,'button2']"
                        @click="changeMenu2(2)"
                >
                  <!-- С начала месяца -->{{ trans("visualcenter.monthBegin") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                        :class="[`${buttonYearlyTab}`,'button2']"
                        @click="changeMenu2(3)"
                >
                  <!-- С начала года -->{{ trans("visualcenter.yearBegin") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div class="dropdown3">
                  <div
                          :class="[`${buttonPeriodTab}`,'button2']"
                          @click="changeMenu2(4)"
                  >
                    <span v-if="oneDate">
                      <!-- Дата  -->{{ trans("visualcenter.date") }} [{{
                        timeSelect
                      }}]</span
                    >
                    <span v-else>
                      <!-- Период  -->{{ trans("visualcenter.period") }} [{{
                        timeSelect
                      }}
                      - {{ timeSelectOld }}]</span
                    >
                  </div>
                  <ul class="center-menu2 right-indent">
                    <li class="center-li">
                      <br /><br />

                      <div class="month-day">
                        <div>
                          <date-picker
                            v-if="selectedPeriod === 0"
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
                    <!--<option value="all" v-if="company != 'all'">
                      {{ getNameDzoFull(company) }}
                    </option>-->
                    <option value="all">
                      <!-- Все компании -->{{
                        trans("visualcenter.allCompany")
                      }}
                    </option>
                    <!-- <option value="all"></option>-->
                    <option value="ОМГ">
                      <!-- АО «ОзенМунайГаз» -->{{ trans("visualcenter.omg") }}
                    </option>
                    <option value="ММГ">
                      <!-- АО «Мангистаумунайгаз» -->{{
                        trans("visualcenter.mmg")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО «КазГерМунай» -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КОА">
                      <!-- ТОО "Казахойл Актобе -->{{
                        trans("visualcenter.koa")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО "Казгермунай" -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КБМ">
                      <!-- АО «Каражанбасмунай» -->{{
                        trans("visualcenter.kbm")
                      }}
                    </option>
                    <option value="ЭМГ">
                      <!-- АО «ЭмбаМунайГаз» -->{{ trans("visualcenter.emg") }}
                    </option>
                  </select>
                </div>

                <div class="w-50 pl-2 pr-1">
                  <div class="col">
                    <div
                      class="button2"
                      :style="`${buttonHoverNagInnerWells}`"
                      @click="buttonInnerWellsNag()"
                    >
                      <!-- В простое -->{{ trans("visualcenter.in_idle") }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
              <div class="vis-table px-3 col-sm-7">
                <table v-if="innerWells.length" class="table7 w-100">
                  <tbody>
                    <tr
                      v-for="(item, index) in innerWells"
                      @click="innerWellsSelectedRow = item.code"
                    >
                      <td
                        @click="innerWellsSelectedRow = item.code"
                        class="width-40"
                        :class="{
                          tdStyle: index % 2 === 0,
                          selected: innerWellsSelectedRow === item.code,
                        }"
                        style="cursor: pointer"
                      >
                      <span class="data-titles">
                        {{ item.name }}
                      </span>
                      </td>
                      <td
                        @click="innerWellsSelectedRow = item.code"
                        class="w-25 tdNumber"
                        :class="index % 2 === 0 ? 'tdStyle' : ''"
                        style="cursor: pointer"
                      >
                      <div class="data-values">
                        {{ formatVisTableNumber2(item.value) }}
                        <span class="data-metrics">
                          {{ trans("visualcenter.skv") }}
                        </span>
                      </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-5">
                <div  class="name-chart-left">Кол-во скважин</div>
                <visual-center3-wells
                  v-if="innerWellsNagDataForChart"
                  :chartData="innerWellsNagDataForChart"
                >
                  ></visual-center3-wells
                >
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
                <div class="ml-4 bold">
                  <!-- Фонд добывающих скважин -->{{
                    trans("visualcenter.prod_wells")
                  }}
                </div>
              </div>
              <div class="col px-4">
                <div class="close2" @click="changeTable('1')">
                  <!-- Закрыть -->{{ trans("visualcenter.close") }}
                </div>
              </div>
            </div>

            <div class="row px-4">
              <div class="w-25 pr-2">
                <div
                        :class="[`${buttonDailyTab}`,'button2']"
                        @click="changeMenu2(1)"
                >
                  <!-- Суточная -->{{ trans("visualcenter.daily") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                        :class="[`${buttonMonthlyTab}`,'button2']"
                  @click="changeMenu2(2)"
                >
                  <!-- С начала месяца -->{{ trans("visualcenter.monthBegin") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                        :class="[`${buttonYearlyTab}`,'button2']"
                        @click="changeMenu2(3)"
                >
                  {{ trans("visualcenter.yearBegin") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div class="dropdown3">
                  <div
                          :class="[`${buttonPeriodTab}`,'button2']"
                          @click="changeMenu2(4)"
                  >
                    <span v-if="oneDate">
                      <!-- Дата  -->{{ trans("visualcenter.date") }} [{{
                        timeSelect
                      }}]</span
                    >
                    <span v-else>
                      <!-- Период  -->{{ trans("visualcenter.period") }} [{{
                        timeSelect
                      }}
                      - {{ timeSelectOld }}]</span
                    >
                  </div>
                  <ul class="center-menu2 right-indent">
                    <li class="center-li">
                      <br /><br />

                      <div class="month-day">
                        <div>
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
                    </option>
                    <option value="all" v-if="company != 'all'">
                      {{ getNameDzoFull(company) }}
                    </option>-->
                    <option value="all">
                      <!-- Все компании -->{{
                        trans("visualcenter.allCompany")
                      }}
                    </option>
                    <!-- <option value="all"></option>-->
                    <option value="ОМГ">
                      <!-- АО «ОзенМунайГаз» -->{{ trans("visualcenter.omg") }}
                    </option>
                    <option value="ММГ">
                      <!-- АО «Мангистаумунайгаз» -->{{
                        trans("visualcenter.mmg")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО «КазГерМунай» -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КОА">
                      <!-- ТОО "Казахойл Актобе" -->{{
                        trans("visualcenter.koa")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО "Казгермунай" -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КБМ">
                      <!-- АО «Каражанбасмунай» -->{{
                        trans("visualcenter.kbm")
                      }}
                    </option>
                    <option value="ЭМГ">
                      <!-- АО «ЭмбаМунайГаз» -->{{ trans("visualcenter.emg") }}
                    </option>
                  </select>
                </div>

                <div class="w-50 pl-2 pr-1">
                  <div class="col">
                    <div
                      class="button2"
                      :style="`${buttonHoverProdInnerWells}`"
                      @click="buttonInnerWellsProd()"
                    >
                      <!-- В простое -->{{ trans("visualcenter.in_idle") }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
              <div class="vis-table px-3 col-sm-7">
                <table v-if="innerWells2.length" class="table7 w-100">
                  <tbody>
                    <tr
                      v-for="(item, index) in innerWells2"
                      @click="innerWells2SelectedRow = item.code"
                    >
                      <td
                        @click="innerWells2SelectedRow = item.code"
                        class="width-40"
                        :class="{
                          tdStyle: index % 2 === 0,
                          selected: innerWells2SelectedRow === item.code,
                        }"
                        style="cursor: pointer"
                      >
                      <span class="data-titles">
                        {{ item.name }}
                      </span>
                      </td>
                      <td
                        @click="innerWells2SelectedRow = item.code"
                        class="w-25 text-center"
                        :class="
                          index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                        "
                        style="cursor: pointer"
                      >
                      <div class="data-values">
                        {{ formatVisTableNumber2(item.value) }}
                        <span class="data-metrics">
                          {{trans("visualcenter.otmMetricSystemWells")}}
                        </span>
                      </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-5">
                <div  class="name-chart-left">Кол-во скважин</div>
                <visual-center3-wells
                  v-if="innerWellsProd2DataForChart"
                  :chartData="innerWellsProd2DataForChart"
                >
                </visual-center3-wells>
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
                <div class="ml-4 bold">
                  <!-- ОТМ -->{{ trans("visualcenter.otm") }}
                </div>
              </div>
              <div class="col px-4">
                <div class="close2" @click="changeTable('1')">
                  <!-- Закрыть -->{{ trans("visualcenter.close") }}
                </div>
              </div>
            </div>

            <div class="row px-4">
              <div class="w-25 pr-2">
                <div
                        :class="[`${buttonDailyTab}`,'button2']"
                        @click="changeMenu2(1)"
                >
                  {{ trans("visualcenter.daily") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                  :class="[`${buttonMonthlyTab}`,'button2']"
                  @click="changeMenu2(2)"
                >
                  {{ trans("visualcenter.monthBegin") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div
                        :class="[`${buttonYearlyTab}`,'button2']"
                        @click="changeMenu2(3)"
                >
                  {{ trans("visualcenter.yearBegin") }}
                </div>
              </div>
              <div class="w-25 px-2">
                <div class="dropdown3">
                  <div
                          :class="[`${buttonPeriodTab}`,'button2']"
                          @click="changeMenu2(4)"
                  >
                    <span v-if="oneDate">
                      {{ trans("visualcenter.date") }} [{{
                        timeSelect
                      }}]</span
                    >
                    <span v-else>
                      <!-- Период  -->{{ trans("visualcenter.period") }} [{{
                        timeSelect
                      }}
                      - {{ timeSelectOld }}]</span
                    >
                  </div>
                  <ul class="center-menu2 right-indent">
                    <li class="center-li">
                      <br /><br />

                      <div class="month-day">
                        <div>
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
                    <!--<option value="all" v-if="company != 'all'">
                      {{ getNameDzoFull(company) }}
                    </option>-->
                    <option value="all">
                      <!-- Все компании -->{{
                        trans("visualcenter.allCompany")
                      }}
                    </option>
                    <option value="ОМГ">
                      <!-- АО «ОзенМунайГаз» -->{{ trans("visualcenter.omg") }}
                    </option>
                    <option value="ММГ">
                      <!-- АО «Мангистаумунайгаз» -->{{
                        trans("visualcenter.mmg")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО «КазГерМунай» -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КОА">
                      <!-- ТОО "Казахойл Актобе" -->{{
                        trans("visualcenter.koa")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО "Казгермунай" -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КБМ">
                      <!-- АО «Каражанбасмунай» -->{{
                        trans("visualcenter.kbm")
                      }}
                    </option>
                    <option value="ЭМГ">
                      <!-- АО «ЭмбаМунайГаз» -->{{ trans("visualcenter.emg") }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
              <div class="vis-table px-3 col-sm-7">
                <table
                  v-if="otmData.length"
                  class="table7 w-100"
                  style="height: calc(100% - 20px)"
                >
                  <tbody>
                    <tr
                      v-for="(item, index) in otmData"
                      @click="otmSelectedRow = item.code"
                    >
                      <td
                        @click="otmSelectedRow = item.code"
                        class="width-40"
                        :class="{
                          tdStyle: index % 2 === 0,
                          selected: otmSelectedRow === item.code,
                        }"
                        style="cursor: pointer"
                      >
                      <span class="data-titles">
                        {{ item.name }}
                      </span>
                      </td>
                      <td
                        @click="otmSelectedRow = item.code"
                        class="width-20 text-center data-pointer"
                        :class="
                          index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                        "
                      >
                        <div
                          v-if="index === 0"
                          class="center"
                          style="font-size: 12px; line-height: 1.2"
                        >
                          <!-- План -->{{ trans("visualcenter.plan") }}
                        </div>

                        <div class="data-values">
                          {{ formatVisTableNumber2(item.plan) }}
                          <span class="data-metrics">
                            {{item.metricSystem}}
                          </span>
                        </div>
                      </td>
                      <td
                        @click="otmSelectedRow = item.code"
                        class="width-20 text-center data-pointer"
                        :class="
                          index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                        "
                      >
                        <div
                          v-if="index === 0"
                          class="center"
                          style="font-size: 12px; line-height: 1.2"
                        >
                          <!-- Факт -->{{ trans("visualcenter.fact") }}
                        </div>
                        <div class="data-values">
                          {{formatVisTableNumber2(item.fact) }}
                          <span class="data-metrics">
                            {{item.metricSystem}}
                          </span>
                        </div>
                      </td>
                      <td
                        class="width-20 text-center data-pointer"
                        :class="
                          index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                        "
                      >
                        <div v-if="index === 0" class="center">+/-</div>
                        <div
                          class="right"
                        >
                        <span class="data-metrics">
                          {{item.metricSystem}}
                        </span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-5">
                <div  class="name-chart-left">Кол-во скважин</div>
                <visual-center3-wells
                  v-if="otmDataForChart"
                  :chartData="otmDataForChart"
                ></visual-center3-wells>
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
                <div class="ml-4 bold">
                  <!-- Химизация -->{{ trans("visualcenter.chem") }}
                </div>
              </div>
              <div class="col px-4">
                <div class="close2" @click="changeTable('1')">
                  <!-- Закрыть -->{{ trans("visualcenter.close") }}
                </div>
              </div>
            </div>

            <div class="row px-4">
              <div class="col px-2">
                <div
                        :class="[`${buttonMonthlyTab}`,'button2']"
                        @click="changeMenu2(2)"
                >
                  {{ trans("visualcenter.monthBegin") }}
                </div>
              </div>
              <div class="col px-2">
                <div
                        :class="[`${buttonYearlyTab}`,'button2']"
                        @click="changeMenu2(3)"
                >
                  {{ trans("visualcenter.yearBegin") }}
                </div>
              </div>
              <div class="col px-2">
                <div class="dropdown3">
                  <div
                          :class="[`${buttonPeriodTab}`,'button2']"
                          @click="changeMenu2(4)"
                  >
                    <span v-if="oneDate">
                      {{ trans("visualcenter.date") }} [{{
                        timeSelect
                      }}]</span
                    >
                    <span v-else>
                      {{ trans("visualcenter.period") }} [{{
                        timeSelect
                      }}
                      - {{ timeSelectOld }}]</span
                    >
                  </div>
                  <ul class="center-menu2 right-indent">
                    <li class="center-li">
                      <br /><br />

                      <div class="month-day">
                        <div>
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
                    <!-- <option value="all" v-if="company != 'all'">
                      {{ getNameDzoFull(company) }}
                    </option>-->
                    <option value="all">
                      <!-- Все компании -->{{
                        trans("visualcenter.allCompany")
                      }}
                    </option>
                    <option value="ОМГ">
                      <!-- АО «ОзенМунайГаз» -->{{ trans("visualcenter.omg") }}
                    </option>
                    <option value="ММГ">
                      <!-- АО «Мангистаумунайгаз» -->{{
                        trans("visualcenter.mmg")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО «КазГерМунай» -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КОА">
                      <!-- ТОО "Казахойл Актобе" -->{{
                        trans("visualcenter.koa")
                      }}
                    </option>
                    <option value="КГМ">
                      <!-- ТОО "Казгермунай" -->{{ trans("visualcenter.kgm") }}
                    </option>
                    <option value="КБМ">
                      <!-- АО «Каражанбасмунай» -->{{
                        trans("visualcenter.kbm")
                      }}
                    </option>
                    <option value="ЭМГ">
                      <!-- АО «ЭмбаМунайГаз» -->{{ trans("visualcenter.emg") }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <br />
            <div class="row container-fluid">
              <div class="vis-table px-3 col-sm-7">
                <table
                  v-if="chemistryData.length"
                  class="table7 w-100"
                  style="height: calc(100% - 20px)"
                >
                  <tbody>
                    <tr
                      v-for="(item, index) in chemistryData"
                      @click="chemistrySelectedRow = item.code"
                    >
                      <td
                        @click="chemistrySelectedRow = item.code"
                        class="width-40"
                        :class="{
                          tdStyle: index % 2 === 0,
                          selected: chemistrySelectedRow === item.code,
                        }"
                        style="cursor: pointer"
                      >
                        <span class="data-titles">
                          {{ item.name }}
                        </span>
                      </td>
                      <td
                        @click="chemistrySelectedRow = item.code"
                        class="width-20 text-center data-pointer"
                        :class="
                          index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                        "
                      >
                        <div
                          v-if="index === 0"
                          class="center"

                        >
                          <span class="data-column-name">
                            {{ trans("visualcenter.plan") }}
                          </span>
                        </div>
                        <div class="data-values">
                          {{ formatVisTableNumber2(item.fact) }}
                          <span class="data-metrics">
                            {{item.metricSystem}}
                          </span>
                       </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-5">
              <div  class="name-chart-left">Объём хим. реагента, тонны</div>
                <visual-center3-wells
                  v-if="chemistryDataForChart"
                  :chartData="chemistryDataForChart"
                ></visual-center3-wells>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="right-side2 flex-grow-1 pl-1">
      <div class="first-string">
        <div>
          <table class="table table1-2">
            <tr class="cursor-pointer">
              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4">
                  {{ formatVisTableNumber2(prod_wells_work) }}
                </div>
                <div class="in-work">
                  <!-- В работе -->{{ trans("visualcenter.in_work") }}
                </div>
                <div
                  :class="`${getColor2(
                    getDiffProcentLastP(prod_wells_work, prod_wells_workPercent)
                  )}`"
                ></div>

                <div class="txt2-2">
                  {{
                    Math.abs(
                      getDiffProcentLastP(
                        prod_wells_work,
                        prod_wells_workPercent
                      )
                    )
                  }}%
                </div>
              </td>

              <td
                class="w-50"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt4 d-flex justify-content-between">
                  <div>
                    {{ formatVisTableNumber2(prod_wells_idle) }}
                  </div>
                  <div class="mt-1">
                    <img src="/img/icons/link.svg" />
                  </div>
                </div>
                <div class="in-idle">
                  <!-- В простое -->{{ trans("visualcenter.in_idle") }}
                </div>
                <div
                  :class="`${getColor2(
                    getDiffProcentLastP(prod_wells_idle, prod_wells_idlePercent)
                  )}`"
                ></div>

                <div class="txt2-2">
                  {{
                    Math.abs(
                      getDiffProcentLastP(
                        prod_wells_idle,
                        prod_wells_idlePercent
                      )
                    )
                  }}%
                </div>
                <br />
              </td>
            </tr>
            <tr class="cursor-pointer">
              <td
                colspan="2"
                @click="changeTable('4')"
                :style="`${tableHover4}`"
              >
                <div class="txt2">
                  <!-- Фонд добывающих скважин -->
                  {{ trans("visualcenter.prod_wells") }}
                </div>
              </td>
            </tr>
          </table>
          <!-- <div class="line-bottom"></div>-->
        </div>
        <div class="first-string first-string2">
          <div>
            <table class="table table1-2">
              <tr class="cursor-pointer">
                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4">
                    {{
                  formatVisTableNumber2(inj_wells_work)
                    }}
                  </div>
                  <div class="in-work">
                    <!-- В работе -->{{ trans("visualcenter.in_work") }}
                  </div>
                  <div
                    :class="`${getColor2(
                      getDiffProcentLastP(inj_wells_work, inj_wells_workPercent)
                    )}`"
                  ></div>

                  <div class="txt2-2">
                    {{
                      Math.abs(
                        getDiffProcentLastP(
                          inj_wells_work,
                          inj_wells_workPercent
                        )
                      )
                    }}%
                  </div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt4 d-flex justify-content-between">
                    <div>
                      {{
                        formatVisTableNumber2(inj_wells_idle)
                      }}
                    </div>
                    <div class="mt-1">
                      <img src="/img/icons/link.svg" />
                    </div>
                  </div>
                  <div class="in-idle">
                    <!-- В простое -->
                    {{ trans("visualcenter.in_idle") }}
                  </div>
                  <div
                    :class="`${getColor2(
                      getDiffProcentLastP(inj_wells_idle, inj_wells_idlePercent)
                    )}`"
                  ></div>

                  <div class="txt2-2">
                    {{
                      Math.abs(
                        getDiffProcentLastP(
                          inj_wells_idle,
                          inj_wells_idlePercent
                        )
                      )
                    }}%
                  </div>
                  <br />
                </td>
              </tr>
              <tr class="cursor-pointer">
                <td
                  colspan="2"
                  @click="changeTable('5')"
                  :style="`${tableHover5}`"
                >
                  <div class="txt2">
                    <!--Фонд нагнетательных скважин-->{{
                      trans("visualcenter.idle_wells")
                    }}
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <div class="first-string first-string2">
          <div>
            <table class="table table5">
              <tr class="cursor-pointer">
                <td
                  class="w-50"
                  @click="changeTable('6')"
                  :style="`${tableHover6}`"
                >
                  <div class="mt-1 float-right">
                    <img data-v-3712f8d4="" src="/img/icons/link.svg" />
                  </div>
                  <div class="otm"></div>
                  <div class="txt2">
                    <!-- ОТМ -->{{ trans("visualcenter.otm") }}
                  </div>
                </td>

                <td
                  class="w-50"
                  @click="changeTable('7')"
                  :style="`${tableHover7}`"
                >
                  <div class="mt-1 float-right">
                    <img data-v-3712f8d4="" src="/img/icons/link.svg" />
                  </div>
                  <div class="him"></div>
                  <div class="txt2">
                    <!-- Химизация -->{{ trans("visualcenter.chem") }}
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="first-string first-string2">
        <div>
          <table class="table">
            <tr>
              <td class="w-50 px-2">
                <div class="number">{{ staff }}</div>
                <div class="in-idle2">
                  {{ quarter1[0] }}
                  <!-- квартал  -->{{ trans("visualcenter.quarter") }}
                  {{ quarter1[1] }} г.
                </div>
              </td>

              <td class="w-50">
                <div class="column-1">
                  <div class="column-1">
                    <div
                      :class="`${getColor2(
                        getDiffProcentLastP(staffPercent, staff)
                      )}`"
                    ></div>
                    <div class="txt2-2">
                      {{ Math.abs(getDiffProcentLastP(staffPercent, staff)) }}%
                    </div>
                  </div>
                </div>
                <div class="column-1">
                  <div class="in-idle">
                    {{ getDiffProcentLastP(staffPercent, staff, "1") }}
                  </div>
                  <div class="in-idle">
                    vs {{ quarter2[0] }}
                    <!-- квартал  -->{{ trans("visualcenter.quarter") }}
                    {{ quarter2[1] }}г.
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">
                  <!-- Численность персонала -->{{
                    trans("visualcenter.personal")
                  }}
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div>
          <table class="table">
            <tr>
              <td class="w-50 px-2">
                <div class="number">{{ covid }}</div>
                <div class="in-idle2">{{ timeSelect }}</div>
              </td>

              <td class="w-50">
                <div class="column-1">
                  <div
                    :class="`${getColor2(
                      getDiffProcentLastP(covidPercent, covid)
                    )}`"
                  ></div>
                  <div class="txt2-2">
                    {{ Math.abs(getDiffProcentLastP(covidPercent, covid)) }}%
                  </div>
                </div>
                <div class="column-1">
                  <div class="in-idle">
                    {{ getDiffProcentLastP(covidPercent, covid, "1") }}
                  </div>
                  <div class="in-idle">
                    vs
                    <span v-if="oneDate"> {{ lastDate2 }}</span>
                    <span v-else> {{ lastDate1 }} - {{ lastDate2 }}</span>
                  </div>
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
        <div>
          <table class="table table1-2">
            <tr>
              <td>
                <div class="number">{{ accidentTotal }}</div>
                <div class="near-number">
                  <!--  <div class="column-1">
                    <div class="arrow"></div>
                    <div class="txt2">7</div>
                  </div>-->
                  <div class="column-1">
                    <!--<div class="in-idle">Прирост</div>-->
                    <div class="in-idle">
                      <!-- с начала -->{{ trans("visualcenter.from_begin") }}
                    </div>
                    <div class="in-idle">
                      <!-- года -->{{ trans("visualcenter.year") }}
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">
                  <!-- Несчастные случаи -->{{ trans("visualcenter.accident") }}
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="first-string first-string2">
        <div>
          <table class="table">
            <tr>
              <td class="size-td">
                <div class="number">0</div>
              </td>

              <td class="w-65">
                <div class="column-1">
                  <div class="in-idle">
                    <!-- Прирост -->{{ trans("visualcenter.increase") }}
                  </div>
                  <div class="in-idle">
                    <!-- с начала месяца -->{{
                      trans("visualcenter.monthBegin")
                    }}
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <div class="txt2">
                  <!-- Смертельные случаи -->
                  {{ trans("visualcenter.death") }}
                </div>
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
.vis-table {
  flex: 0 0 56%;
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

  .table4 {
    tr {
      td {
        padding: 5px 5px 5px 10px;
        position: relative;
        vertical-align: middle;
        min-width: 71px;
        &:first-child {
          display: inline-block;
          white-space: normal;
          min-width: 327px;
          width: 100%;
          font-weight: bold;
          font-size: 15px;
          min-height: 32px;
          span {
            img {
              width: 9px;
            }
          }
          div .data-titles {
            height: 50px;
          }
        }
        &.selected {
          background: #2e47c0 !important;
        }
        .font {
          align-items: baseline;
          display: flex;
          justify-content: space-between;
          font-size: 15px;
          margin-left: 0;
          &.dynamic {
            padding-left: 17px;
          }
          .right {
            font-size: 10px;
            margin-right: 0;
            display: none;
            font-family: 'Harmonia-sans', sans-serif;
            opacity: 0.6;
          }
        }
        .center {
          font-size: 0.63em;
          font-weight: bold;
          left: 0;
          margin: 0;
          position: absolute;
          text-align: center;
          top: 4px;
          width: 100%;
        }
      }
    }
    tr:after {
      content: ' ';
      display: block;
      visibility: hidden;
      clear: both;
    }
    tr:first-child .th {
      background: inherit;
      top: -1px;
      z-index: 3000;
    }
    th {
      position: sticky;
      position: --webkit-sticky;
      top: -1;
      z-index: 2;
      border: 0.5px solid #272953;
      width: 81px;
      position: sticky;
      font-family: Bold;
      font-size: 12px;
      background: #353EA1;
      text-align: center;
      &:first-child {
        width: 322px;
        padding-top: 5px;
        font-size: 16px;
      }
    }
  }
}

.vis-table-small {
  max-width: 46% !important;
  tr {
    line-height: 4.2rem !important;
    font-size: 1.2rem !important;
    font-family: Bold !important;
  }
  .tdNumber {
    font-size: 1.6rem;
    text-align: right;
    span {
      font-size: 0.7rem;
      font-weight: normal;
      opacity: 0.6;
    }
  }
}

.vis-table-small2 {
  max-width: 46% !important;
  tr {
    // line-height: 4.2rem !important;
    font-size: 1.2rem !important;
    font-family: Bold !important;
  }
  .tdNumber {
    font-size: 1.6rem;
    text-align: right;
    span {
      font-size: 0.7rem;
      font-weight: normal;
    }
  }
}

.vis-chart {
  flex: 0 0 44%;
  max-width: 44%;
}

.table7 {
  tr {
    td {
      padding: 0px 0px 0px 10px;
      position: relative;
      vertical-align: middle;
      &:first-child {
        height: 50px;
        white-space: normal;
        width: 235px;
        span {
          font-weight: bold;
          img {
            width: 9px;
          }
        }
      }
      &.selected {
        background: #2e47c0 !important;
      }
      .font {
        align-items: baseline;
        display: flex;
        justify-content: space-between;
        font-size: 24px;
        margin-left: 0;
        &.dynamic {
          padding-left: 17px;
        }
        .right {
          font-size: 10px;
          margin-right: 0;
        }
      }
      .center {
        font-size: 0.63em;
        font-weight: bold;
        left: 0;
        margin: 0;
        position: absolute;
        text-align: center;
        top: 4px;
        width: 100%;
      }
      .triangle {
        border: 6px solid transparent;
        height: 6px;
        margin-right: 5px;
        position: absolute;
        width: 6px;
      }
    }
  }
}

.width-40 {
    width: 40%;
  }
  .width-20 {
    width: 20%;
  }
  .data-titles {
    font-family: "HarmoniaSansProCyr-Regular";
    font-style: normal;
    font-size: 16px;
    height: 50px;
  }
  .data-values {
    font-family: "Bold";
    font-style: normal;
    font-size: 24px;
  }
  .data-metrics {
    font-family: "Harmonia-sans, sans-serif";
    font-style: normal;
    font-size: 10px;
    margin-left: 2%;
  }
  .data-column-name {
    font-size: 12px;
    font-family: "Harmonia-sans, sans-serif";
    font-style: normal;
  }
  .triangle-responsive {
    border: 6px solid transparent;
    height: 6px;
    margin-right: 5px;
    width: 6px;
    float: left;
  }
  .data-pointer {
    cursor: pointer;
    font-size: 30px;
  }
  .growth-indicator {
    margin-top: 6px;
    border-bottom: 6px solid #009846;
  }
  .fall-indicator {
    margin-top: 13px;
    border-top: 6px solid #e31e24;
  }
  .growth-indicator-production-data {
    border-bottom: 6px solid #009846;
  }
  .fall-indicator-production-data {
    margin-top: 8px;
    border-top: 6px solid #e31e24;
  }

  .accident-triangle {
    border-top: 6px solid rgb(227, 30, 36);
    margin-left: 30%;
  }
  .no-accident-triangle {
    position: relative;
    width: 14px;
    height: 5px;
    background: #9da0b7;
    border: unset;
    margin-left: 30%;
  }
  .button-tab-highlighted {
    border: none;
    background: #2E50E9;
    color:white;
  }
  .dzo-company-list ul {
    height: 450px;
    position: absolute;
    left: -0.5px;
    background: #40467E;
    top: 3em;
    margin-top: 10px;
    padding: 5px;
    list-style: none;
    z-index: 999;
    cursor: pointer;
    color:white;
    border-radius: inherit;
    overflow: hidden;
    overflow: auto;
    max-width: 252.45px;
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
  }
  .show-company-list {
    display: block;
  }
  .hide-company-list {
    display: none;
  }
  .dzo-company-list li {
    text-align: left;
    background: #40467E;
    font-family: "HarmoniaSansProCyr-Regular";
    font-style: normal;
    font-size: 14px;
    line-height: 27px;
    padding: 3px;
  }
  .arrow-down {
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid #9EA4C9;
    display: inline-block;
    cursor: pointer;
    float: right;
    margin-top: 20px;
    margin-right: 15px;
  }
  .dzo-company-reason {
    background: rgb(54, 59, 104);
    min-height: 60%;
    width: 100%;
    border-top: 5px solid #272953;
  }
  .mh-60 {
    min-height: 60%;
  }


</style>
