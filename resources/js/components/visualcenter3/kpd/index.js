import moment from "moment";

export default {
    data: function () {
        return {
            kpdCeo: [
                {
                    progress: 70,
                    name: 'Рост запасов',
                },
                {
                    progress: 125,
                    name: 'Повышение операционной\n эффективности',
                },
                {
                    progress: 50,
                    name: 'Реализация инвестиционных\n проектов',
                },
                {
                    progress: 125,
                    name: 'Оптимизация затрат\n и повышение ликвидности',
                },
            ]
        };
    },
    methods: {
        getProgressBarFillingColor(progress) {
            if (progress <= 70) {
                return 'progress-bar_filling__medium';
            } else if (progress > 70) {
                return 'progress-bar_filling__high';
            }
        }
    },
    async mounted() {

    }
}