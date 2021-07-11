<template>
  <div class="aw-form__input">
    <label v-if="label" :for="getUID">{{ label }}</label>
    <input v-bind="$attrs"
           :readonly="readonly || plaintext"
           v-on="listeners" :type="type" :id="getUID" type="text"
           @input="onInput($event)"
           @change="onChange($event)"
    >
  </div>
</template>

<script>
import inputProps from "./inputProps";
import inputComputed from "./inputComputed";
import inputMethods from "./inputMethods";

export default {
  name: "AwInput",
  mixins: [inputProps, inputComputed, inputMethods],
  inheritAttrs: false,
  props: {
    type: String
  },
  data() {
    return {
      state: this.value,
      syncTimeout: null
    }
  },
}
</script>
