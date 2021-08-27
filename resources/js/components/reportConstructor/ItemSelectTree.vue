<template>
  <div class="bd-forms col-12 p-0 pl-2 h-100">
    <div class="blueblock h-100 m-0">
      <div class="wells-select-block m-0 p-3" v-if="renderComponent">
        <tree-view
            v-for="(treeData, index) in selectedObjects[currentOption.name]"
            :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
            :key="`${index}-${treeData.id}`"
            :node="treeData"
            :handle-click="nodeClick"
            :get-wells="getWells"
            :get-initial-items="getInitialItems"
            :isShowCheckboxes="isShowCheckboxes"
            :isWell="isWell"
            :level="level+1"
            :nodeClickOnArrow="true"
            :renderComponent="renderComponent"
            :updateThisComponent="updateThisComponent"
            :isSelectUntilWells="isSelectUntilWells"
            :selectedObjects="selectedObjects"
            :isCheckedCheckbox="isCheckedCheckbox"
            :onCheckboxClick="onCheckboxClick"
        ></tree-view>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import axios from "axios";

export default {
  data() {
    return {
      baseUrl: process.env.MIX_MICROSERVICE_USER_REPORTS,
      level: 0,
      renderComponent: 1,
    }
  },
  props: {
    structureType: String,
    itemType: Number,
    isShowCheckboxes: Boolean,
    isSelectUntilWells: Boolean,
    currentOption: Object,
    selectedObjects: Object,
    isCheckedCheckbox: Function,
  },
  beforeMount() {
    this.init();
  },
  watch: {
    itemType(newValue) {
      this.init()
    }
  },
  methods: {
    init: async function() {
      if(!this.selectedObjects[this.currentOption.name]) {
        this.getInitialItems().then((items) => {
          this.selectedObjects[this.currentOption.name] = items;
        }).then(() => {
          this.updateThisComponent();
        });
      }
    },
    getInitialItems() {
      this.isLoading = true
      return this.axios.get(this.baseUrl + "get_items", {
        params: {
          structure_type: this.structureType,
          item_type: this.itemType
        },
        responseType: 'json',
        headers: {
          'Content-Type': 'application/json'
        }
      }).then((response) => {
        if (response.data) {
          return response.data
        } else {
          console.log("No data");
        }
        this.isLoading = false;
      }).catch((error) => {
        console.log(error)
        this.isLoading = false
      });

    },
    nodeClick(node) {
      this.isLoading = true
      return this.axios.get(this.baseUrl + "get_children_of_item", {
        params: {
          structure_type: this.structureType,
          item_id: node.id
        },
        responseType: 'json',
        headers: {
          'Content-Type': 'application/json'
        }
      }).then((response) => {
        if (response.data) {
          node.children = response.data
        } else {
          console.log("No data");
        }
      }).finally(() => {
        this.isLoading = false;
      })
    },
    updateThisComponent() {
      this.renderComponent += 1;
    },
    isNodeOnBottomLevelOfHierarchy(node) {
      return (!node.children || node.children.length === 0)
    },
    isWell: function(node){
      return (typeof node.type !== 'undefined' && node.type === 'well')
    },
    getWells: function (child) {
      let node = (typeof child.node === 'undefined') ? child : child.node;

      return this.axios.get(this.baseUrl + "get_wells", {
        params: {
          structure_type: this.structureType,
          item_id: node.id
        },
        responseType: 'json',
        headers: {
          'Content-Type': 'application/json'
        }
      }).then((response) => {
        if (response.data) {
          node.children = response.data
        } else {
          console.log("No data");
        }
      }).finally(() => {
        child.isLoading = false;
      })
    },
    onCheckboxClick: async function (content) {
      let node = content.node;

      this.isLoading = true;
      this.loadChildren(node)
      .then(() => {
        if(node.isChecked) {
          if(this.isSelectUntilWells) {
            this.updateWellOfNode(node, node.level, true);
          }else {
            this.updateNextLevelOfNode(node, node.level);
          }
        }else {
          this.updateChildren(node, node.level, false);
        }
      }).finally(() => {
        this.updateThisComponent();
        this.isLoading = false;
      });

      node.level = level;
    },
    loadChildren: async function(node) {
      if(this.isWell(node)) return;
      if(typeof node.children === 'undefined') {
        await this.handleClick(node);
      }
      if(!this.isHaveChildren(node)) {
        await this.getWells(node);
        this.updateThisComponent();
      }
      
      for(let idx in node.children) {
        this.loadChildren(node.children[idx]);
      }
    },updateNextLevelOfNode: async function(node, level) {
      if(!node?.children) return;
      for(let child of node.children) {
        child.isChecked = this.node.isChecked;
        child.level = level+1;
      }
      this.updateThisComponent();
    },
    updateChildren: async function(node, level, val) {
      if(!node?.children) return;
      for(let child of node.children) {
        child.isChecked = val;
        child.level = level+1;
        this.updateChildren(child, level+1, val);
      }
      this.updateThisComponent();
    },
    updateWellOfNode: async function(node, level, val) {
      if(!node?.children) return;
      for(let child of node.children) {
        if(this.isWell(child)) {
          child.isChecked = val;
          child.level = level+1;
        }
        this.updateWellOfNode(child, level+1, val);
      }
      this.updateThisComponent();
    },
    isHaveChildren(node) {
      return typeof node !== 'undefined' && 
             typeof node.children !== 'undefined' && 
             !this.isNodeOnBottomLevelOfHierarchy(node);
    },
  },
}
</script>