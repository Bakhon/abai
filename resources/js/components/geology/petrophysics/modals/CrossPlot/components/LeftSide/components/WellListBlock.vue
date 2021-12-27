<template>
  <div class="cross-plot__left-panel__content-well-list-block d-flex flex-nowrap">
    <div class="w-100">
      <dropdown search block button-text="Выбор скважины" :options="getWellList" @change="change"/>
    </div>
    <div class="cross-plot__left-panel__content-well-list-block-checkbox">
      <label class="d-flex flex-nowrap">
        <input type="checkbox" disabled>
        Синхронизировать
      </label>
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

  &-checkbox {
    background: #363B68;
    border: 0.5px solid #545580;
    border-radius: 4px;
    padding: 6px;
    margin-left: 8px;

    input {
      margin-right: 9px;
    }
  }
}
</style>
