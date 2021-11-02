<template>
  <div>
    <ul class="tree-main-ul">
      <gtm-node-tree :node="treeData" :handle-click="handleClick"></gtm-node-tree>
    </ul>
  </div>
</template>
<script>

import {paegtmMapActions, paegtmMapState} from "../../../store/helpers";

export default {
  props: {
    treeData: Object
  },
  data: function () {
    return {
      url: process.env.MIX_PODBOR_GTM_URL,
    }
  },
  computed: {
    ...paegtmMapState([
      'clickable',
    ]),
  },
  methods: {
    ...paegtmMapActions([
      'onGetTableByClickableValue'
    ]),
    handleClick(node) {
      if ((node.children && node.children.length > 0) || (node.setting_model && node.setting_model.children)) {
        this.$emit('node-click', {node: node, hideIoiMenu: true})
        const bodyAction = {
          action_type: 'finder_item_clicked',
          main_data: node.name,
        }
        let body = {url: this.url, body: bodyAction}
        this.onGetTableByClickableValue(body)
        this.$emit('event-emit')
      }
    },
  },
}
</script>
<style scoped>
.tree-setting-block div {
  min-width: 30rem !important;
}
</style>