<template>
  <div class="wrapper">
    <div class="text">
      {{ downloads_monitoring }}
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      downloads_monitoring: this.trans("plast_fluids.downloads_monitoring"),
    };
  },
};
</script>

<style scoped>
.wrapper {
  height: 40px;
  width: 910px;
  border-radius: 4px;
  background: #333975;
}
.text {
  font-family: "Harmonia Sans Pro Cyr", sans-serif;
  font-size: 16px;
  color: white;
}
</style>
