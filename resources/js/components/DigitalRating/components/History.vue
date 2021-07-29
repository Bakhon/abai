<template>
  <table class="table text-center text-white rating-table">
    <thead>
      <tr>
        <th class="align-middle" v-for="col in cols" :key="col.name">
          {{ col.title}}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in historyData" :key="index">
        <td v-for="(col, colIdx) in cols" :key="colIdx">
          <span>{{ item[col.name] }}</span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import { histories } from '../data';

export default {
  name: "History",

  data() {
    return {
      historyData: histories
    }
  },

  computed: {
    cols() {
      return [
        {
          title: this.trans('digital_rating.period'),
          name: 'period'
        },
        {
          title: this.trans('digital_rating.reconciling'),
          name: 'reconciling'
        },
        {
          title: this.trans('digital_rating.comments'),
          name: 'comment'
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>
