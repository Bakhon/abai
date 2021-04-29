import dzoCompaniesInitial from "../dzo_companies_initial.json";

export default {
    data: function () {
        return {
            isMultipleDzoCompaniesSelected: true,
            dzoCompaniesSummaryForChart: {},
            dzoColumns: {
                daily: ['companyName', 'plan', 'fact', 'difference', 'percent'],
                monthly: ['companyName', 'monthlyPlan', 'plan', 'fact', 'difference', 'percent'],
                yearly: ['companyName', 'yearlyPlan', 'plan', 'fact', 'difference', 'percent'],
            },
            currentDzoList: 'daily',
            dzoCompaniesAssets: {
                isAllAssets: true,
                isOperating: false,
                isNonOperating: false,
                isOpecRestriction: false,
                isRegion: false,
                assetTitle: this.trans("visualcenter.summaryAssets"),
            },
            dzoCompaniesAssetsInitial: {
                isAllAssets: true,
                isOperating: false,
                isNonOperating: false,
                isOpecRestriction: false,
                isRegion: false,
                assetTitle: this.trans("visualcenter.summaryAssets"),
            },
            dzoRegionsMapping: {
                aturay: {
                    isActive: false,
                    translationName: this.trans("visualcenter.dzoRegions.aturay"),
                },
                actubinsk: {
                    isActive: false,
                    translationName: this.trans("visualcenter.dzoRegions.actubinsk"),
                },
                kuzulord: {
                    isActive: false,
                    translationName: this.trans("visualcenter.dzoRegions.kuzulord"),
                },
                mangistau: {
                    isActive: false,
                    translationName: this.trans("visualcenter.dzoRegions.mangistau"),
                },
                west: {
                    isActive: false,
                    translationName: this.trans("visualcenter.dzoRegions.west"),
                },
                zhambul: {
                    isActive: false,
                    translationName: this.trans("visualcenter.dzoRegions.zhambul"),
                },
            },
            selectedDzoCompanies: [],
            company: "all",
            dzoCompanies: _.cloneDeep(dzoCompaniesInitial),
            dzoCompanySummary: this.bigTable,
            dzoCompaniesSummaryInitial: {
                plan: 0,
                periodPlan: 0,
                fact: 0,
                difference: 0,
                percent: 0,
                targetPlan: 0,
            },
            dzoCompaniesSummary: {},
            dzoType: {
                isOperating: [],
                isNonOperating: []
            },
        };
    },
    methods: {
        getSelectedDzoCompanies(type, category, regionName) {
            this.disableDzoRegions();
            if (!regionName) {
                return _.cloneDeep(dzoCompaniesInitial).filter(company => company[category] === type).map(company => company.ticker);
            }
            this.dzoRegionsMapping[regionName].isActive = !this.dzoRegionsMapping[regionName].isActive;
            if (regionName === 'zhambul') {
                category = regionName;
                type = type.toLowerCase().replace('is','');
                return ['АГ'];
            }
            if (this.dzoRegionsMapping[regionName].isActive) {
                category = regionName;
                type = type.toLowerCase().replace('is','');
                return _.cloneDeep(dzoCompaniesInitial).filter(company => company[type] === category).map(company => company.ticker);
            }
            return _.cloneDeep(dzoCompaniesInitial).map(company => company.ticker);
        },

        selectMultipleDzoCompanies(type,category,regionName) {
            this.selectCompany('all');
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.disableDzoCompaniesVisibility();
            this.switchDzoCompaniesVisibility(type,category,regionName);
            this.calculateDzoCompaniesSummary();
        },

        selectCompany(com) {
            this.company = com;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },

        disableDzoCompaniesVisibility() {
            _.forEach(this.dzoCompanies, function (dzo) {
                _.set(dzo, 'selected', false);
            });
        },

        switchDzoCompaniesVisibility(condition,type,regionName) {
            if (regionName) {
                condition = regionName;
            }
            _.map(this.dzoCompanies, function(company) {
                if (company[type] === condition) {
                    company.selected = !company.selected;
                }
            });
            let selectedCompanies = this.dzoCompanies.filter(row => row.selected === true).map(row => row.ticker);
            this.dzoCompanySummary = this.bigTable.filter(row => selectedCompanies.includes(row.dzoMonth));
        },

        calculateDzoCompaniesSummary() {
            let summary = _.cloneDeep(this.dzoCompaniesSummaryInitial);
            let self = this;
            _.map(this.dzoCompanySummary, function (company) {
                summary.plan = parseInt(summary.plan) + parseInt(company.planMonth);
                summary.fact = parseInt(summary.fact) + parseInt(company.factMonth);
                summary.periodPlan = parseInt(summary.periodPlan) + parseInt(company.periodPlan);
                if (self.isFilterTargetPlanActive) {
                    summary.targetPlan = parseInt(summary.targetPlan) + parseInt(company.targetPlan);
                }
            });
            summary.difference = this.formatDigitToThousand(
                summary.plan - summary.fact);
            summary.percent = new Intl.NumberFormat("ru-RU")
                .format(((summary.plan - summary.fact) /
                    summary.fact * 100).toFixed(1));
            summary.plan = this.formatDigitToThousand(summary.plan);
            summary.fact = this.formatDigitToThousand(summary.fact);
            summary.periodPlan = this.formatDigitToThousand(summary.periodPlan);
            this.dzoCompaniesSummary = summary;
        },

        getAllDzoCompanies() {
            return _.cloneDeep(dzoCompaniesInitial).map(company => company.ticker);
        },

        selectAllDzoCompanies() {
            this.selectDzoCompanies();
            this.dzoCompanies = _.cloneDeep(dzoCompaniesInitial);
        },

        selectDzoCompanies() {
            this.selectCompany('all');
            this.isMultipleDzoCompaniesSelected = true;
            this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
            this.disableDzoRegions();
            this.selectedDzoCompanies = this.getAllDzoCompanies();
            this.buttonDzoDropdown = "";
            this.dzoCompanySummary = this.bigTable;
            this.calculateDzoCompaniesSummary();
        },

        selectOneDzoCompany(companyTicker) {
            this.disableDzoCompaniesVisibility();
            this.selectDzoCompany(companyTicker);
        },

        selectDzoCompany(companyTicker) {
            this.disableDzoRegions();
            this.selectCompany(companyTicker);

            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.buttonDzoDropdown = this.highlightedButton;
            this.switchDzoCompaniesVisibility(companyTicker,'ticker');
            this.isMultipleDzoCompaniesSelected = this.dzoCompanySummary.length > 1;
            if (this.isMultipleDzoCompaniesSelected) {
                this.selectedDzoCompanies.push(companyTicker);
            } else {
                this.selectedDzoCompanies = [companyTicker];
            }
            this.calculateDzoCompaniesSummary();
        },

        getDzoFactSummary(summaryData) {
            return _.sumBy(summaryData, 'productionFactForChart');
        },

        getFilteredDzoYearlyPlan() {
            let dzoMonthlyPlanData = _.cloneDeep(this.dzoMonthlyPlans);
            let filteredPlanData = dzoMonthlyPlanData.filter(row => this.selectedDzoCompanies.includes(row.dzo));
            if (filteredPlanData.length === 0) {
                filteredPlanData = dzoMonthlyPlanData;
            }
            return filteredPlanData;
        },

        exportDzoCompaniesSummaryForChart() {
            this.$store.commit('globalloading/SET_LOADING', false);
            this.$emit("data", {
                dzoCompaniesSummaryForChart: this.dzoCompaniesSummaryForChart,
                isOpecFilterActive: this.isOpecFilterActive,
                isFilterTargetPlanActive: this.isFilterTargetPlanActive
            });
        },
        sortDzoList() {
            let self = this;
            _.forEach(dzoCompaniesInitial, function(item) {
                self.dzoType[item.type].push(item.ticker)
            });
        },
        getFilteredCompaniesList(data) {
            let self = this;
            return _.filter(data, function (item) {
                return self.selectedDzoCompanies.includes(item.dzo);
            });
        },
    },
}