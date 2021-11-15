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
            this.node.isChecked = (this.parent.isChecked || false);
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

            this.$forceUpdate()
        },
        onCheckboxClick: async function () {
            this.onClick(this);
        },
        updateChildren: async function (node, level, val) {
            if (!node?.children) return;
            for (let child of node.children) {
                if(!('level' in child)) {
                    child.level = level + 1;
                }
                child.isChecked = val;
                this.updateChildren(child, level + 1, val);
            }
        },
        updateParent: async function(val) {
            let content = this.$parent;
            while(!!content?.node) {
                if(!val && this.hasCheckedChildren(content.node)) break;
                if(!('level' in content.node)) {
                    content.node.level = content.level;
                }
                content.node.isChecked = val;
                content = content.$parent;
            }
        },
        hasCheckedChildren: function(node) {
            if(!this.isHaveChildren(node)) return false;
            for(let child of node.children) {
                if(child.isChecked) return true;
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