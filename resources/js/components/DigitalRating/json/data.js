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

export {
    overviews,
    histories,
    indicators
}
