<template>
    <li class="text-white list-style-none mt-2">
        <span class="cursor-pointer" @click.stop="toggleUl(node)">{{ node.name }}</span>
        <span v-if="node.children && node.children.length">
            <img width="20" height="20" :src="showChildren ? '/img/GTM/arrow_down.svg' : '/img/GTM/arrow_right.svg'">
        </span>
        <ul class="ml-4 treeUl" v-if="node.children && node.children.length && showChildren">
            <node v-for="child in node.children" :node="child" :key="child.name"></node>
        </ul>
    </li>
</template>
<script>
export default {
    name: "node",
    props: {
        node: Object,
    },
    methods: {
        toggleUl: function () {
            this.showChildren = !this.showChildren;
        }
    },
    data: function () {
        return {
            showChildren: (this.node.children && this.node.children.length > 0),
        };
    },
}
</script>