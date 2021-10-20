<template>
  <div
    class="box"
    v-show="loading"
    :style="
      page === 'upload' ? 'background: transparent;' : 'background: #454d7d99;'
    "
  >
    <div class="cat">
      <div class="cat__body"></div>
      <div class="cat__body"></div>
      <div class="cat__tail"></div>
      <div class="cat__head"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SmallCatLoader",
  props: {
    loading: Boolean,
    page: String,
  },
};
</script>

<style scoped lang="scss" src="./SmallCatLoaderStyles.scss"></style>
