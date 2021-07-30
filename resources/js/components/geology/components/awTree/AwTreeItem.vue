<template>
  <li :class="itemClasses">
    <div class="d-flex align-items-center">
      <div ref="stateBox" :class="getStatBoxClasses" v-if="isFolder" @click="ontoggle">
        <AwIcon width="6" height="8" name="minus" v-if="isOpen" />
        <AwIcon width="8" height="8" name="plus" v-else />
      </div>
      <div class="label-wrapper">
        <div ref="iconBox" class="item">
          <div class="icon-box">
            <AwIcon :fill="item.iconFill" :name="item.iconType" v-if="item.iconType" />
          </div>
        </div>
        <div class="item">
          <input
              class="d-block"
              type="checkbox"
              @change="clickItem(item.value)"
              :checked="getSelectedItems.includes(item.value)"
              v-if="item.value">
        </div>
        <div class="item">
          <span class="aw-tree__list-item__label" @click="ontoggle">{{ item.name }}</span>
        </div>
      </div>
    </div>
    <ul v-if="item.children" v-show="isOpen" :style="getPaddingWithDeep">
      <AwTreeItem :settings="settings" v-for="(child, i) in item.children" :item="child" :key="i" :index="index+1" />
    </ul>
  </li>
</template>

<script>
import AwTreeItemsMixins from "./AwTreeItemsMixins";
export default {
  name: "AwTreeItem",
  mixins: [AwTreeItemsMixins],
  computed: {
    getPaddingWithDeep() {
      return {
        paddingLeft: `${this.index}em`
      }
    },
    itemClasses() {
      return {
        "AwTreeItem aw-tree__list-item": true,
        "is-folder": this.isFolder,
      }
    }
  }
}
</script>

<style lang="scss">
.AwTreeItem{
  .aw-tree {
    &__list {
      position: relative;
      margin-bottom: 0;
      overflow: hidden;
      ul {
        margin-bottom: 0;

        &:after {
          content: '';
          width: 0;
          height: 100%;
          position: absolute;
          top: 17px;
          left: 6px;
          border: 1px dashed var(--a-default);
        }
      }

      &-item {
        padding-bottom: 12px;
        &:last-child {
          padding-bottom: 0;
        }
        .label-wrapper {
          display: flex;
          align-items: center;
          .item {
            &:nth-child(1),
            &:nth-child(2) {
              width: 14px;
              height: auto;
            }
            &:nth-child(2) {
              margin: 0 10px;
            }
          }
        }
        ul {
          .state-box {
            position: relative;

            &:after {
              content: '';
              position: absolute;
              width: calc(100% + 7px);
              left: calc(-100% - 8px);
              top: 5px;
              height: 1px;
              border: 1px dashed var(--a-default);
            }
          }
        }
      }
    }
  }
}
</style>
