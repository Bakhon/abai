<template>
  <div class="box" v-show="loading">
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
  },
};
</script>

<style scoped lang="scss" src="./SmallCatLoaderStyles.scss"></style>
