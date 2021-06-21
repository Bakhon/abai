<template>
  <div class="tool-block__group-divider d-flex align-items-stretch">
    <div class="tool-block__group-divider__content">
      <slot/>
    </div>
    <div v-if="$scopedSlots['right-side']" class="tool-block__group-divider__right-side">
      <slot name="right-side" />
    </div>
  </div>
</template>

<script>
export default {
  name: "ToolBlockGroupDivider"
}
</script>

<style scoped lang="scss">
.tool-block__group-divider{
  background: var(--a-accent-400);
  border-top: 1px solid var(--a-accent-300);
  border-bottom: 1px solid var(--a-accent-300);
  font-size: 14px;
  color: #ffffff;

  &__content{
    width: 100%;
    padding: 7px 12px;
  }
  &__right-side{
    padding: 10px 5px;
    min-width: 40px;
  }
}
</style>
