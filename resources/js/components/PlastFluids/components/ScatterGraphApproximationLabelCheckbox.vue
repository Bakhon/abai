<template>
  <div class="approximation-forecast-checkbox-holder">
    <input
      type="checkbox"
      :checked="checkboxInput"
      @change="$emit('update:checkboxInput', $event.target.checked)"
      :id="'approximation' + labelTransKey + graphType"
    /><label :for="'approximation' + labelTransKey + graphType">{{
      trans("plast_fluids." + labelTransKey)
    }}</label>
  </div>
</template>

<script>
export default {
  name: "ScatterGraphApproximationLabelCheckbox",
  props: {
    labelTransKey: String,
    graphType: String,
    checkboxInput: Boolean,
  },
};
</script>

<style scoped>
.approximation-forecast-checkbox-holder {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.approximation-forecast-checkbox-holder:last-child {
  margin-bottom: 0;
}

.approximation-forecast-checkbox-holder > input {
  margin-right: 10px;
}
</style>
