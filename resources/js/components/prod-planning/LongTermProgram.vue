<template>
  <div class="d-flex main-block pt-2 pb-2">
    <div class="left-block d-flex flex-dir-column">
      <prod-plan-sidebar :activatedBlocks="activatedBlocks"/>
    </div>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      activatedBlocks: {
        isIndexActive: true,
        isSearchWell: true,
        isIndicatorActive: true,
        isSearchWellButton: false
      },
    }
  }
}
</script>