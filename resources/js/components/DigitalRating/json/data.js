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

const indicators = [
    {
        number: 'UZN_0001',
        liquid: 32,
        water: 45,
        oil: '14,8',
        level: 550
    },
    {
        number: 'UZN_0002',
        liquid: 45,
        water: 60,
        oil: '15,1',
        level: 420
    },
    {
        number: 'UZN_0003',
        liquid: 50,
        water: 80,
        oil: '16,5',
        level: 700
    }
]

const secondIndicators = [
    {
        number: 'UZN_1001',
        response: 100,
        pressure: 123,
        distance: 452,
        diameter: 2
    },
    {
        number: 'UZN_0002',
        response: 200,
        pressure: 120,
        distance: 245,
        diameter: 3
    },
    {
        number: 'UZN_0003',
        response: 500,
        pressure: 100,
        distance: 345,
        diameter: 4
    }
]

const cods = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']

const maps = [
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

const objects = [
    {
        id: 1,
        title: '13 горизонт'
    },
    {
        id: 2,
        title: '14 горизонт'
    },
    {
        id: 3,
        title: '15 горизонт'
    },
    {
        id: 4,
        title: '16 горизонт'
    },
    {
        id: 5,
        title: '17 горизонт'
    },
    {
        id: 6,
        title: '18 горизонт'
    },
    {
        id: 7,
        title: '19 горизонт'
    },
    {
        id: 8,
        title: '20 горизонт'
    },
    {
        id: 9,
        title: '21 горизонт'
    },
    {
        id: 10,
        title: '22 горизонт'
    },
    {
        id: 11,
        title: '23 горизонт'
    },
    {
        id: 12,
        title: '24 горизонт'
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

export {
    overviews,
    histories,
    indicators,
    secondIndicators,
    cods,
    maps,
    properties,
    objects,
    fileActions,
    mapActions
}
