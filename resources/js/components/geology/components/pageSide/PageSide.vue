<template>
  <div :class="getClasses">
    <button @click="toggleSide" class="page-side__toggle-button">
      <AwIcon name="arrowLeft" />
    </button>
    <transition-group name="aw-scale-fade-side" tag="div">
      <div key="first" class="page-side__top w-100 mb-2" v-show="getSidesState">
        <slot name="top" />
      </div>
      <div key="second" v-show="getSidesState">
        <slot />
      </div>
    </transition-group>
  </div>
</template>

<script>
import AwIcon from "../icons/AwIcon";
import {geologyMutations} from "../../../../store/helpers";
import {SET_TOGGLE_LEFT_SIDE, SET_TOGGLE_RIGHT_SIDE} from "../../../../store/modules/geology.const";

export default {
  name: "PageSide",
  components: {
    AwIcon
  },
  props: {
    direction: {
      type: String,
      default: "left"
    }
  },
  computed: {
    getSideDirection() {
      let direction = this.direction === "left";
      return {
        get: direction ? 'isOpenedLeftSide' : 'isOpenedRightSide',
        set: direction ? SET_TOGGLE_LEFT_SIDE : SET_TOGGLE_RIGHT_SIDE
      };
    },
    getSidesState() {
      return this.$store.state.geology[this.getSideDirection.get];
    },
    getClasses() {
      return {
        "page-side": true,
        [this.direction]: true
      }
    }
  },
  methods: {
    ...geologyMutations([
      SET_TOGGLE_LEFT_SIDE,
      SET_TOGGLE_RIGHT_SIDE
    ]),
    toggleSide(){
      this[this.getSideDirection.set]('toggle')
    }
  }
}
</script>

<style scoped lang="scss">
.page-side {
  position: relative;
  padding: 6px 7px;

  &__top {
    padding-left: 30px;
  }

  &__toggle-button {
    position: absolute;
    left: 0;
    top: 0;
    border: none;
    background: var(--a-accent);
    padding: 14px 6px;
    border-radius: 0 10px 10px 0;
  }
}

.right {
  .page-side {
    &__top {
      flex-direction: row-reverse;
      padding-left: 0;
      padding-right: 30px;
    }

    &__toggle-button {
      left: auto;
      right: 0;
      border-radius: 10px 0 0 10px;

      .a-svg-icons {
        transform: rotate(180deg);
      }
    }
  }
}
</style>
