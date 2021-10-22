<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Потери от остановок: добыча рентабельных и нерентабельных скважин
    </subtitle>

    <div class="mt-2 text-white font-size-12px line-height-14px">
      <div class="bg-blue font-weight-600 pr-10px">
        <div class="pr-1 py-2 text-center border-grey pl-20">
          Количество скважин, остановленных НРС, ЧРФ, Опек+
        </div>

        <div class="d-flex">
          <div class="py-1 px-2 border-grey d-flex align-items-center justify-content-center flex-20">
            Месяцы
          </div>

          <div v-for="(title, titleIndex) in titles"
               :key="titleIndex"
               class="text-center flex-20">
            <div class="py-1 px-2 border-grey">
              {{ title.name }}
            </div>

            <div class="d-flex">
              <div v-for="(subTitle, subTitleIndex) in subTitles"
                   :key="subTitleIndex"
                   :style="`flex: 0 0 ${100 / subTitles.length}%`"
                   class="py-2 px-2 border-grey">
                {{ subTitle.name }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex flex-column customScroll">
        <table-oil-production-loss-row
            v-for="(row, rowIndex) in tableRows"
            :key="rowIndex"
            :row="row"
            :titles="titles"
            :sub-titles="subTitles"
            :style="row.style"
            class="flex-grow-1"/>
      </div>
    </div>

    <div class="text-white font-size-12px line-height-14px mt-3">
      <div class="bg-blue font-weight-600 pr-1 py-2 text-center border-grey pl-20 pr-10px">
        Потери нефти, тонн
      </div>

      <div class="d-flex flex-column customScroll">
        <table-oil-production-loss-row
            v-for="(row, rowIndex) in tableOilRows"
            :key="rowIndex"
            :row="row"
            :titles="titles"
            :sub-titles="subTitles"
            :style="row.style"
            class="flex-grow-1"/>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";
import TableOilProductionLossRow from "./TableOilProductionLossRow";

export default {
  name: "TableOilProductionLoss",
  components: {
    Subtitle,
    TableOilProductionLossRow
  },
  computed: {
    tableRows() {
      let rows = this.dates.map((date, dateIndex) => {
        return {
          date: date,
          values: this.titles.map((title, titleIndex) => {
            return this.subTitles.map((subTitle, subTitleIndex) => {
              return titleIndex * 100 + subTitleIndex * 50
            })
          }),
          style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
        }
      })

      rows.push({
        date: 'Итог скважин (без повторов)',
        values: this.titles.map((title, titleIndex) => {
          return this.subTitles.map((subTitle, subTitleIndex) => {
            let sum = 0

            rows.forEach(row => {
              sum += row.values[titleIndex][subTitleIndex]
            })

            return sum
          })
        }),
        style: 'background: #293688; font-weight: 600'
      })

      return rows
    },

    tableOilRows() {
      let rows = this.dates.map((date, dateIndex) => {
        return {
          date: date,
          values: this.titles.map((title, titleIndex) => {
            return this.subTitles.map((subTitle, subTitleIndex) => {
              return titleIndex * 100 + subTitleIndex * 50
            })
          }),
          style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
        }
      })

      rows.push({
        date: 'Итог потерь нефти',
        values: this.titles.map((title, titleIndex) => {
          return this.subTitles.map((subTitle, subTitleIndex) => {
            let sum = 0

            rows.forEach(row => {
              sum += row.values[titleIndex][subTitleIndex]
            })

            return sum
          })
        }),
        style: 'background: #293688; font-weight: 600'
      })

      return rows
    },

    dates() {
      return [
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
      ]
    },

    titles() {
      return [
        {
          name: 'Остановка НРС'
        },
        {
          name: 'Остановка ЧРФ'
        },
        {
          name: 'Остановка ОПЕК+'
        },
        {
          name: 'Общий итог'
        }
      ]
    },

    subTitles() {
      return [
        {
          name: 'Всего'
        },
        {
          name: 'Рентаб.'
        },
        {
          name: 'Нерент.'
        },
      ]
    },
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

.flex-20 {
  flex: 0 0 20%;
}

.pl-20 {
  padding-left: 20%;
}

.pr-10px {
  padding-right: 10px;
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

.customScroll {
  overflow-y: scroll;
  height: 205px
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>