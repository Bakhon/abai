<template>
  <div class="bd-forms col-12 p-0 pl-2 h-100">
    <div class="blueblock h-100 m-0">
      <div class="wells-select-block m-0 p-3">
        <tree-view
            v-for="treeData in items"
            :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
            :ref="'child_' + treeData.id"
            :key="treeData.id"
            :nodeLocal="treeData"
            :handle-click="nodeClick"
            :get-wells="getWells"
            :get-initial-items="getInitialItems"
            :isShowCheckboxes="isShowCheckboxes"
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
    }
  },
  props: {
    structureType: String,
    itemType: Number,
    isShowCheckboxes: Boolean,
  },
  mounted() {
    this.init()
  },
  watch: {
    itemType(newValue) {
      this.init()
    }
  },
  methods: {
    init() {
      this.getInitialItems().then(items => this.items = items);
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
    async nodeClick(node) {
      this.$parent.currentStructureId = node.structureId
      this.$parent.setCurrentStructureId(node.structureId)
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
          return response.data
        } else {
          console.log("No data");
        }
        this.isLoading = false;
      }).finally(() => {
        this.isLoading = false;
      })
    },
    isNodeOnBottomLevelOfHierarchy(node) {
      return node.children.length === 0
    },
    getWells: async function (node) {
      this.isLoading = true
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
          return response.data
        } else {
          console.log("No data");
        }
        this.isLoading = false;
      }).finally(() => {
        this.isLoading = false;
      })
    },
  },
}
</script>