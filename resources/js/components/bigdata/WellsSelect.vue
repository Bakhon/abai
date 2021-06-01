<template>
  <div class="bd-forms col-12 p-0 pl-2 h-100">
    <div class="blueblock h-100 m-0">
      <div class="wells-select-block m-0 p-3">
        <b-tree-view
            v-if="filterTree.length"
            :contextMenu="false"
            :contextMenuItems="[]"
            :data="filterTree"
            :renameNodeOnDblClick="false"
            nodeLabelProp="name"
            v-on:nodeSelect="filterForm"
        ></b-tree-view>
      </div>
    </div>
  </div>
</template>

<script>
import forms from '../../json/bd/forms.json'
import moment from "moment";
import {bdFormActions} from '@store/helpers'
import {bTreeView} from 'bootstrap-vue-treeview'
import BigDataTableForm from "./forms/TableForm";

export default {
  components: {
    bTreeView,
    BigDataTableForm
  },
  data() {
    return {
      forms: forms,
      activeForm: null,
      date: moment().toISOString(),
      filterTree: [],
      tech: null,
      isloading: false
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    ...bdFormActions([
      'updateForm'
    ]),
    filterForm(item, isSelected) {
      if (isSelected) {
        if (item.data.type === 'org') return false
        this.tech = item.data.id
      }
    },
    init() {
      this.activeForm = this.forms[Object.keys(this.forms)[1]]
      this.isloading = true
      this.updateForm(this.activeForm.code).then(data => {
        this.filterTree = data.filterTree
        this.isloading = false
      })
    },
  },
}
</script>

<style>
  .wells-select-block .tree-node-label {
    font-size: 14px;
    color: #fff;
    white-space: nowrap;
  }
  .wells-select-block .tree-node-icon {
    color: #fff;
  }
</style>