const optimizedColumns = [
    'Revenue_total',
    'Revenue_local',
    'Revenue_export',
    'oil',
    'liquid',
    'prs',
    'uwi_count',
    'days_worked',
    'production_export',
    'production_local',
    'Fixed_noWRpayroll_expenditures',
    'Overall_expenditures',
    'Overall_expenditures_full',
    'Operating_profit',
];

const optimizedScenarioColumns = [
    'Overall_expenditures',
    'Overall_expenditures_full',
    'Operating_profit',
];

const jsonColumns = [
    'uwi_stop',
]

let economicRes = {
    scenarios: [{
        scenario_id: null,
        percent_stop_cat_1: 0,
        percent_stop_cat_2: 0,
        coef_Fixed_nopayroll: 0,
        coef_cost_WR_payroll: 0,
        dollar_rate: 0,
        oil_price: 0,
        uwi_stop: [],
    }],
    dollarRate: {
        value: 0,
        url: ''
    },
    oilPrice: {
        value: 0,
        url: ''
    },
    org: {
        id: '',
        name: ''
    },
    gtms: []
}

let columnPairs = (column) => {
    if (optimizedScenarioColumns.includes(column)) {
        return [
            {
                original: column,
                optimized: `${column}_scenario`
            },
            {
                original: `${column}_profitable`,
                optimized: `${column}_scenario_profitable`
            },
            {
                original: `${column}_profitless_cat_1`,
                optimized: `${column}_scenario_profitless_cat_1`
            },
            {
                original: `${column}_profitless_cat_2`,
                optimized: `${column}_scenario_profitless_cat_2`
            },
        ]
    }

    return [
        {
            original: column,
            optimized: `${column}_optimized`
        },
        {
            original: `${column}_profitable`,
            optimized: `${column}_profitable_optimized`
        },
        {
            original: `${column}_profitless_cat_1`,
            optimized: `${column}_profitless_cat_1_optimized`
        },
        {
            original: `${column}_profitless_cat_2`,
            optimized: `${column}_profitless_cat_2_optimized`
        },
    ]
}

let columnVariations = (column) => {
    let pairs = columnPairs(column)

    let variations = []

    pairs.forEach(pair => variations.push(pair.original, pair.optimized))

    return variations
}

optimizedColumns.forEach(column => {
    columnPairs(column).forEach(pair => {
        economicRes.scenarios[0][pair.original] = {
            original_value: 0,
            original_value_optimized: 0,
        }
    })
})

