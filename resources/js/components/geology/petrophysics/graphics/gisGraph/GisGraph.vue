<template>
  <GisGraphItem/>
</template>

<script>
import GisGraphItem from "./GisGraphItem";
export default {
  name: "GisGraph",
  components: {
    GisGraphItem
  },
  props: {
    graphData: {
      type: Array,
      required: true
    }
  },
}
</script>

<style scoped>

</style>
