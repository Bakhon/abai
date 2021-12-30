const overviews = [
    {
        horizon: 13,
        code: 1,
        liquid: 32,
        water: 45,
        oil: 14.8,
        note: 'Низкое К прод'
    },
    {
        horizon: 14,
        code: 8,
        liquid: 45,
        water: 65,
        oil: 15.5,
        note: 'Низкое К прод'
    },
    {
        horizon: 17,
        code: 4,
        liquid: 22,
        water: 40,
        oil: 11.5,
        note: 'Низкое К прод'
    },
];

const histories = [
    {
        period: 2017,
        reconciling: 'КазНИПИ',
        comment: 'Не согласовано.Риск получения высокообводненной продукции'
    },
    {
        period: 2018,
        reconciling: 'КМГИ',
        comment: 'Не согласовано'
    },
    {
        period: 2019,
        reconciling: 'ОМГ',
        comment: 'Не согласовано'
    }
]

const secondIndicators = [
    {
        number: 'UZN_1001',
        response: 100,
        pressure: 123,
        distance: 452,
    },
    {
        number: 'UZN_0002',
        response: 200,
        pressure: 120,
        distance: 245,
    },
    {
        number: 'UZN_0003',
        response: 500,
        pressure: 100,
        distance: 345,
    }
]

const legends = [
    {
        color: '#008000',
        title: 'Нефтяная зона, не вовлеченная в разработку'
    },
    {
        color: '#20B2AA',
        title: 'Водо-нефтяная зона, не вовлеченная в разработку'
    },
    {
        color: '#F0E68C',
        title: 'Выработка запасов менее 50%'
    },
    {
        color: '#BDB76B',
        title: 'Возможно бурение дублеров'
    },
    {
        color: '#FFFF00',
        title: 'Возможны возвраты с выше- или нижележащих горизонтов'
    },
    {
        color: '#8B4513',
        title: 'Выработка запасов более 50%'
    },
    {
        color: '#FF0000',
        title: 'Имеются действущие скважины'
    },
    {
        color: '#FF6347',
        title: 'Возможно углубления забоя вышележащих скважин'
    },
    {
        color: '#FFA500',
        title: 'Имеются проектные скважины'
    }
]

const mapList = [
    {
        id: 1,
        title: 'Карта пробуренного фонда скважин'
    },
    {
        id: 2,
        title: 'Карта текущих отборов/закачки'
    },
    {
        id: 3,
        title: 'Карта накопленных отборов/закачки'
    }
]

const horizons = [
    {
        id: 13,
        title: '13 горизонт'
    },
    {
        id: 14,
        title: '14 горизонт'
    },
    {
        id: 15,
        title: '15 горизонт'
    },
    {
        id: 16,
        title: '16 горизонт'
    },
    {
        id: 17,
        title: '17 горизонт'
    },
    {
        id: 18,
        title: '18 горизонт'
    },
    {
        id: 19,
        title: '19 горизонт'
    },
    {
        id: 20,
        title: '20 горизонт'
    },
    {
        id: 21,
        title: '21 горизонт'
    },
    {
        id: 22,
        title: '22 горизонт'
    },
    {
        id: 23,
        title: '23 горизонт'
    },
    {
        id: 24,
        title: '24 горизонт'
    }
]

const objectList = [
    {
        id: 1,
        title: 'Карамандыбас',
        children: [
            {
                id: 18,
                title: '18 горизонт',
                children: [
                    {
                        id: 21,
                        title: 'Западный купол'
                    },
                ]
            },
            {
                id: 14,
                title: '14 горизонт'
            },
        ]
    },
    {
        id: 2,
        title: 'Узень',
        children: [
            {
                id: 13,
                title: '13 горизонт',
                children: [

                ]
            },
            {
                id: 14,
                title: '14 горизонт',
            },
            {
                id: 15,
                title: '15 горизонт',
                children: [
                    {
                        id: 5,
                        title: 'Основной свод',
                        owc_id: 'owc_out_uzn_15_osn'
                    },
                    {
                        id: 6,
                        title: 'Северо-запад'
                    },
                    {
                        id: 7,
                        title: 'Парсумурун'
                    },
                ]
            }
        ]
    }
]

