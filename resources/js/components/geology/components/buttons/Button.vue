<template>
  <button
      :class="getClasses"
      @click="!disabled?$emit('click', $event):''">
    <AwIcon
        v-if="icon&&!loading"
        :width="iWidth"
        :height="iHeight"
        :style="{marginRight: (icon&&$slots.default&&$slots.default.length)&&'10px'}"
        :name="icon" />
    <AwIcon :width="iWidth" :height="iHeight" name="loading" v-if="loading"/>
    <slot />
  </button>
</template>

<script>
import AwIcon from "../icons/AwIcon.vue";
import props from "./props";
import computed from "./computed";

export default {
  name: "Button",
  mixins: [props, computed],
  components: {
    AwIcon
  },
  computed: {
    getClasses() {
      let color = (this.isActive && this.activeColor);
      return {
        ...this.classes,
        [this.color]: !color,
        [`active-btn__${this.activeColor}`]: color,
        [`icon-color__${this.activeColor || this.color}`]: this.activeColor || this.color,
        [`variant__${this.variant}`]: this.variant,
        "disabled": this.disabled
      }
    }

  }
}
</script>
