<template>
  <div class="correlation-scheme">
    <div class="correlation-scheme__item" v-for="(item, idx) in 3">
      <div class="correlation-scheme__header">
        <div class="correlation-scheme__header-title">
          {{ trans('digital_rating.correlationScheme') }} {{ idx + 1 }}
        </div>
      </div>
      <div class="correlation-scheme__content">
        <img src="/img/digital-rating/scheme.svg" alt="">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Scheme"
}
</script>

<style scoped lang="scss">
.correlation-scheme {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.correlation-scheme__item {
  width: calc(33% - 2px);
  background-color: #272953;
  padding: 10px;
  margin-bottom: 10px;
}
.correlation-scheme__header {
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
.correlation-scheme__content {
  img {
    width: 100%;
  }
}
</style>
