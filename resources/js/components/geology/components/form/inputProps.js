export default {
    props: {
        label: String,
        labelDirection: {
            type: String,
            default: "column"
        },
        readonly: Boolean,
        plaintext: Boolean,
        value: String|Number,
        size: {
            type: String,
            default: 'md',
        }
    }
}
