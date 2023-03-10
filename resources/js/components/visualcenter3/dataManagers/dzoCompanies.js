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
            dzoHoverIndex: null,
            dzoHoverMapping: {
                '??????': '100%',
                '????????': '100%',
                '??????': '50%',
                '??????': '100%',
                '??????': '50%',
                '??????': '50%',
                '??????': '100%',
                '??????': '50%',
                '????': '100%',
                '??????': '20%',
                '??????': '8,44%',
                '??????': '10%',
                '??????': '33%',
                '????????': '100% * 33%',
                '????????????': '50% * 33%',
                '????': '50% * 33%',
                '????': '100%'
            },
            opekHoverIndex: null,
            factHoverIndex: null
        };
    },
    methods: {
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

        getAllDzoCompanies() {
            return _.cloneDeep(this.dzoCompaniesTemplate).map(company => company.ticker);
        },

        selectAllDzoCompanies() {
            if (!this.isOneDzoSelected) {
                //this.productionData = _.cloneDeep(this.productionTableData);
                this.dzoCompanies = _.cloneDeep(this.dzoCompaniesTemplate);
                _.forEach(this.dzoCompanies, function (dzo) {
                    _.set(dzo, 'selected', true);
                });
                this.selectDzoCompanies();
                this.productionChartData = this.getSummaryForChart();
                this.exportDzoCompaniesSummaryForChart(this.productionChartData);
            }
        },

        selectDzoCompanies() {
            this.isMultipleDzoCompaniesSelected = true;
            this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
            this.disableDzoRegions();
            this.selectedDzoCompanies = this.getAllDzoCompanies();
            this.productionData = _.cloneDeep(this.productionTableData);
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
                this.switchDzoCompaniesVisibility(companyTicker, 'ticker');
                if (companyTicker === '??????') {
                    this.selectedDzoCompanies.push('????????');
                }
                this.productionData = this.getFilteredTableData();
                this.productionChartData = this.getSummaryForChart();
                this.exportDzoCompaniesSummaryForChart(this.productionChartData);
            }
        },

        selectDzoCompany(isWithoutRefresh) {
            this.disableDzoRegions();
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.productionData = this.getFilteredTableData();
            this.productionChartData = this.getSummaryForChart();
            this.exportDzoCompaniesSummaryForChart(this.productionChartData);
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
                '????????': '??????',
                '????????': '??????',
                '????????????': '??????'
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

        assignOneCompanyToSelectedDzo(oneDzoNameSelected) {
            if (oneDzoNameSelected == '??????') {
                oneDzoNameSelected = [oneDzoNameSelected, '????????'];
            }
            this.selectedDzoCompanies = oneDzoNameSelected;
            if (Array.isArray(oneDzoNameSelected)) {
                oneDzoNameSelected = oneDzoNameSelected[0]
            }
            this.chemistrySelectedCompany= oneDzoNameSelected;
            this.wellsWorkoverSelectedCompany= oneDzoNameSelected;
            this.drillingSelectedCompany= oneDzoNameSelected;
            this.productionFondSelectedCompany = oneDzoNameSelected;
            this.injectionFondSelectedCompany = oneDzoNameSelected;
            this.updateDzoMenu();
            if (this.dzoWithoutAdditionalWidgets.includes(oneDzoNameSelected)) {
                return;
            }
            this.updateChemistryWidget();
            this.updateWellsWorkoverWidget();
            this.updateDrillingWidget();
            this.updateProductionFondWidget();
            this.updateInjectionFondWidget();
        },
    },
}