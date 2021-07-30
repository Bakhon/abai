<template>
  <div class="bd-forms col-12 p-0 pl-2 h-100">
    <div class="blueblock h-100 m-0">
      <div class="wells-select-block m-0 p-3">
        <tree-view
            v-for="(treeData, index) in items"
            :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
            :key="index + treeData.id"
            :node="treeData"
            :handle-click="nodeClick"
            :get-wells="getWells"
            :get-initial-items="getInitialItems"
            :isShowCheckboxes="isShowCheckboxes"
            :isWell="isWell"
            :onCheckboxClick="onCheckboxClick"
            :level="level+1"
            :nodeClickOnArrow="true"
            :markedNodes="markedNodes[currentOption.name]"
            :structureType="structureType"
            :renderComponent="renderComponent"
            :updateThisComponent="updateThisComponent"
            :isUntilWells="isUntilWells"
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
      items: null,
      level: 0,
      renderComponent: 1,
    }
  },
  props: {
    structureType: String,
    itemType: Number,
    isShowCheckboxes: Boolean,
    onCheckboxClick: Function,
    markedNodes: Object,
    isUntilWells: Boolean,
    currentOption: Object,
  },
  mounted() {
    this.init();
  },
  watch: {
    itemType(newValue) {
      this.init()
    }
  },
  methods: {
    init() {
      this.getInitialItems().then(items => this.items = items);
      if(this.currentOption && !this.markedNodes[this.currentOption.name]) {
        this.markedNodes[this.currentOption.name] = {};
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
      this.$parent.setCurrentStructure(node.structureId, node.type)
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
  },
}
</script>