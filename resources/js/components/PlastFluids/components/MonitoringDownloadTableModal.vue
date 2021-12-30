<template>
  <div class="modal">
    <div
      class="content"
      :style="{ width: mainContentWidth }"
      v-click-outside="emitClose"
    >
      <div class="content-header">
        <p>{{ trans("plast_fluids.template_create") }}</p>
        <button @click="emitClose">
          {{ trans("plast_fluids.close") }}
        </button>
      </div>
      <div class="content-main">
        <div class="content-main-header">
          <p>{{ trans("plast_fluids.ready_templates") }}: {{ templateName }}</p>
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
              v-model="computedCheckedFields"
              :id="index + 'pf-upload-' + field"
            /><label :title="field" :for="index + 'pf-upload-' + field">{{
              field
            }}</label>
          </div>
        </div>
      </div>
      <div class="content-footer">
        <button
          @click="addCustomTemplate"
          :disabled="!checkedFields.length"
          :class="{ disabled: !checkedFields.length }"
        >
          <img src="/img/PlastFluids/add.svg" alt="create template" />{{
            trans("plast_fluids.create_template")
          }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { DataTableModalWidthCalculator } from "../mixins";

export default {
  name: "MonitoringDownloadTableModal",
  mixins: [DataTableModalWidthCalculator],
  computed: {
    computedCheckedFields: {
      get() {
        return this.checkedFields;
      },
      set(value) {
        this.$emit("update:checkedFields", value);
      },
    },
  },
  methods: {
    addCustomTemplate() {
      this.$emit("add-custom-template");
      this.$emit("close-modal");
    },
  },
};
</script>

<style scoped lang="scss" src="./DataTableModalStyles.scss"></style>
