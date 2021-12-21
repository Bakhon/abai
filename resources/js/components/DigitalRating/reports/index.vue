<template>
  <div>
    <gtm-main-menu
      :parentType="this.parentType"
      :mainMenu="menu"
      @menuClick="menuClick"
    />
    <div class="rating-report">
      <div class="rating-report__title">
        {{ trans('digital_rating.wellsReport') }}
        <img src="/img/icons/link.svg" alt="">
      </div>
      <table class="table text-center text-white rating-table">
        <thead>
          <tr>
            <th class="align-middle" v-for="(col, colIdx) in cols" :key="colIdx">
              {{ col.title }}
            </th>
          </tr>
        </thead>
        <tbody v-if="reports && reports.length">
          <tr
            v-for="(item, index) in reports"
            :key="index"
          >
            <td
              v-for="(col, colIdx) in cols"
              :key="colIdx"
              :class="col.name === 'sector' ? 'cursor-pointer' : ''"
              @click="onTableClick(item, col)">
              <span>{{ item[col.name] }}</span>
            </td>
          </tr>
        </tbody>
      </table>
      <button class="btn-button btn-button--thm-blue minw-400 mb-10px d-block m-auto">
        {{ trans('app.download') }}
      </button>
    </div>
    <well-atlas-modal
      ref="atlasModal"
      @close="closeAtlasModal"
    />
  </div>
</template>

<script>
import mainMenu from "../../GTM/mock-data/main_menu.json";
import axios from "axios";
import { globalloadingMutations, digitalRatingMutations } from '@store/helpers';
import WellAtlasModal from "../components/WellAtlasModal";

export default {
  name: "DigitalRatingReport",

  components: {
    WellAtlasModal
  },

  data() {
    return {
      parentType: '',
      menu: mainMenu,
      reports: []
    }
  },

  computed: {
    cols() {
      return [
        {
          title: this.trans('digital_rating.number'),
          name: 'num'
        },
        {
          title: this.trans('digital_rating.sector'),
          name: 'sector'
        },
        {
          title: this.trans('digital_rating.rating'),
          name: 'rating'
        },
        {
          title: this.trans('digital_rating.horizon'),
          name: 'horizon'
        },
        {
          title: 'X',
          name: 'x_c',
        },
        {
          title: 'Y',
          name: 'y_c'
        },
        {
          title: this.trans('digital_rating.liquidFlowRate') + ', ' + this.trans('digital_rating.cubeDay'),
          name: 'liquid_rate'
        },
        {
          title: this.trans('digital_rating.waterCut') + ' %',
          name: 'wc'
        },
        {
          title: this.trans('digital_rating.oilFlowRate') + ', ' + this.trans('digital_rating.tonDay'),
          name: 'oil_rate'
        },
        {
          title: this.trans('digital_rating.note'),
          name: 'comment'
        }
      ]
    },
  },

  async mounted() {
    this.SET_LOADING(true);
    await this.fetchData();
    this.SET_LOADING(false);
  },

  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),

    ...digitalRatingMutations([
      'SET_SECTOR', 'SET_HORIZON'
    ]),

    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    },

    async fetchData() {
      const res = await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/indicator/top?limit=50`);

      if (!res.error) {
        this.reports = res.data;
      }
    },

    onTableClick(item, col) {
      if (col.name !== 'sector') return;
      const {sector, horizon} = item;
      this.SET_SECTOR(sector);
      this.SET_HORIZON(horizon);
      this.$bvModal.show('modalAtlas');
    },

    closeAtlasModal() {
      this.$bvModal.hide('modalAtlas');
    },
  }
}
</script>

<style scoped lang="scss">
.rating-report {
  width: 100%;
  background-color: #272953;
  padding: 10px;
  color: #fff;
  margin-top: 3rem;
}
.rating-report__title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}

.rating-table thead th, .rating-table tbody tr td {
  width: 2%;
}
</style>
