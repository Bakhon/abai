<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      {{ trans('economic_reference.table_additional_stops') }}
    </subtitle>

    <div class="mt-2 text-white font-size-12px line-height-14px">
      <div class="d-flex bg-blue font-weight-600 text-center pr-10px">
        <div :style="headers[0].style"
             class="py-2 px-1 border-grey d-flex align-items-center justify-content-center">
          {{ headers[0].title }}
        </div>

        <div :style="headers[1].style"
             class="py-2 px-1 border-grey d-flex align-items-center justify-content-center">
          {{ headers[1].title }}
        </div>

        <div :style="headers[2].styleSubTitle">
          <div class="py-2 px-1 border-grey d-flex align-items-center justify-content-center">
            {{ headers[2].subTitle }}
          </div>

          <div class="d-flex overflow-hidden">
            <div class="flex-50 py-2 px-1 border-grey d-flex align-items-center justify-content-center">
              {{ headers[2].title }}
            </div>

            <div class="flex-50 py-2 px-1 border-grey d-flex align-items-center justify-content-center">
              {{ headers[3].title }}
            </div>
          </div>
        </div>

        <div v-for="(header, headerIndex) in headers.slice(4)"
             :key="headerIndex"
             :style="header.style"
             class="py-2 px-1 border-grey d-flex align-items-center justify-content-center">
          {{ header.title }}
        </div>
      </div>

      <div class="d-flex bg-blue font-weight-600 text-center pr-10px">
        <div v-for="(header, headerIndex) in headers"
             :key="headerIndex"
             :style="header.style"
             class="p-2 border-grey">
          {{ header.dimension }}
        </div>
      </div>

      <div class="d-flex flex-column customScroll">
        <div v-for="(row, rowIndex) in tableData"
             :key="rowIndex"
             :style="row.style || `background: ${rowIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`"
             class="flex-grow-1 d-flex text-center">
          <div v-for="(header, headerIndex) in headers"
               :key="headerIndex"
               :style="header.style"
               class="p-3 border-grey d-flex align-items-center justify-content-center">
            {{ header.isString ? row[header.key] : localeValue(row[header.key]) }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {formatValueMixin} from "../../mixins/formatMixin";

import Subtitle from "../../components/Subtitle";

export default {
  name: "TableAdditionalStops",
  components: {
    Subtitle
  },
  mixins: [
    formatValueMixin,
  ],
  props: {
    wells: {
      required: true,
      type: Array
    }
  },
  computed: {
    wellsByDates() {
      let wellByDates = {}

      this.wells.forEach(well => {
        wellByDates.hasOwnProperty(well.date_month)
            ? wellByDates[well.date_month].push(well)
            : wellByDates[well.date_month] = [well]
      })

      return wellByDates
    },

    tableData() {
      let totalRow = {
        title: 'Всего',
        count: 0,
        profitable: 0,
        profitless: 0,
        stopped: 0,
        notStopped: 0,
        oilLoss: 0,
        operatingProfitLoss: 0,
        style: 'background: #293688;'
      }

      let rows = Object.values(this.wellsByDates).map((wells, dateIndex) => {
        let row = {
          title: this.dates[dateIndex],
          count: 0,
          profitable: 0,
          profitless: 0,
          stopped: 0,
          notStopped: 0,
          oilLoss: 0,
          operatingProfitLoss: 0,
        }

        wells.forEach(well => {
          let count = +well.uwi_count

          row.count += count

          if (well.is_become_profitable) {
            return row.profitable += count
          }

          row.profitless += count

          if (well.is_stopped) {
            return row.stopped += count
          }

          row.oilLoss += +well.oil

          row.operatingProfitLoss += +well.operating_profit_stop - +well.operating_profit
        })

        row.notStopped = row.profitless - row.stopped

        Object.keys(totalRow).forEach(key => totalRow[key] += +row[key])

        return row
      })

      totalRow.title = 'Всего'

      rows.push(totalRow)

      return rows
    },

    dates() {
      return Object.keys(this.wellsByDates)
    },

    headers() {
      return [
        {
          title: this.trans('economic_reference.months'),
          key: 'title',
          dimension: '',
          style: 'flex: 0 0 10%',
          isString: true
        },
        {
          title: this.trans('economic_reference.count_profitless_wells_with_prs'),
          key: 'count',
          dimension: this.trans('economic_reference.units'),
          style: 'flex: 0 0 10%',
        },
        {
          title: this.trans('economic_reference.become_profitable'),
          key: 'profitable',
          subTitle: this.trans('economic_reference.incl_exclude_prs'),
          dimension: this.trans('economic_reference.units'),
          styleSubTitle: 'flex: 0 0 20%',
          style: 'flex: 0 0 10%',
        },
        {
          title: this.trans('economic_reference.remain_profitless'),
          key: 'profitless',
          dimension: this.trans('economic_reference.units'),
          style: 'flex: 0 0 10%',
        },
        {
          title: this.trans('economic_reference.proposed_for_stop_in_proposed_variant'),
          key: 'stopped',
          dimension: this.trans('economic_reference.units'),
          style: 'flex: 0 0 15%',
        },
        {
          title: this.trans('economic_reference.additionally_can_stop'),
          key: 'notStopped',
          dimension: this.trans('economic_reference.units'),
          style: 'flex: 0 0 15%',
        },
        {
          title: this.trans('economic_reference.production_loss_with_additional_stop'),
          key: 'oilLoss',
          dimension: this.trans('economic_reference.tons'),
          style: 'flex: 0 0 15%',
        },
        {
          title: this.trans('economic_reference.savings_with_additional_stop'),
          key: 'operatingProfitLoss',
          dimension: this.trans('economic_reference.thousand_tenge'),
          style: 'flex: 0 0 15%',
        }
      ]
    },
  },
  created() {
    this.$emit('updateWide', false)
  }
}
</script>

<style scoped>
.bg-blue {
  background: #333975;
}

.border-grey {
  border: 1px solid #454D7D
}

.flex-50 {
  flex: 0 0 50%;
}

.font-weight-600 {
  font-weight: 600;
}

.font-size-12px {
  font-size: 12px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-18px {
  line-height: 18px;
}

.pr-10px {
  padding-right: 10px;
}

.customScroll {
  overflow-y: scroll;
  height: 455px
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>