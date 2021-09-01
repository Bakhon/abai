<template>
  <div class="cross-plot h-100">
    <div class="d-flex align-items-stretch h-100">
      <div class="cross-plot__left-panel customScroll">

      </div>
      <div class="cross-plot__content">

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CrossPlot"
}
</script>

<style scoped lang="scss">
.cross-plot {
  width: 100%;
  > div {
    min-height: 512px;
  }
  &__left-panel{
    background: var(--a-accent-400);
    padding: 10px;
    min-width: 472px;
  }
  &__content{
    background: var(--a-accent-darken-200);
    width: 100%;
  }
}
</style>
