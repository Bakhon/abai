export default {
    computed: {
        getUID() {
            return this._uid;
        },
        listeners() {
            const {input, change, ...listeners} = this.$listeners
            return listeners
        },
        getClasses() {
            return {
                ["direction-"+this.labelDirection]: true,
                [this.size]: true
            }
        }
    }
}
