export class TechnicalWellForecastKitModel {
    constructor() {
        this.permanent_stop_coefficient = {value: 0}

        this.form = {
            name: null,
            economic_log_id: null,
            technical_log_id: null,
            permanent_stop_coefficients: [
                {value: 0.1},
                {value: 0.2},
                {value: 0.3},
                {value: 0.4},
                {value: 0.5},
                {value: 0.6},
                {value: 0.7},
                {value: 0.8},
                {value: 0.9},
            ]
        }
    }
}
