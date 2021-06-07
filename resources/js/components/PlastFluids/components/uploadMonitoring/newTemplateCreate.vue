<template>
  <div class="wrapper">
    <div class="text">
      {{ creating_new_download_templates }}
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      creating_new_download_templates: this.trans(
        "plast_fluids.creating_new_download_templates"
      ),
    };
  },
};
</script>

<style scoped>
.wrapper {
  height: 40px;
  width: 910px;
  border-radius: 4px;
  background: #2E50E9;

}
.text {
  font-family: "Harmonia Sans Pro Cyr", sans-serif;
  font-size: 16px;
  color: white;
}
</style>
