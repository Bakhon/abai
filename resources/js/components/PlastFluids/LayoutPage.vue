<template>
  <LayoutPage>
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
  </LayoutPage>
</template>

<script>
import PageLayoutGrid from "../LayoutPage";
import BaseGis from "./BaseGis";
import LeftSide from "./LeftSide";
import RightSide from "./RightSide";
import TopSide from "../TopSide";

export default {
  name: "PagePetrophysics",
  components: {
    LayoutPage,
    BaseGis,
    LeftSide,
    RightSide,
    TopSide
  }
}
</script>
