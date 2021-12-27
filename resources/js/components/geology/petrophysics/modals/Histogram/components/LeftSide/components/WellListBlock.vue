<template>
  <div class="cross-plot__left-panel__content-well-list-block d-flex flex-nowrap">
    <div class="w-100">
      <dropdown search block button-text="Выбор скважины" :options="getWellList" @change="change"/>
    </div>
  </div>
</template>

<script>
import dropdown from '../../../../../../components/dropdowns/dropdown';
import {GET_WELLS_OPTIONS} from "../../../../../../../../store/modules/geologyGis.const";

export default {
  name: 'WellListBlock',

  components: {
    dropdown,
  },

  computed: {
    getWellList() {
      return this.$store.getters[GET_WELLS_OPTIONS];
    }
  },

  methods: {
    change(value) {
      this.$emit('change', value);
    }
  }
};
</script>

<style scoped lang="scss">
.cross-plot__left-panel__content-well-list-block {
  height: 32px;
  margin-bottom: 10px;
}
</style>
