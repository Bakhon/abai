<template>
  <div class="dropdown">
    <button @click.stop="isOpen = !isOpen">
      <span>{{ selectedValue || placeholder }}</span>
      <img src="/img/PlastFluids/backArrow.svg" />
    </button>
    <div v-show="isOpen" v-click-outside="closeDropdown">
      <button
        @click="handleSelect(item)"
        v-for="(item, index) in items"
        :key="index"
        :title="description ? item['description_' + currentLang] : ''"
      >
        {{
          isParentShortNameExist
            ? getItem(item) + " - " + parentShortName
            : getItem(item)
        }}
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
    dropKey: [Array],
    description: Boolean,
    parentShortName: String,
    dropKeyRepeat: Boolean,
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
  computed: {
    isParentShortNameExist() {
      return this.parentShortName && this.parentShortName !== "Unknown";
    },
  },
  methods: {
    getItem(item) {
      return this.dropKey.reduce((acc, current) => {
        acc += item[current] + " ";
        return acc;
      }, "");
    },
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
  height: 30px;
  position: relative;
  background: #1f2142;
  color: #fff;
  border-radius: 4px;
  margin-bottom: 6px;
}

.dropdown > button {
  width: 100%;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.dropdown > button > img {
  transform: rotate(270deg);
  width: 16px;
}

.dropdown > div {
  background: #1f2142;
  color: #fff;
  position: absolute;
  display: flex;
  flex-flow: column;
  width: 100%;
  top: calc(100% + 2px);
  left: 0;
  z-index: 2;
  max-height: 130px;
  overflow: auto;
}

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
