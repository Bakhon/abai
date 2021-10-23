<template>
  <div class="plast-fluids-footer">
    <div class="footer-block" v-for="(province, index) in provinces" :key="index">
      <div class="footer-icon" :style="'background-color: ' + province.color"></div>
      <p>
        {{ trans(`plast_fluids.${province.name}`) }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Footer",
  data() {
    return {
      provinces: [
        { color: "#5970A8", name: "caspian_ngp" },
        { color: "#804C6B", name: "mangistau_ngp" },
        { color: "#895D5D", name: "central_ngp" },
        { color: "#487B65", name: "west_ngp" },
        { color: "#938364", name: "east_ngp" },
      ],
    };
  },
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

.footer-icon {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 1px solid #7581C5;
}
</style>
