import moment from "moment";
import integrationFieldsMapping from '../import_form_integration_fields_mapping.json';

export default {
    data: function () {
        return {
            isProductionDetailsActive: true,
            otmDetails: [],
            currentMonthDateStart: moment().subtract(2,'months').format('MMMM YYYY'),
            currentMonthDateEnd: moment().subtract(1,'months').format('MMMM YYYY'),
            selectedWidget: 'productionDetails'
        };
    },
    methods: {
        getFormattingProductionDetails(data) {
            let self = this;
            let updatedData = [];
            _.forEach(data, function(item) {
                let temporaryData = {
                    'dzo': item.dzo_name,
                    'date': item.date,
                    '__time': new Date(item.date).getTime()
                };
                _.forEach(Object.keys(integrationFieldsMapping), function(key) {
                    let paramName = integrationFieldsMapping[key];
                    if (['import_downtime_reason','import_decrease_reason'].includes(key) && item[key] !== null) {
                        temporaryData = self.getUpdatedCategoryParams(item[key],paramName,temporaryData);
                    } else if (['natural_gas_production_fact','associated_gas_production_fact'].includes(key)) {
                        temporaryData[paramName] = self.getUpdateGasParam(temporaryData[paramName],item[key]);
                    } else {
                        temporaryData[paramName] = item[key];
                    }
                });
                updatedData.push(temporaryData);
            });
            return updatedData;
        },

        getUpdateGasParam(param,inputData) {
            if (!param) {
                return inputData;
            } else {
                return param + inputData;
            }
        },

        getUpdatedCategoryParams(items,paramName,temporaryData) {
            let updatedData = temporaryData;
            _.forEach(Object.keys(items), function(key) {
                if (!['id','dzo_import_data_id'].includes(key)) {
                    let fieldName = paramName[key];
                    if (fieldName) {
                        updatedData[fieldName] = items[key];
                    }
                }
            });
            return updatedData;
        },

        async getOtmByMonth() {
            let queryOptions = {'startPeriod': new Date(this.timestampToday),'endPeriod': new Date(this.timestampEnd)};
            let uri = this.localeUrl("/get-otm-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                console.log('otm');
                console.log(response.data)
                return response.data;
            }
            return {};
        },

        async getChemistryByMonth() {
            let queryOptions = {'startPeriod': new Date(this.timestampToday),'endPeriod': new Date(this.timestampEnd)};
            let uri = this.localeUrl("/get-chemistry-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                console.log('chemistry');
                console.log(response.data)
                return response.data;
            }
            return {};
        },

        updateChemistryWidget() {
            let temporaryChemistryDetails = _.cloneDeep(this.chemistryDetails);
            let self = this;
            _.forEach(temporaryChemistryDetails, function(item) {
                let dateOption = [moment(item.date).month(),moment(item.date).year()];
                let planIndex = self.dzoMonthlyPlans.findIndex(element => self.isChemistryRecordsSimple(dateOption,element,item.dzo_name));
                if (planIndex !== -1) {
                    item['bactericide_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_bakteracid * moment(item.date).daysInMonth();
                    item['corrosion_inhibitor_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_ingibator_korrozin * moment(item.date).daysInMonth();
                    item['demulsifier_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_demulg * moment(item.date).daysInMonth();
                    item['scale_inhibitor_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_ingibator_soleotloj * moment(item.date).daysInMonth();
                }
            });
            let groupedForChart =  _.groupBy(temporaryChemistryDetails, item => {
                return moment(item.date).startOf('day').format("YYYY-MM");
            });
            let chartData = {};
            if (groupedForChart) {
                for (let i in groupedForChart) {
                    chartData[i] = {
                        demulsifier: _.round(_.sumBy(groupedForChart[i], 'demulsifier'), 0),
                        bactericide: _.round(_.sumBy(groupedForChart[i], 'bactericide'), 0),
                        corrosion_inhibitor: _.round(_.sumBy(groupedForChart[i], 'corrosion_inhibitor'), 0),
                        scale_inhibitor: _.round(_.sumBy(groupedForChart[i], 'scale_inhibitor'), 0),
                    }
                }
            }

            this.chemistryChartData = chartData;
            let tableData = _(temporaryChemistryDetails)
                .groupBy("data")
                .map((item) => ({
                    bactericide: _.round(_.sumBy(item, 'bactericide'), 0),
                    bactericide_plan: _.round(_.sumBy(item, 'bactericide_plan'), 0),
                    corrosion_inhibitor: _.round(_.sumBy(item, 'corrosion_inhibitor'), 0),
                    corrosion_inhibitor_plan: _.round(_.sumBy(item, 'corrosion_inhibitor_plan'), 0),
                    demulsifier: _.round(_.sumBy(item, 'demulsifier'), 0),
                    demulsifier_plan: _.round(_.sumBy(item, 'demulsifier_plan'), 0),
                    scale_inhibitor: _.round(_.sumBy(item, 'scale_inhibitor'), 0),
                    scale_inhibitor_plan: _.round(_.sumBy(item, 'scale_inhibitor_plan'), 0),
                })).value();

            if (tableData.length > 0) {
                _.forEach(this.chemistryData, function(item) {
                    item.plan = tableData[0][item.code + '_plan'];
                    item.fact = tableData[0][item.code];
                });
                let totalChemistryFact = 0;
                _.forEach(Object.keys(tableData[0]), function(key) {
                    totalChemistryFact += tableData[0][key];
                });

                this.chemistryDataFactSumm = totalChemistryFact;
            }
        },

        isChemistryRecordsSimple(inputDateOption,planItem,inputDzoName) {
            return inputDateOption[0] === moment(planItem.date).month() &&
                inputDateOption[1] === moment(planItem.date).year() &&
                planItem.dzo === inputDzoName;
        },
    }
}