const properties = ['Значок', 'Шрифт', 'Палитра']

const fileActions = [
    { title: 'digital_rating.import', icon: 'upload', type: 'import'  },
    { title: 'digital_rating.export', icon: 'download', type: 'export' },
    { title: 'digital_rating.save', icon: 'save', type: 'save' }
]

const mapActions = [
    { title: 'digital_rating.uploadCustomMaps', icon: 'share', type: 'upload' },
    { title: 'digital_rating.importPlannedWells', icon: 'upload', type: 'importWells' }
]

const rowsOil = [
    {
        year: '2007',
        project: '324,5',
        fact: '251,5',
        rejection: '-73,3'
    },
    {
        year: '2008',
        project: '324,5',
        fact: '251,5',
        rejection: '-78,6'
    },
    {
        year: '2009',
        project: '324,5',
        fact: '251,5',
        rejection: 19
    },
    {
        year: '2010',
        project: '324,5',
        fact: '251,5',
        rejection: 5
    },
    {
        year: '2011',
        project: '324,5',
        fact: '251,5',
        rejection: '-5,4'
    },
    {
        year: '2012',
        project: '324,5',
        fact: '251,5',
        rejection: '-0,8'
    },
    {
        year: '2013',
        project: '324,5',
        fact: '251,5',
        rejection: 19
    },
    {
        year: '2014',
        project: '324,5',
        fact: '251,5',
        rejection: 5
    },
    {
        year: '2015',
        project: '324,5',
        fact: '251,5',
        rejection: '-0,8'
    },
    {
        year: '2016',
        project: '324,5',
        fact: '251,5',
        rejection: 19
    },
    {
        year: '2017',
        project: '324,5',
        fact: '251,5',
        rejection: 5
    },
    {
        year: '2018',
        project: '324,5',
        fact: '251,5',
        rejection: '-0,8'
    },
    {
        year: '2019',
        project: '324,5',
        fact: '251,5',
        rejection: 19
    },
    {
        year: '2020',
        project: '324,5',
        fact: '251,5',
        rejection: 5
    },
];

const rowsHorizon = [
    {
        key: 'Пробуренный фонд на 2008г.',
        value: 50
    },
    {
        key: 'Количество проектных скважин',
        value: 80
    },
    {
        key: 'Количество пробуренных скважин 2007-2008гг.',
        value: 34
    },
    {
        key: 'Радиус',
        value1: '50м',
        value2: '100м',
        value3: '200м'
    },
    {
        key: 'Совпадение пробуренных скважин с проектными точками, скв.(%)',
        value1: '5(10%)',
        value2: '7(15%)',
        value3: '8(17%)'
    }
];

const actualIndicators = [
    {
        id: 1,
        title: 'Добыча нефти, тыс.т',
        value: 'oil_production'
    },
    {
        id: 3,
        title: 'Добыча жидкости, тыс.т',
        value: 'liquid_val'
    },
    {
        id: 4,
        title: 'Обводненность, %',
        value: 'water_inj'
    }
]

const analysis = [
    {
        id: 1,
        title: 'Сравнение по добыче нефти и фонду скважин',
        checked: false
    },
    {
        id: 2,
        title: 'Сравнение по накопленной добыче нефти',
        checked: false
    },
    {
        id: 3,
        title: 'Отклонение по добыче нефти и фонду скважин',
        checked: false
    },
    {
        id: 4,
        title: 'Отклонение по добыче нефти и дебиту нефти',
        checked: false
    },
    {
        id: 5,
        title: 'Распределение отклонений нефти по факторам, тыс.т',
        checked: false
    },
    {
        id: 6,
        title: 'Распределение отклонений нефти по факторам, %',
        checked: false
    }
]

