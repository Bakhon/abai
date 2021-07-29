<template>
  <div>
    <div id="map">
    </div>
  </div>
</template>

<script>

import leafMap from './leafMap';

// import kzStatesData from '../plugins/global';

export default {
  name: "OilMapKz",
  data() {
    return {
      map: null,
      // global: kzStatesData,
      province: undefined,
      currentProvince: undefined,
    }
  },
  mounted() {
    leafMap();
    // kzStatesData();
  },
  // methods: {
  //   selectProvince(province) {
  //     this.province = province;
  //   },
  //   openInfo(province) {
  //     this.currentProvince = province;
  //   },
  //   closeInfo() {
  //     this.currentProvince = undefined;
  //   },
  // },
}
</script>

<style lang="scss" scoped>
#map {
  height: 100vh;
  width: 100%;
}

.info {
  padding: 6px 8px;
  font: 14px/16px Arial, Helvetica, sans-serif;
  background: white;
  background: rgba(255, 255, 255, 0.8);
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  border-radius: 5px;
}
.info h4 {
  margin: 0 0 5px;
  color: #777;
}

.legend {
  line-height: 18px;
  color: #555;
}
.legend i {
  width: 18px;
  height: 18px;
  float: left;
  margin-right: 8px;
  opacity: 0.7;
}
</style>
