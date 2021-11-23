<template>
  <div>
    <gtm-main-menu
      :parentType="this.parentType"
      :mainMenu="menu"
      @menuClick="menuClick"
    />
    <div class="rating-analysis">
      <div class="rating-analysis__title">
        <span>{{ trans('digital_rating.factorAnalysis') }}</span>
      </div>
      <div class="rating-analysis__wrapper">
        <div class="rating-analysis__table">
          <table class="table text-center text-white rating-table mb-0">
            <thead>
              <tr v-for="(thead, theadIdx) in tableHead" :key="theadIdx">
                <template v-for="(th, thIdx) in thead">
                  <th :key="thIdx" :colspan="th.colspan" :rowspan="th.rowspan" class="align-middle">
                    {{ th.title }}
                  </th>
                </template>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, itemIdx) in rows" :key="itemIdx">
                <td>{{ item.year }}</td>
                <td>{{ item.project }}</td>
                <td>{{ item.fact }}</td>
                <td>{{ item.difference }}</td>
                <td>{{ item.wellDifference }}</td>
                <td>{{ item.wellDistribution }}</td>
                <td>{{ item.oilDifference }}</td>
                <td>{{ item.oilDistribution }}</td>
                <td>{{ item.waterDifference }}</td>
                <td>{{ item.waterDistribution }}</td>
                <td>{{ item.uploadDifference }}</td>
                <td>{{ item.uploadDistribution }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="./factorAnalysis.js"></script>

<style scoped lang="scss">
.rating-analysis {
  height: 100%;
  color: #fff;
  margin-top: 3rem;
  background: #272953;
  padding: 6px;

  &__wrapper {
    position: relative;
    background: #1A214A;
    border: 1px solid #545580;
    box-sizing: border-box;
    padding: 6px;
    display: flex;

    &-title {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px;
      background: #323370;
      border: 1px solid #545580;
      box-sizing: border-box;

      h5 {
        margin: 0;
      }
    }
  }

  &__table {
    width: 70%;
    .rating-table {
      height: 100%;
      overflow: auto;

      thead th {
        font-size: 14px;
        width: 5%;
      }
    }

    td.alert {
      background: rgba(227, 31, 37, 0.35);
      border-radius: 0;
    }
  }

  &__title {
    padding: 6px 12px;
    background: #323370;
    border: 1px solid #545580;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
  }

  &__chart {
    p {
      background: #323370;
      border: 1px solid #545580;
      box-sizing: border-box;
      padding: 6px;
      margin: 0;
    }
    div {
      border: 3px solid #545580;
    }
  }
}
</style>