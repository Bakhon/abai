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

/*.tree-main-ul, li { list-style: none; margin: 0; padding: 0; }*/
/*.tree-main-ul { padding-left: 1em; }*/
/*li { padding-left: 1em;*/
/*  border: 1px dotted white;*/
/*  border-width: 0 0 1px 1px;*/
/*}*/
/*li.container { border-bottom: 0px; }*/

/*li p { margin: 0;*/
/*  background: white;*/
/*  position: relative;*/
/*  top: 0.5em;*/
/*}*/
/*li .tree-main-ul {*/
/*  border-top: 1px dotted white;*/
/*  margin-left: -1em;*/
/*  padding-left: 2em;*/
/*}*/
/*.tree-main-ul li:last-child ul {*/
/*  border-left: 1px solid white;*/
/*  margin-left: -17px;*/
/*}*/
</style>