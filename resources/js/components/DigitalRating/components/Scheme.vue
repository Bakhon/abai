<template>
  <div class="correlation-scheme">
    <AwGis />
<!--    <div class="correlation-scheme__item" v-for="(item, idx) in 3">-->
<!--      <div class="correlation-scheme__header">-->
<!--        <div class="correlation-scheme__header-title">-->
<!--          {{ trans('digital_rating.correlationScheme') + idx + 1 }}-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="correlation-scheme__content">-->
<!--        <img src="/img/digital-rating/scheme.svg" alt="">-->
<!--      </div>-->
<!--    </div>-->
  </div>
</template>

<script>
import AwGis from '../../geology/petrophysics/graphics/awGis/AwGis';
import {FETCH_WELLS_MNEMONICS, SET_WELLS_BLOCKS} from "../../../store/modules/geologyGis.const";

export default {
  name: "Scheme",

  components: {
    AwGis
  },

  data() {
    return {
      wellList: ['UZN_1428', 'UZN_0144', 'UZN_9093', 'UZN_1027']
    }
  },

  async mounted() {
    await this.fetchGraphs();
  },

  methods: {
    async fetchGraphs() {
      await this.$store.dispatch(FETCH_WELLS_MNEMONICS, this.wellList);
      this.$store.commit(SET_WELLS_BLOCKS, this.wellList);
    }
  }
}
</script>

<style scoped lang="scss">
.correlation-scheme {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.correlation-scheme__item {
  width: calc(33% - 2px);
  background-color: #272953;
  padding: 10px;
  margin-bottom: 10px;
}
.correlation-scheme__header {
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
.correlation-scheme__content {
  img {
    width: 100%;
  }
}
</style>
