<template>
    <li class="text-white list-style-none mt-2 pl-3">
        <div
            v-if="node.name"
            v-bind:class="{ 'cursor-pointer': pointerClass }"
            @click.stop="handleClick(node)">
            <span v-if="node.children.length === 0 && !node.setting_model && this.checkable !== undefined">
                <span v-if="this.checkState">
                    <img width="20" height="20" :src="'/img/GTM/flag.svg'">
                </span>
                <div v-else class="gtm-setting-checkbox-div">
                    <input type="checkbox" class="gtm-setting-checkbox"></input>
                    <span class="gtm-setting-custom-checkbox"></span>
                </div>
            </span>
            <span @click="toggleCheckState()">{{ node.name }}</span>
            <span v-if="node.value" class="text-right">{{ node.value }}</span>
            <span v-if="node.children && node.children.length" @click.stop="toggleUl()">
                <img width="20" height="20" :src="showChildren ? '/img/GTM/arrow_down.svg' : '/img/GTM/arrow_right.svg'">
            </span>
        </div>
        <ul class="treeUl" v-if="node.children && node.children.length && showChildren">
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
        }
    }
}
</script>