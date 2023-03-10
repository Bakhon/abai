<template>
  <div class="bd-forms col-12 p-0  ">
    <div class="blueblock m-0">
      <div class="wells-select-block m-0 " v-if="renderComponent">
        <tree-view
            v-for="(treeData, index) in selectedObjects[currentOption.name]"
            :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
            :key="`${index}-${treeData.id}`"
            :node="treeData"
            :parent="treeData"
            :handle-click="nodeClick"
            :get-wells="getWells"
            :get-initial-items="getInitialItems"
            :isShowCheckboxes="isShowCheckboxes"
            :isWell="isWell"
            :level="level+1"
            :nodeClickOnArrow="true"
            :renderComponent="renderComponent"
            :updateThisComponent="updateThisComponent"
            :selectedObjects="selectedObjects"
            :isCheckedCheckbox="isCheckedCheckbox"
            :onClick="onClick"
        ></tree-view>
      </div>
    </div>
  </div>
</template>

<script>

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
    async nodeClick(node) {
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
    getWells: async function (child) {
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
    onClick: async function (content) {
      let node = content.node;
      node.isChecked = !node.isChecked;

      content.isLoading = true;
      node.level = content.level;
      content.updateChildren(node, content.level, node.isChecked)
      .then(
        content.updateParent(node.isChecked)
      )
      .then(() => {
        content.updateThisComponent();
        content.isLoading = false;
      });
    },
    loadChildren: async function(node) {
      if(this.isWell(node)) return;
      if(typeof node.children === 'undefined') {
        await this.nodeClick(node);
      }
      if(!this.isHaveChildren(node)) {
        await this.getWells(node);
      }
      
      for(let idx in node.children) {
        await this.loadChildren(node.children[idx]);
      }
    },
    isHaveChildren(node) {
      return typeof node !== 'undefined' && 
             typeof node.children !== 'undefined' && 
             !this.isNodeOnBottomLevelOfHierarchy(node);
    },
  },
}
</script>
