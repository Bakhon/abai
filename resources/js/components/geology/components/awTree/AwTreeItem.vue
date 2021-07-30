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
            <AwIcon :name="item.iconType" v-if="item.iconType"/>
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
import AwIcon from "../icons/AwIcon";

export default {
  name: "AwTreeItem",
  inject: ["settings", "selected", "clickItem"],
  props: {
    item: Object,
    settings: Object,
    index: Number
  },
  data() {
    return {
      isOpen: this.item.isOpen
    }
  },
  components: {
    AwIcon
  },
  computed: {
    getSelectedItems() {
      return this.selected || []
    },
    getPaddingWithDeep() {
      return {
        paddingLeft: `${this.index}em`
      }
    },
    getStatBoxClasses() {
      return {
        "state-box": true,
        "opened": this.isOpen
      }
    },
    isFolder() {
      return (this.item.children && this.item.children.length);
    },
    itemClasses() {
      return {
        "aw-tree__list-item": true,
        "is-folder": this.isFolder
      }
    }
  },
  methods: {
    ontoggle() {
      this.isOpen = !this.isOpen;
    }
  }
}
</script>
