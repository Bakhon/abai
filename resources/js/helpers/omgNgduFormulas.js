const averageOilDensity = 853;

export function calcDailyGasProduction(daily_fluid_production, gas_factor, bsw, precision = 2) {
    return (gas_factor * daily_fluid_production * (1 - bsw / 100)).toFixed(precision);
}

export function calcDailyWaterProduction(daily_fluid_production, bsw, precision = 2) {
    return ((daily_fluid_production * bsw) / 100).toFixed(precision);
}

export function calcDailyOilProduction(daily_fluid_production, bsw, precision = 2) {
    return (((daily_fluid_production * (100 - bsw)) / 100) * averageOilDensity / 1000).toFixed(precision);
}
