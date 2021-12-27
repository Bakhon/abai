<template>
  <div class="histogram h-100">
    <div class="d-flex align-items-stretch h-100">
      <LeftSide @setXData="setXData"/>
      <RightSide ref="RightSide"/>
    </div>
  </div>
</template>

<script>
import LeftSide from './components/LeftSide/LeftSide';
import RightSide from './components/RightSide';

export default {
  name: 'Canvas',

  components: {
    LeftSide,
    RightSide
  },

  methods: {

    setXData(value) {
      this.$refs.RightSide.draw(value, null);
    },
  },
}
</script>

<style scoped lang="scss">
.histogram {
  width: 100%;
  background: #272953;

  > div {
    min-height: 794px;
  }
}
</style>
