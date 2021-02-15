<template>
  <div class="third-table big-area usd-chart">
    <div class="first-string first-string2">
      <div class="container-fluid vc-oil-usd-wrapper">
        <div class="close2"
             @click="changeTable()">
          <!-- Закрыть -->{{trans("visualcenter.close")}}
        </div>

        <div class="vc-chart-block-header">
            {{ mainTitle }}
        </div>

        <div class="row no-margin vc-chart-content-wrapper">
          <div class="col-sm-9 vc-chart-container">
            <div class="vc-chart-block-subheader">
              {{ secondTitle }}
            </div>

            <div class="vc-chart-wrapper">
              <div class="vc-period-container">
                <button
                    v-for="(menuDMY, index) in periodSelectFunc"
                    @click="selectPeriod(menuDMY.id)"
                    class="vc-period-item"
                    :class="{ 'active': menuDMY.active }"
                    :disabled="false"
                >
                  {{ menuDMY.DMY }}
                </button>
              </div>

              <visual-center-chart-area-oil3 :chart-data.sync="oilRatesData.for_chart"
                                             :table-data.sync="tableData"/>
            </div>
          </div>

          <div class="col-sm-3 oil-table">
            <div class="vc-chart-block-subheader">
              {{ activeTitle }}
            </div>

            <div class="vc-chart-table-wrapper">
              <perfect-scrollbar>
                <table class="vc-charts-table">
                  <thead>
                  <tr>
                    <th>
                      {{this.trans("visualcenter.date")}}
                      </th>
                    <th>
                      {{this.trans("visualcenter.kurs")}}
                      </th>
                    <th>
                      {{this.trans("visualcenter.change")}}
                      </th>
                  </tr>
                  </thead>

                  <tbody>
                  <tr v-for="(data, index) in tableData">
                    <td>{{ data.date_string }}</td>
                    <td>{{ data.value }}</td>
                    <td>
                      <span>
                        {{ data.change }}%
                      </span>

                      <span class="vc-down-arrow"
                            v-if="data.index === 'DOWN'">
                        <i class="fas fa-arrow-down"></i>
                      </span>

                      <span class="vc-up-arrow"
                            v-if="data.index === 'UP'">
                        <i class="fas fa-arrow-up"></i>
                      </span>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </perfect-scrollbar>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {PerfectScrollbar} from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";

export default {
  components: { PerfectScrollbar },
  props: [
    'oilRatesData',
    'period',
    'periodSelectFunc',
    'currencyChartData',
    'isPricesChartLoading',
    'mainTitle',
    'secondTitle',
    'tableData'
  ],
  computed: {
    activeTitle() {
      let active = this.periodSelectFunc.find((item) => {
        return item.active
      });

      return active.DMY_title;
    }
  },
  methods: {
    changeTable() {
      this.$emit('change-table');
    },
    selectPeriod(period) {
      this.$emit('update:period', period);
      this.$emit('period-select-usd');
    }
  },
}
</script>


<style scoped>
  .oil-table {
    max-height: 590px;
  }
</style>
