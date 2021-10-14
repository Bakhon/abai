<template>
  <div :id="`pie_wrapper${_uid}`" class="pie-wrapper">
    <v-style v-if="radiusWidth">
      #pie_wrapper{{_uid}}{
          --radius-width: {{radiusWidth}}px;
      }
    </v-style>
    <div class="csspie" :data-value="data_value">
    </div>
    <div class="pie__info">
      <div class="well__name">{{ wellName }}</div>
      <div>92 - 70%</div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
Vue.component('v-style', {
  render: function (createElement) {
    return createElement('style', this.$slots.default)
  }
});
export default {
  props :[
    'data_value',
    'wellName',
    'radiusWidth',
    'type'
  ],
  data: function () {
    return {
      radius_width: 100
    }
  }
}
</script>
<style lang="scss" scoped>

.csspan{
  height: 100px;
  width: 100px;
  background-color: red;
}
.pie-wrapper {
  height: var(--radius-width);
  width: var(--radius-width);
  display: inline-block;
  position: relative;
  background: #1997c7;
  border-radius:calc(var(--radius-width) / 2);
}
.csspie {
  position: absolute;
  width: calc( var(--radius-width) / 2) ;
  height: var(--radius-width);
  overflow: hidden;
  transform-origin: left center;
  &:BEFORE {
    content: "";
    position: absolute;
    width: calc( var(--radius-width) / 2);
    height: var(--radius-width);
    left: calc(var(--radius-width) / 2 * (-1));
    border-radius: calc(var(--radius-width) / 2) 0 0 calc(var(--radius-width) / 2);
    transform-origin: right center;
  }
}
  .csspie:BEFORE,.csspie:AFTER {
    background-color: #e88f1a;
  }
@for $i from 1 through 99 {
  .csspie[data-value="#{$i}"]:BEFORE {
    transform: (rotate(#{$i * 3.6}deg));
    transition:All 1s ease;
  }
}
@for $i from 50 through 100 {
  .csspie[data-value="#{$i}"] {
    width: var(--radius-width);
    height: var(--radius-width);
    transform-origin: (center, center);

&:BEFORE {
   left: 0px;
 }
    &:AFTER {
              content: "";
              position: absolute;
              width: calc(var(--radius-width) / 2);
              height: var(--radius-width);
              left: calc(var(--radius-width) / 2);
              border-radius: 0 calc(var(--radius-width) / 2) calc(var(--radius-width) / 2) 0;
            }
  }
}
@for $i from 0 through 49 {
  .csspie[data-value="#{$i}"] {
    left: calc(var(--radius-width) / 2);
  }
}
.well__name{
  border-bottom: 1px solid ;
}
.pie__info{
  position: absolute;
  top: 0;
  left: 60%;
  font-weight: bold;
  //font-size: calc(var(--radius-width) / 2 );
  z-index: 1999;
  color: #000;
}
.pie-label{
  width: var(--radius-width);
  position:absolute;
  top: var(--radius-width);
  font-size: 12px;
  background-color: #666;
  color: #fff;
  text-align: center;
}
@keyframes glow {
  0% { box-shadow: 0px 0px 12px 0px rgba(255, 255, 255, 0.75); }
  50% {  box-shadow: 0px 0px 18px 0px rgba(255, 255, 255, 0.75);}
  75%{  box-shadow: 0px 0px 16px 0px rgba(255, 255, 255, 0.75);}
  100%{  box-shadow: 0px 0px 14px 0px rgba(255, 255, 255, 0.75);}
}
</style>