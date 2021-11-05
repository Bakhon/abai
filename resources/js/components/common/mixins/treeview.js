export default {
    props: {
        node: Object,
        parent: Object,
        level: Number,
        renderComponent: Number,
        updateThisComponent: Function,
        handleClick: Function,
        getWells: Function,
        getInitialItems: Function,
        isNodeOnBottomLevelOfHierarchy: Function,
        isShowCheckboxes: Boolean,
        isWell: Function,
        onClick: Function,
        currentWellId: {
            type: Number,
            required: false
        },
        isCheckedCheckbox: {
            type: Function,
            required: false
        },
        nodeClickOnArrow: false,
    },
    created() {
        if (!this.isShowCheckboxes) return;
        if (!('isChecked' in this.node)) {
            this.node.isChecked = this.parent.isChecked;
        }
    },
    model: {
        prop: "node",
        event: "nodeChange"
    },
    methods: {
        showChildren: async function () {
            this.isShowChildren = !this.isShowChildren;
            if (!this.isShowChildren) {
                return
            }
            if (this.nodeClickOnArrow && !this.node.children) {
                await this.handleClick(this.node);
            }
            if (!this.isHaveChildren(this.node)) {
                this.isLoading = true;
                await this.getWells(this);
            }

            this.assignParentToChilds(this.node);
            this.$forceUpdate()
        },
        onCheckboxClick: async function () {
            this.onClick(this);
        },
        updateChildren: async function (node, level, val) {
            if (!node?.children) return;
            for (let child of node.children) {
                child.isChecked = val;
                child.level = level + 1;
                this.updateChildren(child, level + 1, val);
            }
        },
        assignParentToChilds: async function (node) {
            if (!node?.children) return;
            for (let child of node.children) {
                child.parent = node;
                this.assignParentToChilds(child);
            }
        },
        updateParent: async function (node, val) {
            while (node) {
                if (!val && !this.hasCheckedChildren(node)) node.isChecked = val;
                else node.isChecked = true;
                node = node?.parent;
            }
        },
        hasCheckedChildren: function (node) {
            if (!this.isHaveChildren(node)) return false;
            for (let child of node.children) {
                if (child.isChecked) return true;
            }
            return false;
        },
        isHaveChildren(node) {
            return typeof node !== 'undefined' &&
                typeof node.children !== 'undefined' &&
                !this.isNodeOnBottomLevelOfHierarchy(node);
        },
    },
    data: function () {
        return {
            isShowChildren: false,
            isLoading: false,
        };
    },
}