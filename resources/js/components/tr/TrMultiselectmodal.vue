<template>
  <multiselect
    :value="filter"
    @input="updateValueAction"
    :options="fieldFilterOptions"
    :multiple="true"
    :searchable="false"
    :closeOnSelect="false"
    select-label=""
    deselect-label=""
    select-group-label=""
    deselect-group-label=""
    selected-label=""
    noOptions="Нет доступных опций"
    group-values="fields"
    group-label="group"
    :option-height="35"
    :preselect-first="true"
    :group-select="true"
    :limit="1"
    :limit-text="() => ''"
    :placeholder="`${this.trans('tr.choose_well')} ${filterName} ${filterNameAdditional}`"
  >
    <div
      class="multiselect__option__item"
      slot="option"
      slot-scope="scope"
      @click.self="select(scope.option)"
    >
      <div class="multiselect__option__checkbox">
        <img
          src="/img/check.svg"
          class="multiselect__option__checkbox__check"
        />
      </div>
      <span>{{
        scope.option.$groupLabel ? scope.option.$groupLabel : scope.option
      }}</span>
    </div>
    <template slot="tag"
      ><span class="option__desc">{{ getFieldFilterText() }}</span></template
    >
  </multiselect>
</template>

<script>
import Multiselect from "vue-multiselect";
import trHelper from '~/mixins/trHelper';

export default {
  name: "TrMultiselectmodal",
  components: {
    Multiselect,
  },
  mixins: [trHelper],
  props: {
    filter: {
      type: Array,
      default() {
        return [];
      },
    },
    fieldFilterOptions: {
      type: Array,
      default() {
        return [];
      },
    },
    filterName: {
      type: String,
      default: "",
    },
    filterNameAdditional: {
      type: String,
      default: "",
    },
    filterNames: {
      type: Array,
    },
    textFormsRow: {
      type: String,
      default: "fields",
    },
    selectedAllTag: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    updateValueAction(value) {
      this.$emit("change-filter", value);
    },
    getFieldFilterText() {
      if (!this.fieldFilterOptions[0] || !this.fieldFilterOptions[0].fields) return "Нет опций"
      if (this.selectedAllTag && this.fieldFilterOptions[0].fields.length === this.filter.length) return `${this.trans('tr.all_wells_selected')}`;
      return `${this.filter.length} ${this.trans(`${this.declOfNum(this.filter.length, this.textFormsRow)}`)}`;
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
