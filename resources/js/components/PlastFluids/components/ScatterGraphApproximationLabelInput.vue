<template>
  <div class="approximation-forecast-space-input">
    <label :for="'approximation-' + labelTransKey">{{
      trans(`plast_fluids.${labelTransKey}`)
    }}</label
    ><input
      type="number"
      step="0.1"
      :id="'approximation-' + labelTransKey"
      placeholder="0,0"
      :value="inputText"
      @input="$emit('update:inputText', $event.target.value)"
    />
  </div>
</template>

<script>
export default {
  name: "ScatterGraphApproximationLabelInput",
  props: {
    labelTransKey: String,
    inputText: String,
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

.approximation-forecast-space-input > input {
  font-size: 14px;
  background-color: #1f2142;
  color: #a5a6b3;
  padding: 3px 10px;
  border: 0.5px solid #454fa1;
  border-radius: 4px;
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
