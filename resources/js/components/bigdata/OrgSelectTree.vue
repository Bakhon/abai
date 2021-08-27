<template>
  <div class="bd-forms col-12 p-0 pl-2 h-100">
    <div class="blueblock h-100 m-0">
      <div class="wells-select-block m-0 p-3 scrollable blueblock">
        <tree-view
            v-for="(treeData, index) in filterTree"
            :isNodeOnBottomLevelOfHierarchy="isNodeOnBottomLevelOfHierarchy"
            :node="treeData"
            :key="`${index}-${treeData.id}`"
            :handle-click="nodeClick"
            :get-wells="getWells"
            :isShowCheckboxes="false"
            :isWell="isWell"
            :currentWellId="currentWellId"
        ></tree-view>
      </div>
    </div>
  </div>
</template>

<script>
import forms from '../../json/bd/forms.json'
import moment from "moment";
import BigDataTableForm from "./forms/TableForm";

export default {
  components: {
    BigDataTableForm
  },
  props: {
    currentWellId: {
      type: Number,
      required: false
    },
  },
  data() {
    let activeForm = {};
    forms.forEach((form) => {
      if (form.code === 'fluid_production') {
        activeForm = form;
      }
    });
    return {
      forms: forms,
      activeForm: activeForm,
      date: moment().toISOString(),
      filterTree: [],
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    init() {
      this.axios.get(this.localeUrl(`/api/bigdata/wells/tree`)).then(data => {
        this.filterTree = data.data
      })
    },
    nodeClick(node) {
      this.$emit('idChange', {
        id: node.id,
        type: node.type
      })
    },
    isNodeOnBottomLevelOfHierarchy: function (node) {
      return node.type !== 'org'
    },
    isWell: function (node) {
      return (typeof node.type !== 'undefined' && node.type === 'well')
    },
    getWells: function (child) {
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
            newChildren.push({id: well.id, name: well.uwi, type: 'well'});
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