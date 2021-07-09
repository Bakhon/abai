export default {
    methods: {
        onInput(e) {
            this.state = e.target.value
            this.$emit('input', this.state, e)
            if (this.lazy === true) {
                return
            }
            clearTimeout(this.syncTimeout)
            this.syncTimeout = setTimeout(() => {
                this.$emit('update:value', this.state, e)
            }, this.lazy !== false ? this.lazy : 0)
        },
        onChange(e) {
            this.state = e.target.value
            this.$emit('change', this.state, e)
            this.$emit('update:value', this.state, e)
        },
    }
}
