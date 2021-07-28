<template>
  <div class="rating-reports">
    <div class="rating-reports__title">
      {{ trans('digital_rating.wellsReport') }}
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
    <button class="btn-button btn-button--thm-blue minw-400 mb-10px d-block m-auto">
      {{ trans('app.download') }}
    </button>
  </div>
</template>

<script>
export default {
  name: "Reports",

  computed: {
    cols() {
      return [
        'digital_rating.number',
        'digital_rating.wellNumber',
        'X',
        'Y',
        'digital_rating.horizon',
        'digital_rating.liquidFlowRate',
        'digital_rating.waterCut',
        'digital_rating.oilFlowRate',
        'PI',
      ]
    },
  }
}
</script>

<style scoped lang="scss">
.rating-reports {
  width: 100%;
  background-color: #272953;
  padding: 10px;
  color: #fff;
}
.rating-reports__title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
.podbor-middle-table th {
  padding: 1.2rem!important;
}
</style>
