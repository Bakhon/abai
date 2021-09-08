<template>
  <div
    class="rating-accordion"
    :class="{ 'is-active': isOpen }"
  >
    <div class="rating-accordion__header" @click="handleToggle">
      <div class="rating-accordion__title">
        {{ trans(title) }}
      </div>
      <div class="rating-accordion__icon"/>
    </div>
    <transition-expand duration="100">
      <div v-show="isOpen" class="rating-accordion__body">
        <slot v-if="$slots.default"></slot>
        <ul class="list" v-else>
          <li
            v-for="(item, index) in list" :key="index"
            @click="$emit('selectItem', item)">
            {{ item.title || item }}
          </li>
        </ul>
      </div>
    </transition-expand>
  </div>
</template>

<script>
import { TransitionExpand } from 'vue-transition-expand';

export default {
  name: "Accordion",

  props: {
    list: Array,
    title: String,
  },

  components: {
    TransitionExpand,
  },

  data() {
    return {
      isOpen: true,
    }
  },

  methods: {
    handleToggle() {
      this.isOpen = !this.isOpen;
    }
  }
}
</script>

<style scoped>
.expand-enter-active, .expand-leave-active {
  -webkit-transition: height 0.3s ease-in-out, margin 0.3s ease-in-out, padding 0.3s ease-in-out;
  transition: height 0.3s ease-in-out, margin 0.3s ease-in-out, padding 0.3s ease-in-out;
  overflow: hidden;
}

.expand-enter, .expand-leave-to {
  height: 0;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important
}
</style>
