<template>
  <div class="tool-block__group">
    <slot/>
  </div>
</template>

<script>
export default {
  name: "ToolBlockGroup"
}
</script>

<style scoped lang="scss">
.tool-block__group {
  border: 1px solid var(--a-accent-300);
  .tool-block{
    border: none;
    &:not(&:last-child){
      border-bottom: 1px solid var(--a-accent-300);
    }
  }
}
</style>
