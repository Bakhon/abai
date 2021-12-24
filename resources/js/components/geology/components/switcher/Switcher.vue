<template>
  <div v-if="getItems.length" class="aw-switcher align-items-center d-flex align-items-stretch">
    <Button
        :key="key"
        v-for="(item, key) in getItems"
        :class="getClasses(item.value||item.label)"
        align="center"
        variant="for-switch"
        @click="itemClick(item.value||item.label, $event)">
      {{ item.label || item.value }}
    </Button>
  </div>
</template>

<script>
import Button from "../buttons/Button";

export default {
  name: "Switcher",
  props: {
    items: Array,
    active: [String, Array],
    multiple: Boolean
  },
  components: {
    Button
  },
  computed: {
    getItems() {
      return this.items || [];
    },
    isActive() {
      return this.active;
    },
  },
  methods: {
    getClasses(val) {
      return {
        ['flex-grow-1']: true,
        ['is-active']: this.getMultipleActive(val)
      }
    },
    getMultipleActive(val) {
      return this.isActive.includes(val);
    },
    itemClick(value) {
      let active = [];
      if (this.multiple) {
        active = JSON.parse(JSON.stringify(this.isActive));
        let index = active.indexOf(value);
        if (~index) {
          active.splice(index, 1);
        } else {
          active.push(value);
        }
      } else {
        active = value;
      }
      this.$emit("click", active);
      this.$emit("update:active", active);
    },
  }
}
</script>

<style scoped lang="scss">
.aw-switcher {
  width: 100%;
  background: var(--a-accent-50);
  padding: 2px;

  .is-active {
    background: var(--a-accent-darken-300);
    border: 1px solid var(--a-blue);
  }
}
</style>
