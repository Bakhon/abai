<template>
  <div class="tool-block">
    <div class="tool-block__header" v-if="$scopedSlots['header']||title">
      <slot name="header">
        <h5>{{ title }}</h5>
      </slot>
    </div>
    <div v-if="$scopedSlots['under-header']" class="tool-block__header-under">
      <slot name="under-header" />
    </div>
    <div class="tool-block__body">
      <div class="tool-block__body__content customScroll">
        <slot />
      </div>
      <div v-if="$scopedSlots['tools-btn']" class="tool-block__body__tool-buttons customScroll">
        <slot name="tools-btn" />
      </div>
    </div>
    <div v-if="$scopedSlots['tools-footer']" class="tool-block__footer">
      <slot name="tools-footer"/>
    </div>
  </div>
</template>

<script>
export default {
  name: "ToolBlock",
  props: {
    title: [String, Number]
  },
}
</script>

<style scoped lang="scss">
.tool-block {
  border: 1px solid var(--a-accent-300);
  &__header {
    border-bottom: 1px solid var(--a-accent-300);
    background: var(--a-accent-darken-100);
    padding: 7px 12px;
    h5{
      font-size: 14px;
      line-height: 16px;
      font-weight: 400;
      color: #ffffff;
      margin: 0;
    }
    &-under{
      font-size: 12px;
      padding: 8px 12px;
      background: var(--a-accent-300);
      color: #ffffff;
    }
  }

  &__body {
    display: flex;
    width: 100%;

    &__content {
      background: var(--a-accent-darken-200);
      overflow-y: auto;
      width: 100%;
    }

    &__tool-buttons {
      min-width: 40px;
      background: #000;
      background: var(--a-accent-darken-100);
      border-left: 1px solid var(--a-accent-300);
      padding: 10px 5px;
    }
  }

  &__footer{
    background: var(--a-accent-darken-100);
    padding: 10px 7px;
    color: #ffffff;
  }

}
</style>
