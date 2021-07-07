import moment from "moment";

export default {
    data: function () {
        return {
            currentYear: moment().year(),
            currentMonthName: moment().format('MMMM'),
            template: {
                'number': 0,
                'dzo': '',
                'yearlyPlan': 0,
                'monthlyPlan': 0,
                'monthlyPlanOpec': 0,
                'planByDay': 0,
                'planOpecByDay': 0,
                'factByDay': 0,
                'differenceByDay': 0,
                'differenceOpecByDay': 0,
                'planByMonth': 0,
                'planOpecByMonth': 0,
                'factByMonth': 0,
                'differenceByMonth': 0,
                'differenceOpecByMonth': 0,
                'planByYear': 0,
                'planOpecByYear': 0,
                'factByYear': 0,
                'differenceByYear': 0,
                'differenceOpecByYear': 0,
            },
            production: [],
            totalNames: {
                'KMGParticipation': 'Всего добыча нефти и конденсата с учетом доли участия АО НК "КазМунайГаз"',
                'summary': 'Всего добыча нефти и конденсата с участием АО НК "КазМунайГаз"',
                'condensate': 'в т.ч.: газовый конденсат'
            },
            opecColumns: [4,6,9,11,14,16,19],
            isOpecActive: false,
            buttonName: 'Добыча',
            viewType: {
                'production': 'Добыча',
                'delivery': 'Сдача'
            },
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
            tableOutput: {
                'summaryByDzo': [],
                'summaryByKMG': []
            },
            withKMGCompanies: ['ОМГ','ОМГК','ЭМГ','АГК','ТШО','ММГ','КОА','КТМ','КГМ','ПКК','ТП','КБМ','КПО','НКО','УО'],
            oilCompanies: ['ОМГ','ЭМГ','ТШО','ММГ','КОА','КТМ','КГМ','ПКК','ТП','КБМ','КПО','НКО','УО'],
            condensateCompanies: ['ОМГК','АГК'],
            yearlyPlanMapping: {
                'ОМГ': 5564864,
                'ОМГК': 4623,
                'ЭМГ': 2695000,
                'АГК': 15062,
                'ТШО': 28287408,
                'ММГ': 6050452,
                'КОА': 603255,
                'КТМ': 429477,
                'КГМ': 1452906,
                'ПКК': 868017,
                'ТП': 320722,
                'КБМ': 2139093,
                'КПО': 10704916,
                'НКО': 16777633,
                'УО': 71539
            },
            companiesNameMapping: {
                'summaryByDzo': {
                    'ОМГ': this.trans("visualcenter.omg") + ' (нефть)',
                    'ОМГК': '(конденсат)',
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
                }
            },
            differenceKeys: [
                'differenceByDay',
                'differenceByMonth',
                'differenceByYear',
                'differenceOpecByDay',
                'differenceOpecByMonth',
                'differenceOpecByYear',
            ]
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
                return 'background-light';
            } else {
                return 'background-dark';
            }
        },
        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.abs(Math.round(num))))
        },
        switchOpecFilter() {
            this.isOpecActive = !this.isOpecActive;
        },
        switchView() {
            if (this.buttonName === this.viewType.production) {
                this.buttonName = this.viewType.delivery;
            } else {
                this.buttonName = this.viewType.production;
            }
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
            if (this.productionByDay.length !== 15) {
                this.productionByDay = this.getFilteredBy(this.comparedSummary,this.period.yesterdayStart,this.period.yesterdayEnd);
            }
            console.log(this.productionByDay.length);
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
            this.tableOutput.summaryByDzo = this.getSummaryByDzo();
            this.tableOutput.summaryByKMG = this.getSummaryByKMG();
            console.log('this.tableOutput')
            console.log(this.tableOutput)
        },
        getSummaryByKMG() {
            let summary = [];
            let oilSummary = this.getSummaryByType('summary','oilCompanies');
            let condensateSummary = this.getSummaryByType('condensate','condensateCompanies');
            if (!this.isWithKMG) {
                oilSummary.number = 2;
                oilSummary.yearlyPlan += condensateSummary.yearlyPlan;
                oilSummary.monthlyPlan += condensateSummary.monthlyPlan;
                oilSummary.monthlyPlanOpec += condensateSummary.monthlyPlanOpec;
            }
            return [oilSummary,condensateSummary];
        },
        getSummaryByType(type,companies) {
            let template = _.cloneDeep(this.template);
            let filtered = this.getFilteredByType(_.cloneDeep(this.tableOutput.summaryByDzo),companies);
            template.dzo = this.totalNames[type];
            if (this.isWithKMG) {
                template.number = 1;
            } else {
                template.number = '';
            }
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
        getSummaryByDzo() {
            let summary = [];
            let self = this;
            _.forEach(this.withKMGCompanies, function(acronym,index) {
                summary.push(self.getSummary(acronym,index));
            });
            summary[0].number = '2.1.';
            return summary;
        },
        getSummary(acronym,index) {
            let dzoSummary = {};
            dzoSummary = this.getByDay(acronym);
            dzoSummary = this.getByPeriod(acronym,dzoSummary,this.productionByMonth,'Month');
            dzoSummary = this.getByPeriod(acronym,dzoSummary,this.productionByYear,'Year');
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
        getByDay(dzoName) {
            let template = _.cloneDeep(this.template);
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
                template.planByDay = dzoRecord.plan_oil;
                template.factByDay = dzoRecord.oil_production_fact;
                template.planOpecByDay = dzoRecord.plan_oil_opek;
                template.yearlyPlan = this.yearlyPlanMapping[dzoName];
                template.monthlyPlan = dzoRecord.plan_oil * moment().daysInMonth();
                template.monthlyPlanOpec = dzoRecord.plan_oil_opek * moment().daysInMonth();
            } else {
                let dzoRecord = this.getDzoRecord(this.productionByDay,mapping[dzoName]);
                template.planByDay = dzoRecord.plan_kondensat;
                template.factByDay = dzoRecord.condensate_production_fact;
                template.planOpecByDay = dzoRecord.plan_kondensat;
                template.yearlyPlan = this.yearlyPlanMapping[dzoName];
                template.monthlyPlan = dzoRecord.plan_kondensat * moment().daysInMonth();
                template.monthlyPlanOpec = dzoRecord.plan_kondensat * moment().daysInMonth();
            }
            return template;
        },
        getByPeriod(dzoName,template,input,periodName) {
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
                template[fields.plan] = _.sumBy(filtered, 'plan_oil');
                template[fields.fact] = _.sumBy(filtered, 'oil_production_fact');
                template[fields.planOpec] = _.sumBy(filtered, 'plan_oil_opek');
            } else {
                let filtered = this.getFilteredByCompany(input,mapping[dzoName],'dzo_name');
                template[fields.plan] = _.sumBy(filtered, 'plan_kondensat');
                template[fields.fact] = _.sumBy(filtered, 'condensate_production_fact');
                template[fields.planOpec] = _.sumBy(filtered, 'plan_kondensat');
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
            if (number > 0) {
                return 'color_green';
            } else {
                return 'color_red';
            }
        },
    },
    async mounted() {
        this.$store.commit('globalloading/SET_LOADING', true);
        for (let i=2; i<19; i++) {
            let emptyCompany = _.cloneDeep(this.template);
            emptyCompany.number = i;
            if (i === 9) {
                emptyCompany.differenceByDay = -1000;
            }
            if (i === 12) {
                emptyCompany.differenceByDay = 3000;
            }
            this.production.push(emptyCompany);
        }
        this.productionSummary = await this.getProduction();
        this.planSummary = await this.getPlans();
        this.updatePlanByPeriod();
        this.updateProductionByPeriod();
        this.fillTable();
        this.$store.commit('globalloading/SET_LOADING', false);
    }
}