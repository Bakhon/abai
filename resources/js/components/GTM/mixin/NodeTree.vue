<template>
  <li class="text-white list-style-none mt-2 pl-3">
    <div
        class="pb-1"
        v-if="node.name"
        v-bind:class="{ 'cursor-pointer': pointerClass }"
        @click.stop="handleClick(node)">
            <span v-if="nodeHasChildren" @click="toggleUl()">
              <img width="20" height="20" :src="showChildren ? '/img/GTM/arrow_down.svg' : '/img/GTM/arrow_right.svg'">
              <img width="20" height="20" src='../img/folder.svg'>
            </span>
      <span v-if="!nodeHasChildren && !node.value">
        <template>
          <input v-if="this.checkable === true" type="checkbox">
          <img v-else width="20" height="20" src='../img/file.svg'>
        </template>
      </span>
      <span v-if="this.checkable !== undefined"></span>
      <span class="margin-input" @click="toggleCheckState()">{{ node.name }} </span>
      <input class="input-tree" v-if="node.value" type="text" v-model="node.value">
    </div>
    <ul class="treeUl" v-if="nodeHasChildren && showChildren">
      <node
          v-for="child in node.children"
          :node="child"
          :key="child.name"
          :handle-click="handleClick"
      ></node>
    </ul>
  </li>
</template>
<script>
import {paegtmMapActions} from "../../../store/helpers";

export default {
    name: "node",
    props: {
        node: Object,
        handleClick: Function,
    },
    methods: {
      ...paegtmMapActions([
        'changeClickable',
      ]),
        toggleUl: function () {
            this.showChildren = !this.showChildren;
        },
        toggleCheckState: function () {
          let clickable = this.node.clickable
            if (this.node.clickable) {
              this.changeClickable(clickable)
              this.$emit('emitValue', clickable)
            }

            if (this.checkable) {
              this.checkState = !this.checkState;
            }
        },
    },
    data: function () {
        let showChildren = true;
        return {
            showChildren: showChildren,
            checkState: this.node.check_state,
            checkable: this.node.checkable,
        };
    },
    computed: {
        pointerClass: function () {
            return (this.node.setting_model && this.node.setting_model.children.length > 0) || this.node.checkable
        },
        nodeHasChildren: function () {
            return this.node.children && this.node.children.length;
        },
        // nodeHasClickable: function () {
        //     return this.node.clickable
        // }
    }
}
</script>