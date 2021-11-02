import AwIcon from "../icons/AwIcon";

export default {
    inject: [
        "selectItem",
        "settings",
        "selected",
        "clickItem",
        "clickItemFn",
    ],
    props: {
        item: Object,
        settings: Object,
        parent: Object,
        index: Number,
    },
    data() {
        return {
            isOpen: this.item.isOpen
        }
    },
    components: {
        AwIcon
    },
    computed: {
        getSelectedItems() {
            return this.selected || []
        },
        getStatBoxClasses() {
            return {
                "state-box": true,
                "opened": this.isOpen
            }
        },
        isFolder() {
            return (this.item.children && this.item.children.length);
        },
    },
    methods: {
        ontoggle() {
            this.isOpen = !this.isOpen;
        }
    }
}
