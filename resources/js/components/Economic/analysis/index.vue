<template>
  <div :class="isWide ? 'pr-75px' : 'pr-0'"
       class="position-relative row">
    <div class="col-12 px-3 mb-10px">
      <div class="row text-white text-wrap flex-nowrap">
        <calculated-header
            v-for="(header, index) in calculatedHeaders"
            :key="`calculated_${index}`"
            :header="header"
            :index="index"
            :class="index ? 'ml-2' : ''"
            class="flex-grow-1 px-3 py-1 min-h-130px"/>

        <remote-header
            v-for="(header, index) in remoteHeaders"
            :key="`remote_${index}`"
            :header="header"
            :form="form"
            class="flex-grow-1 px-3 py-1 ml-2 min-h-130px"/>
      </div>
    </div>

    <div class="col-12 p-2 bg-main1 mb-10px">
      <div class="d-flex bg-main1 text-white text-wrap">
        <div class="ml-2">
          <div class="text-nowrap font-size-14px line-height-18px font-weight-600">
            {{ trans('economic_reference.select_params') }}
          </div>

          <div class="form-check mt-16px">
            <input v-model="isFullScreen"
                   id="isFullScreen"
                   type="checkbox"
                   class="form-check-input">

            <label for="isFullScreen" class="form-check-label">
              {{ trans('economic_reference.full_screen') }}
            </label>
          </div>
        </div>

        <select-organization
            :form="form"
            class="ml-2"/>

        <select-permanent-stop-coefficient
            :form="form"
            class="ml-2"/>

        <select-technical-well-forecast-kit
            :form="form"
            :fetch-params="{is_processed: 1}"
            form-key="kit_ids"
            class="ml-2"
            is-multiple/>

        <i v-if="form.kit_ids.length && form.permanent_stop_coefficient"
           class="fas fa-search cursor-pointer ml-2 mt-40px"
           @click="getData()"></i>
      </div>
    </div>

    <div :class="isFullScreen ? 'col-12' : 'col-9 pr-2'">
      <tables
          v-if="wellsSum"
          :form="form"
          :wells-sum-by-status="wellsSumByStatus"
          :wells-sum-by-loss-status="wellsSumByLossStatus"
          :wells-sum="wellsSum"
          :proposed-wells-sum="proposedWellsSum"
          :proposed-stopped-wells="proposedStoppedWells"
          :profitless-wells-with-prs="profitlessWellsWithPrs"
          class="h-100"
          @updateWide="val => isWide = val"/>
    </div>

    <div v-show="!isFullScreen" class="col-3 pr-0">
      <economic-block
          v-for="(block, index) in economicBlocks"
          :key="index"
          :index="index"
          :block="block"
          :form="form"
          class="mb-10px min-h-160px"/>

      <analysis-block
          :analysis-params="analysisParams"
          :permanent-stop-coefficient="form.permanent_stop_coefficient"/>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import {formatValueMixin} from "../mixins/formatMixin";
import {calcPercentMixin} from "../mixins/percentMixin";

import SelectOrganization from "../components/SelectOrganization";
import SelectPermanentStopCoefficient from "./components/SelectPermanentStopCoefficient";
import SelectTechnicalWellForecastKit from "./components/SelectTechnicalWellForecastKit";
import CalculatedHeader from "./components/CalculatedHeader";
import RemoteHeader from "../optimization/components/RemoteHeader";
import EconomicBlock from "./components/EconomicBlock";
import AnalysisBlock from "./components/AnalysisBlock";
import Tables from "./components/Tables";

import {TechnicalWellLossStatusModel} from "../models/TechnicalWellLossStatusModel";

