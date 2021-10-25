<template>
    <div>
        <ul class="tree-main-ul">
            <gtm-node-tree :node="treeData" :handle-click="handleClick"></gtm-node-tree>
        </ul>
    </div>
</template>
<script>

export default {
    props: {
        treeData: Object
    },
    methods: {
        emittedValue(v) {
          this.$emit('emitted-value', v)
        },
        toggleUl: function () {
            this.showChildren = !this.showChildren;
        },
        handleClick (node) {
            if ((node.children && node.children.length > 0) || (node.setting_model && node.setting_model.children)) {
                this.$emit('node-click', {node: node, hideIoiMenu: true});
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