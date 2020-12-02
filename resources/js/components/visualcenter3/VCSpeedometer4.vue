<template>
<div class="round-slider">
<round-slider
  v-model="sliderValue"
  start-angle="0"
  end-angle="+180"
  line-cap="round"
  radius="80"
  :rangeColor="rangeColor"
  readOnly="true"
  sliderType="range"
  pathColor="#323370"
  width="15"
  
/>
</div>
</template>

<script>
import RoundSlider from 'vue-round-slider';

Vue.component("roundslider", RoundSlider);
export default {
 // name: "mix-chart",
  data: function () {
    return {
   sliderValue: [35 , 65],
   rangeColor:"#237deb",

    };
  },
};
</script>
