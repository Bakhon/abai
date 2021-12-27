<template>
  <div class="cross-plot__left-panel__well-block">
    <div class="cross-plot__left-panel__well-block-title">{{ title }}</div>
    <div class="cross-plot__left-panel__well-block-data-wrapper">
      <div class="cross-plot__left-panel__well-block-data">
        <div>
          <dropdown block class="w-100" :options="getOptions" :button-text="placeholder" @change="change"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dropdown from '../../../../../../components/dropdowns/dropdown';

export default {
  name: 'WellBlock',

  props: {
    title: String,
    placeholder: String,
    options: Array,
  },

  components: {
    dropdown,
  },

  methods: {
    change(value) {
      this.$emit('change', value);
    }
  },

  computed: {
    getOptions() {
      return this.options;
    }
  },
};
</script>

<style scoped lang="scss">
.cross-plot__left-panel__well-block {
  margin-top: 8px;

  &-title {
    padding: 5px 0 5px 10px;
    background: #323370;
    height: 26px;
  }

  &-data-wrapper {
    background: blue;
    border: 6px solid #2c2f5a;
  }

  &-data {
    padding: 7px;
    background: #363B68;
    border: 0.5px solid #545580;
    font-size: 12px;
  }
}
</style>
