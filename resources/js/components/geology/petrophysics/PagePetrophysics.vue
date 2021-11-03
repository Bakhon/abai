<template>
  <PageLayoutGrid>
    <template #topSide>
      <topSide />
    </template>
    <template #leftSide>
      <leftSide :saveTableSettings="saveTableSetting"/>
    </template>
    <template #rightSide>
      <rightSide />
    </template>
    <template #baseSlot>
      <BaseGis ref="baseGis"/>
    </template>
  </PageLayoutGrid>
</template>

<script>
import PageLayoutGrid from "../PageLayoutGrid";
import BaseGis from "./BaseGis";
import LeftSide from "./LeftSide";
import RightSide from "./RightSide";
import TopSide from "../TopSide";

export default {
  name: "PagePetrophysics",
  components: {
    PageLayoutGrid,
    BaseGis,
    LeftSide,
    RightSide,
    TopSide
  },
  methods:{
    saveTableSetting() {
      this.$refs.baseGis.saveTableSettings();
    }
  }
}
</script>
