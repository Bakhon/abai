export const waterCutMixin = {
    methods: {
        calcWaterCut(liquid, oil) {
            return liquid
                ? (100 * (liquid - oil) / liquid).toFixed(2)
                : 0
        }
    }
}