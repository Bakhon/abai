<template>
  <div class="data-analysis-accordion" :class="{ 'is-active': isOpen }">
    <div class="data-analysis-accordion__header" @click="handleToggle">
      <div class="data-analysis-accordion__title">
        {{ trans(title) }}
      </div>
      <div v-if="!hideIcon" class="data-analysis-accordion__icon" />
    </div>
    <transition-expand duration="100">
      <div v-show="isOpen" class="data-analysis-accordion__body">
        <slot name="list"></slot>
      </div>
    </transition-expand>
  </div>
</template>

<script>
import { TransitionExpand } from "vue-transition-expand";

export default {
  name: "Accordion",

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
      isOpen: false,
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
.data-analysis-accordion {
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
    .data-analysis-accordion__header {
    }
    .data-analysis-accordion__icon {
      transform: translateY(2px) rotate(225deg);
    }
  }

  &__header {
    position: relative;
    padding: 8px 10px;
    background-color: #323370;
    cursor: pointer;
    border: 1px solid #545580;
  }

  &__body {
    background: #363b68;
    border: 1px solid #545580;
    border-top: none;
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
