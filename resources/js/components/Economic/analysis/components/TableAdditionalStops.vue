<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Возможность дополнительных остановок
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
          title: 'Месяцы',
          key: 'title',
          dimension: '',
          style: 'flex: 0 0 10%',
          isString: true
        },
        {
          title: 'Кол-во нерентаб. скважин с ПРС',
          key: 'count',
          dimension: 'ед.',
          style: 'flex: 0 0 10%',
        },
        {
          title: 'Становятся рентаб.',
          key: 'profitable',
          subTitle: 'В том числе при исключении ПРС',
          dimension: 'ед.',
          styleSubTitle: 'flex: 0 0 20%',
          style: 'flex: 0 0 10%',
        },
        {
          title: 'Остаются нерент.',
          key: 'profitless',
          dimension: 'ед.',
          style: 'flex: 0 0 10%',
        },
        {
          title: 'Предложено к отключению (в предл. вар.)',
          key: 'stopped',
          dimension: 'ед.',
          style: 'flex: 0 0 15%',
        },
        {
          title: 'Можно дополнительно отключить скв.',
          key: 'notStopped',
          dimension: 'ед.',
          style: 'flex: 0 0 15%',
        },
        {
          title: 'Потери добычи при доп. отключении',
          key: 'oilLoss',
          dimension: 'тонн',
          style: 'flex: 0 0 15%',
        },
        {
          title: 'Экономия при доп. отключении (при сохр. 70% пост. рас., ПРС)',
          key: 'operatingProfitLoss',
          dimension: 'тенге',
          style: 'flex: 0 0 15%',
        }
      ]
    },

    titles() {
      return [
        {
          name: 'Предложено к отключению (в предл.вар.)'
        },
        {
          name: 'Можно дополнительно отключить скв.'
        },
        {
          name: 'Потери добычи при доп. отключении'
        },
        {
          name: 'Экономия при доп. отключении (при сохр. 70% пост. рас., ПРС)'
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