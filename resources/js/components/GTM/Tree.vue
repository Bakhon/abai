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
            this.$emit('node-click', node);
        }
    },
}
</script>