<template>
  <div class="container-fluid position-relative">
    <cat-loader v-show="loading"/>

    <div class="row">
      <div class="col-10">
        <modal
            v-for="bignKey in bignKeys"
            :key="bignKey"
            :name="bignKey"
            :width="1150"
            :height="400"
            adaptive>
          <div class="modal-bign">
            <vue-table-dynamic ref="table" :params="params"/>
          </div>
        </modal>

        <div class="main row justify-content-between text-white"
             style="padding:10px;">
          <div class="col-md-3 col-sm-12"
               @click="pushBign('bign1')">
            <economic-title>
              {{ res.averageProfitlessCat1MonthCount.toLocaleString() }}
            </economic-title>

            <economic-percent-badge :percent="res.percentCount"/>

            <div class="white-space-normal">
              Количество нерентабельных скважин за последний месяц
            </div>
          </div>

          <div class="col-md-3 col-sm-12"
               @click="pushBign('bign2')">
            <economic-title>
              <span>{{ res.year.toLocaleString() }}</span>
              <span class="font-size-16px text-blue">{{ res.yearWord }}</span>
            </economic-title>

            <div class="white-space-normal">
              Операционные убытки по НРС с начала года
            </div>
          </div>

          <div class="col-md-3 col-sm-12"
               @click="pushBign('bign3')">
            <economic-title>
              <span>{{ res.month }}</span>
              <span class="font-size-16px text-blue">{{ res.monthWord }}</span>
            </economic-title>

            <economic-percent-badge :percent="res.percent"/>

            <div class="white-space-normal">
              Операционные убытки по НРС за последний месяц
            </div>
          </div>

          <div class="col-md-3 col-sm-12"
               @click="pushBign('bign4')">
            <economic-title>
              {{ res.prs }}
            </economic-title>

            <div class="white-space-normal">
              Количество ПРС на НРС с начала года
            </div>
          </div>
        </div>

        <div class="main container-fluid">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-5 col-sm-12">
              <h5 class="subtitle text-wrap">
                Распределение добычи нефти по типу рентабельности скважин
              </h5>

              <chart2-component/>
            </div>

            <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
              <h5 class="subtitle text-wrap">
                Распределение скважин по типу рентабельности
              </h5>

              <chart1-component/>
            </div>

            <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
              <h5 class="subtitle text-wrap">
                Распределение добычи жидкости по типу рентабельности скважин
              </h5>

              <chart4-component/>
            </div>

            <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
              <h5 class="subtitle text-wrap">
                Рейтинг ТОП 10 прибыльных и убыточных скважин
              </h5>

              <chart3-component/>
            </div>
          </div>
        </div>
      </div>

      <economic-select-organization
          :organizations="organizations"
          class="col-2"
          @change="changeOrganization"/>
    </div>
  </div>
</template>

<script>
import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from '../ui-kit/CatLoader'
import EconomicTitle from "./components/EconomicTitle";
import EconomicSelectOrganization from "./components/EconomicSelectOrganization";
import EconomicPercentBadge from "./components/EconomicPercentBadge";

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});


export default {
  name: "economic-component",
  components: {
    VueTableDynamic,
    CatLoader,
    EconomicTitle,
    EconomicSelectOrganization,
    EconomicPercentBadge
  },
  data: () => ({
    organizations: [],
    res: {
      averageProfitlessCat1MonthCount: '',
      month: '',
      monthWord: '',
      year: '',
      yearWord: '',
      percent: null,
      percentCount: null,
      wellsList: null,
      OperatingProfitMonth: null,
      OperatingProfitYear: null,
      prs: null,
      prs1: null,
    },
    params: {
      data: [],
      enableSearch: true,
      header: 'row',
      border: true,
      stripe: true,
      pagination: true,
      pageSize: 10,
      pageSizes: [10, 20, 50],
      height: 300
    },
    loading: false
  }),
  computed: {
    urlOrganizations() {
      return '/ru/organizations'
    },

    urlEconomicData() {
      return '/ru/geteconimicdata'
    },

    bignKeys() {
      return [
        'bign1',
        'bign2',
        'bign3',
        'bign4',
      ]
    },

    chartKeys() {
      return [
        'chart1',
        'chart2',
        'chart3',
        'chart4',
      ]
    }
  },
  async created() {
    await this.getOrganizations()

    if (this.organizations.length) {
      await this.getEconomicData(this.organizations[0].id)
    }
  },
  methods: {
    changeOrganization(org) {
      this.getEconomicData(org)
    },

    async getOrganizations() {
      this.loading = true

      const {data} = await this.axios.get(this.urlOrganizations)

      this.organizations = data.organizations

      this.loading = false
    },

    async getEconomicData(org) {
      this.loading = true

      const {data} = await this.axios.get(this.urlEconomicData, {params: {org: org}})

      if (!data) {
        return this.loading = false
      }

      this.res = data

      this.params.data = data.wellsList

      this.chartKeys.forEach(chartKey => {
        this.$emit(chartKey, data[chartKey])
      })

      this.loading = false
    },

    pushBign(bign) {
      switch (bign) {
        case 'bign1':
          this.params.data = this.res.wellsList;
          break;
        case 'bign2':
          this.params.data = this.res.OperatingProfitYear;
          break;
        case 'bign3':
          this.params.data = this.res.OperatingProfitMonth;
          break;
        case 'bign4':
          this.params.data = this.res.prs1;
          break;
      }

      this.$modal.show(bign);
    }
  }
};
</script>
<style scoped>
.font-size-16px {
  font-size: 16px;
}

.text-blue {
  color: #82BAFF;
}

.white-space-normal {
  white-space: normal;
}

.loader {
  flex: 0 1 auto;
  flex-flow: row wrap;
  width: 100%;
  align-items: flex-start;
  position: absolute;
  height: 100%;
  justify-content: center;
  display: flex;
  z-index: 5000;
  background: rgba(0, 0, 0, 0.4);
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
}
</style>
