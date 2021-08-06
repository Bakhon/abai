import moment from "moment";
import Vue from "vue";

Vue.component('kpd-modal-documents', require('./modalDocuments.vue').default);
Vue.component('kpd-modal-catalog', require('./modalCatalog.vue').default);
Vue.component('kpd-modal-map', require('./modalMap.vue').default);
Vue.component('kpd-modal-monitoring', require('./modalMonitoring.vue').default);

export default {
    data: function () {
        return {
            hoveredElement: {
                index: 0,
                type: ''
            },
            currentYear: moment().year(),
            kpdCeo: [
                {
                    progress: 70,
                    name: 'Рост запасов',
                    hovered: false
                },
                {
                    progress: 125,
                    name: 'Повышение операционной\n эффективности',
                    hovered: false
                },
                {
                    progress: 50,
                    name: 'Реализация инвестиционных\n проектов',
                    hovered: false
                },
                {
                    progress: 125,
                    name: 'Оптимизация затрат\n и повышение ликвидности',
                    hovered: false
                },
            ],
            kpdCeoDecompositionA: [
                {
                    progress: 70,
                    name: 'Прирост извлекаемых запасов\n нефти и конденсата',
                    hovered: false
                },
                {
                    progress: 125,
                    name: 'Исполнение бизнес-инициатив',
                    hovered: false
                },
                {
                    progress: 50,
                    name: 'Реализация инвестиционных проектов',
                    hovered: false
                },
                {
                    progress: 0,
                    name: 'Чистый денежный поток в КЦ КМГ\n от дивизиона',
                    hovered: false
                },
                {
                    progress: 125,
                    name: 'Операционные и капитальные\n затраты по ДЗО дивизиона',
                    hovered: false
                },
            ],
            kpdCeoDecompositionB: [
                {
                    'manager': 'Конысов Н.К.',
                    'title': 'Директор департамента геологии и разведки',
                    'img': '/img/kpd-tree/konysov.png',
                    'kpd': [
                        {
                            name: 'Коэффициент восполнения запасов нефти и конденсата по категориям А+В+С1',
                            progress: 40,
                            parent: 0
                        },
                        {
                            name: 'Подготовка новых площадей для разведки и доразведки',
                            progress: 5,
                            parent: 0
                        },
                        {
                            name:'Количество успешных разведочных скважин',
                            progress:10,
                            parent: 0
                        },
                        {
                            name:'Коэффициент успешности бурения оценочных скважин',
                            progress:5,
                            parent: 0
                        },
                        {
                            name:'Завершить проведение полевых работ по ИГИ и получить отчет по проекту Женис',
                            progress:10,
                            parent: 0
                        }
                    ],
                    'concordants': [
                        {
                            'img': '/img/kpd-tree/vice-chairman.png',
                            'status': 'Согласовано',
                            'position': 'Заместитель председателя Правления по разведке и добыче',
                            'name': 'Марабаев Ж.Н.'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                    ]
                },
                {
                    'manager': 'Хасанов Д.К.',
                    'title': 'Директор департамента добычи',
                    'img': '/img/kpd-tree/hasanov.png',
                    'kpd': [
                        {
                            name: 'Исполнение бизнес-инициатив',
                            progress: 125,
                            parent: 1
                        },
                        {
                            name: 'Реализация инвестиционных проектов',
                            progress: 20,
                            parent: 2
                        },
                        {
                            name:'Исполнение мероприятий на 2021г. планов работ (программ) по увеличению КИН на 10 ключевых месторождений АО «НК «КазМунайГаз»',
                            progress:20,
                            parent: null
                        },
                        {
                            name:'«Разработка Плана мероприятий с целевыми показателями по  энерго-и ресурсосбережению и по снижению выбросов в атмосферный воздух до 2030 года» (предложения ДОТОС)',
                            progress:10,
                            parent:null
                        }
                    ],
                    'concordants': [
                        {
                            'img': '/img/kpd-tree/vice-chairman.png',
                            'status': 'Согласовано',
                            'position': 'Заместитель председателя Правления по разведке и добыче',
                            'name': 'Марабаев Ж.Н.'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                    ]
                },
                {
                    'manager': 'Туяков А.А.',
                    'title': 'Директор департамента крупных нефтегазовых проектов',
                    'img': '/img/kpd-tree/tuyakov.png',
                    'kpd': [
                        {
                            name: 'Чистый денежный поток в КЦ КМГ',
                            progress: 0,
                            parent: 3
                        },
                        {
                            name: 'Контроль затрат по проекту проекту установки 5го компрессора обратной закачки газа в рамках годовой Рабочей Программы и Бюджета',
                            progress: 100,
                            parent: 4
                        },
                        {
                            name:'Оптимизация затрат в рамках пред-базового проектирования и переход на базовое проектирование инвестиционного проекта Этап 2A.',
                            progress: 100,
                            parent: 4
                        },
                        {
                            name:'Контроль затрат ПБР/ПУУД',
                            progress: 100,
                            parent: 4
                        },
                        {
                            name:'Привлечение ДЗО КМГ для выполнения услуг в рамках реализации КНП, включая договора в рамках СоТУ/RFS/AWO',
                            progress: 100,
                            parent: null
                        }
                    ],
                    'concordants': [
                        {
                            'img': '/img/kpd-tree/vice-chairman.png',
                            'status': 'Согласовано',
                            'position': 'Заместитель председателя Правления по разведке и добыче',
                            'name': 'Марабаев Ж.Н.'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                        {
                            'img': '/img/kpd-tree/empty_photo.png',
                            'status': 'Согласовано',
                            'position': 'Должность',
                            'name': 'ФИО'
                        },
                    ]
                }
            ],
            kpdDecompositionA: {
                'manager': 'Марабаев Ж.Н.',
                'title': 'Заместитель председателя Правления по разведке и добыче',
                'img': '/img/kpd-tree/vice-chairman.png',
                'concordants': [
                    {
                        'img': '/img/kpd-tree/vice-chairman.png',
                        'status': 'Согласовано',
                        'position': 'Заместитель председателя Правления по разведке и добыче',
                        'name': 'Марабаев Ж.Н.'
                    },
                    {
                        'img': '/img/kpd-tree/empty_photo.png',
                        'status': 'Согласовано',
                        'position': 'Должность',
                        'name': 'ФИО'
                    },
                    {
                        'img': '/img/kpd-tree/empty_photo.png',
                        'status': 'Согласовано',
                        'position': 'Должность',
                        'name': 'ФИО'
                    },
                    {
                        'img': '/img/kpd-tree/empty_photo.png',
                        'status': 'Согласовано',
                        'position': 'Должность',
                        'name': 'ФИО'
                    }
                ]
            },
            selectedManager: {
                concordants: []
            }
        };
    },
    methods: {
        getProgressBarFillingColor(progress) {
            if (progress <= 70) {
                return 'progress-bar_filling__medium';
            } else if (progress > 70) {
                return 'progress-bar_filling__high';
            }
        },
        getHoveredElement(index, el) {
            this.hoveredElement.index = index;
            this.hoveredElement.type = el;
        },
        switchManager(manager) {
            this.selectedManager = manager;
            this.$modal.show('modalMap');
        }
    },
    async mounted() {
        this.selectedManager = this.kpdDecompositionA;
    }
}