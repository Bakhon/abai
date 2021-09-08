import companiesListWithKMG from "../dzo_companies_initial_consolidated_withkmg.json";

export default {
    data: function () {
        return {
            isMultipleDzoCompaniesSelected: true,
            dzoColumns: ['companyName', 'plan', 'fact', 'difference', 'percent'],
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
            dzoCompanies: _.cloneDeep(companiesListWithKMG),
            dzoCompaniesTemplate: _.cloneDeep(companiesListWithKMG),
            dzoType: {
                isOperating: [],
                isNonOperating: []
            },
            dzoSummaryForTable: [],
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
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.disableDzoCompaniesVisibility();
            this.switchDzoCompaniesVisibility(type,category,regionName);
            this.calculateSecondaryCategories();
            this.calculateDzoCompaniesSummary();
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

        getAllDzoCompanies() {
            return _.cloneDeep(this.dzoCompaniesTemplate).map(company => company.ticker);
        },

        selectAllDzoCompanies() {
            if (!this.isOneDzoSelected) {
                this.dzoCompanies = _.cloneDeep(this.dzoCompaniesTemplate);
                _.forEach(this.dzoCompanies, function (dzo) {
                    _.set(dzo, 'selected', true);
                });
                this.changeDate();
                this.selectDzoCompanies();
            }
        },

        selectDzoCompanies() {
            this.isMultipleDzoCompaniesSelected = true;
            this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
            this.disableDzoRegions();
            this.selectedDzoCompanies = this.getAllDzoCompanies();
            this.calculateSecondaryCategories();
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
                this.selectedDzoCompanies.push(companyTicker);
                this.switchDzoCompaniesVisibility(companyTicker,'ticker');
            }
            this.selectDzoCompany();
        },

        switchOneCompanyView(companyTicker) {
            if (!this.isOneDzoSelected) {
                this.isMultipleDzoCompaniesSelected = false;
                this.disableDzoCompaniesVisibility();
                this.selectedDzoCompanies = [companyTicker];
                this.calculateSecondaryCategories();
                this.switchDzoCompaniesVisibility(companyTicker, 'ticker');
                this.selectDzoCompany(true);
            }
        },

        selectDzoCompany(isWithoutRefresh) {
            this.disableDzoRegions();
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.buttonDzoDropdown = this.highlightedButton;
            this.calculateSecondaryCategories();
            this.calculateDzoCompaniesSummary(isWithoutRefresh);
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
                isFilterTargetPlanActive: this.isFilterTargetPlanActive,
            });
        },
        getFilteredCompaniesList(data) {
            let condensateMapping = {
                'ОМГК': 'ОМГ',
                'ПККР': 'ПКК',
                'КГМКМГ': 'КГМ'
            };
            let companies = _.cloneDeep(this.selectedDzoCompanies);
            for (let i in companies) {
                if (condensateMapping[companies[i]] && !companies.includes(condensateMapping[companies[i]])) {
                    companies[i] = condensateMapping[companies[i]];
                }
            }
            return _.filter(data, function (item) {
                return companies.includes(item.dzo);
            });
        },

        setDzoCompaniesToInitial() {
            this.dzoCompanies = _.cloneDeep(this.dzoCompaniesTemplate);
            _.forEach(this.dzoCompanies, function (dzo) {
                _.set(dzo, 'selected', true);
            });
            this.isMultipleDzoCompaniesSelected = true;
            this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
            this.disableDzoRegions();
            this.selectedDzoCompanies = this.getAllDzoCompanies();
            this.buttonDzoDropdown = "";
        },
    },
}