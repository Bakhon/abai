export default {
    props: {
        href: String,
        iWidth:[String, Number],
        iHeight:[String, Number],
        loading: Boolean,
        align: {
            type: String,
            validator(value) {
                return ['center', 'left', 'right', ''].includes(value);
            }
        },
        color: {
            type: String,
            default: "default",
        },
        variant: {
            type: String,
            validator(value) {
                return ['for-switch', ''].includes(value);
            }
        },
        icon: {
            type: [String, null],
            default: null
        },
        size: {
            type: String
        },
        hasCheckActive: Boolean,
        disabled: Boolean,
        activeColor: {
            type: String,
            default: 'primary'
        },
    }
}
