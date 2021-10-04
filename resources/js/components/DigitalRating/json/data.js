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

const indicatorList = [
    {
        uwi: 'UZN_0001',
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
        key: 'Действующий добывающий фонд на 30.07.2021',
        value: 1009
    },
    {
        key: 'Пробуренный фонд до 2007г',
        value: 1290
    },
    {
        key: 'Проектные скважины ПЗ-2007',
        value: 1239
    },
    {
        key: 'Плотность сетки, га/скв',
        value: '18,3'
    },
    {
        key: 'Проектный документ',
        value: 'Проект разработки 2007 г.'
    },
    {
        key: 'Расстояние между скважинами, м',
        value1: 50,
        value2: 100,
        value3: 200
    },
    {
        key: 'Кол-во пробуренных точек после 2007, ед.',
        value1: 57,
        value2: 197,
        value3: 239
    },
    {
        key: 'Совпадение точек после 2007г, %',
        value1: '74,3%',
        value2: '62,2%',
        value3: 239
    }
]

export {
    overviews,
    histories,
    secondIndicators,
    legends,
    maps,
    properties,
    objects,
    fileActions,
    mapActions,
    rowsOil,
    rowsHorizon
}
