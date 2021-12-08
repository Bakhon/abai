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
                <td>
                  <i
                    v-if="item.difference"
                    :class="`fas fa-caret-${item.difference > 0 ? 'up' : 'down'}`"
                    :style="`color: ${getColor(item.difference)}; margin-right: 4px;`"
                  />
                  {{ item.difference }}
                </td>
                <td>
                  <i
                    v-if="item.wellDifference"
                    :class="`fas fa-caret-${item.wellDifference > 0 ? 'up' : 'down'}`"
                    :style="`color: ${getColor(item.wellDifference)}; margin-right: 4px;`"
                  />
                  {{ item.wellDifference }}
                </td>
                <td>{{ item.wellDistribution }}</td>
                <td>
                  <i
                    v-if="item.oilDifference"
                    :class="`fas fa-caret-${item.oilDifference > 0 ? 'up' : 'down'}`"
                    :style="`color: ${getColor(item.oilDifference)}; margin-right: 4px;`"
                  />
                  {{ item.oilDifference }}
                </td>
                <td>{{ item.oilDistribution }}</td>
                <td>
                  <i
                    v-if="item.waterDifference"
                    :class="`fas fa-caret-${item.waterDifference > 0 ? 'up' : 'down'}`"
                    :style="`color: ${getColor(item.waterDifference)}; margin-right: 4px;`"
                  />
                  {{ item.waterDifference }}
                </td>
                <td>{{ item.waterDistribution }}</td>
                <td>
                  <i
                    v-if="item.uploadDifference"
                    :class="`fas fa-caret-${item.uploadDifference > 0 ? 'up' : 'down'}`"
                    :style="`color: ${getColor(item.uploadDifference)}; margin-right: 4px;`"
                  />
                  {{ item.uploadDifference }}
                </td>
                <td>{{ item.uploadDistribution }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="rating-analysis__diagram">
          <div class="rating-analysis__diagram--header">
            <btn-dropdown :list="getYearList" @select="handleSelectYear" class="mr-10px">
              <template #title>
                {{ trans('digital_rating.year') }}
              </template>
            </btn-dropdown>
          </div>
          <div class="rating-analysis__diagram--body">
            <div class="rating-analysis__chart">
              <div class="rating-analysis__chart--header">
                <span>{{ trans('digital_rating.oilProductionLossDistribution') }},
                  {{ trans('digital_rating.thousandTons') }}</span>
              </div>
              <div class="rating-analysis__chart--body">
                <apexchart
                  height="350"
                  type="bar"
                  :series="barChartData"
                  :options="barChartOptions"
                />
              </div>
            </div>
            <div class="rating-analysis__chart">
              <div class="rating-analysis__chart--header">
                <span>{{ trans('digital_rating.oilProductionLossDistribution') }}, %</span>
              </div>
              <div class="rating-analysis__chart--body">
                <apexchart
                  height="350"
                  type="donut"
                  :series="donutChartData"
                  :options="donutChartOptions"
                />
              </div>
            </div>
          </div>
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

      tbody td {
        width: 6%;
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

  &__diagram {
    width: 30%;
    margin-left: 6px;

    &--header {
      background-color: #363B68;
      padding: 8px;
      text-align: center;
    }

    &--body {
      border: 5px solid #363B68;
      border-top: none;
      padding: 4px;
    }
  }

  &__chart {

    &--header {
      background-color: #323370;
      padding: 4px 8px;
    }

    &--body {
      border: 5px solid #363B68;
      padding: 4px;
    }
  }
}
</style>