<template>
  <button :class="classes">
    <Icon :width="iWidth" :height="iHeight" v-if="icon" :style="{marginRight: (icon&&$slots.default&&$slots.default.length)&&'10px'}" :name="icon" />
    <slot />
  </button>
</template>

<script>
import Icon from "../icons/Icon.vue";

export default {
  name: "Button",
  props: {
    iWidth:[String, Number],
    iHeight:[String, Number],
    align: {
      type: String,
      validator(value) {
        return ['center', 'left', 'right', ''].includes(value);
      }
    },
    color: {
      type: String,
      default: "default",
    },
    icon: {
      type: [String, null],
      default: null
    },
    size: {
      type: String
    }
  },
  components: {
    Icon
  },
  computed: {
    classes() {
      return {
        'a-btn': true,
        [this.color]: this.color,
        [this.align]: this.align,
        [this.size]: this.size,
      }
    }
  },
}
</script>
