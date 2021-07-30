import AwIcon from "../icons/AwIcon";

export default {
    inject: [
        "settings",
        "selected",
        "clickItem",
    ],
    props: {
        item: Object,
        settings: Object,
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