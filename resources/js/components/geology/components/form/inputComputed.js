export default {
    computed: {
        getUID() {
            return this._uid;
        },
        listeners() {
            const {input, change, ...listeners} = this.$listeners
            return listeners
        },

    }
}
