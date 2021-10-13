import moment from "moment";
import fondsMapping from '../founds_mapping.json';

export default {
    data: function () {
        return {
            fondList: fondsMapping,
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
                'fondType': fondType,
                'fields' : fields,
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

        async getChartData(workFields,idleFields,periodStart,periodEnd,fondType,company) {
            let uri = this.localeUrl("/get-fond-daily-chart");
            let queryOptions = {
                startPeriod: periodStart,
                endPeriod: periodEnd,
                workFields: workFields,
                idleFields: idleFields,
                fondType: fondType,
                company: company
            };
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status !== 200) {
                return {};
            }
            return response.data;
        },

        getSumOfFond(input,workFields,idleFields,filter) {
            let fonds = workFields;
            if (this.fondsFilter[filter]) {
                fonds = idleFields;
            }
            let result = {};
            _.forEach(fonds, (fondName) => {
                result[fondName] = _.sumBy(input,fondName);
            });
            return result;
        },
    }
}