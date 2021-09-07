<template>
  <div class="data-analysis-dropdown" :class="{ 'is-active': isOpen }">
    <div class="data-analysis-dropdown__header" @click="handleToggle">
      <div class="data-analysis-dropdown__title">
        {{ trans(title) }}
      </div>
      <div v-if="!hideIcon" class="data-analysis-dropdown__icon" />
    </div>
    <transition-expand duration="100">
      <div v-show="isOpen" class="data-analysis-dropdown__body">
        <slot name="list"></slot>
      </div>
    </transition-expand>
  </div>
</template>

<script>
import { TransitionExpand } from "vue-transition-expand";

export default {
  name: "Dropdown",

  props: {
    list: Array,
    title: String,
    hideIcon: Boolean,
  },

  components: {
    TransitionExpand,
  },

  data() {
    return {
      isOpen: true,
    };
  },

  methods: {
    handleToggle() {
      this.isOpen = !this.isOpen;
    },
  },
};
</script>

<style scoped lang="scss">
.data-analysis-dropdown {
  margin-bottom: 10px;

  &__icon {
    display: block;
    position: absolute;
    top: 0;
    right: 1.25rem;
    bottom: 0;
    margin: auto;
    width: 8px;
    height: 8px;
    border-right: 2px solid #fff;
    border-bottom: 2px solid #fff;
    transform: translateY(-2px) rotate(45deg);
    transition: transform 0.2s ease;
  }

  &.is-active {
    .data-analysis-dropdown__header {
    }
    .data-analysis-dropdown__icon {
      transform: translateY(2px) rotate(225deg);
    }
  }

  &__header {
    position: relative;
    padding: 8px 10px;
    background: #1f2142;
    border: 1px solid #454fa1;
    cursor: pointer;
    border-radius: 4px;
    margin-bottom: 4px;
  }

  &__body {
    background: #1f2142;
    border-radius: 2px;
    padding: 8px;
    height: auto;
    overflow: auto;

    .list {
      list-style: none;
      margin-bottom: 0;

      li {
        padding: 4px 6px;
        cursor: pointer;
      }
    }
  }
}

.expand-enter-active,
.expand-leave-active {
  -webkit-transition: height 0.3s ease-in-out, margin 0.3s ease-in-out,
    padding 0.3s ease-in-out;
  transition: height 0.3s ease-in-out, margin 0.3s ease-in-out,
    padding 0.3s ease-in-out;
  overflow: hidden;
}

.expand-enter,
.expand-leave-to {
  height: 0;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}
</style>
