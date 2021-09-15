<template>
  <div class="checkbox-dropdown">
    <button @click.stop="isOpen = !isOpen">
      <span>{{ placeholder }}</span>
      <img src="/img/PlastFluids/backArrow.svg" />
    </button>
    <div v-show="isOpen" v-click-outside="closeDropdown">
      <div v-for="item in items" :key="item[dropKey]">
        <input
          type="checkbox"
          :value="item"
          v-model="selectedItems"
          @click="handleSelect"
          :id="item[dropKey]"
        />
        <label :for="item[dropKey]">{{ item[dropKey] }}</label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CheckboxDropdown",
  props: {
    items: Array,
    placeholder: String,
    dropKey: String,
  },
  data() {
    return {
      isOpen: false,
      selectedItems: [],
    };
  },
  methods: {
    closeDropdown() {
      this.isOpen = false;
    },
    handleSelect() {
      this.$emit("dropdown-select", this.selectedItems);
    },
  },
};
</script>

<style scoped>
.checkbox-dropdown {
  display: flex;
  width: 100%;
  height: 30px;
  position: relative;
  background: #1f2142;
  color: #fff;
  border-radius: 4px;
  margin-bottom: 6px;
}

.checkbox-dropdown > button {
  width: 100%;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: inherit;
  color: inherit;
  border: none;
  padding: 7px 14px;
}

.checkbox-dropdown > button > img {
  transform: rotate(270deg);
  width: 16px;
}

.checkbox-dropdown > div {
  background: #1f2142;
  color: #fff;
  position: absolute;
  display: flex;
  flex-flow: column;
  width: 100%;
  top: calc(100% + 2px);
  left: 0;
  z-index: 2;
}

.checkbox-dropdown > div > div {
  padding: 7px 14px;
}

label {
  margin: 0;
}
</style>
