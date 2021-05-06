<template>
  <div class="row">
    <div class="col">
      <div class="left-section bg-dark">
        <section class="">
          LEFT MENU
        </section>
      </div>
    </div>
    <div class="section-main">
      <div class="col">
        <div class="row">
          <section class="section-top  bg-dark">Right TOP</section>
        </div>
      </div>
      <div class="col">
        <div class="row">
          <section class="section-content bg-dark">
            RIGHT MAIN
          </section>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
body {
  color: white;
}

.left-section {
  width: 441px;
}

.section-main {
  width: -webkit-fill-available;
  max-width: calc(100% - 500px);

  .section-top {
    display: table-cell;
  }

  .section-content {
    display: table-cell;
  }
}

.row {
  display: flex;
  color: white;
}

</style>

