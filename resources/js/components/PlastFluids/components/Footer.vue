<template>
  <div class="plast-fluids-footer">
    <div class="footer-block">
      <img class="flat" src="/img/digital-drilling/foot5.svg" alt="" />
      <p>
        Граница государства
      </p>
    </div>
    <div class="footer-block">
      <img class="flat" src="/img/digital-drilling/foot6.svg" alt="" />
      <p>
        Границы нефтегазосносных НГП
      </p>
    </div>
    <div class="footer-double-icon-block">
      <div>
        <img class="flat" src="/img/digital-drilling/foot6.svg" alt="" />
        <img class="shaped" src="/img/digital-drilling/foot2.svg" alt="" />
      </div>
      <p>
        Границы месторождении
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
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  height: 45px;
  width: 100%;
  background-color: #1C1F4D;
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

.footer-double-icon-block > div {
  display: flex;
  align-items: center;
}

.footer-double-icon-block > div > img:last-child {
  margin-left: 10px;
}

.flat {
  width: 35px;
  height: 10px;
}

.shaped {
  width: 25px;
  height: 25px;
}
</style>
