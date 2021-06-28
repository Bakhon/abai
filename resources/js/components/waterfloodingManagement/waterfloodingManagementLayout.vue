<template>
<div class="main-wrappers">
  <water-flooding-management-main-menu></water-flooding-management-main-menu>
  <div v-bind:is="mainContent"></div>
</div>
</template>
<script>
export default {
  data: function () {
    return {
      mainContent: {
        name: "main-component",
        template: "<div><water-flooding-management-map></water-flooding-management-map></div>",
      },
    };
  },
}
</script>
<style scoped>
.main-wrappers{
  font-family: Harmonia Sans Pro Cyr;
  font-style: normal;
  color: #fff;
}
</style>