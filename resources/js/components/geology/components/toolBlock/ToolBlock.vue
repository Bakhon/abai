<template>
  <div :class="getClasses">
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
      <slot name="tools-footer" />
    </div>
  </div>
</template>

<script>
export default {
  name: "ToolBlock",
  props: {
    title: [String, Number],
    color: String
  },
  computed:{
    getClasses() {
      return {
        ['tool-block']: true,
        [this.color]: true
      };
    }
  }
}
</script>

<style scoped lang="scss">

.tool-block {
  border: 1px solid var(--a-accent-300);
  background: var(--a-accent-darken-200);

  &__header {
    border-bottom: 1px solid var(--a-accent-300);
    background: var(--a-accent-darken-100);
    padding: 7px 12px;

    h5 {
      font-size: 14px;
      line-height: 16px;
      font-weight: 400;
      color: #ffffff;
      margin: 0;
    }

    &-under {
      font-size: 12px;
      padding: 8px 12px;
      background: var(--a-accent-300);
      color: #ffffff;
    }

    & + .tool-block__body {
      height: calc(100% - 31px);
    }
  }

  &__body {
    display: flex;
    width: 100%;
    height: 100%;
    position: relative;
    &__content {
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

  &__footer {
    background: var(--a-accent-darken-100);
    padding: 10px 7px;
    color: #ffffff;
  }

  $parent: &;
  &.danger{
    #{$parent}__header{
      background: var(--a-danger);
    }
    #{$parent}__body{
      background: #dcbaba;
      color: var(--a-danger);
      font-size: 13px;
    }
  }
  &.warning{
    #{$parent}__header{
      background: #ffcc00;
      h5{
        color: #323232;
      }
    }
    #{$parent}__body{
      background: #fff2c0;
      color: #323232;
      font-size: 13px;
    }
  }
}
</style>
