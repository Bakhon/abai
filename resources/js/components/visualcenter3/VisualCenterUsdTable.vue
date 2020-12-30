<template>
  <div class="third-table big-area usd-chart">
    <div class="first-string first-string2">
      <div class="container-fluid vc-oil-usd-wrapper">
        <div class="close2"
             @click="changeTable()">
          Закрыть
        </div>

        <div class="vc-chart-block-header">
            {{ mainTitle }}
        </div>

        <div class="row no-margin vc-chart-content-wrapper">
          <div class="col-sm-9">
            <div class="vc-chart-block-subheader">
              {{ secondTitle }}
            </div>

            <div class="vc-chart-wrapper">
              <div class="vc-period-container">
                <button
                    v-for="(menuDMY, index) in periodSelectFunc"
                    @click="selectPeriod(menuDMY.id)"
                    class="vc-period-item"
                    :class="{ 'active': menuDMY.active_usd }"
                    :disabled="true"
                >
                  {{ menuDMY.DMY }}
                </button>
              </div>

              <visual-center-chart-area-usd3 :usd-rates-data.sync="usdRatesData"/>
            </div>
          </div>

          <div class="col-sm-3">
            <div class="vc-chart-block-subheader">
              {{ activeTitle }}
            </div>

            <div class="vc-chart-table-wrapper">
              <perfect-scrollbar>
                <table class="vc-charts-table">
                  <thead>
                  <tr>
                    <th>Дата</th>
                    <th>Курс</th>
                    <th>Изменение</th>
                  </tr>
                  </thead>

                  <tbody>
                  <tr v-for="(data, index) in usdRatesData.for_table">
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
    'usdRatesData',
    'selectedUsdPeriod',
    'periodSelectFunc',
    'currencyChartData',
    'usdChartIsLoading',
    'mainTitle',
    'secondTitle',
  ],
  computed: {
    activeTitle() {
      let active = this.periodSelectFunc.find((item) => {
        return item.active_usd
      });

      return active.DMY_title;
    }
  },
  methods: {
    changeTable() {
      this.$emit('change-table');
    },
    selectPeriod(period) {
      this.$emit('update:selectedUsdPeriod', period);
      this.$emit('period-select-usd');
    }
  },
}
</script>