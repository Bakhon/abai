export const paletteMixin = {
    props: {
        scenarios: {
            required: true,
            type: Array
        },
        scenario: {
            required: true,
            type: Object
        },
        oilPrices: {
            required: true,
            type: Array,
        },
        isFullscreen: {
            required: false,
            type: Boolean
        },
        manufacturingProgram: {
            required: false,
            type: Object,
            default: null
        },
    },
    computed: {
        reverseOilPrices() {
            return [...this.oilPrices].reverse()
        },

        scenariosByOilPrice() {
            let scenariosByDollarRate = this.scenarios.filter(scenario =>
                +scenario.dollar_rate === +this.scenario.dollar_rate
            )

            return this.reverseOilPrices.map(oilPrice => {
                let variants = []

                scenariosByDollarRate.forEach(scenario => {
                    if (+scenario.oil_price !== +oilPrice) return

                    scenario.variants.forEach(variant => {
                        if (+variant.coef_cost_WR_payroll !== +this.scenario.coef_cost_WR_payroll) return

                        if (+variant.coef_Fixed_nopayroll !== +this.scenario.coef_Fixed_nopayroll) return

                        variants.push(variant)
                    })
                })

                return variants.reduce((prev, current) =>
                    (+prev.Operating_profit_optimize > +current.Operating_profit_optimize) ? prev : current
                )
            })
        },

        wellsByOilPrice() {
            return this.reverseOilPrices.map(oilPrice =>
                this.scenarios
                    .find(scenario =>
                        +scenario.oil_price === +oilPrice &&
                        +scenario.dollar_rate === +this.scenario.dollar_rate
                    )
                    .wells
            )
        },

        revenueTotalByOilPrice() {
            return this.reverseOilPrices.map((oilPrice, oilPriceIndex) => {
                let stoppedWells = this.scenariosByOilPrice[oilPriceIndex].stopped_uwis

                return {
                    title: `${+oilPrice} ${this.trans('economic_reference.dollar_per_bar')}`,
                    manufacturingProgram:
                        this.manufacturingProgram && +this.manufacturingProgram.oil_price === +oilPrice
                            ? +this.manufacturingProgram.revenue
                            : '',
                    bgColor: this.getBgColor(oilPriceIndex),
                    columns: this.reverseOilPrices.map((price, priceIndex) => {
                        let revenue = 0

                        this.wellsByOilPrice[priceIndex].forEach(well => {
                            if (stoppedWells.includes(well.uwi)) return

                            revenue += well.Revenue_total
                        })

                        return {
                            value: (revenue / 1000000).toFixed(2),
                            color: this.getColor(oilPrice, oilPriceIndex, price, priceIndex)
                        }
                    })
                }
            })
        },

        overallExpendituresByOilPrice() {
            return this.reverseOilPrices.map((oilPrice, oilPriceIndex) => {
                let stoppedWells = this.scenariosByOilPrice[oilPriceIndex].stopped_uwis

                return {
                    title: `${+oilPrice} ${this.trans('economic_reference.dollar_per_bar')}`,
                    manufacturingProgram:
                        this.manufacturingProgram && +this.manufacturingProgram.oil_price === +oilPrice
                            ? +this.manufacturingProgram.expenditures
                            : '',
                    bgColor: this.getBgColor(oilPriceIndex),
                    columns: this.reverseOilPrices.map((price, priceIndex) => {
                        let expenditures = 0

                        this.wellsByOilPrice[priceIndex].forEach(well => {
                            if (!stoppedWells.includes(well.uwi)) {
                                return expenditures += +well.Overall_expenditures_full
                            }

                            expenditures +=
                                +this.scenario.coef_Fixed_nopayroll * +well.Fixed_nopayroll_expenditures +
                                +this.scenario.coef_cost_WR_payroll * +well.Fixed_payroll_expenditures
                        })

                        return {
                            value: (expenditures / 1000000).toFixed(2),
                            color: this.getColor(oilPrice, oilPriceIndex, price, priceIndex)
                        }
                    }),
                }
            })
        },

        operatingProfitByOilPrice() {
            return this.reverseOilPrices.map((oilPrice, oilPriceIndex) => {
                let revenue = this.revenueTotalByOilPrice[oilPriceIndex]

                let expenditures = this.overallExpendituresByOilPrice[oilPriceIndex]

                return {
                    title: `${+oilPrice} ${this.trans('economic_reference.dollar_per_bar')}`,
                    manufacturingProgram:
                        this.manufacturingProgram && +this.manufacturingProgram.oil_price === +oilPrice
                            ? +this.manufacturingProgram.operating_profit
                            : '',
                    bgColor: this.getBgColor(oilPriceIndex),
                    columns: this.reverseOilPrices.map((price, priceIndex) => {
                        let operatingProfit = revenue.columns[priceIndex].value - expenditures.columns[priceIndex].value

                        return {
                            value: (operatingProfit).toFixed(2),
                            color: this.getColorOperatingProfit(oilPriceIndex, priceIndex, operatingProfit)
                        }
                    }),
                }
            })
        },
    },
    methods: {
        getColor(scenarioPrice, scenarioIndex, currentPrice, currentIndex) {
            if (scenarioPrice === currentPrice) {
                return '#106B4B'
            }

            let diff = Math.abs(scenarioIndex - currentIndex)

            switch (diff) {
                case 1:
                    return '#BDA74D'
                case 2:
                    return '#AC7550'
                default:
                    return scenarioIndex % 2 === 0 ? '#505585' : '#272953'
            }
        },

        getColorOperatingProfit(scenarioIndex, currentIndex, operatingProfit) {
            if (scenarioIndex === currentIndex) {
                return '#106B4B'
            }

            if (operatingProfit > 0 || currentIndex - scenarioIndex > 0) {
                return '#4A9B7E'
            }

            if (operatingProfit > -25000) {
                return '#BDA74D'
            }

            if (operatingProfit > -50000) {
                return '#AC7550'
            }

            return '#682041'
        },

        getBgColor(index) {
            return index % 2 === 0 ? '#333975' : '#393F78'
        }
    }
}