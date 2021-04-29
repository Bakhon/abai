export class EcoRefsScenarioModel {
    constructor() {
        this.oil_price = {value: 0}

        this.course_price = {value: 0}

        this.optimization = {
            fixed_nopayroll: 0.5,
            fixed_payroll: 0.7
        }

        this.form = {
            name: null,
            sc_fa_id: null,
            params: {
                oil_prices: [this.oil_price],
                course_prices: [this.course_price],
                optimizations: [this.optimization]
            }
        }
    }
}
