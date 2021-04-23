const showToast = {
    methods: {
        showToast(message, title, variant, delay = 5000) {
            this.$bvToast.toast(message, {
                title: title,
                variant: variant,
                solid: true,
                autoHideDelay: delay,
            });
        }
    }
}

export default showToast;