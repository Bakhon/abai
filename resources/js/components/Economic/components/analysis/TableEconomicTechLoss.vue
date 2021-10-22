<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Технологические потери: упущенная выгода, расходы на ПРС
    </subtitle>

    <div class="mt-2 text-white font-size-12px line-height-14px">
      <div class="bg-blue font-weight-600 pr-10px">
        <div class="pr-1 py-2 text-center border-grey pl-10">
          Упущенная выгода по потерям нефти, млн. тенге
        </div>

        <div class="d-flex">
          <div class="py-1 px-2 border-grey d-flex align-items-center justify-content-center flex-10">
            Месяцы
          </div>

          <div v-for="(title, titleIndex) in titles"
               :key="titleIndex"
               class="text-center flex-18">
            <div class="p-1 border-grey text-nowrap">
              {{ title.name }}
            </div>

            <div class="d-flex">
              <div v-for="(subTitle, subTitleIndex) in subTitles"
                   :key="subTitleIndex"
                   :style="`flex: 0 0 ${100 / subTitles.length}%`"
                   class="py-2 px-1 border-grey">
                {{ subTitle.name }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="customScroll">
        <table-oil-production-tech-loss-row
            v-for="(row, rowIndex) in tableRows"
            :key="rowIndex"
            :row="row"
            :titles="titles"
            :sub-titles="subTitles"
            :style="row.style"
            class="line-height-14px"/>
      </div>
    </div>

    <div class="text-white font-size-12px line-height-14px mt-3">
      <div class="bg-blue font-weight-600 pr-1 py-2 text-center border-grey pl-10 pr-10px">
        Расходы на ПРС, млн. тенге
      </div>

      <div class="d-flex flex-column customScroll" style="height: 310px">
        <table-oil-production-tech-loss-row
            v-for="(row, rowIndex) in tableOilRows"
            :key="rowIndex"
            :row="row"
            :titles="titles"
            :sub-titles="subTitles"
            :style="row.style"
            class="flex-grow-1 line-height-14px"/>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";
import TableOilProductionTechLossRow from "./TableOilProductionTechLossRow";

export default {
  name: "TableEconomicTechLoss",
  components: {
    Subtitle,
    TableOilProductionTechLossRow
  },
  computed: {
    tableRows() {
      let rows = this.columns.map((date, dateIndex) => {
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

      let sumValues = this.titles.map((title, titleIndex) => {
        return this.subTitles.map((subTitle, subTitleIndex) => {
          let sum = 0

          rows.forEach(row => {
            sum += row.values[titleIndex][subTitleIndex]
          })

          return sum
        })
      })

      rows.push(
          {
            date: 'Упущенная выгода, млн. тг.',
            values: sumValues,
            style: 'background: #293688; font-weight: 600'
          }
      )

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

      let sumValues = this.titles.map((title, titleIndex) => {
        return this.subTitles.map((subTitle, subTitleIndex) => {
          let sum = 0

          rows.forEach(row => {
            sum += row.values[titleIndex][subTitleIndex]
          })

          return sum
        })
      })

      rows.push(
          {
            date: 'Расходы на ПРС по тех. простоям*',
            values: sumValues,
            style: 'background: #323D85; font-weight: 600'
          },
          {
            date: 'Кол-во ПРС',
            values: sumValues,
            style: 'background: #293688; font-weight: 600'
          }
      )

      return rows
    },

    dates() {
      return [
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
      ]
    },

    columns() {
      return [
        'Кол-во скв. в простое',
        'Потери нефти, тн',
      ]
    },

    titles() {
      return [
        {
          name: 'Гидродинамическое исследование'
        },
        {
          name: 'КРС на восстановление добычи'
        },
        {
          name: 'КРС на повышение добычи'
        },
        {
          name: 'ПРС'
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

.flex-10 {
  flex: 0 0 10%;
}

.flex-18 {
  flex: 0 0 18%;
}

.pl-10 {
  padding-left: 10%;
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
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>