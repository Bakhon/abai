<template>
    <div>
        <el-tree :data="reptt" :props="defaultProps" @node-click="handleNodeClick"></el-tree>
    </div>
</template>

<script>
    export default {
        props: [
            'reptt'
        ],
        data() {
            return {
                data: [],
                defaultProps: {
                    id: 'id',
                    children: 'repts',
                    label: 'title',
                }
            };
        },
        methods: {
            handleNodeClick(data) {
                console.log(data);
            }
        },
        computed: {
            propsChildren() {
                return this.props.children || 'repts' || 'childRepts';
            },
        }
    };
</script>
<style>
    .el-tree-node__label {
        color: white !important;
    }

    .el-tree {
        padding: 16px;
        background-color: #20274f !important;
    }

    .el-tree-node:focus > .el-tree-node__content > .el-tree-node__label {
        color: #20274f !important;
    }

    .el-tree-node__expand-icon {
        color: white;
    }

    .el-tree-node__content:hover .el-tree-node__label, .el-tree-node__label:hover {
        color: #20274f !important;
    }

    .el-tree-node__content:hover .el-tree-node__expand-icon.is-leaf {
        color: none !important;
    }

    .el-tree-node__content:hover .el-tree-node__expand-icon {
        color: #20274f !important;
    }
</style>