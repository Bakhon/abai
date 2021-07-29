<template>
  <PageLayoutGrid area-class="geophysics">
    <template #topSide>
      <TopSide />
    </template>
    <template #leftSide>
      <LeftSide />
    </template>
    <template #baseSlot>
      <BaseGeophysics />
    </template>
  </PageLayoutGrid>
</template>

<script>
import TopSide from "../TopSide";
import LeftSide from "./LeftSide";
import BaseGeophysics from "./BaseGeophysics";
import PageLayoutGrid from "../PageLayoutGrid";
export default {
  name: "PageGeophysics",
  components: {
    TopSide,
    LeftSide,
    BaseGeophysics,
    PageLayoutGrid
  }
}
</script>
