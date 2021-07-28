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
      <tr v-for="item in overviewData">
        <td></td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "Overview",

  data() {
    return {
      overviewData: []
    }
  },

  computed: {
    cols() {
      return [
        {
          title: this.trans('digital_rating.horizon') ,
          name: 'horizon'
        },
        {
          title: this.trans('digital_rating.code'),
          name: 'code'
        },
        {
          title: `${this.trans('digital_rating.liquidFlowRate')}, ${this.trans('digital_rating.cubeDay')}`,
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
          title: this.trans('digital_rating.note'),
          name: 'note'
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>
