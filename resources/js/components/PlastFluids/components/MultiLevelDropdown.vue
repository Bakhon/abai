<template>
  <div v-click-outside="closeDropdown" class="multi-level-dropdown">
    <button
      :style="[
        { 'justify-content': item.justify ? item.justify : '' },
        cssVars,
      ]"
      @click="toggle(), routeTo()"
    >
      <img class="custom-img" v-if="item.imagePath" :src="item.imagePath" />
      <span>{{ item.name }}</span>
      <img
        class="arrow-img"
        src="/img/PlastFluids/backArrow.svg"
        v-if="item.showArrow"
      />
    </button>
    <div v-show="isOpen" v-if="hasChild" :class="item.position">
      <MultiLevelDropdown
        v-for="(child, index) in item.children"
        :key="index"
        :item="child"
        :hover="hover"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: "MultiLevelDropdown",
  props: {
    item: Object,
    ind: Number,
    hover: String,
  },
  data() {
    return {
      isOpen: false,
    };
  },
  computed: {
    hasChild() {
      return this.item.children && this.item.children.length;
    },
    cssVars() {
      return {
        "--bg-color": this.hover,
      };
    },
  },
  methods: {
    closeDropdown() {
      this.isOpen = false;
    },
    toggle() {
      this.isOpen = !this.isOpen;
    },
    routeTo() {
      if (this.item.url) {
        const { reload, pathname, origin } = location;
        if (this.localeUrl(this.item.url) === pathname) {
          reload();
          return;
        }
        location.href = origin + this.localeUrl(this.item.url);
      }
    },
  },
};
</script>

<style scoped>
.multi-level-dropdown {
  display: flex;
  height: 30px;
  position: relative;
  background: #1f2142;
  color: #fff;
  border-radius: 4px;
  margin-bottom: 6px;
}

.multi-level-dropdown > button {
  width: 100%;
  border-radius: 4px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: inherit;
  color: inherit;
  border: none;
  padding: 7px 14px;
}

.multi-level-dropdown > button:hover {
  background-color: var(--bg-color);
  transition: 0.5s ease;
}

.custom-img {
  width: 16px;
  margin-right: 8px;
}

.arrow-img {
  transform: rotate(270deg);
  position: absolute;
  right: 12px;
  width: 16px;
}

.multi-level-dropdown > div {
  background: #1f2142;
  color: #fff;
  position: absolute;
  display: flex;
  flex-flow: column;
  width: 100%;
  z-index: 2;
}

.top {
  bottom: calc(100% + 2px);
}

.bottom {
  top: calc(100% + 2px);
}

.right {
  left: calc(100% + 2px);
}

.left {
  right: calc(100% + 2px);
}
</style>
