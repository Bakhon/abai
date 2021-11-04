<template>
  <div class="dropdown btn-dropdown">
    <div class="btn-dropdown__header dropdown-toggle" data-toggle="dropdown">
      <slot name="icon"/>
      <div class="btn-dropdown__title">
        <slot name="title"/>
      </div>
      <div class="btn-dropdown__icon"/>
    </div>
    <div class="dropdown-menu btn-dropdown__area" role="menu" aria-labelledby="dLabel">
      <slot v-if="$slots.default"></slot>
      <ul v-else class="btn-dropdown__area-list">
        <li v-for="(item, index) in list" :key="index" @click="$emit('select', item)">
          <i :class="`fas fa-${item.icon}`"/>
          <span>{{ item.title ? trans(item.title) : trans(item) }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "BtnDropdown",

  props: {
    list: [],
  }
}
</script>

<style scoped lang="scss">
.dropdown-toggle::after {
  display:none;
}
</style>