const factorTableHeads = [
    [
        {
            title: 'Годы',
            rowspan: '3',
        },
        {
            title: 'Сравнение по добыче нефти, тыс.т.',
            rowspan: '2',
            colspan: '3'
        },
        {
            title: 'Распределение отклонения добычи нефти по факторам',
            colspan: '8'
        }
    ],
    [
        {
            title: 'по фонду добывающих скважин',
            colspan: '2'
        },
        {
            title: 'по дебиту нефти',
            colspan: '2'
        },
        {
            title: 'по обводненности',
            colspan: '2'
        },
        {
            title: 'по закачке (компенсации отборов) и другим факторам',
            colspan: '2'
        }
    ],
    [
        {
            title: 'проект'
        },
        {
            title: 'факт'
        },
        {
            title: 'разница, +/-'
        },
        {
            title: '+/-'
        },
        {
            title: '% распределения'
        },
        {
            title: '+/-'
        },
        {
            title: '% распределения'
        },
        {
            title: '+/-'
        },
        {
            title: '% распределения'
        },
        {
            title: '+/-'
        },
        {
            title: '% распределения'
        },
    ]
]

const factorRows = [
    {
        year: 2007,
        project: '324,6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '31',
        oilDifference: '-48.9',
        oilDistribution: '67',
        waterDifference: '1.7',
        waterDistribution: '2',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2008,
        project: '324.6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '31',
        oilDifference: '-48.9',
        oilDistribution: '67',
        waterDifference: '1.7',
        waterDistribution: '2',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2009,
        project: '324.6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '100',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2010,
        project: '324.6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '100',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2011,
        project: '324.6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '96',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '-2.4',
        waterDistribution: '3',
        uploadDifference: '-1.9',
        uploadDistribution: '2'
    },
    {
        year: 2012,
        project: '324.6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '80',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '-16.4',
        uploadDistribution: '20'
    },
    {
        year: 2013,
        project: '324.6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '100',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2014,
        project: '324.6',
        fact: '-21.9',
        difference: '-73.3',
        wellDifference: '-22.7',
        wellDistribution: '100',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2015,
        project: '324.6',
        fact: '-21.9',
        difference: '5.0',
        wellDifference: '5.0',
        wellDistribution: '100',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2016,
        project: '324.6',
        fact: '-21.9',
        difference: '16.9',
        wellDifference: '8.0',
        wellDistribution: '47',
        oilDifference: '8.9',
        oilDistribution: '53',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2017,
        project: '324.6',
        fact: '-21.9',
        difference: '16.3',
        wellDifference: '2.0',
        wellDistribution: '12',
        oilDifference: '5.0',
        oilDistribution: '31',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '9.3',
        uploadDistribution: '57'
    },
    {
        year: 2018,
        project: '324.6',
        fact: '-21.9',
        difference: '-8.3',
        wellDifference: '-8.3',
        wellDistribution: '100',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2019,
        project: '324.6',
        fact: '-21.9',
        difference: '-18.8',
        wellDifference: '-18.8',
        wellDistribution: '100',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '',
        waterDistribution: '',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 2020,
        project: '324.6',
        fact: '297.4',
        difference: '-48.5',
        wellDifference: '-47.8',
        wellDistribution: '99',
        oilDifference: '',
        oilDistribution: '',
        waterDifference: '-0.4',
        waterDistribution: '1',
        uploadDifference: '',
        uploadDistribution: ''
    },
    {
        year: 'Итого',
        project: '3421.2',
        fact: '1.2323',
        difference: '1.693',
        wellDifference: '1.434',
        wellDistribution: '86',
        oilDifference: '-64.3',
        oilDistribution: '12',
        waterDifference: '-7.1',
        waterDistribution: '1',
        uploadDifference: '-48.2',
        uploadDistribution: '2'
    }
]

export {
    overviews,
    histories,
    secondIndicators,
    legends,
    mapList,
    properties,
    horizons,
    fileActions,
    mapActions,
    rowsOil,
    rowsHorizon,
    actualIndicators,
    objectList,
    analysis,
    factorTableHeads,
    factorRows
}
