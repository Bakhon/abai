<template>
  <div class="row proactive-factors-page-container">
    <div class="col-10 middle-block-columns">
      <div class="col px-2 container-col_color">
      </div>
    </div>
    <div class="col-2 px-2 middle-block-columns">
      <div class="col px-2">
        <div class="col container-col_color">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterFactor"
          ></proactive-factors-select-filter>
        </div>
        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterCompany"
          ></proactive-factors-select-filter>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import selectFilterFactor from "./selectFilterData/selectFilterFactor.json";
import selectFilterCompany from "./selectFilterData/selectFilterCompany.json";
export default {
  data: function () {
    return {
    filterClass: 'col container-col_color mt-2',
    selectFilterFactor: selectFilterFactor,
    selectFilterCompany: selectFilterCompany,
    };
  },
};
</script>
