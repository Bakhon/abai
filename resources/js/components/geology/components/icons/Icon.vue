<template>
  <div class="a-svg-icons">
    <svg :width="width" :height="height" :viewBox="icons[0]" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g v-html="icons[1]" />
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

<style lang="scss" scoped>
.a-svg-icons {

}
</style>
