<template>
  <div class="rating-indicators">
    <div class="rating-indicators__title">
      {{ trans('digital_rating.environmentIndicators') }}
      <img src="/img/icons/link.svg" alt="">
    </div>
    <table class="table text-center text-white rating-table">
      <thead>
        <tr>
          <th class="align-middle" v-for="col in cols" :key="col">
            {{ trans(col) }}
          </th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "Indicators",

  data() {
    return {
      indicators: [],
    }
  },

  computed: {
    cols() {
      return [
        'digital_rating.wellNumber',
        'digital_rating.liquidFlowRate',
        'digital_rating.waterCut',
        'digital_rating.oilFlowRate',
        'digital_rating.dynamicLevel'
      ]
    },
  }
}
</script>

<style scoped lang="scss">
.rating-indicators {
  width: 100%;
  background-color: #272953;
  padding: 10px;
  color: #fff;
}
.rating-indicators__title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
</style>
