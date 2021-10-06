import {calcDailyGasProduction, calcDailyWaterProduction, calcDailyOilProduction} from '~/helpers/omgNgduFormulas.js'

const calculateFluidParams = {
    methods: {
        calculateFluidParams(calculateGas = false) {
            let daily_fluid_production = this.formFields.daily_fluid_production.value;
            let bsw = this.formFields.bsw.value;

            if (daily_fluid_production && bsw) {
                this.formFields.daily_water_production.value = calcDailyWaterProduction(daily_fluid_production, bsw);
                this.formFields.daily_oil_production.value = calcDailyOilProduction(daily_fluid_production, bsw);
            }

            if (calculateGas) {
                let gas_factor = this.formFields.gas_factor.value;

                if (daily_fluid_production && gas_factor && bsw) {
                    this.formFields.daily_gas_production.value = calcDailyGasProduction(daily_fluid_production, gas_factor, bsw);
                }
            }
        }
    }
}

export default calculateFluidParams;