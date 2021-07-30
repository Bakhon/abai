<template>
  <PageLayoutGrid>
    <template #topSide>
      <topSide />
    </template>
    <template #leftSide>
      <leftSide />
    </template>
    <template #rightSide>
      <rightSide />
    </template>
    <template #baseSlot>
      <BaseGis/>
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
  }
}
</script>
