<template>
  <div class="dropdown btn-dropdown mr-10px">
    <div class="btn-dropdown__header dropdown-toggle" data-toggle="dropdown">
      <slot name="icon"/>
      <div class="btn-dropdown__title">
        <slot name="title"/>
      </div>
      <div class="btn-dropdown__icon"/>
    </div>
    <div class="dropdown-menu btn-dropdown__area">
      <ul class="btn-dropdown__area-list">
        <li v-for="(item, index) in list" :key="index">
          <i :class="`fas fa-${item.icon}`"></i>
          <span>{{ trans(item.title) }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "BtnDropdown",

  props: {
    list: Array,
  }
}
</script>

<style scoped lang="scss">
.dropdown-toggle::after {
  display:none;
}
</style>
