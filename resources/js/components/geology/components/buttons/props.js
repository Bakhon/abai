export default {
    props: {
        href: String,
        iWidth:[String, Number],
        iHeight:[String, Number],
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
        icon: {
            type: [String, null],
            default: null
        },
        size: {
            type: String
        },
        hasCheckActive: Boolean,
        activeColor: {
            type: String,
            default: 'primary'
        },
    }
}
