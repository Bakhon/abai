<template>
  <ul class="asside-db-list">
    <org-select-tree-item
        v-for="(treeData, index) in tree"
        :key="`${index}-${treeData.id}`"
        :currentWellId="currentWellId"
        :get-wells="getWells"
        :handle-click="nodeClick"
        :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
        :isShowCheckboxes="false"
        :active="isActiveNode"
        :is-well="isWell"
        :load-wells="isLoadWells"
        :structure-types="structureTypes"
        :node="treeData"
    ></org-select-tree-item>
  </ul>
</template>

<script>
import OrgSelectTreeItem from './OrgSelectTreeItem'

export default {
  components: {
    OrgSelectTreeItem
  },
  props: {
    currentWellId: {
      type: Number,
      required: false
    },
    searchQuery: {
      type: String,
      required: false
    },
    structureTypes: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      tree: [],
    }
  },
  computed: {
    filteredTree() {
      if (!this.searchQuery) return this.tree

      return this.tree.filter(treeItem => {

      })

    }
  },
  mounted() {
    this.init()
  },
  methods: {
    init() {
      this.axios.get(this.localeUrl(`/api/bigdata/wells/tree`), {
        params: {
          types: this.structureTypes.join(',')
        }
      }).then(data => {
        this.tree = data.data
      })
    },
    nodeClick(node) {
      if (!this.isActiveNode(node)) return false
      this.$emit('idChange', {
        id: node.id,
        type: node.type,
        name: node.name,
        fullName: node.full_name
      })
    },
    isActiveNode(node) {
      if (!this.structureTypes) return true
      return this.structureTypes
          .filter(type => {
            if (type.indexOf(':') === -1) return node.type.toLowerCase() === type.toLowerCase()
            let typeWithSub = type.toLowerCase().split(':')
            return node.type.toLowerCase() === typeWithSub[0] && node.sub_type.toLowerCase() === typeWithSub[1]
          })
          .length > 0
    },
    isNodeOnBottomLevelOfHierarchy: function (node) {
      return node.type !== 'org'
    },
    isWell: function (node) {
      return (typeof node.type !== 'undefined' && node.type === 'well')
    },
    isLoadWells() {
      return this.structureTypes.includes('well')
    },
    getWells: function (child) {
      if (!this.isLoadWells()) {
        child.isLoading = false
        return
      }

      let node = child.node
      this.axios.get(this.localeUrl(`/api/bigdata/tech/wells`), {
        params: {
          'techId': node.id
        }
      }).then((data) => {
        if (data.data.length > 0) {
          let newChildren = [];
          if (typeof node.children === "undefined") {
            node.children = []
          }
          newChildren = node.children.filter((child) => {
            return child.type !== 'well';
          });
          data.data.forEach((well) => {
            newChildren.push({id: well.id, name: well.uwi, type: 'well', full_name: `${node.full_name} / ${well.uwi}`});
          });
          node.children = newChildren;
        }
      }).finally(() => {
        child.isLoading = false;
      });
    },
  },
}
</script>