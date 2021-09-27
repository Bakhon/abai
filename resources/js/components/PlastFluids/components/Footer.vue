<template>
  <div class="plast-fluids-footer">
    <div class="footer-block">
      <img src="/img/digital-drilling/foot5.svg" alt="" />
      <p>
        {{ trans("plast_fluids.actual_oil_pipeline") }}
      </p>
    </div>
    <div class="footer-block">
      <img src="/img/digital-drilling/foot6.svg" alt="" />
      <p>
        {{ trans("plast_fluids.actual_gas_pipeline") }}
      </p>
    </div>
    <div class="footer-block">
      <img src="/img/PlastFluids/constructionGas.svg" alt="" />
      <p>
        {{ trans("plast_fluids.construction_gas_pipeline") }}
      </p>
    </div>
    <div class="footer-double-icon-block">
      <div>
        <img src="/img/PlastFluids/oilExploration.svg" alt="" />
        <img src="/img/digital-drilling/foot2.svg" alt="" />
      </div>
      <p>
        {{ trans("plast_fluids.exploration_and_production") }}
      </p>
    </div>
    <div class="footer-block">
      <img src="/img/PlastFluids/processing.svg" alt="" />
      <p>
        {{ trans("plast_fluids.processing") }}
      </p>
    </div>
    <div class="footer-block">
      <img src="/img/PlastFluids/factories.svg" alt="" />
      <p>
        {{ trans("plast_fluids.subsidiaries_affiliates_factories") }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Footer",
};
</script>

<style scoped>
.plast-fluids-footer {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(115px, 1fr));
  height: 45px;
  width: 100%;
  background-color: #1c1f4d;
}

.plast-fluids-footer > div {
  display: flex;
  justify-content: center;
  align-items: center;
}

.plast-fluids-footer > div > p {
  margin: 0 0 0 10px;
  color: rgba(255, 255, 255, 0.5);
}

img {
  width: 20px;
  height: 20px;
}

.footer-double-icon-block > div {
  display: flex;
  align-items: center;
}

.footer-double-icon-block > div > img:last-child {
  margin-left: 10px;
}
</style>
