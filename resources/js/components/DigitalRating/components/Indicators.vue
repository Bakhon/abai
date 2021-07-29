<template>
  <div class="rating-indicators">
    <table class="table text-center text-white rating-table">
      <thead>
        <tr>
          <th class="align-middle" v-for="col in cols" :key="col.name">
            {{ col.title }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in indicators" :key="index">
          <td v-for="(col, colIdx) in cols" :key="colIdx">
            <span>{{ item[col.name] }}</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { indicators } from '../data';

export default {
  name: "Indicators",

  data() {
    return {
      indicators: indicators,
    }
  },

  computed: {
    cols() {
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
