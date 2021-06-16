import moment from "moment";
import integrationFieldsMapping from '../import_form_integration_fields_mapping.json';

export default {
    data: function () {
        return {
            isProductionDetailsActive: true,
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

        switchWidget(widgetName) {
            this.$store.commit('globalloading/SET_LOADING', true);
            _.forEach(this.tableMapping, function (item) {
                _.set(item, 'class', 'hide-company-list');
                _.set(item, 'hover', '');
            });
            this.tableMapping[widgetName]['class'] = 'show-company-list';
            this.tableMapping[widgetName]['hover'] = 'button_hover';
        },
    }
}