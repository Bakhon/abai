const showToast = {
    methods: {
        showToast(message, title, variant) {
            this.$bvToast.toast(message, {
                title: title,
                variant: variant,
                solid: true
            });
        }
    }
}

export default showToast;