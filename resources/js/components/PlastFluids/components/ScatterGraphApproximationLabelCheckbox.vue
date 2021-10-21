<template>
  <div class="approximation-forecast-checkbox-holder">
    <input
      type="checkbox"
      :checked="checkboxInput"
      :disabled="disableCheckbox"
      :class="{ disabled: disableCheckbox }"
      @change="$emit('update:checkboxInput', $event.target.checked)"
      :id="'approximation' + labelTransKey + graphType"
    /><label
      :for="'approximation' + labelTransKey + graphType"
      :class="{ disabledText: disableCheckbox }"
      >{{ trans("plast_fluids." + labelTransKey) }}</label
    >
  </div>
</template>

<script>
export default {
  name: "ScatterGraphApproximationLabelCheckbox",
  props: {
    labelTransKey: String,
    graphType: String,
    checkboxInput: Boolean,
    disableCheckbox: Boolean,
  },
};
</script>

<style scoped>
.approximation-forecast-checkbox-holder {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

label {
  margin-bottom: 0;
}

.approximation-forecast-checkbox-holder > input {
  margin-right: 10px;
}

.disabled {
  cursor: not-allowed;
}

.disabledText {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
