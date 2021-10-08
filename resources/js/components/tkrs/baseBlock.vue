<template>
  <div class="data-analysis-left-block">
    <div class="left-block-collapse-holder">
      <div>
        <img
          src="/img/PlastFluids/chooseParameters.svg"
          alt="choose parameters icon"
        />
        <span>Параметры</span>
      </div>
    </div>
    <div class="dropdown-holder">
      
      
      
    </div>
    
  </div>
</template>

<script>

import { mapState, mapMutations, mapActions } from "vuex";


export default {
  name: "baseBlock",
  components: {

  },

  computed: {
    ...mapState("plastFluids", [
      "currentSubsoil",
      "subsoilFields",
      "currentSubsoilField",
      "subsoilHorizons",
      "currentSubsoilHorizon",
    ]),
  },
  methods: {
    ...mapActions("plastFluidsLocal", [
      "handleTableData",
      "handleTableGraphData",
    ]),
    ...mapActions("plastFluids", ["UPDATE_CURRENT_SUBSOIL_FIELD"]),
    ...mapMutations("plastFluids", ["SET_CURRENT_SUBSOIL_HORIZON"]),
    updateCurrentSubsoilField(value) {
      this.UPDATE_CURRENT_SUBSOIL_FIELD(value);
      this.handleTableGraphData({ field_id: value.field_id });
    },
    updateCurrentHorizon(value) {
      this.SET_CURRENT_SUBSOIL_HORIZON(value);
    },
  },
};
</script>

<style scoped>
.data-analysis-left-block {
  width: 300px;
  flex-shrink: 0;
  display: flex;
  flex-flow: column;
  height: 799px;
  background: #272953;
  color: #fff;
}

.left-block-collapse-holder {
  display: flex;
  width: 100%;
  height: 42px;
  background-color: #323370;
}

.left-block-collapse-holder > div {
  display: flex;
  height: 100%;
  width: calc(100% - 29px);
  align-items: center;
  background-color: #323370;
}

.left-block-collapse-holder > div > img {
  margin: 0 8px 0 10px;
}

.collapse-left__sidebar {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 29px;
  background: var(--a-accent);
  padding: 14px 6px;
  border-radius: 10px 0 0 10px;
  border: none;
  border-left: 5px solid #272953;
}

.dropdown-holder {
  background-color: rgba(255, 255, 255, 0.04);
  width: 100%;
  padding: 6px 6px 1px 6px;
  margin-bottom: 10px;
}
</style>