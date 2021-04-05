<template>
  <div class="container-fluid economic-wrap">
    <cat-loader v-show="loading"/>

    <div class="row justify-content-between">
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

      <div class="col-md-9 col-sm-12">
        <h2 class="subtitle text-wrap">
          Нерентабельный фонд скважин 2020 год
        </h2>
      </div>

      <div class="col-md-3 col-sm-12">
        <select-organization
            :organizations="organizations"
            @change="changeOrganization"/>
      </div>
    </div>

    <div class="main row justify-content-between"
         style="padding:10px;">
      <div class="col-md-3 col-sm-12 bignumber"
           @click="pushBign('bign1')">
        <p class="bignumber-number text-center text-wrap">
          <span>{{ averageProfitlessCat1MonthCount }}</span>

          <percent-badge :percent="persentCount"/>
        </p>

        <p class="text-center bignumber-title text-wrap">
          Количество нерентабельных скважин за последний месяц
        </p>
      </div>

      <div class="col-md-3 col-sm-12 bignumber"
           @click="pushBign('bign2')">
        <p class="bignumber-number text-center text-wrap">
          {{ year }}
        </p>

        <p class="text-center bignumber-title text-wrap">
          Операционные убытки по НРС с начала года
        </p>
      </div>

      <div class="col-md-3 col-sm-12 bignumber"
           @click="pushBign('bign3')">
        <p class="bignumber-number text-center text-wrap">
          <span>{{ month }}</span>

          <percent-badge :percent="persent"/>
        </p>

        <p class="text-center bignumber-title text-wrap">
          Операционные убытки по НРС за последний месяц
        </p>
      </div>

      <div class="col-md-3 col-sm-12 bignumber" @click="pushBign('bign4')">
        <p class="bignumber-number text-center text-wrap">
          {{ prs }}

        <p class="text-center bignumber-title text-wrap">
          Количество ПРС на НРС с начала года
        </p>
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
</template>

<script>
import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from '../ui-kit/CatLoader'
import SelectOrganization from "./components/SelectOrganization";
import PercentBadge from "./components/PercentBadge";

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});


export default {
  name: "economic-component",
  components: {
    VueTableDynamic,
    CatLoader,
    SelectOrganization,
    PercentBadge
  },
  data: () => ({
    averageProfitlessCat1MonthCount: null,
    month: null,
    persent: null,
    persentCount: null,
    prs: null,
    year: null,
    wellsList: null,
    OperatingProfitMonth: null,
    OperatingProfitYear: null,
    prs1: null,
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
    organizations: [],
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

      this.averageProfitlessCat1MonthCount = data.averageProfitlessCat1MonthCount
      this.month = data.month
      this.persent = data.persent
      this.persentCount = data.persentCount
      this.prs = data.prs
      this.year = data.year
      this.wellsList = data.wellsList
      this.OperatingProfitMonth = data.OperatingProfitMonth
      this.OperatingProfitYear = data.OperatingProfitYear
      this.prs1 = data.prs1
      this.is_data_fetched = true
      this.params.data = data.wellsList

      this.chartKeys.forEach(chartKey => {
        this.$emit(chartKey, data[chartKey])
      })

      this.loading = false
    },
    pushBign(bign) {
      switch (bign) {
        case 'bign1':
          this.params.data = this.wellsList;
          break;
        case 'bign2':
          this.params.data = this.OperatingProfitYear;
          break;
        case 'bign3':
          this.params.data = this.OperatingProfitMonth;
          break;
        case 'bign4':
          this.params.data = this.prs1;
          break;
      }
      this.$modal.show(bign);
    }
  }
};
</script>
<style lang="scss" scoped>
.title,
.subtitle,
.drag-area-title {
  color: white;
}

.table {
  color: #fff !important;
}

.bignumber {
  background-color: #20274e !important;
  border-radius: 15px;
  flex: 0 0 24%;
  margin-bottom: 5px;

  &-number {
    color: #fff;
    font-size: 40px;
  }

  &-title {
    color: #fff;
    font-size: 20px;
    word-wrap: break-word;
  }
}

.economic-wrap {
  position: relative;

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
}
</style>