export const scenarioMixin = {
    data: () => ({
        form: {
            org_id: null,
            scenario_id: null
        },
        scenarioVariation: {
            dollar_rate: null,
            oil_price: null,
            salary_percent: null,
            retention_percent: null,
            optimization_percent: {
                cat_1: null,
                cat_2: null,
            },
            isFullScreen: false
        },
        res: economicRes,
    }),
    computed: {
        scenarios() {
            return [
                {
                    label: this.trans('economic_reference.basic_variant'),
                    value: null,
                },
                {
                    label: this.trans('economic_reference.test_scenario'),
                    value: 6,
                }
            ]
        },

        scenario() {
            let scenario = this.res.scenarios.find(item =>
                item.oil_price === this.scenarioVariation.oil_price &&
                item.dollar_rate === this.scenarioVariation.dollar_rate &&
                item.coef_cost_WR_payroll === this.scenarioVariation.salary_percent &&
                item.coef_Fixed_nopayroll === this.scenarioVariation.retention_percent &&
                item.percent_stop_cat_1 === this.scenarioVariation.optimization_percent.cat_1 &&
                item.percent_stop_cat_2 === this.scenarioVariation.optimization_percent.cat_2
            ) || this.res.scenarios[0]

            jsonColumns.forEach(column => {
                if (typeof scenario[column] === 'string') {
                    scenario[column] = JSON.parse(scenario[column])
                }
            })

            return scenario
        },

        scenarioVariations() {
            let variations = {
                oil_prices: {},
                dollar_rates: {},
                salary_percents: {},
                retention_percents: {},
                optimization_percents: {},
            }

            this.res.scenarios.forEach(item => {
                variations.oil_prices[item.oil_price] = 1

                variations.dollar_rates[item.dollar_rate] = 1

                variations.salary_percents[item.coef_cost_WR_payroll] = 1

                variations.retention_percents[item.coef_Fixed_nopayroll] = 1

                variations.optimization_percents[`${item.percent_stop_cat_1}-${item.percent_stop_cat_2}`] = 1
            })

            variations.oil_prices = Object.keys(variations.oil_prices)

            variations.dollar_rates = Object.keys(variations.dollar_rates)

            variations.salary_percents = Object.keys(variations.salary_percents).map(value => ({
                label: `${value * 100}%`,
                value: value,
            }))

            variations.retention_percents = Object.keys(variations.retention_percents).map(value => ({
                label: `${value * 100}%`,
                value: value,
            }))

            variations.optimization_percents = Object.keys(variations.optimization_percents).map((value) => {
                let values = value.split('-')

                let cat1 = values[0]

                let cat2 = values[1]

                return {
                    label: `${this.trans('economic_reference.cat_1_trips')}: ${cat1 * 100}%, ` +
                        `${this.trans('economic_reference.cat_2_trips')}: ${cat2 * 100}%`,
                    value: {
                        cat_1: cat1,
                        cat_2: cat2
                    }
                }
            })

            return variations
        },

        scenarioValueKey() {
            return this.form.scenario_id ? 'original_value_optimized' : 'original_value'
        },

        dollarRatePercent() {
            return (+this.res.dollarRate.value - (+this.scenario.dollar_rate)).toFixed(2)
        },

        oilPricePercent() {
            return (+this.res.oilPrice.value - (+this.scenario.oil_price)).toFixed(2)
        },

        oilPercent() {
            return this.scenario.oil.original_value - this.scenario.oil.original_value_optimized
        },

        prsPercent() {
            return this.scenario.prs.original_value_optimized - this.scenario.prs.original_value
        },

        liquidPercent() {
            return (this.liquidValue() - this.liquidValue(false)).toFixed(2)
        },

        avgOilPercent() {
            return (this.avgOilValue() - this.avgOilValue(false)).toFixed(2)
        },

        avgLiquidPercent() {
            return (this.avgLiquidValue(true, 4) - this.avgLiquidValue(false, 4)).toFixed(2)
        },

        avgPrsPercent() {
            return (this.avgPrsValue(true, 4) - this.avgPrsValue(false, 4)).toFixed(2)
        },

        remoteHeaders() {
            return [
                {
                    name: this.trans('economic_reference.oil_price'),
                    url: this.res.oilPrice.url,
                    value: this.res.oilPrice.value,
                    dimension: '$ / bbl',
                    percent: this.oilPricePercent,
                },
                {
                    name: this.trans('economic_reference.course_prices'),
                    url: this.res.dollarRate.url,
                    value: this.res.dollarRate.value,
                    dimension: 'kzt / $',
                    percent: this.dollarRatePercent,
                }
            ]
        },
    },
    methods:{
        selectScenario() {
            this.scenarioVariation.dollar_rate = this.scenarioVariations.dollar_rates[0]

            this.scenarioVariation.oil_price = this.scenarioVariations.oil_prices[0]

            this.scenarioVariation.salary_percent = this.scenarioVariations.salary_percents[0].value

            this.scenarioVariation.retention_percent = this.scenarioVariations.retention_percents[0].value

            this.scenarioVariation.optimization_percent.cat_1 = this.scenarioVariations.optimization_percents[0].value.cat_1

            this.scenarioVariation.optimization_percent.cat_2 = this.scenarioVariations.optimization_percents[0].value.cat_2
        },

        liquidValue(optimized = true) {
            if (!this.form.scenario_id) {
                optimized = false
            }

            let liquid = optimized
                ? +this.scenario.liquid.original_value_optimized
                : +this.scenario.liquid.original_value

            let oil = optimized
                ? +this.scenario.oil.original_value_optimized
                : +this.scenario.oil.original_value

            // TODO: посмотреть более точную формулу
            return liquid
                ? (100 * (liquid - oil) / liquid).toFixed(2)
                : 0
        },

        avgOilValue(optimized = true) {
            if (!this.form.scenario_id) {
                optimized = false
            }

            let days_worked = optimized
                ? +this.scenario.days_worked.original_value_optimized
                : +this.scenario.days_worked.original_value

            let oil = optimized
                ? +this.scenario.oil.original_value_optimized
                : +this.scenario.oil.original_value

            return days_worked
                ? (oil / days_worked).toFixed(2)
                : 0
        },

        avgLiquidValue(optimized = true, fractionDigits = 2) {
            if (!this.form.scenario_id) {
                optimized = false
            }

            let days_worked = optimized
                ? +this.scenario.days_worked.original_value_optimized
                : +this.scenario.days_worked.original_value

            let liquid = optimized
                ? +this.scenario.liquid.original_value_optimized
                : +this.scenario.liquid.original_value

            return days_worked
                ? (liquid / days_worked).toFixed(fractionDigits)
                : 0
        },

        avgPrsValue(optimized = true, fractionDigits = 2) {
            if (!this.form.scenario_id) {
                optimized = false
            }

            let uwi_count = optimized
                ? +this.scenario.uwi_count.original_value_optimized
                : +this.scenario.uwi_count.original_value

            let prs = optimized
                ? +this.scenario.prs.original_value_optimized
                : +this.scenario.prs.original_value

            return uwi_count
                ? (prs / uwi_count).toFixed(fractionDigits)
                : 0
        },
    }
}
