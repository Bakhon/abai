<template>
  <div class="geology">
    <div class="preloader" v-cloak />
    <div class="layout__t-side mb-3" v-if="$scopedSlots.topSide">
      <slot name="topSide" />
    </div>
    <div class="layout" v-cloak>
      <div :class="getLeftSideClasses"
           v-if="$scopedSlots.leftSide">
        <slot name="leftSide" />
      </div>
      <div class="layout__content layout__center" v-if="$scopedSlots.baseSlot">
        <slot name="baseSlot" />
      </div>
      <div :class="getRightSideClasses"
           v-if="$scopedSlots.rightSide">
        <slot name="rightSide" />
      </div>
    </div>
  </div>
</template>

<script>
import {geologyState} from '../../store/helpers';

export default {
  name: "PageLayoutGrid",
  computed: {
    ...geologyState([
      'isOpenedRightSide',
      'isOpenedLeftSide'
    ]),
    getRightSideClasses() {
      return {
        "layout__content layout__content--background layout__r-side": true,
        "opened": this.isOpenedRightSide
      }
    },
    getLeftSideClasses() {
      return {
        "layout__content layout__content--background layout__l-side": true,
        "opened": this.isOpenedLeftSide
      }
    },
  }
}
</script>

<style scoped lang="scss">
.geology {
  .layout {
    min-height: calc(100vh - 92px);
    display: flex;
    align-items: stretch;
    margin: -5px;

    &__l-side, &__r-side, &__center {
      width: 100%;
      margin: 5px;
    }

    &__l-side, &__r-side {
      transition: 300ms all;
      transition-delay: 200ms;
      max-width: 30px;
      overflow: hidden;

      &.opened {
        transition-delay: 0ms;
        max-width: 300px;
      }
    }

    &__content {
      &--background {
        background: var(--a-accent-darken-300);
      }
    }

    &[v-cloak] {
      display: none;
    }
  }

  .preloader {
    color: #ffffff;

    &[v-cloak],
    &[v-cloak]:after {
      border-radius: 50%;
      width: 10em;
      height: 10em;
    }

    &[v-cloak] {
      margin: 60px auto;
      font-size: 10px;
      position: relative;
      text-indent: -9999em;
      border-top: 1.1em solid rgba(255, 255, 255, 0.2);
      border-right: 1.1em solid rgba(255, 255, 255, 0.2);
      border-bottom: 1.1em solid rgba(255, 255, 255, 0.2);
      border-left: 1.1em solid #ffffff;
      -webkit-transform: translateZ(0);
      -ms-transform: translateZ(0);
      transform: translateZ(0);
      -webkit-animation: load8 1.1s infinite linear;
      animation: load8 1.1s infinite linear;
    }
  }

  @-webkit-keyframes load8 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @keyframes load8 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
}
</style>
