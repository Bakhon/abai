<template>
    <div>
        <ul>
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
        toggleUl: function () {
            this.showChildren = !this.showChildren;
        },
        handleClick (node) {
            if ((node.children && node.children.length > 0) || (node.setting_model && node.setting_model.children)) {
                this.$emit('node-click', {node: node, hideIoiMenu: true});
            }
        }
    },
}
</script>