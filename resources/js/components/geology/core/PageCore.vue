<template>
  <PageLayoutGrid area-class="core">
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
      <BaseCore/>
    </template>
  </PageLayoutGrid>
</template>

<script>
import TopSide from "../TopSide";
import BaseCore from "./BaseCore";
import LeftSide from "./LeftSide";
import RightSide from "./RightSide";
import PageLayoutGrid from "../PageLayoutGrid";
export default {
  name: "PageCore",
  components: {
    TopSide,
    BaseCore,
    LeftSide,
    RightSide,
    PageLayoutGrid
  }
}
</script>
