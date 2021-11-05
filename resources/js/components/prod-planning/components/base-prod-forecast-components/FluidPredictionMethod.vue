<template>
  <div class="fluid-main-block">
    <div class="fluid-body-block">
      <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
        <div>
          Прогноз добычи методом материального баланса
        </div>
        <div class="d-flex">
          <div class="pr-3 pb-1">
            <img src="/img/GTM/download.svg" alt="">
          </div>
          <div class="pr-3 pb-1">
            <img src="/img/GTM/full-screen.svg" alt="">
          </div>
        </div>
      </div>
      <div class="fluid-block">
        <div class="fluid-chart">

        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {}
</script>
<style scoped>
.fluid-body-block {
  background-color: #0c2e5a;
  width: 100%;
  height: 100%;
}

.fluid-main-block {
  width: 100%;
  height: 100%;
}

.fluid-block {
  background-color: #363B68;
  border: 1px solid #545580;
  width: 100%;
  height: 95%;
  padding: 6px;
}

.fluid-chart {
  width: 100%;
  height: 100%;
  background: #1A214A;
}

.block-header {
  height: 5%;
  background-color: #323370;
}
</style>