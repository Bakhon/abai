<template>
  <div class="a-svg-icons">
    <svg :width="width" :height="height" :viewBox="icons[0]" :fill="fill" xmlns="http://www.w3.org/2000/svg">
      <g :icon-name="name" v-html="icons[1]" />
    </svg>
  </div>
</template>

<script>
import iconsImport from "./iconsImport.js";

export default {
  name: "Icon",
  props: {
    width: {
      type: [String, Number],
      default: 17
    },
    height: {
      type: [String, Number],
      default: 17
    },
    name: {
      type: [String, null],
      default: null
    },
    fill: {
      type: String,
      default: "none"
    }
  },
  computed: {
    icons() {
      if (this.name && iconsImport[this.name])
        return iconsImport[this.name];
      console.error(`Пикчи ${this.name} не существует`)
      return [];
    }
  }
}
</script>
