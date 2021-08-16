import moment from "moment";
import integrationFieldsMapping from '../import_form_integration_fields_mapping.json';

export default {
    data: function () {
        return {
            isProductionDetailsActive: true,
            currentMonthDateStart: moment().subtract(2,'months').format('MMMM YYYY'),
            currentMonthDateEnd: moment().subtract(1,'months').format('MMMM YYYY'),
            selectedWidget: 'productionDetails',
            datePickerOptions: {
                disabledDate (date) {
                    return moment(date).startOf('month') >= moment().startOf('month')
                }
            },
            datePickerConfig: {
                start: {
                    type: 'string',
                    mask: 'DD.MM.YYYY',
                },
                end: {
                    type: 'string',
                    mask: 'DD.MM.YYYY',
                },
            },
            dzoMenu: {
                'chemistry': [],
                'wellsWorkover': [],
                'drilling': [],
                'productionFond': [],
                'injectionFond': [],
            },
        };
    },
    methods: {
        getFormattingProductionDetails(data) {
            let self = this;
            let updatedData = [];
            let fieldsMapping = _.cloneDeep(integrationFieldsMapping);
            _.forEach(data, function(item) {
                let temporaryData = {
                    'dzo': item.dzo_name,
                    'date': moment(item.date).startOf('day').valueOf(),
                    '__time': new Date(item.date).getTime()
                };
                _.forEach(Object.keys(fieldsMapping), function(key) {
                    let paramName = fieldsMapping[key];
                    temporaryData = self.getDataUpdatedByMapping(key,paramName,temporaryData,item);
                });
                updatedData.push(temporaryData);
            });
            return updatedData;
        },

        getDataUpdatedByMapping(key,paramName,temporaryData,item) {
            let categories = ['import_downtime_reason','import_decrease_reason'];
            let gasFields = ['natural_gas_production_fact','associated_gas_production_fact'];
            if (categories.includes(key) && item[key] !== null) {
                temporaryData = this.getUpdatedCategoryParams(item[key],paramName,temporaryData);
            } else if (gasFields.includes(key)) {
                temporaryData[key] = item[key];
                temporaryData[paramName] = this.getUpdatedGasParam(temporaryData[paramName],item[key]);
            } else {
                temporaryData[paramName] = this.getMappedByCurrentCategory(item,key);
            }
            return temporaryData;
        },

        getUpdatedGasParam(param,inputData) {
            if (!param) {
                return inputData;
            } else {
                return param + inputData;
            }
        },

        getMappedByCurrentCategory(item,key) {
            if (this.selectedButtonName === 'oilCondensateDeliveryButton') {
                let mappedFieldName = this.consolidatedMenuMapping.oilDelivery[key];
                if (mappedFieldName) {
                    return item[mappedFieldName];
                }
            }
            return item[key];
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
            this.SET_LOADING(true);
            _.forEach(this.tableMapping, function (item) {
                _.set(item, 'class', 'hide-company-list');
                _.set(item, 'hover', '');
            });
            this.tableMapping[widgetName]['class'] = 'show-company-list';
            this.tableMapping[widgetName]['hover'] = 'button_hover';
            this.updateChemistryWidget();
            this.updateWellsWorkoverWidget();
            this.updateDrillingWidget();
            this.updateProductionFondWidget();
            this.SET_LOADING(false);
        },

        getOrderedByAsc(data) {
            return _.orderBy(data,
                ["date"],
                ["asc"]
            );
        },

        updateDzoMenu() {
            let self = this;
            if (this.isOneDzoSelected) {
                self.injectionWellsOptions = _.filter(self.injectionWellsOptions, function (item) {
                    let selectedDzoCompanies = self.selectedDzoCompanies;
                    if (Array.isArray(selectedDzoCompanies)) {
                        selectedDzoCompanies = selectedDzoCompanies['0']
                    }
                    if (item.ticker === selectedDzoCompanies) {
                        return item
                    }
                })
            }
            this.dzoMenu = _.mapValues(this.dzoMenu, () => _.cloneDeep(this.injectionWellsOptions));
        },
    }
}