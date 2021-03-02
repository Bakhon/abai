<template>
  <div class="visualcenter-page-wrapper">
    <div class="row visualcenter-page-container">
      <div class="left-side col-lg-10 middle-block-columns">
        <div class="first-string px-2 middle-block__table">
          <div class="px-2">
            <table class="table table1">
              <tr>
                  <div class="row upper-block">
                  <div class="col-12 col-lg-8">
                    <div class="row">
                      <td class="col-4 col-lg-4 d-flex">
                        <div class="first-td-header">
                          <div class="row oil-block">
                            <div class="number col-8 col-md-6 col-lg-8">
                              {{ formatDigitToThousand(oil_factDay) }}
                            </div>
                            <div class="unit-vc col-12 col-md-5 col-lg-2">{{ thousand }} тонн</div>
                          </div>
                          <div class="additional-header txt1 col-6 col-md-12">
                            {{ trans("visualcenter.getoil") }}
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
                          <div class="row">
                            <div class="percent-header col-5 col-md-6" v-if="oil_factDay">
                              {{ getDiffProcentLastBigN(oil_factDay, oil_planDay) }}%
                            </div>
                            <div class="plan-header col-6" v-if="oil_planDay">
                              {{ formatDigitToThousand(oil_planDay) }}
                            </div>
                            <br />
                          </div>
                          <div class="col-12 mt-4">
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
                        </div>
                        <div class="second-td-header">
                          <div class="vert-line"></div>
                        </div>
                      </td>
                      <td class="col-4 col-lg-4 d-flex">
                        <div class="first-td-header">
                          <div class="row oil-block">
                            <div class="number col-8 col-md-7 col-lg-8">
                              {{ formatDigitToThousand(oil_dlv_factDay) }}
                            </div>
                            <div class="unit-vc col-12 col-md-5 col-lg-2">{{ thousand }} тонн</div>
                          </div>
                          <div class="additional-header txt1 col-6 col-md-12">
                            {{ trans("visualcenter.oildlv") }}
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
                          <div class="row">
                            <div class="percent-header col-5 col-md-6" v-if="oil_dlv_factDay">
                              {{
                                getDiffProcentLastBigN(oil_dlv_factDay, oil_dlv_planDay)
                              }}%
                            </div>
                            <div class="plan-header col-6" v-if="oil_dlv_planDay">
                              {{ formatDigitToThousand(oil_dlv_planDay) }}
                            </div>
                          </div>
                          <br />
                          <div class="col-12 mt-2">
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
                        </div>
                        <div class="second-td-header">
                          <div class="vert-line"></div>
                        </div>
                      </td>
                      <td class="col-4 col-sm-4 d-flex">
                        <div class="first-td-header">
                          <div class="row oil-block">
                            <div class="number col-8 col-md-7 col-lg-9">
                              {{ formatDigitToThousand(gas_factDay) }}
                            </div>
                            <div class="unit-vc col-12 col-md-5 col-lg-2">
                              {{ thousand }} м³
                            </div>
                          </div>
                          <div class="additional-header txt1 col-6 col-md-12">
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
                          <div class="row">
                            <div class="percent-header col-5 col-md-6" v-if="gas_factDay">
                              {{ getDiffProcentLastBigN(gas_factDay, gas_planDay) }}%
                            </div>
                            <div class="plan-header col-6" v-if="gas_planDay">
                              {{ formatDigitToThousand(gas_planDay) }}
                            </div>
                          </div>
                          <br />
                          <div class="col-12 mt-2">
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
                        </div>
                      <div class="second-td-header"></div>
                    </td>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="row rates-block__row">
                      <td
                        class="vc-select-table col-6 col-lg-6 rates-block"
                        @click="changeTable('2')"
                        :style="`${tableHover2}`"
                      >
                        <div>
                          <div class="number d-flex">
                            <div class="col-10">
                              {{ prices['oil']['current'] }}
                            </div>
                            <div class="col-2 mt-1">
                              <img src="/img/icons/link.svg" />
                            </div>
                          </div>
                          <div class="unit-vc col-12">$ / bbl</div>
                        </div>
                        <div class="txt1 col-12">
                          {{trans("visualcenter.oilPrice")}}
                        </div>
                        <br />
                        <div class="percent-currency col-12">
                          <div
                            class="arrow"
                            v-if="dailyOilPriceChange === 'UP'"
                          ></div>
                          <div
                            class="arrow2"
                            v-if="dailyOilPriceChange === 'DOWN'"
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
                      class="vc-select-table col-6 col-lg-6 rates-block"
                      @click="changeTable('3')"
                      :style="`${tableHover3}`"
                    >
                      <div>
                        <div class="number d-flex">
                          <div class="col-9">
                            {{ currencyNow }}
                          </div>
                          <div class="col-2 mt-1">
                            <img src="/img/icons/link.svg" />
                          </div>
                        </div>
                        <div class="unit-vc col-12">kzt / $</div>
                      </div>
                      <div class="txt1 col-12">
                        {{ trans("visualcenter.usdKurs") }}
                      </div>
                      <br />
                      <div class="percent-currency col-12">
                        <div
                          class="arrow"
                          v-if="dailyCurrencyChangeIndexUsd === 'UP'"
                        ></div>
                        <div
                          class="arrow2"
                          v-if="dailyCurrencyChangeIndexUsd === 'DOWN'"
                        ></div>
                        <div class="txt2-2">{{ dailyCurrencyChangeUsd }} {{trans("visualcenter.dzoPercent")}}</div>
                        <div class="txt3">
                          {{ trans("visualcenter.vsSeparator") }}
                          {{ new Date(prices['usd']['previousFetchDate']).toLocaleDateString() }}
                        </div>
                      </div>
                    </td>
                    </div>
                  </div>
                </div>
              </tr>
            </table>
          </div>
        </div>
        <div class="first-table big-area" :style="`${Table1}`">
          <div class="first-string first-string2">
            <div class="row px-4 mt-3 middle-block__list-x-scroll">
              <div class="col-12 col-lg dropdown dropdown4 font-weight">
                <div :class="[`${oilProductionButton}`, 'button1']">
                  <div
                    class="button1-vc-inner"
                    @click="
                      updateProductionData(
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
                    type="button"
                    class="btn btn-primary dropdown-toggle position-button-vc"
                    data-toggle="dropdown"
                  ></button>
                  <div>
                    <ul
                      class="dropdown-menu-vc dropdown-menu dropdown-menu-right"
                    >
                      <li class="center-li row px-4" @click="switchMainMenu('oilProductionButton','kmgParticipation')">
                        <div
                          class="col-1 mt-2"
                          v-html="`${getMainMenuButtonFlag('oilProductionButton','kmgParticipation')}`"
                        ></div>
                        <a
                          class="col-9 px-2"
                          @click="
                            updateProductionData(
                              'oil_plan',
                              'oil_fact',
                              `${oilChartHeadName}`,
                              ' тонн',
                              trans('visualcenter.dolyaUchast')
                            )
                          "
                        >
                          {{trans("visualcenter.dolyaUchast")}}
                        </a>
                      </li>
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('oilProductionButton','opecRestriction')"
                      >
                      <div
                              class="col-1 mt-2"
                              v-html="`${getMainMenuButtonFlag('oilProductionButton','opecRestriction')}`"
                      ></div>
                      <a
                              @click="changeAssets('opecRestiction')"
                              class="col-9 px-2"
                      >
                        {{trans("visualcenter.opek")}}
                      </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg dropdown dropdown4 font-weight">
                <div :class="[`${oilDeliveryButton}`, 'button1']">
                  <div
                    class="button1-vc-inner"
                    @click="
                      updateProductionData(
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
                  </div>
                  <button
                    type="button"
                    class="btn btn-primary dropdown-toggle position-button-vc"
                    data-toggle="dropdown"
                  ></button>

                  <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('oilDeliveryButton','kmgParticipation')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('oilDeliveryButton','kmgParticipation')}`"
                      ></div>

                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>
                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('oilDeliveryButton','oilResidue')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('oilDeliveryButton','oilResidue')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-lg dropdown dropdown4 font-weight">
                <div
                        :class="[`${gasProductionButton}`, 'button1']"
                >
                  <div
                    class="button1-vc-inner"
                    @click="
                      updateProductionData(
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
                  </div>
                  <button
                    type="button"
                    class="btn btn-primary dropdown-toggle position-button-vc"
                    data-toggle="dropdown"
                  ></button>
                  <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('gasProductionButton','deliveryNaturalGas')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('gasProductionButton','deliveryNaturalGas')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>

                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('gasProductionButton','gasConsumptionForNeeds')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('gasProductionButton','gasConsumptionForNeeds')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>
                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('gasProductionButton','deliveryAssociatedGas')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('gasProductionButton','deliveryAssociatedGas')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>
                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('gasProductionButton','associatedGasConsumptionForNeeds')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('gasProductionButton','associatedGasConsumptionForNeeds')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>
                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('gasProductionButton','associatedGasProcessing')"
                    >
                      <div
                            class="col-1 mt-2"
                            v-html="`${getMainMenuButtonFlag('gasProductionButton','associatedGasProcessing')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-12 col-lg dropdown dropdown4 font-weight">
                <div :class="[`${condensateProductionButton}`, 'button1']">
                  <div
                    class="button1-vc-inner"
                    @click="
                      updateProductionData(
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
                      {{ trans("visualcenter.getgk") }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg dropdown dropdown4 font-weight">
                <div
                        :class="[`${waterInjectionButton}`, 'button1']"
                >
                  <div
                    class="button1-vc-inner"
                    @click="
                      updateProductionData(
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
                  </div>
                  <button
                    type="button"
                    class="btn btn-primary dropdown-toggle position-button-vc"
                    data-toggle="dropdown"
                  ></button>
                  <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('waterInjectionButton','seaWaterInjection')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('waterInjectionButton','seaWaterInjection')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>

                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('waterInjectionButton','wasteWaterInjection')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('waterInjectionButton','wasteWaterInjection')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>

                    <li
                            class="center-li row px-4"
                            @click="switchMainMenu('waterInjectionButton','albsenWaterInjection')"
                    >
                      <div
                        class="col-1 mt-2"
                        v-html="`${getMainMenuButtonFlag('waterInjectionButton','albsenWaterInjection')}`"
                      ></div>
                      <a
                        class="col-9 px-2"
                        @click="
                          updateProductionData(
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
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row px-4 mt-3 middle-block__list-x-scroll">
              <div class="col-8 col-lg dropdown">
                <div :class="[`${buttonDzoDropdown}`, 'button2 dzocompanylist__button']">
                  <div class="button2 dzocompanylist__button">
                    {{ trans("visualcenter.dzoAllCompany") }}
                    <button
                            type="button"
                            class="btn btn-primary dropdown-toggle position-button-vc"
                            data-toggle="dropdown"
                    ></button>
                    <div class="dzo-company-list">
                      <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right">
                        <li class="px-4">
                          <div>
                            <input
                                    :disabled="dzoCompaniesAssets['isAllAssets']"
                                    :checked="dzoCompaniesAssets['isAllAssets']"
                                    type="checkbox"
                                    @click="`${selectDzoCompanies()}`"
                            ></input>
                            {{trans("visualcenter.dzoAllCompany")}}
                            <div class="dzocompanies-dropdown__divider"></div>
                          </div>
                        </li>
                        <li class="px-4">
                          <div>
                            <input
                                    type="checkbox"
                                    :checked="dzoCompaniesAssets['isOperating']"
                                    @click="`${changeAssets('isOperating')}`"
                            ></input>
                            {{trans("visualcenter.isOperating")}}
                          </div>
                        </li>
                        <li class="px-4">
                          <div>
                            <input
                                    type="checkbox"
                                    :checked="dzoCompaniesAssets['isNonOperating']"
                                    @click="`${changeAssets('isNonOperating')}`"
                            ></input>
                            {{trans("visualcenter.isNonOperating")}}
                            <div class="dzocompanies-dropdown__divider"></div>
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
                </div>
              </div>
              <div class="col-8 col-lg">
                <div
                        :class="[`${buttonDailyTab}`,'button2']"
                        @click="changeMenu2(1)"
                >
                  {{ trans("visualcenter.daily") }}
                </div>
              </div>
              <div class="col-8 col-lg">
                <div
                        :class="[`${buttonMonthlyTab}`,'button2']"
                        @click="changeMenu2(2)"
                >
                  {{ trans("visualcenter.monthBegin") }}
                </div>
              </div>
              <div class="col-8 col-lg">
                <div
                        :class="[`${buttonYearlyTab}`,'button2']"
                        @click="changeMenu2(3)"
                >
                  {{ trans("visualcenter.yearBegin") }}
                </div>
              </div>
              <div class="col-8 col-lg">
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

            <div class="row mh-60 mt-3 px-3">
              <div
                      class="col-sm-7 vis-table"
                      :class="scroll">
                <table
                        v-if="bigTable.length"
                        :class="buttonDailyTab ? 'table4 w-100' : 'table4 w-100 mh-30'"
                >
                  <thead>
                    <tr>
                      <th>{{ trans("visualcenter.dzo") }}</th>
                      <th v-if="buttonMonthlyTab" >
                        {{ trans("visualcenter.dzoMonthlyPlan") }}
                        <div v-if="currentDzoList !== 'daily'">
                          {{ trans("visualcenter.dzoThousandTon") }}
                        </div>
                        <div v-if="currentDzoList === 'daily'">
                          {{ trans("visualcenter.chemistryMetricTon") }}
                        </div>
                        <div v-if="isOpecFilterActive">
                          {{ trans("visualcenter.dzoOpec") }}
                        </div>
                      </th>
                      <th v-if="buttonYearlyTab">
                        {{ trans("visualcenter.dzoYearlyPlan") }}
                        <div v-if="currentDzoList !== 'daily'">
                          {{ trans("visualcenter.dzoThousandTon") }}
                        </div>
                        <div v-if="currentDzoList === 'daily'">
                          {{ trans("visualcenter.chemistryMetricTon") }}
                        </div>
                        <div v-if="isOpecFilterActive">
                          {{ trans("visualcenter.dzoOpec") }}
                        </div>
                      </th>
                      <th>
                        {{ trans("visualcenter.plan") }}
                        <div v-if="currentDzoList !== 'daily'">
                          {{ trans("visualcenter.dzoThousandTon") }}
                        </div>
                        <div v-if="currentDzoList === 'daily'">
                          {{ trans("visualcenter.chemistryMetricTon") }}
                        </div>
                      </th>
                      <th>
                        {{ trans("visualcenter.fact") }}
                        <div v-if="currentDzoList !== 'daily'">
                          {{ trans("visualcenter.dzoThousandTon") }}
                        </div>
                        <div v-if="currentDzoList === 'daily'">
                          {{ trans("visualcenter.chemistryMetricTon") }}
                        </div>
                      </th>
                      <th>
                        {{ trans("visualcenter.dzoDifference") }}
                        <div v-if="currentDzoList !== 'daily'">
                          {{ trans("visualcenter.dzoThousandTon") }}
                        </div>
                        <div v-if="currentDzoList === 'daily'">
                          {{ trans("visualcenter.chemistryMetricTon") }}
                        </div>
                      </th>
                      <th>
                        {{ trans("visualcenter.dzoPercent") }}
                      </th>
                      <th v-if="exactDateSelected">
                        {{ trans("visualcenter.dzoOpec") }}
                      </th>
                      <th v-if="exactDateSelected">
                        {{ trans("visualcenter.dzoImpulses") }}
                      </th>
                      <th v-if="exactDateSelected">
                        {{ trans("visualcenter.dzoLanding") }}
                      </th>
                      <th v-if="exactDateSelected">
                        {{ trans("visualcenter.dzoAlarmFirst") }}<br>
                        {{ trans("visualcenter.dzoAlarmSecond") }}
                      </th>
                      <th v-if="exactDateSelected">
                        {{ trans("visualcenter.dzoRestrictions") }}
                      </th>
                      <th v-if="exactDateSelected">
                        {{ trans("visualcenter.dzoOthers") }}
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in dzoCompanySummary">
                      <td
                              @click="isMultipleDzoCompaniesSelected ? `${selectOneDzoCompany(item.dzoMonth)}` : `${selectAllDzoCompanies()}`"
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

                      <td :class="`${getDzoColumnsClass(index,'plan')}`">

                        <div class="font">
                          {{ formatDigitToThousand(item.planMonth) }}
                        </div>
                      </td>

                      <td :class="[`${getDzoColumnsClass(index,'fact')}`,'fact']">
                        <div class="font">
                          {{ formatDigitToThousand(item.factMonth) }}
                        </div>
                      </td>
                      <td :class="`${getDzoColumnsClass(index,'difference')}`">
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
                      <td :class="`${getDzoColumnsClass(index,'percent')}`">
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
                        <div :class="item.impulses ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                        </div>
                      </td>
                      <td
                        v-if="exactDateSelected"
                        :class="`${getDarkColorClass(index)}`"
                      >
                        <div :class="item.impulses ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                        </div>
                      </td>

                      <td
                              v-if="exactDateSelected"
                              :class="`${getLightColorClass(index)}`"
                      >
                        <div :class="item.landing ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                        </div>
                      </td>
                      <td
                              v-if="exactDateSelected"
                              :class="`${getDarkColorClass(index)}`"
                      >
                        <div :class="item.accident ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                        </div>
                      </td>
                      <td
                              v-if="exactDateSelected"
                              :class="`${getLightColorClass(index)}`"
                      >
                        <div :class="item.restrictions ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                        </div>
                      </td>
                      <td
                              v-if="exactDateSelected"
                              :class="`${getDarkColorClass(index)}`"
                      >
                        <div :class="item.otheraccidents ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                        </div>
                      </td>
                    </tr>
                    <tr v-if="isMultipleDzoCompaniesSelected">
                      <td :class="index % 2 === 0 ? 'tdStyle3-total' : 'tdNone'">
                        <div class="">{{ dzoCompaniesAssets['assetTitle'] }}</div>
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
                        :class="index % 2 === 0 ? 'tdStyle3-total' : 'tdStyle3-total'"
                      >
                        <div class="font">
                          {{dzoCompaniesSummary.periodPlan}}
                        </div>
                      </td>

                      <td :class="`${getLighterClass(index)}`">
                        <div class="font">
                          {{dzoCompaniesSummary.plan}}
                          <div class="right">
                            {{ thousand }} {{ metricName }}
                          </div>
                        </div>
                      </td>

                      <td :class="`${getDarkerClass(index)}`">
                        <div class="font">
                          {{dzoCompaniesSummary.fact}}
                          <div class="right">
                            {{ thousand }} {{ metricName }}
                          </div>
                        </div>
                      </td>
                      <td :class="`${getLighterClass(index)}`">
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
                          <div class="right">
                            {{ thousand }}{{ metricName }}
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
                        v-if="!isMultipleDzoCompaniesSelected && buttonDailyTab"
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
                class="pl-3 col-sm-5"
                v-if="
                  ((planFieldName != 'oil_plan' &&
                    planFieldName != 'oil_dlv_plan' &&
                    planFieldName != 'oil_opek_plan') ||
                  oneDate != 1) && !buttonDailyTab
                "
              >
                <div class="name-chart-left">
                  {{ chartSecondaryName }}, {{ thousand }} {{ metricName }}
                </div>
                <div class="name-chart-head">{{ chartHeadName }}</div>
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
                <div class="col-3 pr-2">
                  <div
                          :class="[`${buttonDailyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(1)"
                  >
                    <!-- Суточная -->{{ trans("visualcenter.daily") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${buttonMonthlyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(2)"
                  >
                    <!-- С начала месяца -->{{ trans("visualcenter.monthBegin") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${buttonYearlyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(3)"
                  >
                    <!-- С начала года -->{{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div class="dropdown3">
                    <div
                            :class="[`${buttonPeriodTab}`,'button2 side-tables__main-menu-button']"
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
                              :class="wellStockIdleButtons.isInjectionIdleButtonActive ? 'button2 button-tab-highlighted' : 'button2'"
                              @click="calculateInjectionWellsData()"
                      >
                        {{ trans("visualcenter.in_idle") }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="row container-fluid">
                <div class="vis-table px-3 col-sm-7">
                  <table v-if="injectionWells.length" class="table4 w-100 chemistry-table">
                    <thead>
                    <tr>
                      <th>{{ trans("visualcenter.idle_wells") }}</th>
                      <th>
                        {{ trans("visualcenter.otmMetricSystemWells") }}
                      </th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in injectionWells"
                        @click="innerWellsSelectedRow = item.code"
                      >
                        <td
                          @click="innerWellsSelectedRow = item.code"
                          class="width-40 cursor-pointer"
                          :class="{
                            tdStyle: index % 2 === 0,
                            selected: innerWellsSelectedRow === item.code,
                          }"
                        >
                        <span>
                          {{ item.name }}
                        </span>
                        </td>
                        <td
                          @click="innerWellsSelectedRow = item.code"
                          class="w-25 tdNumber cursor-pointer"
                          :class="index % 2 === 0 ? 'tdStyle' : ''"
                        >
                          <div class="font">
                            {{ getFormattedNumber(item.value) }}
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-5">
                  <div  class="name-chart-left">{{ trans("visualcenter.wellsNumber") }}</div>
                  <visual-center3-wells
                    v-if="innerWellsNagDataForChart"
                    :chartData="innerWellsNagDataForChart"
                  ></visual-center3-wells>
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
                <div class="col-3 pr-2">
                  <div
                          :class="[`${buttonDailyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(1)"
                  >
                    <!-- Суточная -->{{ trans("visualcenter.daily") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${buttonMonthlyTab}`,'button2 side-tables__main-menu-button']"
                    @click="changeMenu2(2)"
                  >
                    <!-- С начала месяца -->{{ trans("visualcenter.monthBegin") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${buttonYearlyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(3)"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div class="dropdown3">
                    <div
                            :class="[`${buttonPeriodTab}`,'button2 side-tables__main-menu-button']"
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
                              :class="wellStockIdleButtons.isProductionIdleButtonActive ? 'button2 button-tab-highlighted' : 'button2'"
                              @click="calculateProductionWellsData()"
                      >
                        {{ trans("visualcenter.in_idle") }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="row container-fluid">
                <div class="vis-table px-3 col-sm-7">
                  <table v-if="productionWells.length" class="table4 w-100 chemistry-table">
                    <thead>
                    <tr>
                      <th>{{ trans("visualcenter.prod_wells") }}</th>
                      <th>{{ trans("visualcenter.otmMetricSystemWells") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in productionWells"
                        @click="innerWells2SelectedRow = item.code"
                      >
                        <td
                          @click="innerWells2SelectedRow = item.code"
                          class="width-40 cursor-pointer"
                          :class="{
                            tdStyle: index % 2 === 0,
                            selected: innerWells2SelectedRow === item.code,
                          }"
                        >
                        <span>
                          {{ item.name }}
                        </span>
                        </td>
                        <td
                          @click="innerWells2SelectedRow = item.code"
                          class="w-25 text-center cursor-pointer"
                          :class="
                            index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                          "
                        >
                        <div class="font">
                          {{ getFormattedNumber(item.value) }}
                        </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-5">
                  <div  class="name-chart-left">{{ trans('visualcenter.wellsNumber') }}</div>
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
                <div class="col-4 pr-2">
                  <div
                          :class="[`${buttonDailyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(1)"
                  >
                    {{ trans("visualcenter.daily") }}
                  </div>
                </div>
                <div class="col-4 px-2 ">
                  <div
                    :class="[`${buttonMonthlyTab}`,'button2 side-tables__main-menu-button']"
                    @click="changeMenu2(2)"
                  >
                    {{ trans("visualcenter.monthBegin") }}
                  </div>
                </div>
                <div class="col-4 px-2">
                  <div
                          :class="[`${buttonYearlyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(3)"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col-4 px-2">
                  <div class="dropdown3">
                    <div
                            :class="[`${buttonPeriodTab}`,'button2 side-tables__main-menu-button']"
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
                    class="table4 w-100 chemistry-table"
                  >
                    <thead>
                    <tr>
                      <th>{{ trans("visualcenter.otmColumnTitle") }}</th>
                      <th>{{ trans("visualcenter.Plan") }}</th>
                      <th>{{ trans("visualcenter.Fact") }}</th>
                      <th>{{ trans("visualcenter.dzoDifference") }}</th>
                    </tr>
                    </thead>

                    <tbody>
                      <tr
                        v-for="(item, index) in otmData"
                        @click="otmSelectedRow = item.code"
                      >
                        <td
                          @click="otmSelectedRow = item.code"
                          class="width-40 cursor-pointer"
                          :class="{
                            tdStyle: index % 2 === 0,
                            selected: otmSelectedRow === item.code,
                          }"
                        >
                        <span>
                          {{ item.name }}
                        </span>
                        </td>
                        <td
                          @click="otmSelectedRow = item.code"
                          class="width-20 text-center data-pointer"
                          :class="`${getDzoColumnsClass(index,'plan')}`"
                        >
                          <div class="font">
                            {{ getFormattedNumber(item.plan) }}
                            <span class="data-metrics">
                              {{item.metricSystem}}
                            </span>
                          </div>
                        </td>
                        <td
                          @click="otmSelectedRow = item.code"
                          class="width-20 text-center data-pointer"
                          :class="`${getDzoColumnsClass(index,'fact')}`"
                        >
                          <div class="font">
                            {{getFormattedNumber(item.fact) }}
                            <span class="data-metrics">
                              {{item.metricSystem}}
                            </span>
                          </div>
                        </td>
                        <td
                          class="width-20 text-center data-pointer"
                          :class="`${getDzoColumnsClass(index,'difference')}`"
                        >
                          <div class="font dynamic">
                            {{formatDigitToThousand(item.difference)}}
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
                  <div  class="name-chart-left">{{ trans("visualcenter.wellsNumber") }}</div>
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
                          :class="[`${buttonMonthlyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(2)"
                  >
                    {{ trans("visualcenter.monthBegin") }}
                  </div>
                </div>
                <div class="col px-2">
                  <div
                          :class="[`${buttonYearlyTab}`,'button2 side-tables__main-menu-button']"
                          @click="changeMenu2(3)"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col px-2">
                  <div class="dropdown3">
                    <div
                            :class="[`${buttonPeriodTab}`,'button2 side-tables__main-menu-button']"
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
                    class="table4 w-100 chemistry-table"
                  >
                    <thead>
                    <tr>
                      <th>{{ trans("visualcenter.productionChemicalization") }}</th>
                      <th>
                        {{ trans("visualcenter.Plan") }}<br>
                        {{ trans("visualcenter.chemistryMetricTon") }}
                      </th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in chemistryData"
                        @click="chemistrySelectedRow = item.code"
                      >
                        <td
                          @click="chemistrySelectedRow = item.code"
                          class="width-40 cursor-pointer"
                          :class="{
                            tdStyle: index % 2 === 0,
                            selected: chemistrySelectedRow === item.code,
                          }"
                        >
                          <span>
                            {{ item.name }}
                          </span>
                        </td>
                        <td
                          @click="chemistrySelectedRow = item.code"
                          class="width-20 text-center"
                          :class="
                            index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'
                          "
                        >
                          <div v-if="index === 0" class="center">
                          </div>
                          <div class="font">
                            {{ getFormattedNumber(item.fact) }}
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
      <div class="right-side2 col-12 col-lg-2 middle-block-columns">
        <div class="col-md-12 second-column-container">
          <div class="first-string">
            <div>
              <table class="table table1-2">
                <tr class="cursor-pointer d-flex">
                  <td
                    class="col-6"
                    @click="changeTable('4')"
                    :style="`${tableHover4}`"
                  >
                    <div class="txt4">
                      {{ getFormattedNumber(prod_wells_work) }}
                    </div>
                    <div class="in-work">
                      {{ trans("visualcenter.in_work") }}
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
                    class="col-6"
                    @click="changeTable('4')"
                    :style="`${tableHover4}`"
                  >
                    <div class="txt4 d-flex">
                      <div class="col-10 col-lg-9">
                        {{ getFormattedNumber(prod_wells_idle) }}
                      </div>
                      <div class="mt-1 col-2">
                        <img src="/img/icons/link.svg" />
                      </div>
                    </div>
                    <div class="in-idle">
                      {{ trans("visualcenter.in_idle") }}
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
                <tr class="cursor-pointer d-flex">
                  <td
                    class="col-12"
                    @click="changeTable('4')"
                    :style="`${tableHover4}`"
                  >
                    <div class="txt2">
                      {{ trans("visualcenter.prod_wells") }}
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="first-string first-string2">
              <div>
                <table class="table table1-2">
                  <tr class="cursor-pointer d-flex">
                    <td
                      class="col-6"
                      @click="changeTable('5')"
                      :style="`${tableHover5}`"
                    >
                      <div class="txt4">
                        {{getFormattedNumber(inj_wells_work)}}
                      </div>
                      <div class="in-work">
                        {{ trans("visualcenter.in_work") }}
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
                      class="col-6"
                      @click="changeTable('5')"
                      :style="`${tableHover5}`"
                    >
                      <div class="txt4 d-flex">
                        <div class="col-10 col-lg-9">
                          {{getFormattedNumber(inj_wells_idle)}}
                        </div>
                        <div class="mt-1 col-2">
                          <img src="/img/icons/link.svg" />
                        </div>
                      </div>
                      <div class="in-idle">
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
                  <tr class="cursor-pointer d-flex">
                    <td
                      class="col-12"
                      @click="changeTable('5')"
                      :style="`${tableHover5}`"
                    >
                      <div class="txt2">
                        {{ trans("visualcenter.idle_wells") }}
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="first-string first-string2">
              <div>
                <table class="table table5">
                  <tr class="cursor-pointer d-flex">
                    <td
                      class="col-6"
                      @click="changeTable('6')"
                      :style="`${tableHover6}`"
                    >
                      <div class="mt-1 float-right">
                        <img data-v-3712f8d4="" src="/img/icons/link.svg" />
                      </div>
                      <div class="otm"></div>
                      <div class="txt2">
                        {{ trans("visualcenter.otm") }}
                      </div>
                    </td>

                    <td
                      class="col-6"
                      @click="changeTable('7')"
                      :style="`${tableHover7}`"
                    >
                      <div class="mt-1 float-right">
                        <img data-v-3712f8d4="" src="/img/icons/link.svg" />
                      </div>
                      <div class="him"></div>
                      <div class="txt2">
                        {{ trans("visualcenter.chem") }}
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
                <tr class="d-flex">
                  <td class="col-6">
                    <div class="number">{{ staff }}</div>
                    <div class="in-idle2">
                      {{ quarter1[0] }}
                      {{ trans("visualcenter.quarter") }}
                      {{ quarter1[1] }} г.
                    </div>
                  </td>

                  <td class="col-6">
                    <div class="d-flex">
                      <div class="col-12">
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
                    <div>
                      <div class="in-idle">
                        {{ getDiffProcentLastP(staffPercent, staff, "1") }}
                      </div>
                      <div class="in-idle">
                        vs {{ quarter2[0] }}
                        {{ trans("visualcenter.quarter") }}
                        {{ quarter2[1] }}г.
                      </div>
                    </div>
                  </td>
                </tr>
                <tr class="d-flex">
                  <td class="col-12">
                    <div class="txt2">
                      {{trans("visualcenter.personal")}}
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="first-string first-string2">
            <div>
              <table class="table">
                <tr class="d-flex">
                  <td class="col-6 px-2">
                    <div class="number">{{ covid }}</div>
                    <div class="in-idle2">{{ timeSelect }}</div>
                  </td>

                  <td class="col-6">
                    <div class="d-flex">
                      <div
                        :class="`${getColor2(
                          getDiffProcentLastP(covidPercent, covid)
                        )}`"
                      ></div>
                      <div class="txt2-2">
                        {{ Math.abs(getDiffProcentLastP(covidPercent, covid)) }}%
                      </div>
                    </div>
                    <div>
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
                  <td class="col-12">
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
                  <td class="d-flex">
                    <div class="number col-6">{{ accidentTotal }}</div>
                    <div class="col-6">
                      <div>
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
                  <td class="d-flex">
                    <div class="txt2 col-12">
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
                <td class="d-flex">
                  <div class="number col-6">0</div>
                  <div class="col-6">
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
    </div>
  </div>
</template>

<script src="./VisualCenterTable3.js"></script>
<style scoped lang="scss">
  .dzocompanies-dropdown__divider {
    border-bottom: 2px solid #656A8A;
  }
  .middle-block__list-x-scroll {
    overflow-x: inherit;
  }
  .rates-block {
    border-left: 10px solid #0f1430;
  }
  .oil-block {
    align-items: baseline;
  }
  .additional-header {
    margin-left: -15px;
  }

  .visualcenter-page-container {
    flex-wrap: wrap;
    margin: 0 !important;
  }
  .visualcenter-page-wrapper {
    position: relative;
  }
  .second-column-container {
    padding-left: 10px;
    padding-right: 0;
  }
  .middle-block-columns {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
.vis-table {
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
    min-width: 683px;
    tr {
      td {
        padding: 5px 5px 5px 10px;
        position: relative;
        vertical-align: middle;
        min-width: 71px;
        &:first-child {
          white-space: normal;
          min-width: 290px;
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
          justify-content: space-between;
          font-size: 13px;
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

.width-40 {
    width: 40%;
  }
  .width-20 {
    width: 20%;
  }
  .data-titles {
    font-family: "HarmoniaSansProCyr-Regular";
    font-style: normal;
    font-weight: bold;
    font-size: 15px;
    height: 50px;
  }

  .data-metrics {
    font-family: "Harmonia-sans, sans-serif";
    font-style: normal;
    font-size: 10px;
    margin-left: 2%;
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
  .main-menu-button-highlighted {
    color: #fff;
    background: #237deb;
    font-weight:bold;
  }

  .dzo-company-list ul {
    margin: 10px 0 0 0;
    height: 450px;
    position: absolute;
    left: -0.5px;
    background: #40467E;
    top: 3em;
    padding: 5px;
    list-style: none;
    z-index: 999;
    cursor: pointer;
    color:white;
    border-radius: inherit;
    overflow: auto;
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
  .mh-30 {
    min-height: 30%;
  }
  .chemistry-table {
    height: calc(100% - 20px);
  }
  .cursor-pointer {
    cursor: pointer;
  }
  .main-table__scroll {
    flex: unset;
    max-height: 80%;
    max-width: 100%;
    overflow: auto;
  }
  @media (max-width:400px) {
    .upper-block {
      max-width: 380px;
    }
    .rates-block {
      border-left: 0;
      border-top: 10px solid #0f1430 !important;
      &:last-child {
        border-left: 10px solid #0f1430 !important;
      }
    }
    .middle-block__list-x-scroll {
      flex-wrap: unset;
      overflow-x: scroll;
    }
    .second-column-container {
      padding-left: 10px;
      padding-right: 10px;
      border-top: 10px solid #0f1430;
    }
    .table4 {
      min-width: 0 !important;
      font-size: 10px !important;
      th {
        font-size: inherit !important;
        width: 5% !important;
      }
      tr td {
        width: 100%;
        min-width: 62px !important;
        font-size: inherit !important;
        .font {
          font-size: inherit !important;
        }
      }

    }
    .middle-block-columns {
      border-top: 10px solid #0f1430;
    }
    .side-tables__main-menu-button {
      line-height: 20px;
    }
    .middle-block__table {
      margin-left: 10px;
      margin-right: 10px;
    }
    .first-string {
      position: relative;
    }
    .dropdown {
      position: static;
    }
    .dzocompanylist__button {
      position: static;
    }
  }
  .rates-block__row {
    height: 200px;
  }
  @media (max-width:1400px) {
    .rates-block__row {
      height: auto;
    }
    .dzo-company-list li {
      font-size: 12px;
    }
    .vis-table .table4 {
      min-width: 0;
    }
  }
  @media (max-width:2000px) {
    .table4 {
      tr td {
        min-width: 5.3em !important;
      }
    }
  }
</style>
