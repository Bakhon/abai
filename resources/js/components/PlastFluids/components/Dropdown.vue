<template>
  <div class="dropdown">
    <button @click.stop="isOpen = !isOpen">
      <span>{{ selectedValue || placeholder }}</span>
      <img src="/img/PlastFluids/backArrow.svg" />
    </button>
    <div v-show="isOpen" v-click-outside="closeDropdown">
      <button
        @click="handleSelect(item)"
        v-for="item in items"
        :key="item[dropKey]"
      >
        {{ item[dropKey] }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Dropdown",
  props: {
    items: Array,
    placeholder: String,
    dropKey: String,
    selectedValue: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      isOpen: false,
    };
  },
  methods: {
    closeDropdown() {
      this.isOpen = false;
    },
    handleSelect(item) {
      this.closeDropdown();
      this.$emit("dropdown-select", item);
    },
  },
};
</script>

<style scoped>
button {
  background-color: inherit;
  color: inherit;
  border: none;
  padding: 7px 14px;
}

.dropdown {
  display: flex;
  width: 100%;
  position: relative;
  background: #1f2142;
  color: #fff;
  border-radius: 4px;
  margin-bottom: 6px;
}

.dropdown > button {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.dropdown > button > img {
  transform: rotate(270deg);
}

.dropdown > div {
  background: #1f2142;
  color: #fff;
  position: absolute;
  display: flex;
  flex-flow: column;
  width: 100%;
  top: 100%;
  left: 0;
  z-index: 2;
}
</style>
