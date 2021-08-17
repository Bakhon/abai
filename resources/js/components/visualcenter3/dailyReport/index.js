import moment from "moment";
import companyTemplate from './company_template.json';
import yearlyPlanMapping from './yearly_plan_mapping.json';
;
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            allDzoCompanies: [
                'ОМГ','ЭМГ','КБМ','КГМ','ТШО',
                'ММГ','КТМ','КОА','ПКИ','АГ',
                'КПО','НКО','ТП','УО','ПКК'
            ],
            headerOptions: {
                'production': 'Оперативная суточная информация по добыче нефти и конденсата АО НК "КазМунайГаз", тонн',
                'delivery': 'Оперативная суточная информация по сдаче нефти и конденсата АО НК "КазМунайГаз", тонн'
            },
            headerTitle: 'Оперативная суточная информация по добыче нефти и конденсата АО НК "КазМунайГаз", тонн',
            currentDate: moment().format('DD.MM.YYYY'),
            currentYear: moment().year(),
            currentMonthName: moment().format('MMMM'),
            names: {
                'condensate': 'в т.ч.: газовый конденсат',
                'productionByKMG': 'Всего добыча нефти и конденсата с учетом доли участия АО НК "КазМунайГаз"',
                'deliveryByKMG': 'Всего сдача нефти и конденсата с учетом доли участия АО НК "КазМунайГаз"',
                'productionByDzo': 'Всего добыча нефти и конденсата с участием АО НК "КазМунайГаз"',
                'deliveryByDzo': 'Всего сдача нефти и конденсата с участием АО НК "КазМунайГаз"'
            },
            opecColumns: [4,6,9,11,14,16,19],
            isOpecActive: false,
            buttonName: 'Добыча',
            productionSummary: [],
            planSummary: [],
            productionByYear: [],
            period: {
                'todayStart': moment().subtract(1,'days').startOf('day'),
                'todayEnd': moment().subtract(1,'days').endOf('day'),
                'yesterdayStart': moment().subtract(2,'days').startOf('day'),
                'yesterdayEnd': moment().subtract(2,'days').endOf('day'),
                'monthStart': moment().startOf('month'),
                'monthEnd': moment().subtract(1,'days').endOf('day'),
                'yearStart': moment().startOf('year'),
                'yearEnd': moment().subtract(1,'days').endOf('day'),
            },
            productionByMonth: [],
            productionByDay: [],
            comparedSummary: [],
            isWithKMG: false,
            isProduction: true,
            summary: {
                'productionByDzo': [],
                'productionByKMG': [],
                'productionByDzoWithParticipation': [],
                'productionByKMGWithParticipation': [],
                'deliveryByDzo': [],
                'deliveryByKMG': [],
                'deliveryByDzoWithParticipation': [],
                'deliveryByKMGWithParticipation': []
            },
            summaryForExport: {
                'byDzo': [],
                'byKMG': []
            },
            withKMGCompanies: ['ОМГ','ОМГК','ЭМГ','АГК','ТШО','ММГ','КОА','КТМ','КГМ','ПКК','ТП','КБМ','КПО','НКО','УО'],
            oilCompanies: ['ОМГ','ОМГК','ЭМГ','КБМ','КГМ','ПКИ','ТШО','ММГ','КТМ','КОА','АГК','КПО','НКО','УО',],
            condensateCompanies: ['ОМГК','АГК'],
            companiesNameMapping: {
                'summaryByDzo': {
                    'ОМГ': this.trans("visualcenter.omg") + ' (нефть)',
                    'ОМГК': this.trans("visualcenter.omg") + ' (конденсат)',
                    'ЭМГ': this.trans("visualcenter.emg"),
                    'КБМ': this.trans("visualcenter.kbm"),
                    'КГМ': this.trans("visualcenter.kgm"),
                    'ТШ': this.trans("visualcenter.tsho"),
                    'ТШО': this.trans("visualcenter.tsho"),
                    'ММГ': this.trans("visualcenter.mmg"),
                    'КТМ': this.trans("visualcenter.ktm"),
                    'КОА': this.trans("visualcenter.koa"),
                    'ПКИ': this.trans("visualcenter.pki"),
                    'АМГ': this.trans("visualcenter.ag"),
                    'АГК': this.trans("visualcenter.ag") + ' (конденсат)',
                    'КПО': this.trans("visualcenter.kpo"),
                    'НКО': this.trans("visualcenter.nko"),
                    'ТП': this.trans("visualcenter.tp"),
                    'УО': this.trans("visualcenter.uo"),
                    'ПКК': this.trans("visualcenter.pkk"),
                    'oilByDzo': 'Всего добыча нефти и конденсата с участием АО НК "КазМунайГаз"',
                },
                'withParticipation': {
                    'ОМГ': this.trans("visualcenter.consolidatedDzoNameMapping.OMG"),
                    'ОМГК': this.trans("visualcenter.omg") + ' (конденсат) (100%)',
                    'ЭМГ': this.trans("visualcenter.consolidatedDzoNameMapping.EMG"),
                    'КБМ': this.trans("visualcenter.consolidatedDzoNameMapping.KBM"),
                    'КГМ': this.trans("visualcenter.consolidatedDzoNameMapping.KGM"),
                    'КГМД': this.trans("visualcenter.kgm") + '(50%*33%)',
                    'ПКИ': this.trans("visualcenter.consolidatedDzoNameMapping.PKI"),
                    'ТШО': this.trans("visualcenter.consolidatedDzoNameMapping.TSH"),
                    'ММГ': this.trans("visualcenter.consolidatedDzoNameMapping.MMG"),
                    'КТМ': this.trans("visualcenter.consolidatedDzoNameMapping.KTM"),
                    'КОА': this.trans("visualcenter.consolidatedDzoNameMapping.KOA"),
                    'АМГ': this.trans("visualcenter.consolidatedDzoNameMapping.AG"),
                    'АГК': this.trans("visualcenter.consolidatedDzoNameMapping.AG"),
                    'КПО': this.trans("visualcenter.consolidatedDzoNameMapping.KPO"),
                    'НКО': this.trans("visualcenter.nko") + ' (8.44%)',
                    'ТП': this.trans("visualcenter.tp") + ' (50%*33%)',
                    'УО': this.trans("visualcenter.consolidatedDzoNameMapping.YO"),
                    'ПКК': 'АО "ПККР" (100%*33%)',
                    'oilByKMG': 'Всего добыча нефти и конденсата с учетом доли участия АО НК "КазМунайГаз"',
                    'condensateByKMG': 'в т.ч.: газовый конденсат',
                    'oilByDzo': 'Всего добыча нефти и конденсата с участием АО НК "КазМунайГаз"',
                }
            },
            differenceKeys: [
                'differenceByDay',
                'differenceByMonth',
                'differenceByYear',
                'differenceOpecByDay',
                'differenceOpecByMonth',
                'differenceOpecByYear',
            ],
            participationMultiplier: {
                'ОМГ': (val) => val,
                'ОМГК': (val) => val,
                'ЭМГ': (val) => val,
                'КБМ': (val) => val * 0.5,
                'КГМ': (val) => val * 0.5,
                'КГМД': (val) => val * 0.5 * 0.33,
                'ПКК': (val) => val * 0.33,
                'ТП': (val) => val * 0.5 * 0.33,
                'АГК': (val) => val,
                'ТШО': (val) => val * 0.2,
                'ММГ': (val) => val * 0.5,
                'КОА': (val) => val * 0.5,
                'КТМ': (val) => val,
                'КПО': (val) => val * 0.1,
                'НКО': (val) => ((val - val * 0.019) * 241 / 1428) / 2,
                'УО': (val) => val,
            },
            tableOutput: {
                byKMG: [],
                byDzo: [],
                participationByKMG: [],
                participationByDzo: []
            },
            participationOrder: [
                'ОМГ','ОМГК','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО','ТШО','НКО','КПО','ПКИ','КГМД',
                'ПКК','ТП','АГК'
            ],
            summaryOrder: [
                'ОМГ','ОМГК','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО','ТШО','НКО','КПО',
                'ПКК','ТП','АГК'
            ],
            typeMapping: {
                'production': {
                    'oil': {
                        'planByDay': 'plan_oil',
                        'factByDay': 'oil_production_fact',
                        'planOpecByDay': 'plan_oil_opek',
                    },
                    'condensate': {
                        'planByDay': 'plan_kondensat',
                        'factByDay': 'condensate_production_fact',
                        'planOpecByDay': 'plan_kondensat',
                    }
                },
                'delivery': {
                    'oil': {
                        'planByDay': 'plan_oil_dlv',
                        'factByDay': 'oil_delivery_fact',
                        'planOpecByDay': 'plan_oil_dlv_opek',
                    },
                    'condensate': {
                        'planByDay': 'plan_kondensat_dlv',
                        'factByDay': 'condensate_delivery_fact',
                        'planOpecByDay': 'plan_kondensat_dlv',
                    }
                },
            },
            timeouts: {
                'firstLoading': 0,
                'type': 0,
                'opek': 0
            },
            timers: {
                'type': 30000,
                'opek': 15000
            },
            isTypeTimerActive: true,
            timeStart: new Date().getTime(),
            typeRemainingTime: 0,
            decreaseReasonMapping: [
                'accident_explanation_reasons',
                'gas_restriction_explanation_reasons',
                'impulse_explanation_reasons',
                'opec_explanation_reasons',
                'other_explanation_reasons',
                'restriction_kto_explanation_reasons',
                'shutdown_explanation_reasons'
            ],
            isModalActive: false,
            decreaseReason: ''
        }
    },
    methods: {
        async getProduction() {
            let uri = this.localeUrl("/get-production-for-year");
            const response = await axios.get(uri);
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },
        async getPlans() {
            let uri = this.localeUrl("/get-dzo-monthly-plans");
            const response = await axios.get(uri);
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },
        getRowClass(index) {
            if (index % 2 === 0) {
                return 'dzo-row_light';
            } else {
                return 'dzo-row_dark';
            }
        },
        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
        },
        getSortedBy(type,input){
            return _.orderBy(input,
                ["date"],
                [type]
            );
        },
        getFilteredBy(data, periodStart, periodEnd) {
            return _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        moment(item.date),
                        periodStart,
                        periodEnd
                    ),
                ]);
            });
        },
        updateProductionByPeriod() {
            this.productionSummary = this.getSortedBy('asc',this.productionSummary);
            this.comparedSummary = this.getComparedWithPlan();
            this.productionByMonth = this.getFilteredBy(this.comparedSummary,this.period.monthStart,this.period.monthEnd);
            this.productionByYear = this.getFilteredBy(this.comparedSummary,this.period.yearStart,this.period.yearEnd);
            this.productionByDay = this.getFilteredBy(this.comparedSummary,this.period.todayStart,this.period.todayEnd);
            let missingCompanies = this.getMissingCompanies();
            if (missingCompanies.length > 0) {
                let previousPlanFact = this.getFilteredBy(this.comparedSummary,this.period.yesterdayStart,this.period.yesterdayEnd);
                for (let i in missingCompanies) {
                    this.productionByDay.push(this.getPreviousDzo(previousPlanFact,missingCompanies[i]));
                }
            }
        },
        getMissingCompanies() {
            let missingDzo = [];
            for (let i in this.allDzoCompanies) {
                let itemIndex = this.productionByDay.findIndex(element => element.dzo_name === this.allDzoCompanies[i]);
                if (itemIndex === -1) {
                    missingDzo.push(this.allDzoCompanies[i]);
                }
            }
            return missingDzo;
        },
        getPreviousDzo(compared,dzoName) {
            let itemIndex = compared.findIndex(element => element.dzo_name === dzoName);
            if (itemIndex > -1) {
                return compared[itemIndex];
            }
        },
        getComparedWithPlan() {
            let compared = [];
            let self = this;
            _.forEach(this.productionSummary, function(item) {
                let planRecord = self.getPlanBy(item.dzo_name,moment(item.date).startOf('month'));
                let dzoItem = Object.assign({},item,planRecord);
                compared.push(dzoItem);
            });
            return compared;
        },
        getPlanBy(dzoName,date) {
            let notUsableFields = [
                'created_at',
                'date',
                'dzo',
                'updated_at',
                'id'
            ];
            let planRecord = this.planSummary.find(function(item) {
                let planDate = moment(item.date).startOf('day');
                if (item.dzo === dzoName && planDate.valueOf() === date.valueOf()) {
                    return item;
                }
            });
            planRecord = _.omit(planRecord, notUsableFields);
            return planRecord;
        },
        updatePlanByPeriod() {
            this.planSummary = this.getFilteredBy(this.planSummary,this.period.yearStart,this.period.todayEnd);
            this.planSummary = this.getSortedBy('asc',this.planSummary);
        },
        fillTable() {
            this.updateProduction();
            this.updateDelivery();
            this.updateSummaryForExcel();
            this.tableOutput.participationByKMG = this.summary.productionByKMGWithParticipation;
            this.tableOutput.participationByDzo = this.summary.productionByDzoWithParticipation;
            this.tableOutput.byKMG = this.summary.productionByKMG;
            this.tableOutput.byDzo = this.summary.productionByDzo;
        },
        updateProduction() {
            this.summary.productionByDzo = this.getSummaryByDzo(this.typeMapping.production);
            this.summary.productionByKMG = this.getSummaryByKMG(this.summary.productionByDzo,'production',false);
            let oilSummary = this.summary.productionByKMG[0];
            let condensateSummary = this.summary.productionByKMG[1];
            oilSummary.number = 2;
            oilSummary.yearlyPlan += condensateSummary.yearlyPlan;
            oilSummary.monthlyPlan += condensateSummary.monthlyPlan;
            oilSummary.monthlyPlanOpec += condensateSummary.monthlyPlanOpec;
            this.summary.productionByDzoWithParticipation = this.getSummaryWithParticipationByDzo(this.summary.productionByDzo);
            this.summary.productionByKMGWithParticipation = this.getSummaryByKMG(this.summary.productionByDzoWithParticipation,'production',true);
            this.summary.productionByKMGWithParticipation[0].number = 1;
        },
        updateDelivery() {
            this.summary.deliveryByDzo = this.getSummaryByDzo(this.typeMapping.delivery);
            this.summary.deliveryByKMG = this.getSummaryByKMG(this.summary.deliveryByDzo,'delivery',false);
            let oilSummary = this.summary.deliveryByKMG[0];
            let condensateSummary = this.summary.deliveryByKMG[1];
            oilSummary.number = 2;
            oilSummary.yearlyPlan += condensateSummary.yearlyPlan;
            oilSummary.monthlyPlan += condensateSummary.monthlyPlan;
            oilSummary.monthlyPlanOpec += condensateSummary.monthlyPlanOpec;
            this.summary.deliveryByDzoWithParticipation = this.getSummaryWithParticipationByDzo(this.summary.deliveryByDzo);
            this.summary.deliveryByKMGWithParticipation = this.getSummaryByKMG(this.summary.deliveryByDzoWithParticipation,'delivery',true);
            this.summary.deliveryByKMGWithParticipation[0].number = 1;
        },
        getSummaryByKMG(productionByDzo,type,isKMGParticipation) {
            let summary = [];
            let oilName = 'productionByKMG';
            if (type === 'delivery') {
                oilName = 'deliveryByKMG';
            }
            let oilSummary = this.getSummaryByType(oilName,'oilCompanies',productionByDzo);
            if (!isKMGParticipation) {
                oilSummary.dzo = this.names.productionByDzo;
            }
            let condensateSummary = this.getSummaryByType('condensate','condensateCompanies',productionByDzo);
            return [oilSummary,condensateSummary];
        },
        getSummaryByType(type,companies,productionByDzo) {
            let template = _.cloneDeep(companyTemplate);
            let filtered = this.getFilteredByType(_.cloneDeep(productionByDzo),companies);
            template.dzo = this.names[type];
            template.number = 1;
            if (type === 'condensate') {
                template.number = '';
            }
            template = this.getSummaryByPeriod(template,filtered,'Day');
            template = this.getSummaryByPeriod(template,filtered,'Month');
            template = this.getSummaryByPeriod(template,filtered,'Year');
            template.yearlyPlan = _.sumBy(filtered, 'yearlyPlan');
            template.monthlyPlan = _.sumBy(filtered, 'monthlyPlan');
            template.monthlyPlanOpec = _.sumBy(filtered, 'monthlyPlanOpec');
            template = this.getByDifference(template);
            return template;
        },
        getSummaryByPeriod(template,input,period) {
            let fields = {
                'plan': 'planBy' + period,
                'fact': 'factBy' + period,
                'planOpec': 'planOpecBy' + period,
            };
            template[fields.plan] = _.sumBy(input, fields.plan);
            template[fields.fact] = _.sumBy(input, fields.fact);
            template[fields.planOpec] = _.sumBy(input, fields.planOpec);
            return template;
        },
        getSummaryByDzo(typeMapping) {
            let summary = [];
            let self = this;
            _.forEach(this.withKMGCompanies, function(acronym,index) {
                summary.push(self.getSummary(acronym,index,typeMapping));
            });
            summary = this.getSorted(summary,this.summaryOrder,'2.',[]);
            summary[0].number = '2.1.';
            return summary;
        },
        getSummary(acronym,index,typeMapping) {
            let dzoSummary = {};
            dzoSummary = this.getByDay(acronym,typeMapping);
            dzoSummary = this.getByPeriod(acronym,dzoSummary,this.productionByMonth,'Month',typeMapping);
            dzoSummary = this.getByPeriod(acronym,dzoSummary,this.productionByYear,'Year',typeMapping);
            dzoSummary.number = '2.' + index + '.';
            dzoSummary = this.getByDifference(dzoSummary);
            return dzoSummary;
        },
        getByDifference(dzoSummary) {
            dzoSummary.differenceByDay = dzoSummary.factByDay - dzoSummary.planByDay;
            dzoSummary.differenceByMonth = dzoSummary.factByMonth - dzoSummary.planByMonth;
            dzoSummary.differenceByYear = dzoSummary.factByYear - dzoSummary.planByYear;
            dzoSummary.differenceOpecByDay = dzoSummary.factByDay - dzoSummary.planOpecByDay;
            dzoSummary.differenceOpecByMonth = dzoSummary.factByMonth - dzoSummary.planOpecByMonth;
            dzoSummary.differenceOpecByYear = dzoSummary.factByYear - dzoSummary.planOpecByYear;
            return dzoSummary;
        },
        getByDay(dzoName,typeMapping) {
            let template = _.cloneDeep(companyTemplate);
            let mapping = {
                'ОМГК': 'ОМГ',
                'АГК': 'АГ'
            };
            template.dzo = dzoName;
            if (!['ОМГК','АГК'].includes(dzoName)) {
                let dzoRecord = this.getDzoRecord(this.productionByDay,dzoName);
                if (!dzoRecord) {
                    return template;
                }
                template.planByDay = dzoRecord[typeMapping.oil.planByDay];
                template.factByDay = dzoRecord[typeMapping.oil.factByDay];
                template.planOpecByDay = dzoRecord[typeMapping.oil.planOpecByDay];
                template.yearlyPlan = yearlyPlanMapping[dzoName];
                template.monthlyPlan = dzoRecord[typeMapping.oil.planByDay] * moment().daysInMonth();
                template.monthlyPlanOpec = dzoRecord[typeMapping.oil.planOpecByDay] * moment().daysInMonth();
                template.reason = this.getReason(dzoRecord);
            } else {
                let dzoRecord = this.getDzoRecord(this.productionByDay,mapping[dzoName]);
                template.planByDay = dzoRecord[typeMapping.condensate.planByDay];
                template.factByDay = dzoRecord[typeMapping.condensate.factByDay];
                template.planOpecByDay = dzoRecord[typeMapping.condensate.planOpecByDay];
                template.yearlyPlan = yearlyPlanMapping[dzoName];
                template.monthlyPlan = dzoRecord[typeMapping.condensate.planByDay] * moment().daysInMonth();
                template.monthlyPlanOpec = dzoRecord[typeMapping.condensate.planByDay] * moment().daysInMonth();
                template.reason = this.getReason(dzoRecord);
            }
            return template;
        },
        getReason(dzo) {
            let reasons = [];
            if (dzo.import_decrease_reason) {
                _.forEach(this.decreaseReasonMapping, (key) => {
                    if (dzo.import_decrease_reason[key] !== null) {
                        reasons.push(dzo.import_decrease_reason[key]);
                    }
                });
            }
            return reasons;
        },
        getByPeriod(dzoName,template,input,periodName,typeMapping) {
            let mapping = {
                'ОМГК': 'ОМГ',
                'АГК': 'АГ'
            };
            let fields = {
                'plan': 'planBy' + periodName,
                'fact': 'factBy' + periodName,
                'planOpec': 'planOpecBy' + periodName,
            };
            template.dzo = dzoName;
            if (!['ОМГК','АГК'].includes(dzoName)) {
                let filtered = this.getFilteredByCompany(input,dzoName,'dzo_name');
                template[fields.plan] = _.sumBy(filtered, typeMapping.oil.planByDay);
                template[fields.fact] = _.sumBy(filtered, typeMapping.oil.factByDay);
                template[fields.planOpec] = _.sumBy(filtered, typeMapping.oil.planOpecByDay);
            } else {
                let filtered = this.getFilteredByCompany(input,mapping[dzoName],'dzo_name');
                template[fields.plan] = _.sumBy(filtered, typeMapping.condensate.planByDay);
                template[fields.fact] = _.sumBy(filtered, typeMapping.condensate.factByDay);
                template[fields.planOpec] = _.sumBy(filtered, typeMapping.condensate.planOpecByDay);
            }
            return template;
        },
        getDzoRecord(input,dzoName) {
            return input.find(item => item.dzo_name === dzoName);
        },
        getFilteredByCompany(input,dzoName,fieldName) {
            return _.filter(input, function (item) {
                return dzoName == item[fieldName];
            });
        },
        getFilteredByType(input,type) {
            let self = this;
            return _.filter(input, function (item) {
                return self[type].includes(item.dzo);
            });
        },
        getColorBy(number) {
            if (Math.round(number) > 0) {
                return 'color_green';
            } else if (Math.round(number) < 0) {
                return 'color_red';
            } else {
                return '';
            }
        },
        getSummaryWithParticipationByDzo(summary) {
            let self = this;
            let result = [];
            let pkiSummary = _.cloneDeep(companyTemplate);
            _.forEach(_.cloneDeep(summary), function(item,index) {
                 let updatedByMultiplier = self.getCalculatedByMultiplier(item,self.participationMultiplier[item.dzo],item.dzo,index);
                 updatedByMultiplier.number = '1.' + index + '.';
                 result.push(updatedByMultiplier);
                 if (item.dzo === 'КГМ') {
                     let updatedBranch = self.getCalculatedByMultiplier(item,self.participationMultiplier['КГМД'],'КГМД',index);
                     pkiSummary = self.getUpdatedPKI(pkiSummary,updatedBranch);
                     result.push(updatedBranch);
                 }
                 if (['ПКК','ТП'].includes(item.dzo)) {
                     updatedByMultiplier.number = '';
                     pkiSummary = self.getUpdatedPKI(pkiSummary,updatedByMultiplier);
                 }
            });
            pkiSummary = this.getByDifference(pkiSummary);
            pkiSummary.number = '1.5.';
            pkiSummary.dzo = 'ПКИ';
            result.push(pkiSummary);
            result = this.getSorted(result,this.participationOrder,'1.',['КГМД','ПКК','ТП']);
            return result;
        },
        getUpdatedPKI(pkiSummary,item) {
            let self = this;
            _.forEach(Object.keys(pkiSummary), function(key) {
                if (['dzo','number'].includes(key) || self.differenceKeys.includes(key))  {
                    return;
                }
                pkiSummary[key] += item[key];
            });
            return pkiSummary;
        },
        getCalculatedByMultiplier(item,formula,dzoName,index) {
            let calculated = {};
            let self = this;
            _.forEach(Object.keys(item), function(key) {
                if (['dzo','number'].includes(key)) {
                    calculated['dzo'] = dzoName;
                    calculated['number'] = index;
                } else {
                    calculated[key] = formula(item[key]);
                }
            });
            calculated = this.getByDifference(calculated);
            return calculated;
        },
        getSorted(inputData,sortingOrder,category,troubledCompanies) {
            let sorted = [];
            let counter = 0;
            _.forEach(sortingOrder, function (key) {
                let itemIndex = inputData.findIndex(element => element.dzo === key);
                if (itemIndex > -1) {
                    if (!troubledCompanies.includes(key)) {
                        inputData[itemIndex].number = category + counter + '.';
                        counter++;
                    } else {
                        inputData[itemIndex].number = '';
                    }
                    sorted.push(inputData[itemIndex]);
                }
            });
            sorted[0].number = '1.1.';
            return sorted;
        },
        getStyleByDifference(num) {
            if (num < 0) {
                return 'color: red';
            } else {
                return 'color: green';
            }
        },
        getStyleForSummary(index,isSecondParameterAvailable) {
            if (index === 0) {
                return 'background: rgb(252,213,180); font-weight: bold; font-family: Arial; font-size: 13px; text-align:right; border: 1px solid black';
            } else if (index === 1 && isSecondParameterAvailable) {
                return 'background: rgb(253,233,217); font-weight: bold; font-family: Arial; font-size: 13px; text-align:right; border: 1px solid black';
            } else if (index === 1 && !isSecondParameterAvailable) {
                return 'display: none';
            } else {
                return 'font-family: Arial; font-size: 13px; text-align:right; border: 1px solid black';
            }
        },
        tableToExcel(table, name, filename) {
            let uri = 'data:application/vnd.ms-excel;base64,',
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
                base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function(s, c) {
                    return s.replace(/{(\w+)}/g,
                        function(m, p) {
                        return c[p];
                    })
                }
            if (!table.nodeType) {
                table = document.getElementById(table);
            }
            let ctx = {
                worksheet: name || 'Worksheet',
                table: table.innerHTML
            };

            let link = document.createElement('a');
            link.download = filename;
            link.href = uri + base64(format(template, ctx));
            link.click();
        },
        exportToExcel() {
            let fileName = 'Суточная информация по добыче нефти и конденсата НК КМГ_' + moment().subtract(1, 'days').format('DD.MM.YYYY') + ' г. .xls';
            this.tableToExcel('exportReport','name',fileName);
        },
        updateSummaryForExcel() {
            let summaryByDzo = [];
            let self = this;
            _.forEach(this.summary.productionByDzo, function(item) {
                let production = item;
                let delivery = self.getDeliveryForMerge(production.dzo,self.summary.deliveryByDzo);
                let dzoMerged = Object.assign({},production,delivery);
                summaryByDzo.push(dzoMerged);
            });
            let productionByDzoWithParticipation = [];
            _.forEach(this.summary.productionByDzoWithParticipation, function(item) {
                let production = item;
                let delivery = self.getDeliveryForMerge(production.dzo,self.summary.deliveryByDzoWithParticipation);
                let dzoMerged = Object.assign({},production,delivery);
                productionByDzoWithParticipation.push(dzoMerged);
            });
            let productionByKMG = [];
            _.forEach(this.summary.productionByKMG, function(item) {
                let production = item;
                let delivery = self.getDeliveryForMerge(self.names.deliveryByKMG,self.summary.deliveryByKMG);
                let dzoMerged = Object.assign({},production,delivery);
                productionByKMG.push(dzoMerged);
            });
            let productionByKMGWithParticipation = [];
            _.forEach(this.summary.productionByKMGWithParticipation, function(item) {
                let production = item;
                let delivery = self.getDeliveryForMerge(self.names.deliveryByKMG,self.summary.deliveryByKMGWithParticipation);
                let dzoMerged = Object.assign({},production,delivery);
                productionByKMGWithParticipation.push(dzoMerged);
            });
            this.summaryForExport.byKMG = productionByKMGWithParticipation.concat(productionByDzoWithParticipation);
            this.summaryForExport.byDzo  = productionByKMG.concat(summaryByDzo);
            this.summaryForExport.byKMG[0].dzo = 'oilByKMG';
            this.summaryForExport.byKMG[1].dzo = 'condensateByKMG';
            this.summaryForExport.byDzo[0].dzo = 'oilByDzo';
        },
        getDeliveryForMerge(dzoName,delivery) {
            let itemIndex = delivery.findIndex(element => element.dzo === dzoName);
            let isSummary = dzoName.length > 4;
            let mapping = {
                'deliveryDifferenceByDay':  'differenceByDay',
                'deliveryDifferenceByMonth': 'differenceByMonth',
                'deliveryDifferenceByYear': 'differenceByYear',
                'deliveryDifferenceOpecByDay': 'differenceOpecByDay',
                'deliveryDifferenceOpecByMonth': 'differenceOpecByMonth',
                'deliveryDifferenceOpecByYear': 'differenceOpecByYear',
                'deliveryFactByDay': 'factByDay',
                'deliveryFactByMonth': 'factByMonth',
                'deliveryFactByYear': 'factByYear',
                'deliveryMonthlyPlan': 'monthlyPlan',
                'deliveryMonthlyPlanOpec': 'monthlyPlanOpec',
                'deliveryPlanByDay': 'planByDay',
                'deliveryPlanByMonth': 'planByMonth',
                'deliveryPlanByYear': 'planByYear',
                'deliveryPlanOpecByDay': 'planOpecByDay',
                'deliveryPlanOpecByMonth': 'planOpecByMonth',
                'deliveryPlanOpecByYear': 'planOpecByYear',
                'deliveryYearlyPlan': 'yearlyPlan',
            };
            if (itemIndex > -1 || isSummary) {
                let mapped = {};
                for (let field in mapping) {
                    if (isSummary) {
                        mapped[field] = delivery[0][mapping[field]]
                    } else {
                        mapped[field] = delivery[itemIndex][mapping[field]]
                    }
                }
                return mapped;
            }
        },
        getDarkColorClass(rowIndex) {
            if (rowIndex % 2 === 0) {
                return 'tdStyle'
            } else {
                return 'tdNone'
            }
        },

        getLightColorClass(rowIndex) {
            if (rowIndex % 2 === 0) {
                return 'tdStyleLight'
            } else {
                return 'tdStyleLight2'
            }
        },
        switchTimers() {
            if (this.isTypeTimerActive) {
                this.isTypeTimerActive = false;
                this.remainingTime = new Date().getTime() - this.timeStart;
                clearTimeout(this.timeouts.firstLoading);
                clearTimeout(this.timeouts.type);
                clearTimeout(this.timeouts.opek);
            } else {
                this.isTypeTimerActive = true;
                this.timeouts.type = setTimeout(function changeType() {
                    this.isProduction = !this.isProduction;
                    this.timeStart = new Date().getTime();
                    this.timeouts.type = setTimeout(changeType,this.timers.type);
                    this.timeouts.opek = setTimeout(() => {
                        this.isOpecActive = !this.isOpecActive;
                    }, this.timers.opek);
                }.bind(this), this.remainingTime);
            }
        },
        mouseOver(event, reason) {
            if (Array.isArray(reason) && reason.length) {
                this.isModalActive = true;
                this.decreaseReason = reason.join(",\n");
                $('#decreaseReason').css('display', 'block');
            } else {
                this.decreaseReason = '';
                $('#decreaseReason').css('display', 'none');
            }
            $('#decreaseReason').css('top', event.screenY - 225);
            $('#decreaseReason').css('left', event.screenX - 20);
        },
        mouseLeave() {
           this.isModalActive = false;
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
    },
    async mounted() {
        this.SET_LOADING(true);
        this.productionSummary = await this.getProduction();
        this.planSummary = await this.getPlans();
        this.updatePlanByPeriod();
        this.updateProductionByPeriod();
        this.fillTable();
        this.SET_LOADING(false);
        this.timeouts.firstLoading = setTimeout(() => {
            this.isOpecActive = !this.isOpecActive;
        }, this.timers.opek);
        this.timeStart = new Date().getTime();
        this.timeouts.type = setTimeout(function changeType() {
            this.isProduction = !this.isProduction;
            this.timeStart = new Date().getTime();
            this.timeouts.type = setTimeout(changeType,this.timers.type);
            this.timeouts.opek = setTimeout(() => {
                this.isOpecActive = !this.isOpecActive;
            }, this.timers.opek);
        }.bind(this), this.timers.type);
    },
    watch: {
        isProduction: function() {
            this.isOpecActive = false;
            if (this.isProduction) {
                this.headerTitle = this.headerOptions.production;
                this.tableOutput.participationByKMG = this.summary.productionByKMGWithParticipation;
                this.tableOutput.participationByDzo = this.summary.productionByDzoWithParticipation;
                this.tableOutput.byKMG = this.summary.productionByKMG;
                this.tableOutput.byDzo = this.summary.productionByDzo;
            } else {
                this.headerTitle = this.headerOptions.delivery;
                this.tableOutput.participationByKMG = this.summary.deliveryByKMGWithParticipation;
                this.tableOutput.participationByDzo = this.summary.deliveryByDzoWithParticipation;
                this.tableOutput.byKMG = this.summary.deliveryByKMG;
                this.tableOutput.byDzo = this.summary.deliveryByDzo;
            }
        }
    },
}