<template>
  <div :class="['content-main', { marginBottom: showCheckbox }]">
    <input class="checkbox" type="checkbox" v-if="showCheckbox" />
    <input
      type="number"
      v-model="computedInputData"
      :id="'approximation-' + labelTransKey"
    />
    <label :for="'approximation-' + labelTransKey">{{
      trans(`plast_fluids.${labelTransKey}`)
    }}</label>
  </div>
</template>

<script>
export default {
  name: "SearchForFluidsInput",
  computed: {
    computedInputData: {
      get() {
        return this.inputData;
      },
      set(value) {
        this.$emit("update:inputData", Number(value));
      },
    },
  },
  props: {
    showCheckbox: Boolean,
    labelTransKey: String,
    inputData: Number,
  },
};
</script>

<style scoped>
.content-main {
  width: 100%;
  padding: 5px 8px;
  display: flex;
  align-items: center;
}

.checkbox {
  margin-right: 8px;
}

.marginBottom {
  margin-bottom: 9px;
}

.marginBottom:last-child {
  margin-bottom: 0;
}

input[type="number"] {
  background: rgba(31, 33, 66, 0.4);
  border: 0.5px solid #454fa1;
  border-radius: 2px;
  padding: 3px 4px;
  width: 48px;
  margin-right: 6px;
  color: #fff;
  -moz-appearance: textfield; /* Firefox */
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

label {
  font-size: 12px;
  color: #fff;
  margin: 0;
}
</style>
