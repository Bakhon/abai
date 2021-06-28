import moment from "moment";

export default {
    data: function () {
        return {
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
                injection:  {
                    'work': [
                        'operating_injection_fond',
                        'active_injection_fond',
                        'inactive_injection_fond',
                        'developing_injection_fond',
                        'pending_liquidation_injection_fond',
                    ],
                    'idle': [
                        'prs_wait_downtime_injection_wells_count',
                        'prs_downtime_injection_wells_count',
                        'krs_wait_downtime_injection_wells_count',
                        'krs_downtime_injection_wells_count',
                        'well_survey_downtime_injection_wells_count',
                        'other_downtime_injection_wells_count'
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
                'isProductionIdleActive': false,
                'isInjectionIdleActive': false,
            },
            fondDaysCountSelected: {
                production: 1,
                injection: 1
            }
        }
    },
    methods: {
        async getFondByMonth(periodStart,periodEnd,fondType) {
            let inWorkField = 'in_work_' + fondType + '_fond';
            let inIndleField = 'in_idle_' + fondType + '_fond';
            let fields = this.fondList[fondType].work;
            fields.push(inWorkField,inIndleField);
            let queryOptions = {
                'startPeriod': periodStart,
                'endPeriod': periodEnd,
                'fields' : fields
            };

            let uri = this.localeUrl("/get-fond-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        getSumByFond(inputData,fondName,otherFieldName,filterName) {
            let summaryWells = {};
            let self = this;
            if (this.fondsFilter[filterName]) {
                _.forEach(this.fondList[fondName].idle, function(fond) {
                    summaryWells[fond] = _.round((_.sumBy(inputData, fond) / self.fondDaysCountSelected[fondName]), 0);
                });
                _.forEach(this.fondList.other, function(fond) {
                    summaryWells[otherFieldName] += _.sumBy(inputData, fond) / self.fondDaysCountSelected[fondName];
                });
            } else {
                _.forEach(this.fondList[fondName].work, function(fond) {
                    summaryWells[fond] = _.round((_.sumBy(inputData, fond) / self.fondDaysCountSelected[fondName]), 0);
                });
            }
            return summaryWells;
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

        updateFoundsTable(tableData,inputData) {
            if (tableData.length > 0) {
                _.forEach(inputData, function(item) {
                    item.fact = tableData[0][item.code];
                    item.isVisible = typeof item.fact !== 'undefined';
                });
            }
        },

        getFoundsFilteredByDzo(inputData,dzoName) {
            return _.filter(inputData, function (item) {
                return (item.dzo_name === dzoName);
            })
        },
    }
}