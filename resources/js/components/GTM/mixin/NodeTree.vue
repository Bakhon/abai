<template>
  <li class="text-white list-style-none mt-2 pl-4 pb-1 ">
    <div class="span">
    <div
        v-if="node.name"
        v-bind:class="{ 'cursor-pointer': pointerClass }"
        @click.stop="handleClick(node)">
            <span v-if="nodeHasChildren" @click="toggleUl()">
              <span class="asd"><img width="20" height="20" :src="showChildren ? '/img/GTM/arrow_down.svg' : '/img/GTM/arrow_right.svg'"></span>
              <img width="20" height="20" src='../img/folder.svg'>
            </span>
      <span v-if="!nodeHasChildren && !node.value">
        <template>
          <input v-if="this.checkable" type="checkbox">
          <img v-else width="20" height="20" src='../img/file.svg'>
        </template>
      </span>
      <span v-if="this.checkable !== undefined"></span>
      <span class="margin-input" @click="toggleCheckState()">{{ node.name }} </span>
      <input class="input-tree" v-if="node.value || node.value === ''" type="text" v-model="node.value">
    </div>
    <ul class="treeUl" v-if="nodeHasChildren && showChildren">
      <node
          v-for="child in node.children"
          :node="child"
          :key="child.name"
          :handle-click="handleClick"
      ></node>
    </ul>
    </div>
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
      onClickVal(e) {
        console.log(e)
      },
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
      isLeaf: function(node) {
        if (node.hasOwnProperty('value')) {
          console.log('asd')
          return true
        }
      },
    }
}
</script>
<style scoped>
/*.span {*/
/*  padding-left: 1em;*/
/*  border: 1px dotted white;*/
/*  border-width: 0 0 1px 1px;*/
/*}*/

/*.cursor-pointer {*/
/*  padding-left: 1em;*/
/*  border: 1px dotted white;*/
/*  border-width: 0 0 1px 1px;*/
/*}*/
/*.child:last-child:after {*/
/*  position: absolute;*/
/*  width: 2px;*/
/*  height: 13px;*/
/*  background: #fff;*/
/*  left: -1px;*/
/*  bottom: 0px;*/
/*}*/



/*span,*/
/*label {*/
/*  cursor: pointer;*/
/*}*/

/*span > label {*/
/*  margin-right: 34px;*/
/*  position: relative;*/
/*  left: -11px;*/
/*}*/

/*.span:before {*/
/*  content: "";*/
/*  width: 13px;*/
/*  height: 1px;*/
/*  border-bottom: dotted 1px #bcbec0;*/
/*  position: absolute;*/
/*  top: 10px;*/
/*  left: 0;*/
/*}*/

/*.span {*/
/*  border-left: dotted 1px #bcbec0;*/
/*  padding: 1px 0 1px 25px;*/
/*  position: relative;*/
/*  list-style: none;*/
/*}*/

/*ul, li { list-style: none; margin: 0; padding: 0; }*/
/*ul { padding-left: 1em; }*/
/*li { padding-left: 1em;*/
/*  border: 1px dotted white;*/
/*  border-width: 0 0 1px 1px;*/
/*}*/
/*li.container { border-bottom: 0px; }*/

/*li p { margin: 0;*/
/*  background: white;*/
/*  position: relative;*/
/*  top: 0.5em;*/
/*}*/
/*li ul {*/
/*  border-top: 1px dotted white;*/
/*  margin-left: -1em;*/
/*  padding-left: 2em;*/
/*}*/
/*ul li:last-child ul {*/
/*  border-left: 1px solid white;*/
/*  margin-left: -17px;*/
/*}*/
</style>