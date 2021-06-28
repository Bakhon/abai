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
                'productionFond': []
            },
            fondList: {
                production:  {
                    'work': [
                        'operating_production_fond',
                        'active_production_fond',
                        'inactive_production_fond',
                        'developing_production_fond',
                        'pending_liquidation_production_fond',
                    ],
                    'idle': [
                        'prs_wait_downtime_production_wells_count',
                        'prs_downtime_production_wells_count',
                        'krs_wait_downtime_production_wells_count',
                        'krs_downtime_production_wells_count',
                        'well_survey_downtime_production_wells_count',
                        'unprofitable_downtime_production_wells_count',
                        'other_downtime_production_wells_count'
                    ]
                },
                other: [
                    'glut_downtime_production_wells_count',
                    'impulse_replacement_downtime_production_wells_count',
                    'electrical_part_downtime_production_wells_count',
                    'ground_repair_downtime_production_wells_count',
                    'periodic_downtime_production_wells_count',
                    'production_restriction_downtime_production_wells_count',
                    'well_treatment_downtime_production_wells_count',
                    'highly_watered_downtime_production_wells_count',
                    'limited_download_downtime_production_wells_count',
                    'profile_alignment_downtime_production_wells_count',
                    'coiltubing_downtime_production_wells_count',
                    'chrf_restriction_downtime_production_wells_count',
                    'drilling_restriction_downtime_production_wells_count',
                    'waiting_pump_downtime_production_wells_count',
                    'waiting_swabbing_downtime_production_wells_count',
                    'regulate_stopped_downtime_production_wells_count',
                    'waiting_ppr_downtime_production_wells_count',
                    'impact_prs_downtime_production_wells_count',
                    'mkd_stop_downtime_production_wells_count',
                    'technological_downtime_downtime_production_wells_count',
                    'pns_production_wells_count',
                    'vns_production_wells_count',
                ]
            },
            fondsFilter: {
                'isProductionIdleActive': false
            }
        };
    },
    methods: {
        getFormattingProductionDetails(data) {
            let self = this;
            let updatedData = [];
            _.forEach(data, function(item) {
                let temporaryData = {
                    'dzo': item.dzo_name,
                    'date': moment(item.date).startOf('day').valueOf(),
                    '__time': new Date(item.date).getTime()
                };
                _.forEach(Object.keys(integrationFieldsMapping), function(key) {
                    let paramName = integrationFieldsMapping[key];
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
                temporaryData[paramName] = this.getUpdatedGasParam(temporaryData[paramName],item[key]);
            } else {
                temporaryData[paramName] = item[key];
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
            this.updateChemistryWidget();
            this.updateWellsWorkoverWidget();
            this.updateDrillingWidget();
            this.updateProductionFondWidget();
            this.$store.commit('globalloading/SET_LOADING', false);
        },

        getOrderedByAsc(data) {
            return _.orderBy(data,
                ["date"],
                ["asc"]
            );
        },

        updateDzoMenu() {
            this.dzoMenu = _.mapValues(this.dzoMenu, () => _.cloneDeep(this.injectionWellsOptions));
        },

        getMergedByChild(inputData, fieldName) {
            let compared = [];
            _.forEach(inputData, function(item) {
                let merged = item;
                let nested = item[fieldName];
                if (nested) {
                    _.forEach(Object.keys(nested), function(key) {
                        merged[key] = nested[key];
                    });
                }
                delete merged[fieldName];
                compared.push(merged);
            });
            return compared;
        },
    }
}