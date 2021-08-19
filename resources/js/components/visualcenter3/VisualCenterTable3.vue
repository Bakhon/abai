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
                          <div class="row oil-block col-6 col-md-12">
                            <div class="number">
                              {{ formatDigitToThousand(productionSummary.oilCondensateProductionButton.actual.oilFact) }}
                            </div>
                            <div
                                    v-if="!buttonDailyTab && !isOneDateSelected"
                                    class="unit-vc ml-2"
                            >
                              {{ trans("visualcenter.thousand") }}{{ trans('visualcenter.tonWithSpace') }}
                            </div>
                            <div
                                    v-else
                                    class="unit-vc ml-2"
                            >
                              {{ trans('visualcenter.tonWithSpace') }}
                            </div>
                          </div>
                          <div class="additional-header txt1 col-6 col-md-12">
                            {{ trans("visualcenter.oilCondensateProduction") }}
                          </div>
                          <br />
                          <div class="progress">
                            <br />
                            <div
                                    class="progress-bar"
                                    role="progressbar"
                                    :style="{width: productionSummary.oilCondensateProductionButton.actual.progress + '%',}"
                                    :aria-valuenow="productionSummary.oilCondensateProductionButton.actual.oilFact"
                                    aria-valuemin="0"
                                    :aria-valuemax="productionSummary.oilCondensateProductionButton.actual.oilPlan"
                            ></div>
                          </div>
                          <div class="row">
                            <div
                                    class="percent-header col-5 col-md-6"
                                    v-if="productionSummary.oilCondensateProductionButton.actual.oilFact"
                            >
                              {{ getDiffProcentLastBigN(
                                productionSummary.oilCondensateProductionButton.actual.oilFact,
                                productionSummary.oilCondensateProductionButton.actual.oilPlan)
                              }}%
                            </div>
                            <div class="plan-header col-6" v-if="productionSummary.oilCondensateProductionButton.actual.oilPlan">
                              {{ formatDigitToThousand(productionSummary.oilCondensateProductionButton.actual.oilPlan) }}
                            </div>
                            <br />
                          </div>
                          <div class="col-12 mt-4">
                            <div
                                    :class="`${getGrowthIndicatorByDifference(
                                              productionSummary.oilCondensateProductionButton.actual.oilFact,
                                              productionSummary.oilCondensateProductionButton.yesterday.oilFact)
                                            }`"
                            ></div>

                            <div class="txt2-2">
                              {{ Math.abs(getDifferencePercentBetweenLastValues(
                                productionSummary.oilCondensateProductionButton.yesterday.oilFact,
                                productionSummary.oilCondensateProductionButton.actual.oilFact))
                              }}%
                            </div>
                            <div class="txt3">
                              vs
                              <span v-if="isOneDateSelected"> {{ previousPeriodEnd }}</span>
                              <span v-else> {{ previousPeriodStart }} - {{ previousPeriodEnd }}</span>
                            </div>
                          </div>
                        </div>
                        <div>
                          <div class="vert-line"></div>
                        </div>
                      </td>
                      <td class="col-4 col-lg-4 d-flex">
                        <div class="first-td-header">
                          <div class="row oil-block col-6 col-md-12">
                            <div class="number">
                              {{ formatDigitToThousand(productionSummary.oilCondensateDeliveryButton.actual.oilFact) }}
                            </div>
                            <div
                                    v-if="!buttonDailyTab && !isOneDateSelected"
                                    class="unit-vc ml-2"
                            >
                              {{ trans("visualcenter.thousand") }}{{ trans('visualcenter.tonWithSpace') }}
                            </div>
                            <div
                                    v-else
                                    class="unit-vc ml-2"
                            >
                              {{ trans('visualcenter.tonWithSpace') }}
                            </div>
                          </div>
                          <div class="additional-header txt1 col-6 col-md-12">
                            {{ trans("visualcenter.oilCondensateDelivery") }}
                          </div>
                          <br />
                          <div class="progress">
                            <br />
                            <div
                                    class="progress-bar"
                                    role="progressbar"
                                    :style="{width: productionSummary.oilCondensateDeliveryButton.actual.progress + '%'}"
                                    :aria-valuenow="productionSummary.oilCondensateDeliveryButton.actual.oilFact"
                                    aria-valuemin="0"
                                    :aria-valuemax="productionSummary.oilCondensateDeliveryButton.actual.oilPlan"
                            ></div>
                          </div>
                          <div class="row">
                            <div class="percent-header col-5 col-md-6" v-if="productionSummary.oilCondensateDeliveryButton.actual.oilFact">
                              {{getDiffProcentLastBigN(
                                productionSummary.oilCondensateDeliveryButton.actual.oilFact,
                                productionSummary.oilCondensateDeliveryButton.actual.oilPlan)
                              }}%
                            </div>
                            <div class="plan-header col-6" v-if="productionSummary.oilCondensateDeliveryButton.actual.oilPlan">
                              {{ formatDigitToThousand(productionSummary.oilCondensateDeliveryButton.actual.oilPlan) }}
                            </div>
                          </div>
                          <br />
                          <div class="col-12 mt-2">
                            <div
                                    :class="`${getGrowthIndicatorByDifference(
                                              productionSummary.oilCondensateDeliveryButton.actual.oilFact,
                                              productionSummary.oilCondensateDeliveryButton.yesterday.oilFact)
                                            }`"
                            ></div>

                            <div class="txt2-2">
                              {{Math.abs(getDifferencePercentBetweenLastValues(
                                productionSummary.oilCondensateDeliveryButton.yesterday.oilFact,
                                productionSummary.oilCondensateDeliveryButton.actual.oilFact))
                              }}%
                            </div>
                            <div class="txt3">
                              vs
                              <span v-if="isOneDateSelected"> {{ previousPeriodEnd }}</span>
                              <span v-else> {{ previousPeriodStart }} - {{ previousPeriodEnd }}</span>
                            </div>
                          </div>
                        </div>
                        <div>
                          <div class="vert-line"></div>
                        </div>
                      </td>
                      <td class="col-4 col-sm-4 d-flex">
                        <div class="first-td-header">
                          <div class="row oil-block col-6 col-md-12">
                            <div class="number">
                              {{ formatDigitToThousand(productionParams.gas_fact) }}
                            </div>
                            <div
                                    v-if="!buttonDailyTab && !isOneDateSelected"
                                    class="unit-vc ml-2"
                            >
                              {{ trans("visualcenter.thousand") }}{{ trans('visualcenter.meterCubic') }}
                            </div>
                            <div
                                    v-else
                                    class="unit-vc ml-2"
                            >
                              {{ trans('visualcenter.meterCubic') }}
                            </div>
                          </div>
                          <div class="additional-header txt1 col-6 col-md-12">
                            {{ trans("visualcenter.getgaz") }} ({{trans("visualcenter.gasOperatingAssets")}})
                          </div>
                          <br />
                          <div class="progress">
                            <br />

                            <div
                                    class="progress-bar"
                                    role="progressbar"
                                    :style="{
                                width: dailyProgressBars.gas + '%',
                              }"
                                    :aria-valuenow="productionParams.gas_fact"
                                    aria-valuemin="0"
                                    :aria-valuemax="productionParams.gas_plan"
                            ></div>
                          </div>
                          <div class="row">
                            <div class="percent-header col-5 col-md-6" v-if="productionParams.gas_fact">
                              {{ getDiffProcentLastBigN(productionParams.gas_fact, productionParams.gas_plan) }}%
                            </div>
                            <div class="plan-header col-6" v-if="productionParams.gas_plan">
                              {{ formatDigitToThousand(productionParams.gas_plan) }}
                            </div>
                          </div>
                          <br />
                          <div class="col-12 mt-2">
                            <div
                                    :class="`${getGrowthIndicatorByDifference(productionParams.gas_fact, productionPercentParams.gas_fact)}`"
                            ></div>

                            <div class="txt2-2">
                              {{
                              Math.abs(
                              getDifferencePercentBetweenLastValues(productionPercentParams.gas_fact, productionParams.gas_fact)
                              )
                              }}%
                            </div>
                            <div class="txt3">
                              vs
                              <span v-if="isOneDateSelected"> {{ previousPeriodEnd }}</span>
                              <span v-else> {{ previousPeriodStart }} - {{ previousPeriodEnd }}</span>
                            </div>
                          </div>
                        </div>
                        <div></div>
                      </td>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="row rates-block__row">
                      <td
                              class="vc-select-table col-6 col-lg-6 rates-block"
                              @click="changeTable('oilRate')"
                              :class="`${tableMapping.oilRate.hover}`"
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
                          <div class="metric-title col-12">$ / bbl</div>
                        </div>
                        <div class="txt1 col-12">
                          {{trans("visualcenter.oilPrice")}}
                        </div>
                        <br />
                        <div class="percent-currency col-12 p-0">
                          <div
                                  class="indicator-grow"
                                  v-if="dailyOilPriceChange === 'UP'"
                          ></div>
                          <div
                                  class="indicator-fall"
                                  v-if="dailyOilPriceChange === 'DOWN'"
                          ></div>
                          <div class="txt2-2">
                            {{Math.abs(getDifferencePercentBetweenLastValues(prices['oil']['previous'], prices['oil']['current']))}}
                            {{trans("visualcenter.dzoPercent")}}
                          </div>
                          <div class="txt3">
                            {{ trans("visualcenter.vsSeparator") }}
                            {{ new Date(prices['oil']['previousFetchDate']).toLocaleDateString() }}
                          </div>
                        </div>
                      </td>
                      <td
                              class="vc-select-table col-6 col-lg-6 rates-block"
                              @click="changeTable('usdRate')"
                              :class="`${tableMapping.usdRate.hover}`"
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
                          <div class="metric-title col-12">kzt / $</div>
                        </div>
                        <div class="txt1 col-12">
                          {{ trans("visualcenter.usdKurs") }}
                        </div>
                        <br />
                        <div class="percent-currency col-12 mt-20">
                          <div
                                  class="indicator-grow"
                                  v-if="dailyCurrencyChangeIndexUsd === 'UP'"
                          ></div>
                          <div
                                  class="indicator-fall"
                                  v-if="dailyCurrencyChangeIndexUsd === 'DOWN'"
                          ></div>
                          <div class="txt2-2">
                            {{ Math.abs(getDifferencePercentBetweenLastValues(prices['usd']['previous'], prices['usd']['current'])) }}
                            {{trans("visualcenter.dzoPercent")}}
                          </div>
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
        <div :class="[`${tableMapping.productionDetails.class}`, 'first-table big-area']">
          <div class="first-string first-string2">
            <div class="row px-4 mt-3 middle-block__list-x-scroll">
              <div class="col-12 col-lg dropdown dropdown4 font-weight px-1">
                <div class="button1 d-flex">
                  <div :class="[`${oilCondensateProductionButton}`, 'col-10 category-button_border']">
                    <div class="icon-all icons1"></div>
                    <div
                            class="txt5"
                            @click="switchCategory(
                                    'oilCondensateProductionButton',
                                    'oil_plan',
                                    'oil_fact',
                                    trans('visualcenter.tonWithSpace'),
                                    trans('visualcenter.oilCondensateProduction'))"
                    >
                      {{ trans("visualcenter.oilCondensateProduction") }}
                    </div>
                  </div>
                  <button
                          type="button"
                          class="btn btn-primary dropdown-toggle position-button-vc col-2 m-0"
                          data-toggle="dropdown"
                          @click="switchDropdownCategories('oilCondensateProduction')"
                          :class="{ 'button-tab-highlighted': dropdownMenu.oilCondensateProduction }"
                  ></button>
                  <div>
                    <ul
                            class="dropdown-menu dropdown-menu-right dropdown-position mt-1"
                    >
                      <li
                              class="center-li row px-4"
                              @click="switchFilterConsolidatedOilCondensate('oilCondensateProductionButton','withoutKmgParticipation','isWithoutKMGFilterActive')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('oilCondensateProductionButton','withoutKmgParticipation')}`"
                        ></div>
                        <a class="col-9 p-0 ml-3 mt-2">
                          {{trans("visualcenter.withoutKmgParticipation")}}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchFilterConsolidatedOilCondensate('oilCondensateProductionButton','condensateOnly','isCondensateOnly')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('oilCondensateProductionButton','condensateOnly')}`"
                        ></div>
                        <a class="col-9 mt-1 p-0 ml-3">
                          {{trans("visualcenter.getgk")}}
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg dropdown dropdown4 font-weight px-1">
                <div class="button1 d-flex">
                  <div :class="[`${oilCondensateDeliveryButton}`, 'col-10 category-button_border']">
                      <div class="icon-all icons2"></div>
                      <div
                              class="txt5"
                              @click="switchCategory(
                                      'oilCondensateDeliveryButton',
                                      'oil_dlv_plan',
                                      'oil_dlv_fact',
                                      trans('visualcenter.tonWithSpace'),
                                      trans('visualcenter.oilCondensateDelivery'))"
                      >
                        {{ trans("visualcenter.oilCondensateDelivery") }}
                      </div>
                  </div>
                  <button
                          type="button"
                          class="btn btn-primary dropdown-toggle position-button-vc col-2 m-0"
                          data-toggle="dropdown"
                          @click="switchDropdownCategories('oilCondensateDelivery')"
                          :class="{ 'button-tab-highlighted': dropdownMenu.oilCondensateDelivery }"
                  ></button>
                  <div>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-position mt-1">
                      <li
                              class="center-li row px-4"
                              @click="switchFilterConsolidatedOilCondensate('oilCondensateDeliveryButton','withoutKmgParticipation','isWithoutKMGFilterActive')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('oilCondensateDeliveryButton','withoutKmgParticipation')}`"
                        ></div>
                        <a class="col-9 p-0 ml-3 mt-2">
                          {{trans("visualcenter.withoutKmgParticipation")}}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('oilCondensateDeliveryButton','oilResidue')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('oilCondensateDeliveryButton','oilResidue')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
                                @click="
                                    updateProductionData(
                                      'tovarnyi_ostatok_nefti_prev_day',
                                      'tovarnyi_ostatok_nefti_today',
                                      `${oilChartHeadName}`,
                                      ' тонн',
                                      trans('visualcenter.ostatokNefti')
                                    )"
                        >
                          {{trans("visualcenter.ostatokNefti")}}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchFilterConsolidatedOilCondensate('oilCondensateDeliveryButton','condensateOnly','isCondensateOnly')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('oilCondensateDeliveryButton','condensateOnly')}`"
                        ></div>
                        <a class="col-9 mt-1 p-0 ml-3">
                          {{trans("visualcenter.getgk")}}
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg dropdown dropdown4 font-weight px-1">
                <div class="button1 d-flex">
                  <div
                          :class="[`${gasProductionButton}`, 'col-10 category-button_border']"
                  >
                    <div
                            @click="switchCategory(
                              'gasProductionButton',
                              'gas_plan',
                              'gas_fact',
                              trans('visualcenter.meterCubicWithSpace'),
                              trans('visualcenter.getgaz'),
                              'gasProductionButton')"
                    >
                      <div class="icon-all icons3"></div>
                      <div class="txt5">
                        <!-- Добыча газа -->{{ trans("visualcenter.getgaz") }}
                      </div>
                    </div>
                  </div>
                  <button
                          type="button"
                          class="btn btn-primary dropdown-toggle position-button-vc col-2 m-0"
                          data-toggle="dropdown"
                          @click="switchDropdownCategories('gasProduction')"
                          :class="{ 'button-tab-highlighted': dropdownMenu.gasProduction }"
                  ></button>
                  <div>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-position mt-1">
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('gasProductionButton','productionNaturalGas')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('gasProductionButton','productionNaturalGas')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
                                @click="
                                  updateProductionData(
                                    'plan_prirod_gas',
                                    'natural_gas_production_fact',
                                    trans('visualcenter.productionNaturalGasChartName'),
                                    ' м³',
                                    trans('visualcenter.productionNaturalGas')
                                  )
                                "
                        >
                          {{ trans("visualcenter.productionNaturalGas") }}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('gasProductionButton','productionAssociatedGas')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('gasProductionButton','productionAssociatedGas')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
                                @click="
                                  updateProductionData(
                                    'plan_poput_gas',
                                    'associated_gas_production_fact',
                                    trans('visualcenter.productionAssociatedGasChartName'),
                                    ' м³',
                                    trans('visualcenter.productionAssociatedGas')
                                  )
                                "
                        >
                          {{ trans("visualcenter.productionAssociatedGas") }}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('gasProductionButton','flaringAssociatedGas')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('gasProductionButton','flaringAssociatedGas')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
                                @click="
                                  updateProductionData(
                                    'plan_poput_gas_burn',
                                    'associated_gas_flaring_fact',
                                    trans('visualcenter.flaringAssociatedGasChartName'),
                                    ' м³',
                                    trans('visualcenter.flaringAssociatedGas')
                                  )
                                "
                        >
                          {{ trans("visualcenter.flaringAssociatedGas") }}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('gasProductionButton','deliveryNaturalGas')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('gasProductionButton','deliveryNaturalGas')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
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
                          {{trans("visualcenter.prirodGazdlv")}}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('gasProductionButton','gasConsumptionForNeeds')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('gasProductionButton','gasConsumptionForNeeds')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
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
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('gasProductionButton','deliveryAssociatedGas')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('gasProductionButton','deliveryAssociatedGas')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
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
                          {{trans("visualcenter.poputGazdlv")}}
                        </a>
                      </li>
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('gasProductionButton','associatedGasConsumptionForNeeds')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('gasProductionButton','associatedGasConsumptionForNeeds')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
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
                          {{ trans("visualcenter.raskhodpoputGaz") }}
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg dropdown dropdown4 font-weight px-1">
                <div class="button1 d-flex">
                  <div
                          :class="[`${waterInjectionButton}`, 'col-10 category-button_border']"
                  >
                    <div
                            class="button1-vc-inner"
                            @click="switchCategory(
                              'waterInjectionButton',
                              'liq_plan',
                              'liq_fact',
                              trans('visualcenter.meterCubicWithSpace'),
                              trans('visualcenter.liq'))"
                    >
                      <div class="icon-all icons5"></div>
                      <div class="txt5">
                        <!-- Закачка воды -->{{ trans("visualcenter.liq") }}
                      </div>
                    </div>
                  </div>
                  <button
                          type="button"
                          class="btn btn-primary dropdown-toggle position-button-vc col-2 m-0"
                          data-toggle="dropdown"
                          @click="switchDropdownCategories('waterInjection')"
                          :class="{ 'button-tab-highlighted': dropdownMenu.waterInjection }"
                  ></button>
                  <div>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-position mt-1">
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('waterInjectionButton','seaWaterInjection')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('waterInjectionButton','seaWaterInjection')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
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
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('waterInjectionButton','wasteWaterInjection')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('waterInjectionButton','wasteWaterInjection')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
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
                      <hr class="m-0 mt-1 mx-2 dropdown-splitter" />
                      <li
                              class="center-li row px-4"
                              @click="switchMainMenu('waterInjectionButton','albsenWaterInjection')"
                      >
                        <div
                                class="col-1 mt-2"
                                v-html="`${getMainMenuButtonFlag('waterInjectionButton','albsenWaterInjection')}`"
                        ></div>
                        <a
                                class="col-9 p-0 ml-3 mt-2"
                                @click="
                            updateProductionData(
                              'ppd_zakachka_albsen_vody_plan',
                              'ppd_zakachka_albsen_vody_fact',
                              trans('visualcenter.dynamicArtesianWater'),
                              ' м³',
                              trans('visualcenter.injectionArtesianWater')
                            )
                          "
                        >
                          {{trans("visualcenter.injectionArtesianWater")}}
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row px-4 mt-3 middle-block__list-x-scroll">
              <div class="col-8 col-lg dropdown px-1">
                <div  class="button2 no-hover dzocompanylist__button" v-if="isOneDzoSelected">                  
                    {{ trans("visualcenter.dzoAllCompany") }}
                  </div>    
                <div class="button2 dzocompanylist__button" v-else>                               
                  <div class="button2 dzocompanylist__button" >                  
                    {{ trans("visualcenter.dzoAllCompany") }}
                    <button
                            type="button"
                            class="btn btn-primary dropdown-toggle position-button-vc dzocompanies__button_position"
                            data-toggle="dropdown"
                    ></button>
                    <div class="dzo-company-list">
                      <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right dzo-dropdown">
                        <li class="px-4">
                          <div>
                            <input
                                    :disabled="dzoCompaniesAssets['isAllAssets']"
                                    :checked="dzoCompaniesAssets['isAllAssets']"
                                    type="checkbox"
                                    @click="`${selectAllDzoCompanies()}`"
                            ></input>
                            {{trans("visualcenter.dzoAllCompany")}}
                            <div class="dzocompanies-dropdown__divider"></div>
                          </div>
                        </li>
                        <li class="px-4">
                          <div>
                            <input
                                    type="checkbox"
                                    :disabled="dzoCompaniesAssets['isOperating']"
                                    :checked="dzoCompaniesAssets['isOperating']"
                                    @click="`${changeAssets('isOperating','type')}`"
                            ></input>
                            {{trans("visualcenter.isOperating")}}
                          </div>
                        </li>
                        <li class="px-4">
                          <div>
                            <input
                                    type="checkbox"
                                    :disabled="dzoCompaniesAssets['isNonOperating']"
                                    :checked="dzoCompaniesAssets['isNonOperating']"
                                    @click="`${changeAssets('isNonOperating','type')}`"
                            ></input>
                            {{trans("visualcenter.isNonOperating")}}
                            <div class="dzocompanies-dropdown__divider"></div>
                          </div>
                        </li>
                        <li
                                class="px-4"
                                v-for="(region,index) of Object.keys(dzoRegionsMapping)"
                        >
                          <div>
                            <input
                                    type="checkbox"
                                    :disabled="dzoRegionsMapping[region].isActive"
                                    :checked="dzoRegionsMapping[region].isActive"
                                    @click="`${changeAssets('isRegion','region',region)}`"
                            ></input>
                            {{dzoRegionsMapping[region].translationName}}
                            <div
                                    class="dzocompanies-dropdown__divider"
                                    v-if="(Object.keys(dzoRegionsMapping).length - 1) === index"
                            ></div>
                          </div>
                        </li>
                        <li
                                v-for="(company) in dzoCompanies"
                                class="px-4"
                        >
                          <div>
                            <input
                                    type="checkbox"
                                    :disabled="isGrouppingFilterActive()"
                                    :checked="company.selected"
                                    @change="`${selectOneDzoCompany(company.ticker)}`"
                            ></input>
                            {{trans(company.companyName)}}
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-8 col-lg px-1">
                <div
                        :class="[`${buttonDailyTab}`,'button2']"
                        @click="changeMenu2('daily')"
                >
                  {{ trans("visualcenter.daily") }}
                </div>
              </div>
              <div class="col-8 col-lg px-1">
                <div
                        :class="[`${buttonMonthlyTab}`,'button2']"
                        @click="changeMenu2('monthly')"
                >
                  {{ trans("visualcenter.monthBegin") }}
                </div>
              </div>
              <div class="col-8 col-lg px-1">


                <div :class="[`${buttonYearlyTab}`,'button2 d-flex']">
                  <div
                          class="button1-vc-inner"
                          @click="changeMenu2('yearly')"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                  <button
                          v-if="buttonYearlyTab && oilCondensateProductionButton"
                          type="button"
                          class="btn btn-primary dropdown-toggle position-button-vc mt-1"
                          data-toggle="dropdown"
                  ></button>
                  <div class="dzo-company-list">
                    <ul class="dropdown-menu-vc dropdown-menu dropdown-menu-right year-period-dropdown" ref="targetPlan">
                      <li :class="[`${buttonTargetPlan}`, 'px-4']">
                        <input
                                type="checkbox"
                                :disabled="!buttonYearlyTab"
                                :checked="isFilterTargetPlanActive"
                                @change="`${changeTargetCompanyFilter()}`"
                        ></input>
                        {{ trans("visualcenter.targetPlanFilter") }}
                      </li>
                    </ul>
                  </div>
                </div>


              </div>
              <div class="col-8 col-lg px-1">
                <div class="dropdown3">
                  <div
                          :class="[`${buttonPeriodTab}`,'button2']"
                          @click="changeMenu2('period')"
                  >
                    <span v-if="isOneDateSelected">
                      {{ trans("visualcenter.date") }} [{{timeSelect}}]</span
                    >
                    <span v-else>
                      {{ trans("visualcenter.period") }} [{{timeSelect}} - {{ timeSelectOld }}]</span
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

            <div class="row mh-60 mt-3 px-4">
              <div
                      class="col-sm-7 vis-table"
                      :class="isOneDateSelected ? 'main-table__scroll' : ''"
              >
                <table
                        v-if="bigTable.length"
                        :class="getProductionTableClass()"
                >
                  <thead>
                  <tr>
                    <th>№</th>
                    <th>{{ trans("visualcenter.dzo") }}</th>
                    <th v-if="buttonMonthlyTab && !isOilResidueActive" >
                      {{ trans("visualcenter.dzoMonthlyPlan") }}
                      <div v-if="currentDzoList !== 'daily'">
                        {{ getThousandMetricNameByCategorySelected() }}
                      </div>
                      <div v-if="currentDzoList === 'daily'">
                        {{ getMetricNameByCategorySelected() }}
                      </div>
                      <div v-if="isOpecFilterActive && !isConsolidatedCategoryActive()">
                        {{ trans("visualcenter.dzoOpec") }}
                      </div>
                    </th>
                    <th v-if="buttonYearlyTab && !isOilResidueActive">
                      {{ trans("visualcenter.dzoYearlyPlan") }}
                      <div v-if="currentDzoList !== 'daily'">
                        {{ getThousandMetricNameByCategorySelected() }}
                      </div>
                      <div v-if="currentDzoList === 'daily'">
                        {{ getMetricNameByCategorySelected() }}
                      </div>
                      <div v-if="isOpecFilterActive && !isConsolidatedCategoryActive()">
                        {{ trans("visualcenter.dzoOpec") }}
                      </div>
                    </th>
                    <th v-if="!isOilResidueActive">
                      {{ trans("visualcenter.plan") }},
                      <div v-if="currentDzoList !== 'daily' || quantityRange > 1">
                        {{ getThousandMetricNameByCategorySelected() }}
                      </div>
                      <div v-else>
                        {{ getMetricNameByCategorySelected() }}
                      </div>
                      <div v-if="isOpecFilterActive && !isConsolidatedCategoryActive()">
                        {{ trans("visualcenter.dzoOpec") }}
                      </div>
                    </th>
                    <th v-if="isConsolidatedCategoryActive() && !isOilResidueActive">
                      {{ trans("visualcenter.plan") }}
                      <div>
                        {{ trans("visualcenter.dzoOpec") }},
                      </div>
                      <div v-if="currentDzoList !== 'daily' || quantityRange > 1">
                        {{ getThousandMetricNameByCategorySelected() }}
                      </div>
                      <div v-else>
                        {{ getMetricNameByCategorySelected() }}
                      </div>
                    </th>
                    <th>
                      {{ trans("visualcenter.fact") }},
                      <div v-if="currentDzoList !== 'daily' || quantityRange > 1">
                        {{ getThousandMetricNameByCategorySelected() }}
                      </div>
                      <div v-else>
                        {{ getMetricNameByCategorySelected() }}
                      </div>
                    </th>
                    <th v-if="!isOilResidueActive">
                      {{ trans("visualcenter.dzoDifference") }}
                      <div v-if="currentDzoList !== 'daily' || quantityRange > 1">
                        {{ getThousandMetricNameByCategorySelected() }}
                      </div>
                      <div v-else>
                        {{ getMetricNameByCategorySelected() }}
                      </div>
                    </th>
                    <th v-if="!isFilterTargetPlanActive && !isConsolidatedCategoryActive() && !isOilResidueActive">
                      {{ trans("visualcenter.dzoPercent") }}
                    </th>
                    <th v-if="!isFilterTargetPlanActive && isConsolidatedCategoryActive() && !isOilResidueActive">
                      {{ trans("visualcenter.dzoDifference") }}
                      <div>
                        {{ trans("visualcenter.dzoOpec") }},
                      </div>
                      <div v-if="currentDzoList !== 'daily' || quantityRange > 1">
                        {{ getThousandMetricNameByCategorySelected() }}
                      </div>
                      <div v-else>
                        {{ getMetricNameByCategorySelected() }}
                      </div>
                    </th>
                    <th v-if="isFilterTargetPlanActive && !isOilResidueActive">
                      {{ trans("visualcenter.dzoTargetPlan") }}
                      <br>
                      {{ getThousandMetricNameByCategorySelected() }}
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
                    <th v-if="exactDateSelected">
                      {{ trans("visualcenter.gasRestriction") }}
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(item, index) in dzoSummaryForTable">
                    <td :class="`${getDzoColumnsClass(index,'difference')}`">
                      {{getNumberByDzo(item.dzoMonth,index)}}
                    </td>
                    <td
                            @click="isMultipleDzoCompaniesSelected ? `${switchOneCompanyView(item.dzoMonth,item.dzo)}` : `${selectAllDzoCompanies()}`"
                            :class="[index % 2 === 0 ? 'tdStyle' : '','cursor-pointer']"
                    >
                      <span v-if="!isConsolidatedCategoryActive() || isOilResidueActive">
                        {{ getNameDzoFull(item.dzoMonth) }}
                        <img src="/img/icons/link.svg" />
                      </span>
                      <span v-else-if="isConsolidatedCategoryActive() && !oilCondensateFilters.isWithoutKMGFilterActive">
                        {{ getDzoName(item.dzoMonth,dzoNameMappingWithoutKMG) }}
                        <img src="/img/icons/link.svg" />
                      </span>
                      <span v-else :class="getDzoNameFormatting(item.dzoMonth)">
                        {{ getDzoName(item.dzoMonth,dzoNameMapping) }}
                        <img src="/img/icons/link.svg" />
                      </span>
                    </td>
                    <td
                            v-if="buttonYearlyTab && !isOilResidueActive"
                            :class="`${getDzoColumnsClass(index,'monthlyPlan')}`"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.periodPlan) }}
                      </div>
                    </td>

                    <td
                            v-if="buttonMonthlyTab && !isOilResidueActive"
                            :class="`${getDzoColumnsClass(index,'yearlyPlan')}`"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.periodPlan) }}
                      </div>
                    </td>
                    <td v-if="!isOilResidueActive" :class="`${getDzoColumnsClass(index,'plan')}`">

                      <div class="font">
                        {{ formatDigitToThousand(item.planMonth) }}
                      </div>
                    </td>
                    <td
                            v-if="!isFilterTargetPlanActive && isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="currentDzoList === 'daily' ? getDzoColumnsClass(index,'companyName') : getDzoColumnsClass(index,'fact')">
                      <div class="font">
                        {{ formatDigitToThousand(item.opekPlan) }}
                      </div>
                    </td>
                    <td
                            v-if="isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="currentDzoList === 'daily' ?
                            getDzoColumnsClass(index,'plan') : getDzoColumnsClass(index,'difference')"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.factMonth) }}
                      </div>
                    </td>
                    <td
                            v-else
                            :class="isOilResidueActive ? getDzoColumnsClass(index,'yearlyPlan') : getDzoColumnsClass(index,'fact')"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.factMonth) }}
                      </div>
                    </td>
                    <td
                            v-if="isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="currentDzoList === 'daily' ?
                            getDzoColumnsClass(index,'fact') : getDzoColumnsClass(index,'percent')">
                      <div
                              v-if="item.planMonth - item.factMonth  !== 0"
                              :class="item.planMonth > item.factMonth || item.factMonth === 0 ?
                                'triangle fall-indicator-production-data' :
                                'triangle growth-indicator-production-data'
                              "
                      ></div>
                      <div class="font dynamic" >
                        {{getFormattedNumberToThousand(item.planMonth,item.factMonth)}}
                      </div>
                    </td>
                    <td
                            v-else-if="!isOilResidueActive"
                            :class="getDzoColumnsClass(index,'difference')">
                      <div
                              v-if="item.planMonth - item.factMonth  !== 0"
                              :class="item.planMonth > item.factMonth || item.factMonth === 0 ?
                                'triangle fall-indicator-production-data' :
                                'triangle growth-indicator-production-data'
                              "
                      ></div>
                      <div class="font dynamic" >
                        {{getFormattedNumberToThousand(item.planMonth,item.factMonth)}}
                      </div>
                    </td>
                    <td
                            v-if="!isFilterTargetPlanActive && !isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="`${getDzoColumnsClass(index,'percent')}`"
                    >
                      <div
                              v-if="item.planMonth - item.factMonth  !== 0"
                              :class="item.planMonth > item.factMonth || item.factMonth === 0 ?
                                'triangle fall-indicator-production-data' :
                                'triangle growth-indicator-production-data'
                              "
                      ></div>
                      <div class="font dynamic">
                        {{getPercentDifference (item.planMonth , item.factMonth)}}
                      </div>
                    </td>
                    <td
                            v-if="!isFilterTargetPlanActive && isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDzoColumnsClass(index,'difference') : getDzoColumnsClass(index,'difference')"
                    >
                      <div
                              v-if="item.opekPlan - item.factMonth  !== 0"
                              :class="item.opekPlan > item.factMonth || item.factMonth === 0 ?
                                'triangle fall-indicator-production-data' :
                                'triangle growth-indicator-production-data'
                              "
                      ></div>
                      <div class="font dynamic">
                        {{ getFormattedNumberToThousand(item.opekPlan,item.factMonth) }}
                      </div>
                    </td>
                    <td
                            v-if="isFilterTargetPlanActive && !isOilResidueActive"
                            :class="`${getDzoColumnsClass(index,'percent')}`"
                    >
                      <div class="font">
                        {{ formatDigitToThousand(item.targetPlan) }}
                      </div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkColorClass(index) : getLightColorClass(index)"
                    >
                      <div :class="item.opec ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                      </div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getLightColorClass(index) : getDarkColorClass(index)"
                    >
                      <div :class="item.impulses ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                      </div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkColorClass(index) : getLightColorClass(index)"
                    >
                      <div :class="item.landing ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                      </div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getLightColorClass(index) : getDarkColorClass(index)"
                    >
                      <div :class="item.accident ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                      </div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkColorClass(index) : getLightColorClass(index)"
                    >
                      <div :class="item.restrictions ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                      </div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getLightColorClass(index) : getDarkColorClass(index)"
                    >
                      <div :class="item.otheraccidents ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                      </div>
                    </td>
                    <td
                            v-if="exactDateSelected"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkColorClass(index) : getLightColorClass(index)"
                    >
                      <div :class="item.gasRestriction ? 'accident-triangle triangle' : 'no-accident-triangle triangle'">
                      </div>
                    </td>
                  </tr>
                  <tr v-if="isMultipleDzoCompaniesSelected">
                    <td :class="index % 2 === 0 ? `${getLighterClass(index)}` : `${getDarkerClass(index)}`"></td>
                    <td :class="index % 2 === 0 ? 'tdStyle3-total' : 'tdNone'">
                      <div class="">{{ dzoCompaniesAssets['assetTitle'] }}</div>
                    </td>

                    <td
                            v-if="buttonYearlyTab && !isOilResidueActive"
                            :class="
                          index % 2 === 0 ? `${getLighterClass(index)}` : 'tdStyle3-total'
                        "
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.periodPlan}}
                      </div>
                    </td>

                    <td
                            v-if="buttonMonthlyTab && !isOilResidueActive"
                            :class="index % 2 === 0 ? `${getLighterClass(index)}` : 'tdStyle3-total'"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.periodPlan}}
                      </div>
                    </td>

                    <td
                            v-if="(buttonMonthlyTab || buttonYearlyTab) && !isOilResidueActive"
                            :class="index % 2 === 0 ? `${getDarkerClass(index)}` : `${getLighterClass(index)}`"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.plan}}
                        <div class="right">
                          {{ trans("visualcenter.thousand") }} {{ metricName }}
                        </div>
                      </div>
                    </td>
                    <td
                            v-else-if="!isOilResidueActive"
                            :class="index % 2 === 0 ? `${getLighterClass(index)}` : `${getDarkerClass(index)}`"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.plan}}
                        <div class="right">
                          {{ trans("visualcenter.thousand") }} {{ metricName }}
                        </div>
                      </div>
                    </td>
                    <td
                            v-if="isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="currentDzoList === 'daily' ?
                            getDarkerClass(index) : getLighterClass(index)"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.opekPlan}}
                        <div class="right">
                          {{ trans("visualcenter.thousand") }} {{ metricName }}
                        </div>
                      </div>
                    </td>
                    <td
                            v-if="buttonMonthlyTab || buttonYearlyTab"
                            :class="index % 2 === 0 ? `${getDarkerClass(index)}` : `${getLighterClass(index)}`"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.fact}}
                        <div class="right">
                          {{ trans("visualcenter.thousand") }} {{ metricName }}
                        </div>
                      </div>
                    </td>
                    <td
                            v-else
                            :class="(currentDzoList === 'daily' && isConsolidatedCategoryActive()) || isOilResidueActive ?
                            getLighterClass(index) : getDarkerClass(index)"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.fact}}
                        <div class="right">
                          {{ trans("visualcenter.thousand") }} {{ metricName }}
                        </div>
                      </div>
                    </td>
                    <td
                            v-if="(buttonMonthlyTab || buttonYearlyTab) && !isOilResidueActive"
                            :class="index % 2 === 0 ? `${getLighterClass(index)}` : `${getDarkerClass(index)}`"
                    >
                      <div
                              v-if="totalSummary.fact > 0"
                              :class="getIndicatorClass(totalSummary.plan,totalSummary.fact)"
                      ></div>
                      <div class="font dynamic">
                        {{dzoCompaniesSummary.difference}}
                        <div class="right">
                          {{ trans("visualcenter.thousand") }}{{ metricName }}
                        </div>
                      </div>
                    </td>
                    <td
                            v-else-if="!isOilResidueActive"
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkerClass(index) : getLighterClass(index)"
                    >
                      <div
                              v-if="totalSummary.fact > 0"
                              :class="getIndicatorClass(totalSummary.plan,totalSummary.fact)"
                      ></div>
                      <div class="font dynamic">
                        {{dzoCompaniesSummary.difference}}
                        <div class="right">
                          {{ trans("visualcenter.thousand") }}{{ metricName }}
                        </div>
                      </div>
                    </td>
                    <td
                            v-if="isFilterTargetPlanActive && !isOilResidueActive"
                            :class="`${getColorClassBySelectedPeriod(index)}`"
                    >
                      <div class="font">
                        {{dzoCompaniesSummary.targetPlan}}
                      </div>
                    </td>
                    <td
                            v-if="!isFilterTargetPlanActive && isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="currentDzoList === 'daily' ?
                            getLighterClass(index) : getDarkerClass(index)"
                    >
                      <div
                              v-if="totalSummary.fact > 0"
                              :class="getIndicatorClass(totalSummary.opekPlan,totalSummary.fact)"
                      ></div>
                      <div class="font dynamic">
                        {{dzoCompaniesSummary.opekDifference}}
                      </div>
                    </td>
                    <td
                            v-if="!isFilterTargetPlanActive && !isConsolidatedCategoryActive() && !isOilResidueActive"
                            :class="`${getColorClassBySelectedPeriod(index)}`"
                    >
                      <div
                              v-if="totalSummary.fact > 0"
                              :class="getIndicatorClass(totalSummary.opekPlan,totalSummary.fact)"
                      ></div>
                      <div class="font dynamic" v-if="totalSummary.fact > 0">
                        {{dzoCompaniesSummary.percent}}
                      </div>
                    </td>

                    <td
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkerClass(index) : getLighterClass(index)"
                            v-if="exactDateSelected"
                    >
                    </td>
                    <td
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getLighterClass(index) : getDarkerClass(index)"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkerClass(index) : getLighterClass(index)"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getLighterClass(index) : getDarkerClass(index)"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getDarkerClass(index) : getLighterClass(index)"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getLighterClass(index) : getDarkerClass(index)"
                            v-if="exactDateSelected"
                    ></td>
                    <td
                            :class="currentDzoList === 'daily' && isConsolidatedCategoryActive() ?
                            getLighterClass(index) : getDarkerClass(index)"
                            v-if="exactDateSelected"
                    ></td>
                  </tr>
                  </tbody>
                </table>

                <div
                        v-if="!isMultipleDzoCompaniesSelected && buttonDailyTab"
                        v-for="(item) in dzoSummaryForTable"
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
                    <div class="mt-2" v-if="item.gasRestriction">
                      {{ item.gasRestriction }}
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
                  !isOneDateSelected) && !buttonDailyTab
                "
              >
                <div
                        v-if="isConsolidatedCategoryActive() && !isOilResidueActive"
                        class="oil-condensate-chart-secondary-name"
                >
                  {{ chartSecondaryName }}, {{ trans("visualcenter.thousand") }} {{ metricName }}
                </div>
                <div
                        v-else-if="isOilResidueActive"
                        class="oil-condensate-chart-secondary-name"
                >
                  {{ oilResidueChartName }}, {{ trans("visualcenter.thousand") }} {{ metricName }}
                </div>
                <div
                        v-else
                        class="name-chart-left"
                >
                  {{ chartSecondaryName }}, {{ trans("visualcenter.thousand") }} {{ metricName }}
                </div>
                <div class="name-chart-head">{{ chartHeadName }}</div>
                <vc-chart :height="465"> </vc-chart>
              </div>
            </div>
          </div>
        </div>

        <visual-center-usd-table
                :table-class="tableMapping.oilRate.class"
                :period.sync="period"
                :usd-rates-data.sync="oilRatesData"
                :period-select-func.sync="periodSelectFunc"
                :table-data.sync="oilRatesDataTableForCurrentPeriod"
                :usd-chart-is-loading.sync="isPricesChartLoading"
                @period-select-usd="
            updatePrices(periodSelect(selectedPeriod))
          "
                @change-table="changeTable('productionDetails')"
                :main-title="trans('visualcenter.oilPricedynamic')"
                :second-title="'USD Yandex quote'"
        />
        <visual-center-usd-table
                :table-class="tableMapping.usdRate.class"
                :period.sync="period"
                :usd-rates-data.sync="usdRatesData"
                :period-select-func.sync="periodSelectFunc"
                :table-data.sync="usdRatesDataTableForCurrentPeriod"
                :usd-chart-is-loading.sync="isPricesChartLoading"
                @period-select-usd="
            updatePrices(periodSelect(selectedPeriod))
          "
                @change-table="changeTable('productionDetails')"
                :main-title="trans('visualcenter.kursHeader')"
                :second-title="'USD НБ РК'"
        />
        <div :class="[`${tableMapping.injectionWells.class}`, 'third-table big-area']">
          <div class="first-string first-string2">
            <div class="container-fluid">
              <div class="area-6-name row mt-3 mb-3 px-2">
                <div class="col">
                  <div class="ml-4 bold">
                    {{trans("visualcenter.idleWells")}}
                  </div>
                </div>
                <div class="col px-4">
                  <div class="close2" @click="changeTable('productionDetails', true)">
                    {{ trans("visualcenter.close") }}
                  </div>
                </div>
              </div>

              <div class="row px-4">
                <div class="col-3 pr-2">
                  <div
                          :class="[`${injectionFondButtons.dailyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchInjectionFondPeriod('dailyPeriod')"
                  >
                    {{ trans("visualcenter.daily") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${injectionFondButtons.monthlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchInjectionFondPeriod('monthlyPeriod')"
                  >
                    {{ trans("visualcenter.monthBegin") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${injectionFondButtons.yearlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchInjectionFondPeriod('yearlyPeriod')"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col-3 pl-2">
                  <div class="dropdown3">
                    <div
                            :class="[`${injectionFondButtons.period}`,'button2 side-tables__main-menu-button']"
                            @click="switchInjectionFondPeriod('period')"
                    >
                      <span v-if="!isInjectionFondPeriodSelected">
                        {{ trans("visualcenter.date") }} [{{
                          injectionFondPeriodStart
                        }}]
                      </span>
                      <span v-else>
                        {{ trans("visualcenter.period") }} [{{injectionFondPeriodStart}} - {{ injectionFondPeriodEnd }}]
                      </span>
                    </div>
                    <ul class="center-menu2 right-indent">
                      <li class="center-li">
                        <br /><br />

                        <div class="month-day">
                          <div>
                            <date-picker
                                    mode="range"
                                    v-model="injectionFondPeriodMapping.period"
                                    is-range
                                    class="m-auto"
                                    :model-config="datePickerConfig"
                                    @input="switchInjectionFondPeriodRange"
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
                  <div class="col">
                    <select
                            class="side-blocks__dzo-companies-dropdown w-100"
                            @change="changeSelectedInjectionFondCompanies($event)"
                            v-model="injectionFondSelectedCompany"
                    >
                      <option v-for="dzo in dzoMenu.injectionFond" :value="dzo.ticker">
                        {{dzo.name}}
                      </option>
                    </select>
                  </div>

                  <div class="col pl-2">
                    <div
                            :class="fondsFilter.isInjectionIdleActive ? 'button2 button-tab-highlighted' : 'button2'"
                            @click="switchInjectionFondFilter('isInjectionIdleActive')"
                    >
                      {{ trans("visualcenter.inIdle") }}
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="row container-fluid">
                <div class="vis-table px-4 col-sm-7 mh-475">
                  <table v-if="injectionFondData.length" class="table4 w-100 chemistry-table additional-tables">
                    <thead>
                    <tr>
                      <th v-if="fondDaysCountSelected.injection < 2">{{ trans("visualcenter.idleWells") }} ({{ trans("visualcenter.Fact") }})</th>
                      <th v-else>{{ trans("visualcenter.idleWells") }} ({{ trans("visualcenter.fondMiddleInMonth") }})</th>
                      <th>{{ trans("visualcenter.otmMetricSystemWells") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                            v-for="(item, index) in injectionFondData"
                            v-if="item.isVisible"
                            @click="injectionFondSelectedRow = item.code"
                    >
                      <td
                              @click="injectionFondSelectedRow = item.code"
                              class="row-name_width_40 cursor-pointer"
                              :class="{
                                tdStyle: index % 2 === 0,
                                selected: injectionFondSelectedRow === item.code,
                              }"
                      >
                        <span>
                          {{ item.name }}
                        </span>
                      </td>
                      <td
                              @click="injectionFondSelectedRow = item.code"
                              class="w-25 text-center cursor-pointer"
                              :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                      >
                        <div class="font">
                          {{ getFormattedNumber(item.fact) }}
                        </div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-5">
                  <div v-if="isInjectionFondPeriodSelected" class="name-chart-left">{{ trans("visualcenter.wellsNumber") }}</div>
                  <fonds-daily-chart
                          v-if="injectionDailyChart.series.length > 0 && !isInjectionFondPeriodSelected"
                          :chart-data="injectionDailyChart"
                          :name="'visualcenter.countOfInjectionWells'"
                          :is-yaxis-active="false"
                  ></fonds-daily-chart>
                  <visual-center3-wells
                          v-if="injectionFondDataForChart && isInjectionFondPeriodSelected"
                          :chartData="injectionFondDataForChart"
                  ></visual-center3-wells>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div :class="[`${tableMapping.productionWells.class}`, 'third-table big-area']">
          <div class="first-string first-string2">
            <div class="container-fluid">
              <div class="area-6-name row mt-3 mb-3 px-2">
                <div class="col">
                  <div class="ml-4 bold">
                    {{trans("visualcenter.prodWells")}}
                  </div>
                </div>
                <div class="col px-4">
                  <div class="close2" @click="changeTable('productionDetails', true)">
                    {{ trans("visualcenter.close") }}
                  </div>
                </div>
              </div>
              <div class="row px-4">
                <div class="col-3 pr-2">
                  <div
                          :class="[`${productionFondDailyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchProductionFondPeriod('productionFondDailyPeriod')"
                  >
                    {{ trans("visualcenter.daily") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${productionFondMonthlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchProductionFondPeriod('productionFondMonthlyPeriod')"
                  >
                    {{ trans("visualcenter.monthBegin") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${productionFondYearlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchProductionFondPeriod('productionFondYearlyPeriod')"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col-3 pl-2">
                  <div class="dropdown3">
                    <div
                            :class="[`${productionFondPeriod}`,'button2 side-tables__main-menu-button']"
                    >
                      <span v-if="!isProductionFondPeriodSelected">
                        {{ trans("visualcenter.date") }} [{{
                          productionFondPeriodStart
                        }}]</span
                      >
                      <span v-else>
                        {{ trans("visualcenter.period") }} [{{
                          productionFondPeriodStart
                        }}
                        - {{ productionFondPeriodEnd }}]</span
                      >
                    </div>
                    <ul class="center-menu2 right-indent">
                      <li class="center-li">
                        <br /><br />

                        <div class="month-day">
                          <div>
                            <date-picker
                                    mode="range"
                                    v-model="productionFondPeriodMapping.productionFondPeriod"
                                    is-range
                                    class="m-auto"
                                    :model-config="datePickerConfig"
                                    @input="switchProductionFondPeriodRange"
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
                  <div class="col pr-2">
                    <select
                            class="side-blocks__dzo-companies-dropdown w-100"
                            @change="changeSelectedProductionFondCompanies($event)"
                            v-model="productionFondSelectedCompany"
                    >
                      <option v-for="dzo in dzoMenu.productionFond" :value="dzo.ticker">
                        {{dzo.name}}
                      </option>
                    </select>
                  </div>

                  <div class="col pl-2">
                    <div
                            :class="fondsFilter.isProductionIdleActive ? 'button2 button-tab-highlighted' : 'button2'"
                            @click="switchProductionFondFilter('isProductionIdleActive')"
                    >
                      {{ trans("visualcenter.inIdle") }}
                    </div>
                  </div>
                </div>
              </div>
              <br />
              <div class="row container-fluid">
                <div class="vis-table px-4 col-sm-7 mh-475">
                  <table v-if="productionFondData.length" class="table4 w-100 chemistry-table additional-tables">
                    <thead>
                    <tr>
                      <th v-if="fondDaysCountSelected.production < 2">{{ trans("visualcenter.prodWells") }} ({{ trans("visualcenter.Fact") }})</th>
                      <th v-else>{{ trans("visualcenter.prodWells") }} ({{ trans("visualcenter.fondMiddleInMonth") }})</th>
                      <th>{{ trans("visualcenter.otmMetricSystemWells") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                            v-for="(item, index) in productionFondData"
                            v-if="item.isVisible"
                            @click="productionFondSelectedRow = item.code"
                    >
                      <td
                              @click="productionFondSelectedRow = item.code"
                              class="row-name_width_40 cursor-pointer"
                              :class="{
                                tdStyle: index % 2 === 0,
                                selected: productionFondSelectedRow === item.code,
                              }"
                      >
                        <span>
                          {{ item.name }}
                        </span>
                      </td>
                      <td
                              @click="productionFondSelectedRow = item.code"
                              class="w-25 text-center cursor-pointer"
                              :class="index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'"
                      >
                        <div class="font">
                          {{ getFormattedNumber(item.fact) }}
                        </div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-5">
                  <div v-if="isProductionFondPeriodSelected" class="name-chart-left">{{ trans('visualcenter.wellsNumber') }}</div>
                  <fonds-daily-chart
                          v-if="productionDailyChart.series.length > 0 && !isProductionFondPeriodSelected"
                          :chart-data="productionDailyChart"
                          :name="'visualcenter.countOfProductionWells'"
                          :is-yaxis-active="false"
                  ></fonds-daily-chart>
                  <visual-center3-wells
                          v-if="productionFondDataForChart && isProductionFondPeriodSelected"
                          :chartData="productionFondDataForChart"
                  ></visual-center3-wells>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div :class="[`${tableMapping.otmDrilling.class}`, 'third-table big-area']">
          <div class="first-string first-string2">
            <div class="container-fluid">
              <div class="area-6-name row mt-3 mb-3 px-2">
                <div class="col">
                  <div class="ml-4 bold">
                    {{ trans("visualcenter.drillingWells") }}
                  </div>
                </div>
                <div class="col px-4">
                  <div class="close2" @click="changeTable('productionDetails', true)">
                    {{ trans("visualcenter.close") }}
                  </div>
                </div>
              </div>
              <div class="row px-4">
                <div class="col-3 pr-2">
                  <div
                          :class="[`${drillingDailyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchDrillingPeriod('drillingDailyPeriod')"
                  >
                    {{ trans("visualcenter.daily") }}
                  </div>
                </div>
                <div class="col-3 px-2 ">
                  <div
                          :class="[`${drillingMonthlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchDrillingPeriod('drillingMonthlyPeriod')"
                  >
                    {{ trans("visualcenter.monthBegin") }}
                  </div>
                </div>
                <div class="col-3 px-2">
                  <div
                          :class="[`${drillingYearlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchDrillingPeriod('drillingYearlyPeriod')"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col-3 pl-2">
                  <div class="dropdown3">
                    <div
                            :class="[`${drillingPeriod}`,'button2 side-tables__main-menu-button']"
                    >
                      <span v-if="!isDrillingPeriodSelected">
                        {{ trans("visualcenter.date") }} [{{
                          drillingPeriodStart
                        }}]</span
                      >
                      <span v-else>
                        {{ trans("visualcenter.period") }} [{{
                          drillingPeriodStart
                        }}
                        - {{ drillingPeriodEnd }}]</span
                      >
                    </div>
                    <ul class="center-menu2 right-indent">
                      <li class="center-li">
                        <br /><br />

                        <div class="month-day">
                          <div>
                            <date-picker
                                    mode="range"
                                    v-model="drillingPeriodMapping.drillingPeriod"
                                    is-range
                                    class="m-auto"
                                    :model-config="datePickerConfig"
                                    @input="switchDrillingPeriodRange"
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
                  <div class="col">
                    <select
                            class="side-blocks__dzo-companies-dropdown w-100"
                            @change="changeSelectedDrillingCompanies($event)"
                            v-model="drillingSelectedCompany"
                    >
                      <option v-for="dzo in dzoMenu.drilling" :value="dzo.ticker">
                        {{dzo.name}}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <br />
              <div class="row container-fluid">
                <div class="vis-table px-4 col-sm-7">
                  <table
                          v-if="drillingData.length"
                          class="table4 w-100 chemistry-table additional-tables"
                  >
                    <thead>
                    <tr>
                      <th>{{ trans("visualcenter.drillingWells") }}</th>
                      <th>{{ trans("visualcenter.Plan") }}</th>
                      <th>{{ trans("visualcenter.Fact") }}</th>
                      <th>{{ trans("visualcenter.dzoDifference") }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr
                            v-for="(item, index) in drillingData"
                            @click="drillingSelectedRow = item.code"
                    >
                      <td
                              @click="drillingSelectedRow = item.code"
                              class="row-name_width_40 cursor-pointer"
                              :class="{tdStyle: index % 2 === 0,selected: drillingSelectedRow === item.code}"
                      >
                        <span>
                          {{ item.name }}
                        </span>
                      </td>
                      <td
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
                        <div :class="[getIndicatorClass(item.plan,item.fact),'ml-5']">
                        </div>
                        <div class="font dynamic">
                          {{formatDigitToThousand(Math.abs(item.difference))}}
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
                  <div
                          v-if="drillingSelectedRow === 'otm_wells_commissioning_from_drilling_fact'"
                          class="name-chart-left">{{ trans("visualcenter.wellsNumber") }}
                  </div>
                  <div
                          v-else
                          class="name-chart-left">{{ trans("visualcenter.otmDrillingComission") }}, {{ trans("visualcenter.otmMetricSystemMeter") }}
                  </div>
                  <visual-center3-wells
                          v-if="drillingDataForChart"
                          :chartData="drillingDataForChart"
                  ></visual-center3-wells>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div :class="[`${tableMapping.emergencyInfo.class}`, 'third-table big-area']">
          <div class="first-string first-string2">
            <div class="container-fluid">
              <div class="area-6-name row mt-3 mb-3 px-2">
                <div class="col">
                  <div class="ml-4 bold">
                    {{ trans("visualcenter.emergencyHistory") }}
                  </div>
                </div>
                <div class="col px-4">
                  <div class="close2" @click="changeTable('productionDetails')">
                    {{ trans("visualcenter.close") }}
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row p-0 emergency-table__header">
                  <span class="col-1 p-2 pl-5">{{ trans("visualcenter.date") }}</span>
                  <span class="col-11 p-2 pl-3">{{ trans("visualcenter.notes") }}</span>
                </div>
                <div
                        class="row emergency-view"
                        v-for="(item, index) in emergencyHistory"
                >
                  <div class="col-12 d-flex emergency-title p-0">
                    <span class="col-1">{{item.date}}</span>
                    <span class="col-11">{{item.title}}</span>
                  </div>
                  <div class="col-12 d-flex emergency-description p-2">
                    <span class="col-1"></span>
                    <span class="col-11">{{item.description}}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div :class="[`${tableMapping.otmWorkover.class}`, 'third-table big-area']">
          <div class="first-string first-string2">
            <div class="container-fluid">
              <div class="area-6-name row mt-3 mb-3 px-2">
                <div class="col">
                  <div class="ml-4 bold">
                    {{ trans("visualcenter.importForm.wellWorkover") }}
                  </div>
                </div>
                <div class="col px-4">
                  <div class="close2" @click="changeTable('productionDetails', true)">
                    {{ trans("visualcenter.close") }}
                  </div>
                </div>
              </div>
              <div class="row px-4">
                <div class="col-4 px-2 ">
                  <div
                          :class="[`${wellsWorkoverMonthlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchWellsWorkoverPeriod('wellsWorkoverMonthlyPeriod')"
                  >
                    {{ trans("visualcenter.forLastMonth") }}
                  </div>
                </div>
                <div class="col-4 px-2">
                  <div
                          :class="[`${wellsWorkoverYearlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchWellsWorkoverPeriod('wellsWorkoverYearlyPeriod')"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col-4 pl-2">
                  <el-date-picker
                          :class="[`${wellsWorkoverPeriod}`,'button2 side-tables__main-menu-button']"
                          v-model="wellsWorkoverPeriodMapping.wellsWorkoverPeriod"
                          type="monthrange"
                          format="MMMM yyyy"
                          popper-class="custom-date-picker"
                          value-format="MMMM yyyy"
                          :picker-options="datePickerOptions"
                          @change="switchWellsWorkoverPeriodRange"
                  >
                  </el-date-picker>
                </div>
              </div>
              <br />
              <div class="">
                <div class="row px-4">
                  <div class="col">
                    <select
                            class="side-blocks__dzo-companies-dropdown w-100"
                            @change="changeSelectedWellsWorkoverCompanies($event)"
                            v-model="wellsWorkoverSelectedCompany"
                    >
                      <option v-for="dzo in dzoMenu.wellsWorkover" :value="dzo.ticker">
                        {{dzo.name}}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <br />
              <div class="row container-fluid">
                <div class="vis-table px-4 col-sm-7 mh-475">
                  <table
                          v-if="wellsWorkoverData.length"
                          class="table4 w-100 chemistry-table additional-tables"
                  >
                    <thead>
                    <tr>
                      <th>{{ trans("visualcenter.importForm.wellWorkover") }}</th>
                      <th>{{ trans("visualcenter.Plan") }}</th>
                      <th>{{ trans("visualcenter.Fact") }}</th>
                      <th>{{ trans("visualcenter.dzoDifference") }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr
                            v-for="(item, index) in wellsWorkoverData"
                            @click="wellsWorkoverSelectedRow = item.code"
                    >
                      <td
                              @click="wellsWorkoverSelectedRow = item.code"
                              class="row-name_width_40 cursor-pointer"
                              :class="{
                                tdStyle: index % 2 === 0,
                                selected: wellsWorkoverSelectedRow === item.code,
                              }"
                      >
                        <span>
                          {{ item.name }}
                        </span>
                      </td>
                      <td
                              @click="wellsWorkoverSelectedRow = item.code"
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
                              @click="wellsWorkoverSelectedRow = item.code"
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
                        <div :class="[getIndicatorClass(item.plan,item.fact),'ml-5']">
                        </div>
                        <div class="font dynamic">
                          {{formatDigitToThousand(Math.abs(item.difference))}}
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
                  <div v-if="wellsWorkoverMonthlyPeriod.length === 0" class="name-chart-left">{{ trans("visualcenter.wellsNumber") }}</div>
                  <fonds-daily-chart
                          v-if="wellsWorkoverDailyChart.series.length > 0 && wellsWorkoverMonthlyPeriod.length > 0"
                          :chart-data="wellsWorkoverDailyChart"
                          :name="'visualcenter.countWellsWorkover'"
                          :is-yaxis-active="true"
                  ></fonds-daily-chart>
                  <visual-center3-wells
                          v-if="wellsWorkoverDataForChart && wellsWorkoverMonthlyPeriod.length === 0"
                          :chartData="wellsWorkoverDataForChart"
                  ></visual-center3-wells>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div :class="[`${tableMapping.chemistry.class}`, 'third-table big-area']">
          <div class="first-string first-string2">
            <div class="container-fluid">
              <div class="area-6-name row mt-3 mb-3 px-2">
                <div class="col">
                  <div class="ml-4 bold">
                    {{ trans("visualcenter.chem") }}
                  </div>
                </div>
                <div class="col px-4">
                  <div class="close2" @click="changeTable('productionDetails', true)">
                    {{ trans("visualcenter.close") }}
                  </div>
                </div>
              </div>

              <div class="row px-4">
                <div class="col pr-2">
                  <div
                          :class="[`${chemistryMonthlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchChemistryPeriod('chemistryMonthlyPeriod')"
                  >
                    {{ trans("visualcenter.forLastMonth") }}
                  </div>
                </div>
                <div class="col px-2">
                  <div
                          :class="[`${chemistryYearlyPeriod}`,'button2 side-tables__main-menu-button']"
                          @click="switchChemistryPeriod('chemistryYearlyPeriod')"
                  >
                    {{ trans("visualcenter.yearBegin") }}
                  </div>
                </div>
                <div class="col pl-2">
                  <el-date-picker
                          :class="[`${chemistryPeriod}`,'button2 side-tables__main-menu-button']"
                          v-model="chemistryPeriodMapping.chemistryPeriod"
                          type="monthrange"
                          format="MMMM yyyy"
                          popper-class="custom-date-picker"
                          value-format="MMMM yyyy"
                          :picker-options="datePickerOptions"
                          @change="switchChemistryPeriodRange"
                  >
                  </el-date-picker>
                </div>
              </div>
              <br />
              <div class="">
                <div class="row px-4">
                  <div class="col pr-2">
                    <select
                            class="side-blocks__dzo-companies-dropdown w-100"
                            @change="changeSelectedChemistryCompanies($event)"
                            v-model="chemistrySelectedCompany"
                    >
                      <option v-for="dzo in dzoMenu.chemistry" :value="dzo.ticker">
                        {{dzo.name}}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <br />
              <div class="row container-fluid">
                <div class="vis-table px-4 col-sm-7">
                  <table
                          v-if="chemistryData.length"
                          class="table4 w-100 chemistry-table additional-tables"
                  >
                    <thead>
                    <tr>
                      <th>{{ trans("visualcenter.productionChemicalization") }}</th>
                      <th>
                        {{ trans("visualcenter.Fact") }}<br>
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
                              class="row-name_width_40 cursor-pointer"
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
                          {{ getNumberFormat(item.fact) }}
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
                          @click="switchWidget('productionWells')"
                          :class="`${tableMapping.productionWells.hover}`"
                  >
                    <div class="secondaryTitle">
                      {{ getFormattedNumber(productionFondSum.actual.work) }}
                    </div>
                    <div class="in-work">
                      {{ trans("visualcenter.inWork") }}
                    </div>
                    <div
                            :class="`${getGrowthIndicatorByDifference(productionFondSum.actual.work, productionFondSum.history.work)}`"
                    ></div>

                    <div class="txt2-2">
                      {{Math.abs(getDifferencePercentBetweenLastValues(productionFondSum.actual.work,productionFondSum.history.work))}}%
                    </div>
                  </td>

                  <td
                          class="col-6"
                          @click="switchWidget('productionWells')"
                          :class="`${tableMapping.productionWells.hover}`"
                  >
                    <div class="secondaryTitle d-flex">
                      <div class="col-10 col-lg-9">
                        {{ getFormattedNumber(productionFondSum.actual.idle) }}
                      </div>
                      <div class="mt-1 col-2">
                        <img src="/img/icons/link.svg" />
                      </div>
                    </div>
                    <div class="in-idle">
                      {{ trans("visualcenter.inIdle") }}
                    </div>
                    <div
                            :class="`${getIndicatorClassForReverseParams(
                        getDifferencePercentBetweenLastValues(productionFondSum.actual.idle, productionFondSum.history.idle)
                      )}`"
                    ></div>

                    <div class="txt2-2">
                      {{Math.abs(getDifferencePercentBetweenLastValues(productionFondSum.actual.idle,productionFondSum.history.idle))}}%
                    </div>
                    <br />
                  </td>
                </tr>
                <tr class="cursor-pointer d-flex">
                  <td
                          class="col-12"
                          @click="switchWidget('productionWells')"
                          :class="`${tableMapping.productionWells.hover}`"
                  >
                    <br>
                    <div class="right-column_header">
                      {{ trans("visualcenter.prodWells") }}
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
                            @click="switchWidget('injectionWells')"
                            :class="`${tableMapping.injectionWells.hover}`"
                    >
                      <div class="secondaryTitle">
                        {{getFormattedNumber(injectionFondSum.actual.work)}}
                      </div>
                      <div class="in-work">
                        {{ trans("visualcenter.inWork") }}
                      </div>
                      <div
                              :class="`${getGrowthIndicatorByDifference(injectionFondSum.actual.work, injectionFondSum.history.work)}`"
                      ></div>

                      <div class="txt2-2">
                        {{Math.abs(getDifferencePercentBetweenLastValues(injectionFondSum.actual.work,injectionFondSum.history.work))}}%
                      </div>
                    </td>

                    <td
                            class="col-6"
                            @click="switchWidget('injectionWells')"
                            :class="`${tableMapping.injectionWells.hover}`"
                    >
                      <div class="secondaryTitle d-flex">
                        <div class="col-10 col-lg-9">
                          {{getFormattedNumber(injectionFondSum.actual.idle)}}
                        </div>
                        <div class="mt-1 col-2">
                          <img src="/img/icons/link.svg" />
                        </div>
                      </div>
                      <div class="in-idle">
                        {{ trans("visualcenter.inIdle") }}
                      </div>
                      <div
                              :class="`${getIndicatorClassForReverseParams(
                                getDifferencePercentBetweenLastValues(injectionFondSum.actual.idle, injectionFondSum.history.idle)
                              )}`"
                      ></div>

                      <div class="txt2-2">
                        {{Math.abs(getDifferencePercentBetweenLastValues(injectionFondSum.actual.idle,injectionFondSum.history.idle))}}%
                      </div>
                      <br />
                    </td>
                  </tr>
                  <tr class="cursor-pointer d-flex">
                    <td
                            class="col-12"
                            @click="switchWidget('injectionWells')"
                            :class="`${tableMapping.injectionWells.hover}`"
                    >
                      <br>
                      <div class="right-column_header">
                        {{ trans("visualcenter.idleWells") }}
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="first-string first-string2 cursor-pointer">
              <div
                      @click="switchWidget('otmDrilling')"
                      :class="`${tableMapping.otmDrilling.hover}`"
              >
                <table class="table">
                  <tr class="d-flex">
                    <td class="col-10">
                      <div class="secondaryTitle">{{drillingWidgetFactSum}}</div>
                      <div class="metric-title">
                        {{ trans('visualcenter.skv') }}
                      </div>
                      <div class="in-idle">
                        <span v-if="!isDrillingPeriodSelected">
                          {{ drillingPeriodStart}}
                        </span>
                        <span v-else>
                          {{ drillingPeriodStart }} - {{ drillingPeriodEnd }}
                        </span>
                      </div>
                    </td>
                    <td class="col-2 text-right">
                      <div class="mt-1">
                        <img src="/img/icons/link.svg" />
                      </div>
                    </td>
                  </tr>
                  <tr class="d-flex">
                    <td class="col-12">
                      <div class="right-column_header">
                        {{ trans('visualcenter.drillingWells') }}
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="first-string first-string2 cursor-pointer"
                 @click="switchWidget('chemistry')"
                 :class="`${tableMapping.chemistry.hover}`"
            >
              <div>
                <table class="table">
                  <tr class="d-flex">
                    <td class="col-10">
                      <div class="secondaryTitle">{{chemistryWidgetFactSum}}</div>
                      <div class="metric-title">
                        {{ trans('visualcenter.chemistryMetricTon') }}
                      </div>
                      <div class="in-idle">
                        <span v-if="!isChemistryPeriodSelected">
                          {{ chemistryPeriodStartMonth}}
                        </span>
                        <span v-else>
                          {{ chemistryPeriodStartMonth }} - {{ chemistryPeriodEndMonth }}
                        </span>
                      </div>
                    </td>
                    <td class="col-2 text-right">
                      <div class="mt-1">
                        <img src="/img/icons/link.svg" />
                      </div>
                    </td>
                  </tr>
                  <tr class="d-flex">
                    <td class="col-12">
                      <div class="right-column_header">
                        {{ trans('visualcenter.chemistryCategory') }}
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="first-string first-string2">
              <div>
                <table class="table table1-2">
                  <tr class="cursor-pointer d-flex">
                    <td
                            class="col-6"
                            @click="switchWidget('otmWorkover')"
                            :class="`${tableMapping.otmWorkover.hover}`"
                    >
                      <div class="secondaryTitle">
                        {{getFormattedNumber(wellsWorkoverSummary.krs)}}
                      </div>
                      <div class="metric-title">
                        {{ trans("visualcenter.skv") }}
                      </div>
                      <div class="in-work">
                        {{ trans('visualcenter.otmKrsSkv') }}
                      </div>
                    </td>
                    <td
                            class="col-6"
                            @click="switchWidget('otmWorkover')"
                            :class="`${tableMapping.otmWorkover.hover}`"
                    >
                      <div class="secondaryTitle d-flex">
                        <div class="col-9 p-0">
                          {{getFormattedNumber(wellsWorkoverSummary.prs)}}
                        </div>
                        <div class="mt-1 col-2">
                          <img src="/img/icons/link.svg" />
                        </div>
                      </div>
                      <div class="metric-title">
                        {{ trans("visualcenter.skv") }}
                      </div>
                      <div class="in-work">
                        {{ trans('visualcenter.otmPrsSkv') }}
                      </div>
                    </td>
                  </tr>
                  <tr class="cursor-pointer d-flex">
                    <td
                            class="col-12"
                            @click="switchWidget('otmWorkover')"
                            :class="`${tableMapping.otmWorkover.hover}`"
                    >
                      <div class="in-idle">
                        <span v-if="!isWellsWorkoverPeriodSelected"> {{ wellsWorkoverPeriodStartMonth }}</span>
                        <span v-else> {{ wellsWorkoverPeriodStartMonth }} - {{ wellsWorkoverPeriodEndMonth }}</span>
                      </div>
                      <div class="right-column_header">
                        {{ trans("visualcenter.importForm.wellWorkover") }}
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="first-string first-string2">
              <div>
                <table class="table emergency-table">
                  <tr class="d-flex">
                    <td class="col-6">
                      <div class="secondaryTitle">0</div>
                      <div class="metric-title">
                        {{ trans('visualcenter.chemistryMetricTon') }}
                      </div>
                      <div class="in-idle">
                        {{ timeSelect }}
                      </div>
                    </td>
                    <td
                            class="col-6 cursor-pointer emergency-block"
                            @click="switchWidget('emergencyInfo')"
                            :class="`${tableMapping.emergencyInfo.hover}`"
                    >
                      <div class="secondaryTitle d-flex">
                        <div class="col-9 p-0 emergency-icon"></div>
                        <div class="mt-1 col-2">
                          <img src="/img/icons/link.svg" />
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr class="d-flex">
                    <td class="col-6">
                      <div class="right-column_header">
                        {{ trans('visualcenter.expectedProduction') }}
                      </div>
                    </td>
                    <td
                            class="col-6 cursor-pointer emergency-block"
                            :class="`${tableMapping.emergencyInfo.hover}`"
                    >
                      <div class="right-column_header">
                        {{ trans('visualcenter.emergencyHistory') }}
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
  </div>
</template>

<script src="./VisualCenterTable3.js"></script>
<style scoped lang="scss">
  @import './el-datepicker-custom.css';
  .troubled-companies {
    padding-left: 10%;
  }
  .dzocompanies-dropdown__divider {
    border-bottom: 2px solid #656a8a;
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
    .vis-table table {
      tr {
        td:first-child {
          width: 4%;
          text-align: center;
        }
      }
    }

    .table4 {
      min-width: 683px;
      tr {
        td {
          padding: 5px 5px 5px 10px;
          position: relative;
          vertical-align: middle;
          &:not(:first-child) {
            min-width: 71px;
          }
          &:nth-child(2) {
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
          }
          &.selected {
            background: #2e47c0 !important;
          }
          .font {
            align-items: baseline;
            justify-content: space-between;
            font-size: 15px;
            margin-left: 0;
            text-align: end;
            margin-right: 10%;
            &.dynamic {
              padding-left: 17px;
            }
            .right {
              font-size: 10px;
              margin-right: 0;
              display: none;
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
        content: " ";
        display: block;
        visibility: hidden;
        clear: both;
      }
      tr:first-child .th {
        background: inherit;
        top: -1px;
        z-index: 3000;
        width: 4%;
      }
      th {
        position: sticky;
        position: --webkit-sticky;
        top: -1;
        z-index: 2;
        border: 0.5px solid #272953;
        border-left: 0;
        position: sticky;
        font-size: 12px;
        background: #353ea1;
        text-align: center;
        &:nth-child(2) {
          width: 352px;
          padding-top: 5px;
          font-size: 15px;
        }
      }
    }
  }

  .additional-tables {
    th {
      height: 80px;
      padding: 5px 5px 5px 10px;
      font-size: 16px !important;
    }
  }
  .mh-475 {
    max-height: 495px;
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

  .row-name_width_40 {
    width: 40%;
  }
  .width-20 {
    width: 20%;
  }

  .data-metrics {
    font-style: normal;
    font-family: "HarmoniaSansProCyr-Regular";
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
    background: #2e50e9 !important;
    color: white;
  }

  .dzo-dropdown {
    height: 450px;
  }

  .dzo-company-list ul {
    margin: 10px 0 0 0;
    position: absolute;
    left: -0.5px;
    background: #40467e;
    top: 3em;
    padding: 5px;
    list-style: none;
    z-index: 999;
    cursor: pointer;
    color: white;
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
    background: #40467e;
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
    border-top: 5px solid #9ea4c9;
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
  @media (max-width: 400px) {
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
    height: 100%;
  }
  @media (max-width: 1400px) {
    .rates-block__row {
      height: auto;
    }
    .dzo-company-list li {
      font-size: 12px;
    }
    .vis-table .table4 {
      min-width: 0;
    }
    .mt-20 {
      margin-top: 20%;
    }
    .year-period-dropdown {
      min-width: 0;
    }
    .right-column_header {
      font-family: Bold;
      font-size: 0.8rem;
    }
  }
  @media (max-width: 2000px) {
    .table4 {
      tr td:not(:first-child) {
        min-width: 5.3em !important;
      }
    }
    .row-name_width_40 {
      width: 80%;
    }
    .year-period-dropdown {
      min-width: 290px;
      height: 45px;
    }
  }
  .dzocompanies__button_position {
    margin-top: 0.7em;
  }
  .side-blocks__dzo-companies-dropdown {
    position: relative;
    background-color: #333975;
    height: 40px;
    text-align: center;
    line-height: 40px;
    color: #9ea4c9;
    border: none;
  }
  .right-column_header {
    font-family: Bold;
    font-size: 0.9rem;
  }
  .fond-indicator-grow {
    background: url(/img/visualcenter3/red-arrow-grow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
  }

  .fond-indicator-fall {
    background: url(/img/visualcenter3/green-arrow-fall.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
  }

  .indicator-grow {
    background: url(/img/visualcenter3/green-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
  }

  .indicator-fall {
    background: url(/img/visualcenter3/red-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
  }

  .metric-title {
    color: #82BAFF;
    display: inline-block;
  }

  .text-right {
    text-align: right;
  }

  .oil-condensate-chart-secondary-name {
    color: #8489af;
    margin-top: 15%;
    text-align: center;
    position: absolute;
    writing-mode: tb-rl;
    transform: rotate(180deg);
  }
  .emergency-situations {
    background: #333975 60%;
  }
  .emergency-table {
    height: 145px;
    td {
      word-break: break-word;
    }
    tr {
      max-height: 100px;
    }
    tr:last-child {
      max-height: 56px;
    }
  }
  .emergency-block {
    background: #333975 60%;
  }
  .emergency-icon {
    width: 70px;
    height: 70px;
    background: url(/img/visualcenter3/emergency.png) 3% no-repeat;
    background-size: 50%;
  }
  .button_hover {
    background: #0d2792;
  }
  .emergency-view {
    .emergency-title {
      font-size: 16px;
      span:first-child {
        background: #353EA1;
      }
      span:last-child {
        background: #4C537E;
      }
    }
    .emergency-description {
      background: #313561;
    }
  }
  .category-button_border {
    border-right: 2px solid #272953;
  }
  .dropdown-position {
    margin: 0;
    padding: 5px;
    list-style: none;
    background: white;
    z-index: 999;
    border-radius: 10px;
    margin-left: 10px;
    border: 2px solid #2743cb;
    cursor: pointer;
    color: black;
    min-width: 99%;
  }
  .progress-bar_header {
    height: 80px !important;
  }
  .progress-bar_body {
    border-radius: 0;
  }
  .emergency-table__header {
    background: #2E50E9;
    border-bottom: 0.5px solid #272953;
    font-size: 17px;
    span:first-child {
      border-right: 0.5px solid #272953;
    }
  }
  .dropdown-splitter {
    background: #C4DEF2;
  }
</style>
