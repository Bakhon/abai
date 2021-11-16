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
        title: 'УзенМунайГаз',
        children: [
            {
                id: 13,
                title: '13 горизонт',
                children: [
                    {
                        id: 21,
                        title: 'Хум'
                    },
                    {
                        id: 22,
                        title: 'Парс'
                    }
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
        title: 'КаражанбасМунай'
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
        id: 2,
        title: 'Добыча нефти по новым скважинам, тыс.т'
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
    },
    {
        id: 5,
        title: 'Дебит нефти, т/сут',
        value: 'avg_debit'
    },
    {
        id: 6,
        title: 'Дебит нефти по новым скважинам, т/сут'
    },
    {
        id: 7,
        title: 'Ввод скважин, ед.',
        value: 'drilling_unit'
    },
    {
        id: 8,
        title: 'Ввод добывающих скважин из бурения, ед.',
        value: 'fds_operational_unit'
    },
    {
        id: 9,
        title: 'Ввод нагнетательных скважин скважин из бурения, ед.'
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
    analysis
}
