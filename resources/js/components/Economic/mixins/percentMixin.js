export const calcPercentMixin = {
    methods: {
        calcPercent(last, prev) {
            last = +last

            prev = +prev

            if (!prev) {
                return last ? 100 : 0;
            }

            return prev < 0
                ? (prev - last) * 100 / prev
                : (last - prev) * 100 / prev
        }
    }
}
