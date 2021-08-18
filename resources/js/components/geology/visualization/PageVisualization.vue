<template>
  <PageLayoutGrid area-class="page-2d3d">
    <template #topSide>
      <TopSide />
    </template>
    <template #leftSide>
      <LeftSide />
    </template>
    <template #baseSlot>
      <BaseVisualization />
    </template>
  </PageLayoutGrid>
</template>

<script>
import TopSide from "../TopSide";
import BaseVisualization from "./BaseVisualization";
import LeftSide from "./LeftSide";
import PageLayoutGrid from "../PageLayoutGrid";

export default {
  name: "PageVisualization",
  components: {
    TopSide,
    BaseVisualization,
    LeftSide,
    PageLayoutGrid
  }
}
</script>
