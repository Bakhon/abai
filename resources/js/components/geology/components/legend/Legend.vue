<template>
  <div class="legend d-flex align-items-stretch">
    <div class="title" v-if="title">
      {{title}}
    </div>
    <div class="legend__items-wrapper d-flex align-items-stretch">
      <div class="legend__item" v-for="(item, i) in items" :key="i">
        <div class="legend__circle" :style="{background: item.color}"></div>
        {{ item.name }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Legend",
  props: {
    items: Array,
    title: String
  }
}
</script>

<style scoped lang="scss">
.legend {
  border: 1px dashed var(--a-accent-300);
  font-size: 7px;

  .title, &__item {
    padding: 5px 10px;
    display: flex;
    align-items: center;
  }

  .title {
    background: var(--a-accent-300);
  }

  &__circle {
    background: #000;
    border-radius: 10em;
    height: 5px;
    width: 5px;
    margin-right: 4px;
  }
}
</style>
