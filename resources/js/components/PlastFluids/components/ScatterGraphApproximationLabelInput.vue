<template>
  <div class="approximation-forecast-space-input">
    <label :for="'approximation-' + labelTransKey + graphType">{{
      trans(`plast_fluids.${labelTransKey}`)
    }}</label
    ><input
      type="number"
      step="0.1"
      :id="'approximation-' + labelTransKey + graphType"
      placeholder="0,0"
      v-model="computedInputText"
      :style="isAxisInput ? 'width: 70px;' : ''"
    />
    <template v-if="isAxisInput">
      <div class="button-holder">
        <button v-if="!inputText" @click="computedInputText = initialValue">
          {{ trans("plast_fluids.auto") }}
        </button>
        <button v-else @click="computedInputText = ''">
          <img src="/img/PlastFluids/close.svg" alt="reset" /><span>{{
            trans("plast_fluids.reset")
          }}</span>
        </button>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: "ScatterGraphApproximationLabelInput",
  props: {
    labelTransKey: String,
    graphType: String,
    inputText: [String, Number],
    isAxisInput: Boolean,
    initialValue: [String, Number],
  },
  computed: {
    computedInputText: {
      get() {
        return this.inputText;
      },
      set(value) {
        this.$emit("update:inputText", value);
      },
    },
  },
};
</script>

<style scoped>
.approximation-forecast-space-input {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 6px;
}

.approximation-forecast-space-input > label {
  width: 75px;
}

.approximation-forecast-space-input > input {
  font-size: 14px;
  background-color: #1f2142;
  color: #a5a6b3;
  padding: 3px 10px;
  border: 0.5px solid #454fa1;
  border-radius: 4px;
}

.button-holder {
  width: 125px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.button-holder > button {
  background: #333975;
  border: 0.5px solid #454fa1;
  border-radius: 4px;
  padding: 5px 11px;
  color: #fff;
}

.button-holder > button > img {
  width: 12px;
  height: 12px;
}

.button-holder > button > span {
  font-size: 12px;
  color: #fff;
  margin-left: 8px;
}

.approximation-forecast-space-input > input::-webkit-outer-spin-button,
.approximation-forecast-space-input > input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.approximation-forecast-space-input > input[type="number"] {
  -moz-appearance: textfield;
}
</style>
