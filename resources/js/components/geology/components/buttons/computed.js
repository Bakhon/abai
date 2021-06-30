export default {
    computed: {
        classes() {
            return {
                'a-btn': true,
                [this.color]: this.color,
                [this.align]: this.align,
                [this.size]: this.size,
            }
        }
    }
}
