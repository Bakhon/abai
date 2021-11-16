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
        :isWell="isWell"
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
      this.axios.get(this.localeUrl(`/api/bigdata/wells/tree`)).then(data => {
        this.tree = data.data
      })
    },
    nodeClick(node) {
      if (this.structureTypes.length > 0 && !this.structureTypes.includes(node.type)) return false
      this.$emit('idChange', {
        id: node.id,
        type: node.type,
        name: node.name,
        fullName: node.full_name
      })
    },
    isNodeOnBottomLevelOfHierarchy: function (node) {
      return node.type !== 'org'
    },
    isWell: function (node) {
      return (typeof node.type !== 'undefined' && node.type === 'well')
    },
    getWells: function (child) {
      if (!this.structureTypes.includes('well')) return

      child.isLoading = true;

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