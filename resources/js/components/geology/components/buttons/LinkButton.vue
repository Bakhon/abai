<template>
  <a :class="getClasses" :href="$urlLink(href)">
    <AwIcon :width="iWidth" :height="iHeight" v-if="icon" :style="{marginRight: (icon&&$slots.default&&$slots.default.length)&&'10px'}" :name="icon" />
    <slot />
  </a>
</template>

<script>
import AwIcon from "../icons/AwIcon.vue";
import props from "./props";
import computed from "./computed";

export default {
  name: "LinkButton",
  mixins: [props, computed],
  components: {
    AwIcon
  },
  computed: {
    getClasses(){
      let color = (this.isActive&&this.activeColor);
      return {
        ...this.classes,
        'current-page': this.isActive,
        [this.color]: !color,
        [`active-btn__${this.activeColor}`]: color,
        [`icon-color__${this.activeColor || this.color}`]: this.activeColor || this.color
      }
    }
  }
}
</script>
