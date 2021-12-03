<template>
  <table class="table text-center text-white rating-table">
    <thead>
      <tr>
        <th class="align-middle" v-for="col in cols" :key="col.name">
          {{ col.title}}
        </th>
      </tr>
    </thead>
    <tbody v-if="overviewData && overviewData.length">
      <tr v-for="(item, index) in overviewData" :key="index">
        <td v-for="(col, colIdx) in cols" :key="colIdx">
          <span>{{ item[col.name] }}</span>
        </td>
      </tr>
    </tbody>
    <div v-else class="warning-empty">
      <p>{{ trans('app.thereIsNoData') }}</p>
    </div>
  </table>
</template>

<script>
import { digitalRatingState, globalloadingMutations} from '@store/helpers';

export default {
  name: "Overview",

  data() {
    return {
      overviewData: []
    }
  },

  async mounted() {
    await this.fetchData();
  },

  methods: {
    async fetchData() {
      this.SET_LOADING(true);

      const res = await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/sector-forecast/${this.sectorNumber}`);
      if (!res.error) {
        this.overviewData = res?.data;
      }
      this.SET_LOADING(false);
    },

    ...globalloadingMutations([
      'SET_LOADING'
    ]),
  },

  computed: {
    ...digitalRatingState([
      'sectorNumber',
    ]),

    cols() {
      return [
        {
          title: this.trans('digital_rating.horizon') ,
          name: 'horizon'
        },
        {
          title: this.trans('digital_rating.code'),
          name: 'code'
        },
        {
          title: `${this.trans('digital_rating.liquidFlowRate')}, ${this.trans('digital_rating.cubeDay')}`,
          name: 'liquid_rate'
        },
        {
          title: `${this.trans('digital_rating.waterCut')}, %`,
          name: 'wc'
        },
        {
          title: `${this.trans('digital_rating.oilFlowRate')}, ${this.trans('digital_rating.tonDay')}`,
          name: 'oil_rate'
        },
        {
          title: this.trans('digital_rating.note'),
          name: 'comment'
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>
