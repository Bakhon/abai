<template>
  <div class="main-page-module-block">
    <div
      :class="['block', { disabled: !block.url }]"
      :style="isOpen ? 'background-color: #2C44BD;' : ''"
    >
      <div
        v-if="block.children && block.children.length"
        class="multi-block"
        @mouseover="isOpen = true"
        @mouseleave="isOpen = false"
      >
        <a
          :href="block.url"
          class="icons-holder"
          :style="isOpen ? 'background: #2a2e60;' : ''"
        >
          <div :class="['icons', { 'flex-center': isOpen }]">
            <img
              :src="'/img/icons/' + block.icon"
              :alt="block.name"
              :class="{ 'scale-icon': isOpen }"
            />
            <img
              v-show="!isOpen"
              v-for="(childBlock, index) in block.children.slice(0, 3)"
              :key="index"
              :src="'/img/icons/' + childBlock.icon"
              :alt="childBlock.name"
            />
          </div>
        </a>
        <button>
          <img
            v-if="!isOpen"
            src="/img/icons/small_arrow.svg"
            alt="toggle menu"
          />
          <p v-else>{{ trans("app.goTo") }}</p>
        </button>
        <transition name="fade" :duration="120">
          <div
            v-show="isOpen === true"
            class="main-page-modal"
            :style="moveFor"
            @mouseover="isOpen = true"
          >
            <div>
              <div
                :class="[
                  'modal-blocks-holder',
                  { 'no-last-child-margin': isLessChildren },
                ]"
                :style="'width: ' + childBlockWidth"
              >
                <div
                  class="mchild"
                  v-for="(childBlock, index) in block.children"
                  :key="index"
                >
                  <div class="child-block">
                    <a class="single-block" :href="childBlock.url">
                      <img
                        :src="'/img/icons/' + childBlock.icon"
                        :alt="childBlock.name"
                      />
                    </a>
                  </div>
                  <a class="block-url disabled-text" :href="childBlock.url">{{
                    childBlock.name
                  }}</a>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
      <a v-else class="single-block" :href="block.url">
        <img :src="'/img/icons/' + block.icon" :alt="block.name" />
      </a>
    </div>
    <a
      :class="['block-url', { 'disabled-text': !block.url }]"
      :href="block.url"
      >{{ block.name }}</a
    >
  </div>
</template>

<script>
export default {
  name: "MainPageModuleBlock",
  props: {
    block: Object,
  },
  data() {
    return {
      isOpen: false,
    };
  },
  computed: {
    isLessChildren() {
      return this.block.children?.length <= 5;
    },
    moveFor() {
      if (this.block?.children.length < 5)
        return `right: ${this.block.children.length * -55}%`;
      return "right: -275%;";
    },
    childBlockWidth() {
      return this.block.children.length >= 5
        ? "480px"
        : (this.block.children.length - 1) * 108 + 48 + "px";
    },
  },
};
</script>

<style scoped lang="scss" src="./MainPageModuleBlockStyles.scss"></style>
