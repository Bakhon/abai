import companiesListWithKMG from "../dzo_companies_initial_consolidated_withkmg.json";

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
            dzoCompanies: _.cloneDeep(companiesListWithKMG),
            dzoCompaniesTemplate: _.cloneDeep(companiesListWithKMG),
            dzoCompanySummary: this.bigTable,
            dzoCompaniesSummaryInitial: {
                plan: 0,
                periodPlan: 0,
                fact: 0,
                difference: 0,
                percent: 0,
                targetPlan: 0,
                opekPlan: 0,
            },
            dzoCompaniesSummary: {},
            dzoType: {
                isOperating: [],
                isNonOperating: []
            },
            dzoSummaryForTable: []
        };
    },
    methods: {
        getSelectedDzoCompanies(type, category, regionName) {
            this.disableDzoRegions();
            if (!regionName) {
                return _.cloneDeep(this.dzoCompanies).filter(company => company[category] === type).map(company => company.ticker);
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
                return _.cloneDeep(this.dzoCompanies).filter(company => company[type] === category).map(company => company.ticker);
            }
            return _.cloneDeep(this.dzoCompanies).map(company => company.ticker);
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
        },

        calculateDzoCompaniesSummary() {
            let emptyDzo = [];
            this.dzoSummaryForTable = this.dzoCompanySummary.filter(item => this.selectedDzoCompanies.includes(item.dzoMonth));
            let filteredByCompaniesYesterday = this.yesterdaySummary.filter(item => this.selectedDzoCompanies.includes(item.dzoMonth));
            let actualFilteredSummary = _.cloneDeep(this.dzoSummaryForTable);
            if (this.oilCondensateProductionButton.length === 0) {
                filteredByCompaniesYesterday = this.yesterdayProductionDetails.filter(item => this.selectedDzoCompanies.includes(item.dzoMonth));
            } else {
                actualFilteredSummary = this.deleteTroubleCompanies(_.cloneDeep(this.dzoSummaryForTable));
            }
            this.isMultipleDzoCompaniesSelected = this.dzoSummaryForTable.length > 1;
            let summary = _.cloneDeep(this.dzoCompaniesSummaryInitial);
            let self = this;
            _.forEach(actualFilteredSummary, function (company) {
                if(!company) {
                    return;
                }
                summary.plan = parseInt(summary.plan) + parseInt(company.planMonth);
                summary.fact = parseFloat(summary.fact) + parseFloat(company.factMonth);
                summary.periodPlan = parseInt(summary.periodPlan) + parseInt(company.periodPlan);
                if (self.isFilterTargetPlanActive) {
                    summary.targetPlan = parseInt(summary.targetPlan) + parseInt(company.targetPlan);
                }
                if (self.isConsolidatedCategoryActive()) {
                    summary.opekPlan = parseInt(summary.opekPlan) + parseInt(company.opekPlan);
                }
                //console.log(company.planMonth + company.factMonth + company.opekPlan);
            });
            summary = this.getFormatted(summary);
            let yesterdayFilteredSummary = this.deleteTroubleCompanies(filteredByCompaniesYesterday);
            this.updateProductionTotalFact(yesterdayFilteredSummary,summary,actualFilteredSummary);

            this.dzoCompaniesSummary = summary;
            if (this.isConsolidatedCategoryActive()) {
                this.isOpecFilterActive = true;
            }
        },

        getFormatted(summary) {
            if (this.isConsolidatedCategoryActive()) {
                summary.opekDifference = this.getFormattedNumberToThousand(
                    summary.opekPlan,summary.fact);
                summary.opekPlan = this.formatDigitToThousand(summary.opekPlan);
            }
            summary.difference = this.getFormattedNumberToThousand(
                summary.plan,summary.fact);
            summary.percent = this.getPercentDifference(summary.plan,summary.fact);
            summary.plan = this.formatDigitToThousand(summary.plan);
            summary.fact = this.formatDigitToThousand(summary.fact);
            summary.periodPlan = this.formatDigitToThousand(summary.periodPlan);
            return summary;
        },

        updateActualOilFactByFilter() {
            this.productionPercentParams['oil_fact'] = this.productionParamsWidget.yesterdayOilFact;
            if (!this.oilCondensateFilters.isWithoutKMGFilterActive) {
                this.productionPercentParams['oil_fact'] = this.productionParamsWidget.yesterdayOilFactWithFilter;
            }
        },

        getAllDzoCompanies() {
            return _.cloneDeep(this.dzoCompaniesTemplate).map(company => company.ticker);
        },

        selectAllDzoCompanies() {
            this.dzoCompanies = _.cloneDeep(this.dzoCompaniesTemplate);
            _.forEach(this.dzoCompanies, function (dzo) {
                _.set(dzo, 'selected', true);
            });
            this.selectDzoCompanies();
        },

        selectDzoCompanies() {
            this.isMultipleDzoCompaniesSelected = true;
            this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
            this.disableDzoRegions();
            this.selectedDzoCompanies = this.getAllDzoCompanies();
            this.buttonDzoDropdown = "";
            this.calculateDzoCompaniesSummary();
        },

        selectOneDzoCompany(companyTicker) {
            if (this.selectedDzoCompanies.includes(companyTicker)) {
                let index = this.selectedDzoCompanies.findIndex(element => element === companyTicker);
                if (index > -1) {
                    this.selectedDzoCompanies.splice(index, 1);
                }
                this.switchDzoCompaniesVisibility(companyTicker,'ticker');
            } else {
                this.selectedDzoCompanies = [companyTicker];
                this.switchDzoCompaniesVisibility(companyTicker,'ticker');
            }
            this.selectDzoCompany();
        },

        switchOneCompanyView(companyTicker) {
            this.isMultipleDzoCompaniesSelected = false;
            this.disableDzoCompaniesVisibility();
            this.selectedDzoCompanies = [companyTicker];
            this.switchDzoCompaniesVisibility(companyTicker,'ticker');
            this.selectDzoCompany();
        },

        selectDzoCompany() {
            this.disableDzoRegions();
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.buttonDzoDropdown = this.highlightedButton;
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

        exportDzoCompaniesSummaryForChart(data) {
            this.$emit("data", {
                dzoCompaniesSummaryForChart: data,
                isOpecFilterActive: this.isOpecFilterActive,
                isFilterTargetPlanActive: this.isFilterTargetPlanActive,
                isOilResidueActive: this.isOilResidueActive
            });
        },
        sortDzoList() {
            let self = this;
            _.forEach(this.dzoCompanies, function(item) {
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