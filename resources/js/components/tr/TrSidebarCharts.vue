<template>
   
            <div class="dropright" style="z-index: 5000;">
                <div data-toggle="dropdown">
                    <a href="#" class="bg-dark list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-start align-items-center"><svg
            width="27"
            height="23"
            viewBox="0 0 27 23"
            fill="none"
            style="margin-right: 13px;"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.14269 8.93182H7.71417V17.8761H5.14269V8.93182ZM15.4286 12.7647H17.9998V17.8761H15.4286V12.7647ZM10.2854 5.09812H12.8571V17.8761H10.2854V5.09812ZM23.143 5.11115V1.27771H20.5713V5.11115H16.7143V7.66659H20.5713V11.5H23.143V7.66659H27V5.11115H23.143ZM20.5713 20.4446H2.57095V2.55544H17.9998V0H2.57095C1.15709 0 0 1.15022 0 2.55544V20.4446C0 21.8498 1.15709 23 2.57095 23H20.5713C21.986 23 23.143 21.8498 23.143 20.4446V14.0557H20.5713V20.4446Z"
              fill="#FEFEFE"
            />
          </svg> 
          
          <span class="menu-collapsed companyName d-none"></span>

          </div>
          </a>
                </div>
                <div  class="dropdown-menu graphic_dropdown_menu">
                    <div class="move-menu">
                        <li class="left-menu-li tr-sidebar__page"> <a class="tr-sidebar__link" :href="localeUrl('/fa')">{{trans('tr.fa')}}</a></li>
                        <li
                          v-for="(item, index) in chartNamesFA"
                          :key="item"
                          class="tr-sidebar__graph"
                        >
                          <a class="tr-sidebar__link" :href="localeUrl('/trfa')" @click="() => setChartFa(index)">{{ item }}</a>
                        </li>
                        <li class="left-menu-li">
                          <a class="tr-sidebar__link tr-sidebar__page" :href="localeUrl('/tr')">{{trans('tr.tr')}}</a>
                        </li>
                        <li
                          v-for="(item, index) in chartNames"
                          :key="item"
                          class="tr-sidebar__graph"
                        >
                          <a class="tr-sidebar__link" :href="localeUrl('/tr_charts')" @click="() => setChart(index)">{{ item }}</a>
                        </li>

                    </div>
                </div>
            </div>

</template>

<script>
export default {
  props: {},
  data() {
    return {
      chartNames: [
        this.trans('tr.analysis_of_reservoir_depth_pump_run_and_dynamic_level'),
        this.trans('tr.top_30_wells_oil_production_growth_potential'),
        this.trans('tr.top_30_wells_oil_production_growth_potential_water_cut'),
        this.trans('tr.top_30_wells_oil_production_growth_potential_gas_factor'),
        this.trans('tr.top_30_wells_liquid_production_growth_potential'),
        this.trans('tr.total_oil_and_liquid_production_rate'),
        this.trans('tr.distribution_of_productivity_index'),
        this.trans('tr.distribution_of_wells_by_oil_production_rate'),
        this.trans('tr.distribution_of_wells_by_water_cut'),
        this.trans('tr.distribution_of_wells_by_fluid_flow_rate'),
      ],
      chartNamesFA: [
        this.trans('tr.distribution_of_the_well_stock_due_to_the_main_reason_for_the_decline_in_oil_production'),
        this.trans('tr.distribution_of_total_TP_deviations_by_factors'),
      ],
    };
  },
  watch: {},
  methods: {
    setChart(chart) {
      console.log('setChart = ', chart)
      this.$store.commit("tr/SET_CHART", chart);
    },
    setChartFa(chart) {
      console.log('setChartFa = ', chart)
      this.$store.commit("fa/SET_CHART", chart);
    },
  },
};
</script>

<style  scoped>
.tr-sidebar__link {
  color: #FFF;
}
.tr-sidebar__page {
  font-weight: bold;
  font-size: 18px;
}

.dropright.dropright {
  z-index: 5000 !important;
}
.graphic_dropdown_menu {
    width: 555px;
    max-width: 80vw;
    padding: 0px;
    margin: 0;
    z-index: 5000 !important;
}
.tr-sidebar__graph{
  padding: 0px 28px;
}
</style>
