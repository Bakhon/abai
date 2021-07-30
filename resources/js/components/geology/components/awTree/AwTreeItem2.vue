<template>
  <li :class="itemClasses">
    <div class="d-flex align-items-center">
      <div :class="getStatBoxClasses" v-if="isFolder" @click="ontoggle">
        <AwIcon width="6" height="8" name="minus" v-if="isOpen" />
        <AwIcon width="8" height="8" name="plus" v-else />
      </div>
      <div class="d-flex align-items-center label-icon">
        <input
            class="d-block item-checkbox"
            type="checkbox"
            @change="clickItem(item.value)"
            :checked="getSelectedItems.includes(item.value)"
            v-if="item.value">
        <div class="icon-box" v-if="item.iconType">
          <AwIcon :fill="item.iconFill" :name="item.iconType" />
        </div>
        <span class="aw-tree__list-item__label" @click="ontoggle">{{ item.name }}</span>
      </div>
    </div>
    <ul v-if="item.children" v-show="isOpen" >
      <AwTreeItem2 :settings="settings" v-for="(child, i) in item.children" :item="child" :key="i" :index="index+1" />
    </ul>
  </li>
</template>

<script>
import AwTreeItemsMixins from "./AwTreeItemsMixins";

export default {
  name: "AwTreeItem2",
  mixins: [AwTreeItemsMixins],
  computed: {
    getPaddingWithDeep() {
      return {
        paddingLeft: `${this.index}em`
      }
    },
    itemClasses() {
      return {
        "AwTreeItem2 aw-tree__list-item": true,
        "is-folder": this.isFolder,
      }
    }
  }

}
</script>

<style lang="scss">
.___after{
  content: '';
  position: absolute;
  border: 1px dashed var(--a-default);
}
.AwTreeItem2 {
  .aw-tree {
    &__list {
      position: relative;
      margin-bottom: 0;
      overflow: hidden;
      ul{
        padding-left: 2em;
      }
      &, ul {
        margin-bottom: 0;
        &:after {
          @extend .___after;
          width: 0;
          height: 100%;
          top: 17px;
          left: 6px;
        }
      }

      .state-box {
        margin-right: 14px;
        position: relative;
        &.opened{
          background: var(--a-accent-darken-100);
          z-index: 2;
        }
      }
      .label-icon{
        position: relative;
        &:after {
          @extend .___after;
          left: -17px;
          width: 17px;
          top: 10px;
          height: 1px;
        }
      }
      &-item {
        ul {
          position: relative;
          &:after {
            @extend .___after;
            left: 35px;
            width: 1px;
            top: -17px;
            height: calc(100% + 8px);
          }
        }
        .icon-box, .item-checkbox{
          width: 20px;
          margin-right: 14px;
        }
        &:not(.is-folder){
          padding-left: 30px;
          margin-left: 14px;
          .label-icon{
            left: -16px;
          }
        }
      }
    }
  }
}
</style>