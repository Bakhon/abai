<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Возможность дополнительных остановок
    </subtitle>

    <div class="mt-2 text-white font-size-12px line-height-14px">
      <div class="d-flex bg-blue font-weight-600 text-center pr-10px">
        <div class="py-2 px-1 border-grey d-flex align-items-center justify-content-center flex-20">
          Месяцы
        </div>

        <div class="py-2 px-1 border-grey d-flex align-items-center justify-content-center flex-10">
          Кол-во нерентаб. скважин с ПРС
        </div>

        <div class="flex-10">
          <div class="py-2 px-1 border-grey d-flex align-items-center justify-content-center">
            В том числе при исключении ПРС
          </div>

          <div class="d-flex overflow-hidden">
            <div class="flex-50 py-2 px-1 border-grey d-flex align-items-center justify-content-center">
              Становятся рентаб.
            </div>

            <div class="flex-50 py-2 px-1 border-grey d-flex align-items-center justify-content-center">
              Остаются нерент.
            </div>
          </div>
        </div>

        <div v-for="(title, titleIndex) in titles"
             :key="titleIndex"
             class="py-2 px-1 border-grey d-flex align-items-center justify-content-center flex-15">
          {{ title.name }}
        </div>
      </div>

      <div class="d-flex bg-blue font-weight-600 text-center pr-10px">
        <div v-for="dimension in (4 + titles.length)"
             :class="[
                 dimension === 1 ? 'flex-20' : '',
                 dimension === 2 ? 'flex-10' : '',
                 dimension === 3 || dimension === 4 ? 'flex-5' : '',
                 dimension >= 5 ? 'flex-15' : '',
                 ]"
             class="p-2 border-grey">
          {{ dimension === 1 ? '' : 'ед.' }}
        </div>
      </div>

      <div class="d-flex flex-column customScroll">
        <div v-for="(date, dateIndex) in dates"
             :key="date"
             :style="`background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`"
             class="flex-grow-1 d-flex text-center">
          <div class="text-left flex-20 p-3 border-grey">
            {{ date }}
          </div>

          <div v-for="dimension in (3 + titles.length)"
               :class="[
                 dimension === 1 ? 'flex-10' : '',
                 dimension === 2 || dimension === 3 ? 'flex-5' : '',
                 dimension >= 4 ? 'flex-15' : '',
                 ]"
               class="p-3 border-grey">
            {{ dateIndex * 100 + dimension * 10 }}
          </div>
        </div>
      </div>

      <div class="d-flex text-center bg-deep-blue font-weight-600 pr-10px">
        <div class="text-left flex-20 p-3 border-grey">
          Всего (суммированием с повторами скв.)
        </div>

        <div v-for="dimension in (3 + titles.length)"
             :class="[
                 dimension === 1 ? 'flex-10' : '',
                 dimension === 2 || dimension === 3 ? 'flex-5' : '',
                 dimension >= 4 ? 'flex-15' : '',
                 ]"
             class="p-3 border-grey">
          {{ 100 + dimension * 10 }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";

export default {
  name: "TableOilProductionLoss",
  components: {
    Subtitle
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
        'Октябрь',
        'Ноябрь',
        'Декабрь',
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
  }
}
</script>

<style scoped>
.bg-blue {
  background: #333975;
}

.bg-deep-blue {
  background: #293688;
}

.border-grey {
  border: 1px solid #454D7D
}

.flex-5 {
  flex: 0 0 5%;
}

.flex-10 {
  flex: 0 0 10%;
}

.flex-15 {
  flex: 0 0 15%;
}

.flex-20 {
  flex: 0 0 20%;
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
  height: 385px
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>