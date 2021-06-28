<template>
  <button :class="classes">
    <Icon :width="iWidth" :height="iHeight" v-if="icon" :style="{marginRight: (icon&&$slots.default&&$slots.default.length)&&'10px'}" :name="icon" />
    <slot />
  </button>
</template>

<script>
import Icon from "../icons/Icon.vue";
import props from "./props";
import computed from "./computed";
export default {
  name: "Button",
  mixins: [props, computed],
  components: {
    Icon
  }
}
</script>
