<template>
    <li class="text-white list-style-none mt-2 pl-3">
        <div
            v-if="node.name"
            v-bind:class="{ 'cursor-pointer': pointerClass }"
            @click.stop="handleClick(node)">
            <span v-if="this.checkable !== undefined">
                <span>
                    <img width="20" height="20" :src="this.checkState ? '/img/GTM/flag_active.svg' : '/img/GTM/flag.svg'" >
                </span>
            </span>
            <span @click="toggleCheckState()">{{ node.name }}</span>
            <span v-if="node.value" class="text-right">{{ node.value }}</span>
            <span v-if="nodeHasChildren" @click.stop="toggleUl()">
                <img width="20" height="20" :src="showChildren ? '/img/GTM/arrow_down.svg' : '/img/GTM/arrow_right.svg'">
            </span>
        </div>
        <ul class="treeUl" v-if="nodeHasChildren && showChildren">
            <node
                v-for="child in node.children"
                :node="child"
                :key="child.name"
                :handle-click="handleClick"
            ></node>
        </ul>
    </li>
</template>
<script>
export default {
    name: "node",
    props: {
        node: Object,
        handleClick: Function,
    },
    methods: {
        toggleUl: function () {
            this.showChildren = !this.showChildren;
        },
        toggleCheckState: function () {
            if (this.checkable) {
                this.checkState = !this.checkState;
            }
        },
    },
    data: function () {
        let showChildren = true;
        return {
            showChildren: showChildren,
            checkState: this.node.check_state,
            checkable: this.node.checkable
        };
    },
    computed: {
        pointerClass: function () {
            return (this.node.setting_model && this.node.setting_model.children.length > 0) || this.node.checkable
        },
        nodeHasChildren: function () {
            return this.node.children && this.node.children.length;
        }
    }
}
</script>