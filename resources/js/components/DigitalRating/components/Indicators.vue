<template>
  <div class="rating-indicators">
    <div class="d-flex">
      <table class="table text-center text-white rating-table w-50">
        <thead>
          <tr>
            <th class="align-middle" v-for="col in colsIndicator" :key="col.name">
              {{ col.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in indicators" :key="index">
            <td v-for="(col, colIdx) in colsIndicator" :key="colIdx">
              <span>{{ item[col.name] }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="d-flex">
      <table class="table text-center text-white rating-table w-50">
        <thead>
          <tr>
            <th class="align-middle" v-for="col in secondColsIndicators" :key="col.name">
              {{ col.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in secondIndicators" :key="index">
            <td v-for="(col, colIdx) in secondColsIndicators" :key="colIdx">
              <span>{{ item[col.name] }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { indicators, secondIndicators } from '../json/data';

export default {
  name: "Indicators",

  data() {
    return {
      indicators: indicators,
      secondIndicators: secondIndicators
    }
  },

  computed: {
    colsIndicator() {
      return [
        {
          title: this.trans('digital_rating.wellNumber'),
          name: 'number'
        },
        {
          title: this.trans('digital_rating.liquidFlowRate'),
          name: 'liquid'
        },
        {
          title: `${this.trans('digital_rating.waterCut')}, %`,
          name: 'water'
        },
        {
          title: `${this.trans('digital_rating.oilFlowRate')}, ${this.trans('digital_rating.tonDay')}`,
          name: 'oil'
        },
        {
          title: `${this.trans('digital_rating.dynamicLevel')}, м`,
          name: 'level'
        }
      ]
    },
    secondColsIndicators() {
      return [
        {
          title: this.trans('digital_rating.wellNumber'),
          name: 'number'
        },
        {
          title: `${this.trans('digital_rating.throttleResponse')}, ${this.trans('digital_rating.cubeDay')}`,
          name: 'response'
        },
        {
          title: `${this.trans('digital_rating.injectionPressure')}, атм`,
          name: 'pressure'
        },
        {
          title: `${this.trans('digital_rating.distance')}, м`,
          name: 'distance'
        },
        {
          title: `${this.trans('digital_rating.stitchDiameter')}, мм`,
          name: 'diameter'
        }
      ]
    }
  }
}
</script>

<style scoped lang="scss">
.rating-indicators {
  width: 100%;
  color: #fff;
}
.rating-indicators__title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
</style>
