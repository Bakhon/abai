<template>
  <div class="main col-md-12 col-lg-12 row">
    <div class="tables-one col-xs-12 col-sm-5 col-md-5 col-lg-2 col-xl-2">
      <div class="tables-string-gno col-12"><monitor-chart-bar></monitor-chart-bar></div>

      <div class="tables-string-gno col-12"></div>

      <div class="tables-string-gno col-12"><monitor-chart-donut></monitor-chart-donut></div>

      <div class="tables-string-gno col-12"></div>
    </div>

    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-8 col-xl-8">
      <div class="tables-string-gno3">
      <div class="schema"></div>
      </div>
    </div>

  <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-2 col-xl-2">
      <div class="tables-string-gno4"></div>
       <div class="tables-string-gno5"></div>
    </div>
    

  </div>
</template>

<script>
import { EventBus } from "../../event-bus.js";
export default {
  data: function () {
    return {};
  },

  methods: {
    getLinePoints: function () {
      let uri = "/js/json/gno/line_points.json";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          this.$emit("data", data);
        } else {
          console.log("No data");
        }
      });
    },
  },
  async mounted() {
    this.getLinePoints();
  },
};
</script>
