<template>
  <div class="aw-form__input">
    <label v-if="label" :for="getUID">{{ label }}</label>
    <textarea
        v-bind="$attrs"
        :readonly="readonly || plaintext"
        v-on="listeners"
        @input="onInput($event)"
        @change="onChange($event)"
        :id="getUID" type="text" ></textarea>
  </div>
</template>
<script>
import inputProps from "./inputProps";
import inputComputed from "./inputComputed";
import inputMethods from "./inputMethods";

export default {
  name: "AwTextarea",
  mixins: [inputProps, inputComputed, inputMethods],
  inheritAttrs: false,
  data() {
    return {
      state: this.value,
      syncTimeout: null
    }
  },
}
</script>
