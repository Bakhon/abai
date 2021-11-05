<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Потери добычи от остановок за май-октябрь 2020 г.
    </subtitle>

    <div class="mt-2 text-white font-size-14px line-height-16px">
      <div class="d-flex text-center font-weight-600">
        <div class="bg-blue p-2 border-grey min-width-50px"></div>

        <div
            class="bg-blue p-2 border-grey flex-grow-1 d-flex align-items-center justify-content-center min-width-300px">
          Наименование
        </div>

        <div v-for="(title, titleIndex) in titles"
             :key="titleIndex"
             :class="title.styleClass"
             class="bg-blue d-flex flex-column flex-95px">
          <div class="px-1 py-3 border-grey flex-grow-1 w-100 d-flex align-items-center justify-content-center">
            {{ title.name }}
          </div>

          <div class="p-1 border-grey">
            {{ title.dimensionTitle }}
          </div>
        </div>
      </div>

      <table-financial-loss-row
          v-for="(row, rowIndex) in tableRows"
          :key="rowIndex"
          :row="row"
          :titles="titles"
      />

      <table-financial-loss-row
          v-for="(row, rowIndex) in tableOptimizedRows"
          :key="`${rowIndex}_optimized`"
          :row="row"
          :titles="titles"
          :class="rowIndex ? '' : 'mt-2'"
      />

      <table-financial-loss-row
          v-for="(row, rowIndex) in tableSubtractionRows"
          :key="`${rowIndex}_subtraction`"
          :row="row"
          :titles="titles"
          :class="rowIndex ? '' : 'mt-2'"
      />

      <div v-for="(subTitle, subTitleIndex) in subTitles"
           :key="`${subTitleIndex}_subtitle`"
           class="mt-2 d-flex text-center font-weight-600">
        <div class="px-2 py-1 border-grey min-width-50px text-center bg-dark-blue">
          {{ 4 + subTitleIndex }}
        </div>

        <div class="px-2 py-1 border-grey min-width-300px flex-grow-1 text-left bg-dark-blue">
          {{ subTitle.name }}
        </div>

        <div class="bg-dark-blue ml-2 flex-285px d-flex justify-content-end">
          <div class="py-1 pr-1 border-grey bg-orange flex-95px">
            {{ subTitle.value }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";
import TableFinancialLossRow from "./TableFinancialLossRow";

export default {
  name: "TableFinancialLoss",
  components: {
    Subtitle,
    TableFinancialLossRow
  },
  props: {
    wells: {
      required: true,
      type: Array
    }
  },
  created() {
    this.$emit('updateWide', false)
  },
  computed: {
    sumData() {
      let sum = {}

      this.titles.forEach(title => {
        sum[title.key] = {
          profitable: 0,
          profitless: 0,
          total: 0,
        }
      })

      this.wells.forEach(well => {
        this.titles.forEach(title => {
          if (!title.key) return

          sum[title.key][well.profitability] += +well[title.key]

          sum[title.key].total += +well[title.key]
        })
      })

      return sum
    },

    tableRows() {
      return [
        {
          title: 'Фактические показатели',
          subTitle: '1.',
          values: this.titles.map(title => ({
            value: this.sumData[title.key].total
          })),
          style: 'background: #333868',
        },
        {
          title: 'Нерентабельные',
          values: this.titles.map(title => ({
            value: this.sumData[title.key].profitless
          })),
          style: 'background: #7D5F52'
        },
        {
          title: 'Рентабельные',
          values: this.titles.map(title => ({
            value: this.sumData[title.key].profitable
          })),
          style: 'background: #1A5855'
        },
        {
          title: 'Простой',
          values: this.titles.map(title => ({
            value: 0
          })),
          style: 'background: #2B2E5E'
        }
      ]
    },

    tableOptimizedRows() {
      return [
        {
          title: 'Предлагаемый вариант',
          subTitle: '2.',
          values: this.titles.map((title, titleIndex) => ({
            value: 0
          })),
          style: 'background: #333868',
        },
        {
          title: 'Нерентабельные',
          values: this.titles.map((title, titleIndex) => ({
            value: 0
          })),
          style: 'background: #7D5F52'
        },
        {
          title: 'Рентабельные',
          values: this.titles.map((title, titleIndex) => ({
            value: 0
          })),
          style: 'background: #1A5855'
        },
        {
          title: 'Простой',
          values: this.titles.map((title, titleIndex) => ({
            value: 0
          })),
          style: 'background: #2B2E5E'
        }
      ]
    },

    tableSubtractionRows() {
      return [
        {
          title: 'Предлагаемый вариант минус фактические показатели',
          subTitle: '3.',
          values: this.titles.map((title, titleIndex) => ({
            value: titleIndex
                ? this.tableOptimizedRows[0].values[titleIndex].value - this.tableRows[0].values[titleIndex].value
                : 0,
            style: titleIndex === this.titles.length - 1
                ? 'background: #B97919 !important'
                : ''
          })),
          style: 'background: #333868',
        },
        {
          title: 'Нерентабельные',
          values: this.titles.map((title, titleIndex) => ({
            value: titleIndex
                ? this.tableOptimizedRows[1].values[titleIndex].value - this.tableRows[1].values[titleIndex].value
                : 0
          })),
          style: 'background: #7D5F52'
        },
        {
          title: 'Рентабельные',
          values: this.titles.map((title, titleIndex) => ({
            value: titleIndex
                ? this.tableOptimizedRows[2].values[titleIndex].value - this.tableRows[2].values[titleIndex].value
                : 0
          })),
          style: 'background: #1A5855'
        },
        {
          title: 'Простой',
          values: this.titles.map((title, titleIndex) => ({
            value: titleIndex
                ? this.tableOptimizedRows[3].values[titleIndex].value - this.tableRows[3].values[titleIndex].value
                : 0
          })),
          style: 'background: #2B2E5E'
        }
      ]
    },

    titles() {
      return [
        {
          name: 'Кол-во скважин',
          dimensionTitle: 'ед.',
          key: 'uwi_count'
        },
        {
          name: 'Добыча жидкости',
          dimension: 1000,
          dimensionTitle: 'тыс. м3',
          key: 'liquid'
        },
        {
          name: 'Добыча нефти',
          dimension: 1000,
          dimensionTitle: 'тыс. тон',
          key: 'oil'
        },
        {
          name: 'Время всего',
          dimension: 24,
          dimensionTitle: 'дни',
          key: 'total_hours',
        },
        {
          name: 'Отр время',
          dimension: 24,
          dimensionTitle: 'дни',
          key: 'active_hours'
        },
        {
          name: 'Дни простоя',
          dimension: 24,
          dimensionTitle: 'дни',
          key: 'paused_hours'
        },
        {
          name: 'Доходы',
          dimension: 1000000,
          dimensionTitle: 'млн. тенге',
          key: 'netback',
          styleClass: 'ml-2',
        },
        {
          name: 'Расходы',
          dimension: 1000000,
          dimensionTitle: 'млн. тенге',
          key: 'overall_expenditures',
        },
        {
          name: 'Прибыль / убыток',
          dimension: 1000000,
          dimensionTitle: 'млн. тенге',
          key: 'operating_profit',
        },
      ]
    },

    subTitles() {
      return [
        {
          name: 'Рост прибыли от подбора нерентабельных скважин',
          value: 1000
        },
        {
          name: 'Рост прибыли от исключения ПРС на отключаемых скважинах',
          value: 2000
        },
        {
          name: 'Снижение прибыли из-за оставления 70% ФОТ, постоянных',
          value: 3000
        },
      ]
    }
  },
}
</script>

<style scoped>
.bg-blue {
  background: #333975;
}

.bg-dark-blue {
  background: #333868;
}

.bg-orange {
  background: #B97919 !important;
}

.border-grey {
  border: 1px solid #454D7D
}

.flex-95px {
  flex: 0 0 95px;
}

.flex-285px {
  flex: 0 0 285px;
}

.font-weight-600 {
  font-weight: 600;
}

.font-size-14px {
  font-size: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-18px {
  line-height: 18px;
}

.min-width-50px {
  min-width: 50px;
}

.min-width-300px {
  min-width: 300px;
}
</style>