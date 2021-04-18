<template>
  <div class="container-fluid position-relative">
    <cat-loader v-show="loading"/>

    <div class="row">
      <div class="col-9">
        <modal
            v-for="bignKey in bignKeys"
            :key="bignKey"
            :name="bignKey"
            :width="1150"
            :height="400"
            adaptive>
          <vue-table-dynamic ref="table" :params="params"/>
        </modal>

        <div class="row justify-content-between text-white bg-blue-dark text-wrap">
          <economic-col @click.native="pushBign('bign1')">
            <economic-title>
              <span>{{ res.averageProfitlessCat1MonthCount.toLocaleString() }}</span>

              <economic-percent-badge :percent="res.percentCount"/>
            </economic-title>

            <economic-subtitle>
              Количество нерентабельных скважин за последний месяц
            </economic-subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign2')">
            <economic-divider/>

            <economic-title>
              <span>{{ res.year.toLocaleString() }}</span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ res.yearWord }}
              </span>
            </economic-title>

            <economic-subtitle>
              Операционные убытки по НРС с начала года
            </economic-subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign3')">
            <economic-divider/>

            <economic-title>
              <span>{{ res.month }}</span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ res.monthWord }}
              </span>

              <economic-percent-badge :percent="res.percent"/>
            </economic-title>

            <economic-subtitle>
              Операционные убытки по НРС за последний месяц
            </economic-subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign4')">
            <economic-divider/>

            <economic-title>
              {{ res.prs.toLocaleString() }}
            </economic-title>

            <economic-subtitle>
              Количество ПРС на НРС с начала года
            </economic-subtitle>
          </economic-col>
        </div>

        <economic-charts v-if="res.chart1" :charts="res"/>
      </div>

      <div class="col-3">
        <div
            v-for="(block, index) in blocks"
            :key="index"
            class="d-flex bg-main1 text-white text-wrap p-3 mb-3"
            style="height: 220px">
          <div
              v-for="(subBlock, subBlockIndex) in block"
              :key="subBlock.title"
              class="col-6 d-flex flex-column position-relative">
            <economic-divider v-if="subBlockIndex % 2 === 1"/>

            <div class="font-weight-bold font-size-32px line-height-38px">
              {{ subBlock.value.toLocaleString() }}
            </div>

            <div class="text-blue font-size-12px line-height-14px">
              {{ subBlock.valueWord }}
            </div>

            <div class="flex-grow-1 mt-3 font-weight-bold line-height-20px font-size-16px">
              {{ subBlock.title }}
            </div>

            <economic-percent-badge
                :percent="subBlock.percent"
                class="font-size-22px line-height-26px"/>
          </div>
        </div>

        <div class="bg-main1 p-3 mt-3">
          <economic-select-organization
              :organizations="organizations"
              @change="changeOrganization"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from '../ui-kit/CatLoader'
import EconomicDivider from "./components/EconomicDivider";
import EconomicCol from "./components/EconomicCol";
import EconomicCharts from "./components/EconomicCharts";
import EconomicTitle from "./components/EconomicTitle";
import EconomicSubtitle from "./components/EconomicSubtitle";
import EconomicSelectOrganization from "./components/EconomicSelectOrganization";
import EconomicPercentBadge from "./components/EconomicPercentBadge";

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});


export default {
  name: "economic-component",
  components: {
    VueTableDynamic,
    CatLoader,
    EconomicDivider,
    EconomicCol,
    EconomicCharts,
    EconomicTitle,
    EconomicSubtitle,
    EconomicSelectOrganization,
    EconomicPercentBadge
  },
  data: () => ({
    organizations: [],
    activeTab: 0,
    res: {
      averageProfitlessCat1MonthCount: 0,
      month: 0,
      monthWord: '',
      year: 0,
      yearWord: '',
      percent: null,
      percentCount: null,
      wellsList: null,
      OperatingProfitMonth: null,
      OperatingProfitYear: null,
      prs: 0,
      prs1: 0,
      chart1: null,
      chart2: null,
      chart3: null,
      chart4: null,
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
    blocks() {
      return [
        [
          {
            title: 'Выручка экспорт',
            value: 320120,
            valueWord: 'млн. тенге',
            percent: 10.75
          },
          {
            title: 'Выручка местный рынок',
            value: 50160,
            valueWord: 'млн. тенге',
            percent: 10.75
          }
        ],
        [
          {
            title: 'Условно-переменные затраты',
            value: 45230,
            valueWord: 'млн. тенге',
            percent: 10.75
          },
          {
            title: 'Условно-постоянные затраты',
            value: 185190,
            valueWord: 'млн. тенге',
            percent: 10.75
          }
        ],
        [
          {
            title: 'Отчисления в государство(НДПИ, Рентный налог, ЭТП)',
            value: 75300,
            valueWord: '',
            percent: 527
          },
          {
            title: 'Общие призводственые затраты',
            value: 230420,
            valueWord: '',
            percent: 1.2
          },
        ],
      ]
    },

    bignKeys() {
      return [
        'bign1',
        'bign2',
        'bign3',
        'bign4',
      ]
    },
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

      const {data} = await this.axios.get('/ru/organizations')

      this.organizations = data.organizations

      this.loading = false
    },

    async getEconomicData(org) {
      this.loading = true

      const {data} = await this.axios.get('/ru/geteconimicdata', {params: {org: org}})

      if (!data) {
        return this.loading = false
      }

      this.res = data

      this.params.data = data.wellsList

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
.font-size-12px {
  font-size: 12px !important;
}

.font-size-16px {
  font-size: 16px !important;
}

.font-size-22px {
  font-size: 22px !important;
}

.font-size-32px {
  font-size: 32px !important;
}

.line-height-14px {
  line-height: 14px !important;
}

.line-height-22px {
  line-height: 22px !important;
}

.line-height-26px {
  line-height: 26px !important;
}

.bg-blue-dark {
  background: #2B2E5E;
}

.text-blue {
  color: #82BAFF;
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
