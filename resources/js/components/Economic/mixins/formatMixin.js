export const formatValueMixin = {
    methods: {
        formatValue(value) {
            value = +value

            let absoluteValue = Math.abs(+value)

            if (absoluteValue < 1000) {
                return {
                    value: value,
                    dimension: ''
                }
            }

            if (absoluteValue < 1000000) {
                return {
                    value: value / 1000,
                    dimension: this.trans('economic_reference.thousand')
                }
            }

            if (absoluteValue < 1000000000) {
                return {
                    value: value / 1000000,
                    dimension: this.trans('economic_reference.million')
                }
            }

            return {
                value: value / 1000000000,
                dimension: this.trans('economic_reference.billion')
            }
        },
    }
}