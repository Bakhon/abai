export class EcoRefsScenarioModel {
    constructor() {
        this.oil_price = {value: 0}

        this.dollar_rate = {value: 0}

        this.fixed_nopayroll = {value: 0}

        this.fixed_payroll = {value: 0}

        this.form = {
            name: null,
            sc_fa_id: null,
            source_id: null,
            params: {
                oil_prices: [this.oil_price],
                dollar_rates: [this.dollar_rate],
                fixed_nopayrolls: [this.fixed_nopayroll],
                fixed_payrolls: [this.fixed_payroll]
            }
        }
    }

    static get optimizationKeys() {
        return [
            'fixed_nopayroll',
            'fixed_payroll',
        ]
    }
}
