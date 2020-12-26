<template>
  <multiselect
    v-model="filter"
    :options="fieldFilterOptions"
    :multiple="true"
    :searchable="false"
    :closeOnSelect="false"
    select-label=""
    deselect-label=""
    select-group-label=""
    deselect-group-label=""
    selected-label=""
    group-values="fields"
    group-label="group"
    :group-select="true"
    :limit="1"
    :limit-text="() => ''"
    :placeholder="`Выберите ${filterName}`"
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
import { declOfNum } from "./helpers.js";

export default {
  name: "TrMultiselect",
  components: {
    Multiselect,
  },
  props: {
    fieldFilterOptions: {
      type: Array,
      default() {
        return [];
      },
    },
    filterName: {
      type: String,
      default: "месторождения",
    },
    filterNames: {
      type: Array,
    },
  },
  data: function () {
    return {
      filter: []
    }
  },
  watch: {
    filter() {
      this.$emit("change-filter", this.filter);
    },
  },
  created: function () {
    this.filter = this.fieldFilterOptions[0].fields
  },
  methods: {
    getFieldFilterText() {
      if (!this.fieldFilterOptions[0] || !this.fieldFilterOptions[0].fields) return "Нет опций"
      return this.fieldFilterOptions[0].fields.length === this.filter.length
        ? `Выбраны все ${this.filterName}`
        : `Выбрано ${this.filter.length} ${declOfNum(this.filter.length)}`;
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
