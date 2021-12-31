<template>
  <div class="modal">
    <div
      class="content"
      :style="{ width: mainContentWidth }"
      v-click-outside="emitClose"
    >
      <div class="content-header">
        <p>{{ trans("plast_fluids.settings") }}</p>
        <button @click="emitClose">
          {{ trans("plast_fluids.close") }}
        </button>
      </div>
      <div class="content-main">
        <div class="content-main-header">
          <p>{{ templateName }}</p>
        </div>
        <div class="content-main-body">
          <div
            :style="{ width: fieldWidth }"
            v-for="(field, index) in fields"
            :key="index"
          >
            <input
              type="checkbox"
              :value="index"
              v-model="tempCheckedFields"
              :id="index + 'pf-upload-' + field"
            /><label :title="field" :for="index + 'pf-upload-' + field">{{
              field
            }}</label>
          </div>
        </div>
      </div>
      <div class="content-footer">
        <button
          v-if="isAllFieldsChecked"
          @click="tempCheckedFields = [4, 5]"
          class="reset-select-all-button"
        >
          <img src="/img/PlastFluids/refresh.svg" alt="reset checkboxes" />{{
            trans("plast_fluids.reset")
          }}
        </button>
        <button v-else @click="selectAllFields" class="reset-select-all-button">
          <img src="/img/PlastFluids/check.svg" alt="select all checkboxes" />{{
            trans("plast_fluids.select_all")
          }}
        </button>
        <button
          @click="sendTableActiveColumns"
          :disabled="!tempCheckedFields.length"
          :class="[{ disabled: !tempCheckedFields.length }, 'save-button']"
        >
          <img src="/img/PlastFluids/save.svg" alt="save table" />{{
            trans("plast_fluids.save")
          }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { DataTableModalWidthCalculator } from "../mixins";

export default {
  name: "DataAnalysisDataTableModal",
  mixins: [DataTableModalWidthCalculator],
  data() {
    return {
      tempCheckedFields: [],
    };
  },
  computed: {
    isAllFieldsChecked() {
      return this.tempCheckedFields.length === this.fields.length;
    },
  },
  watch: {
    checkedFields: {
      handler(fields) {
        this.tempCheckedFields = fields;
      },
      immediate: true,
    },
  },
  methods: {
    sendTableActiveColumns() {
      this.$emit("send-active-columns", this.tempCheckedFields);
      this.$emit("close-modal");
    },
    selectAllFields() {
      this.tempCheckedFields = this.fields.map((field, index) => index);
    },
  },
};
</script>

<style scoped lang="scss" src="./DataTableModalStyles.scss"></style>
