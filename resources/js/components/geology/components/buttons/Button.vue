<template>
  <button :class="getClasses">
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
  },
  computed:{
    getClasses(){
      let color = (this.isActive&&this.activeColor);
      return {
        ...this.classes,
        [this.color]: !color,
        [`active-btn__${this.activeColor}`]: color,
        [`icon-color__${this.activeColor || this.color}`]: this.activeColor || this.color
      }
    }

  }
}
</script>
