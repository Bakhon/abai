<template>
  <div class="checkbox-dropdown" v-click-outside="closeDropdown">
    <button @click.stop="isOpen = !isOpen">
      <span>{{ placeholder }}</span>
      <img src="/img/PlastFluids/backArrow.svg" />
    </button>
    <div v-show="isOpen">
      <div v-for="item in items" :key="item[dropKey]">
        <input
          type="checkbox"
          :value="item"
          v-model="selectedItems"
          :id="item[dropKey]"
        />
        <label :for="item[dropKey]">{{ item[labelKeyName] }}</label>
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
    labelKeyName: String,
    selected: Array,
  },
  data() {
    return {
      isOpen: false,
    };
  },
  computed: {
    selectedItems: {
      get() {
        return this.selected;
      },
      set(value) {
        this.$emit("update:selected", value);
      },
    },
  },
  methods: {
    closeDropdown() {
      this.isOpen = false;
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
