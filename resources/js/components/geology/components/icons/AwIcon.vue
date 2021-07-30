<template>
  <div class="a-svg-icons">
    <svg :width="width" :height="height" :viewBox="icons[0]" :fill="fill" xmlns="http://www.w3.org/2000/svg">
      <g :icon-name="name" v-html="fillColor(icons[1])" />
    </svg>
  </div>
</template>

<script>
import iconsImport from "./iconsImport.js";

export default {
  name: "AwIcon",
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
  },
  methods: {
    fillColor(str){
      str = str?.match(/%fillPlace%/g) ? str.replace(/%fillPlace%/g, this.fill) : str;
      str = str?.match(/%randomFill%/g) ? str.replaceAll(/%randomFill%/g, (log)=>`#${this.randomFill()}`) : str;
      return str;
    },
    randomFill(){
      return Math.floor(Math.random()*16777215).toString(16);
    }
  }
}
</script>