export default {
  name: "economic-analysis",
  components: {
    SelectOrganization,
    SelectPermanentStopCoefficient,
    SelectTechnicalWellForecastKit,
    CalculatedHeader,
    RemoteHeader,
    EconomicBlock,
    AnalysisBlock,
    Tables,
  },
  mixins: [
    formatValueMixin,
    calcPercentMixin
  ],
  data: () => ({
    form: {
      org_id: null,
      kit_ids: [],
      permanent_stop_coefficient: 0.7,
    },
    wellsSumByStatus: null,
    wellsSumByLossStatus: null,
    wellsSum: null,
    proposedWellsSum: null,
    proposedStoppedWells: null,
    profitlessWellsWithPrs: null,
    analysisParams: null,
    oilPrice: null,
    dollarRate: null,
    isWide: false,
    isFullScreen: false
  }),
  computed: {
    url() {
      return this.localeUrl('/economic/analysis/get-data')
    },

    calculatedHeaders() {
      let defaultWell = {uwi_count: 0, oil_loss: 0}

      let wellKeys = Object.keys(defaultWell)

      let wellsByStatus = {
        profitable: {...defaultWell},
        profitless: {...defaultWell},
      }

      TechnicalWellLossStatusModel.factualIds.forEach(status => {
        wellsByStatus[status] = {
          profitable: {...defaultWell},
          profitless: {...defaultWell},
          total: {...defaultWell},
        }
      })

      let wells = this.wellsSumByLossStatus || []

      let proposedStoppedWellsCount = (this.proposedStoppedWells || []).reduce((prev, next) => {
        return prev + next.uwi_count
      }, 0)

      wells.forEach(well => {
        if (!TechnicalWellLossStatusModel.factualIds.includes(well.status_id)) return

        wellKeys.forEach(wellKey => {
          let value = Math.abs(+well[wellKey])

          wellsByStatus[well.status_id][well.profitability][wellKey] += value

          wellsByStatus[well.status_id].total[wellKey] += value

          wellsByStatus[well.profitability][wellKey] += value
        })
      })

      return [
        {
          name: this.trans('economic_reference.count_factual_stopped_wells'),
          value: this.localeValue(
              wellsByStatus.profitable.uwi_count + wellsByStatus.profitless.uwi_count
          ),
          dimension: this.trans('economic_reference.wells_count').toLocaleLowerCase(),
          blocks: [
            {
              title: this.trans('economic_reference.nrs'),
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.NRS].total.uwi_count
              )
            },
            {
              title: this.trans('economic_reference.crf'),
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.CRF].total.uwi_count
              )
            },
            {
              title: `${this.trans('economic_reference.opek')} +`,
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.OPEK].total.uwi_count
              )
            }
          ]
        },
        {
          name: this.trans('economic_reference.count_proposed_stopped_wells'),
          value: this.localeValue(
              wellsByStatus.profitless.uwi_count + proposedStoppedWellsCount
          ),
          dimension: this.trans('economic_reference.wells_count').toLocaleLowerCase(),
          blocks: [
            {
              title: this.trans('economic_reference.nrs'),
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.NRS].profitless.uwi_count
              )
            },
            {
              title: this.trans('economic_reference.crf'),
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.CRF].profitless.uwi_count
              )
            },
            {
              title: `${this.trans('economic_reference.opek')} +`,
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.OPEK].profitless.uwi_count
              )
            },
            {
              title: this.trans('economic_reference.additionally_short').toLocaleUpperCase(),
              value: this.localeValue(proposedStoppedWellsCount)
            }
          ],
        },
        {
          name: this.trans('economic_reference.production_loss_at_stops'),
          value: this.localeValue(wellsByStatus.profitable.oil_loss, 1000),
          dimension: this.trans('economic_reference.thousand_tons'),
          blocks: [
            {
              title: this.trans('economic_reference.nrs'),
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.NRS].profitable.oil_loss,
                  1000
              )
            },
            {
              title: this.trans('economic_reference.crf'),
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.CRF].profitable.oil_loss,
                  1000
              )
            },
            {
              title: `${this.trans('economic_reference.opek')} +`,
              value: this.localeValue(
                  wellsByStatus[TechnicalWellLossStatusModel.OPEK].profitable.oil_loss,
                  1000
              )
            },
          ],
        }
      ]
    },

    remoteHeaders() {
      let oilPrice = this.oilPrice || {url: '', value: 0}

      let dollarRate = this.dollarRate || {url: '', value: 0}

      return [
        {
          name: this.trans('economic_reference.oil_price'),
          url: oilPrice.url,
          value: oilPrice.value,
          dimension: '$ / bbl',
        },
        {
          name: this.trans('economic_reference.course_prices'),
          url: dollarRate.url,
          value: dollarRate.value,
          dimension: 'kzt / $',
        }
      ]
    },

    economicBlocks() {
      let netBack = this.getSumByWellKey(this.wellsSum, 'netback')
      let netBackPropose = this.getSumByWellKey(this.proposedWellsSum, 'netback')

      let expenditures = this.getSumByWellKey(this.wellsSum, 'overall_expenditures')
      let expendituresPropose = this.getSumByWellKey(this.proposedWellsSum, 'overall_expenditures')

      let operatingProfit = this.getSumByWellKey(this.wellsSum, 'operating_profit')
      let operatingProfitPropose = this.getSumByWellKey(this.proposedWellsSum, 'operating_profit')

      return [
        [
          {
            title: this.trans('economic_reference.income'),
            value: this.formatValue(netBackPropose).value,
            dimension: `
              ${this.formatValue(netBackPropose).dimension}
              ${this.trans('economic_reference.tenge')}
            `,
            percent: this.calcPercent(netBackPropose, netBack),
            percentDimension: '%',
            isReverse: true
          },
          {
            title: this.trans('economic_reference.costs'),
            value: this.formatValue(expendituresPropose).value,
            dimension: `
              ${this.formatValue(expendituresPropose).dimension}
              ${this.trans('economic_reference.tenge')}
            `,
            percent: this.calcPercent(expendituresPropose, expenditures),
            percentDimension: '%',
            isReversePercent: true
          }
        ],
        [
          {
            title: this.trans('economic_reference.profit'),
            value: this.formatValue(operatingProfitPropose).value,
            dimension: `
              ${this.formatValue(operatingProfitPropose).dimension}
              ${this.trans('economic_reference.tenge')}
            `,
            percent: this.calcPercent(operatingProfitPropose, operatingProfit),
            percentDimension: '%',
            isReverse: true
          },
          {
            title: this.trans('economic_reference.economic_effect'),
            value: this.formatValue(operatingProfitPropose - operatingProfit).value,
            dimension: `
              ${this.formatValue(operatingProfitPropose - operatingProfit).dimension}
              ${this.trans('economic_reference.tenge')}
            `,
            percent: this.calcPercent(operatingProfitPropose, operatingProfitPropose),
            percentDimension: '%',
            isHidePercent: true,
            isReverse: true
          },
        ],
      ]
    },
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true)

      let singleKeys = [
        'analysisParams',
        'oilPrice',
        'dollarRate'
      ]

      let kitKeys = [
        'wellsSumByStatus',
        'wellsSumByLossStatus',
        'wellsSum',
        'proposedWellsSum',
        'proposedStoppedWells',
        'profitlessWellsWithPrs',
      ]

      try {
        const {data} = await this.axios.get(this.url, {params: this.form})

        singleKeys.forEach(key => this[key] = data[key])

        kitKeys.forEach(kitKey => {
          let wellsByKit = []

          Object.values(data.wellsByKits).forEach(kit => {
            wellsByKit = [...wellsByKit, ...kit[kitKey]]
          })

          this[kitKey] = wellsByKit
        })

      } catch (e) {
        console.log(e)

        singleKeys.forEach(key => this[key] = null)

        kitKeys.forEach(key => this[key] = null)
      }

      this.SET_LOADING(false)
    },

    getSumByWellKey(wells, wellKey) {
      return wells && wells.length
          ? wells.reduce((prev, next) => prev + +next[wellKey], 0)
          : 0
    },

  }
}
</script>
<style scoped>
.font-size-14px {
  font-size: 14px;
}

.line-height-18px {
  line-height: 18px;
}

.font-weight-600 {
  font-weight: 600;
}

.mb-10px {
  margin-bottom: 10px;
}

.mt-16px {
  margin-top: 16px;
}

.mt-40px {
  margin-top: 40px;
}

.pr-75px {
  padding-right: 75px !important;
}

.min-h-130px {
  min-height: 130px;
}

.min-h-160px {
  min-height: 160px;
}

.white-placeholder >>> *::placeholder {
  color: #fff;
}

.cursor-pointer {
  cursor: pointer;
}
</style>
