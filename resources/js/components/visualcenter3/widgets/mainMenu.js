import mainMenuConfiguration from "../main_menu_configuration.json";
import companiesListWithKMG from "../dzo_companies_initial_consolidated_withkmg.json";
import dzoCompaniesInitial from "../dzo_companies_initial.json";
import companiesListWithoutKMG from "../dzo_companies_initial_consolidated_withoutkmg.json";

export default {
    data: function () {
        return {
            isMainMenuItemChanged: false,
            mainMenuButtonElementOptions: {},
            categoryMenuPreviousParent: '',
            mainMenuButtonHighlighted: "color: #fff;background: #237deb;font-weight:bold;",
            isOpecFilterActive: false,
            flagOn: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.4791 0.469238H2.31923C1.20141 0.469238 0.297516 1.38392 0.297516 2.50136L0.287109 18.7576L7.39917 15.7094L14.5112 18.7576V2.50136C14.5112 1.38392 13.5969 0.469238 12.4791 0.469238Z" fill="#2E50E9"/>' +
                '</svg>',
            flagOff: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg"> \n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.8448 0.286987H2.68496C1.56713 0.286987 0.663191 1.20167 0.663191 2.31911L0.652832 18.5754L7.76489 15.5272L14.877 18.5754V2.31911C14.877 1.20167 13.9627 0.286987 12.8448 0.286987Z" fill="#656A8A"/>' +
                '</svg>',
            selectedButtonName: 'oilCondensateDeliveryButton',
            chartTranslateMapping: {
                'oilProductionButton': this.trans('visualcenter.getoildynamic'),
                'oilDeliveryButton': this.trans('visualcenter.dlvoildynamic'),
                'gasProductionButton': this.trans('visualcenter.getgasdynamic'),
                'oilCondensate': this.trans('visualcenter.liqDynamic'),
                'oilCondensateProductionButton': this.trans('visualcenter.oilCondensateProductionChartName'),
                'oilCondensateDeliveryButton': this.trans('visualcenter.oilCondensateDeliveryChartName'),
                'oilResidue': this.trans('visualcenter.stockOfGoodsDynamic'),
                'waterInjectionButton': this.trans('visualcenter.injectionWaterChartName'),
                'productionNaturalGas': this.trans('visualcenter.productionNaturalGasChartName'),
                'productionAssociatedGas': this.trans('visualcenter.productionAssociatedGasChartName'),
                'flaringAssociatedGas': this.trans('visualcenter.flaringAssociatedGasChartName'),
                'albsenWaterInjection': this.trans('visualcenter.dynamicArtesianWater'),
                'seaWaterInjection': this.trans('visualcenter.liqOceanDynamic'),
                'wasteWaterInjection': this.trans('visualcenter.liqStochnayaDynamic'),
            },
            isOilResidueActive: false,
            oilDeliveryFilters: {
                'oilResidue': 'isOilResidueActive'
            },
            condolidatedButtons: ['oilCondensateProductionButton','oilCondensateDeliveryButton'],
            isFirstLoading: true,
            lastSelectedCategory: 'oilCondensateProductionButton',
            oilResidueChartName: this.trans('visualcenter.ostatokNefti'),
            dropdownMenu: {
                'oilCondensateProduction': true,
                'oilCondensateProductionWithoutKMG': false,
                'oilCondensateProductionCondensateOnly': false,
                'oilCondensateDelivery': false,
                'oilCondensateDeliveryWithoutKMG': false,
                'oilCondensateDeliveryOilResidue': false,
                'oilCondensateDeliveryCondensateOnly': false,
                'gasProduction': false,
                'naturalGasProduction': false,
                'associatedGasProduction': false,
                'flaringGas': false,
                'naturalGasDelivery': false,
                'expensesForOwnNaturalGas': false,
                'associatedGasDelivery': false,
                'expensesForOwnAssociatedGas': false,
                'waterInjection': false,
                'seawaterInjection': false,
                'wasteWaterInjection': false,
                'artezianWaterInjection': false
            }
        };
    },
    methods: {
        switchCategory(buttonName, planFieldName, factFieldName, metricName, categoryName, parentButton, childButton) {
            this.lastSelectedCategory = '';
            this.oilCondensateProductionButton = '';
            this.oilCondensateDeliveryButton = '';
            this.SET_LOADING(true);
            this.isOpecFilterActive = false;
            this.oilCondensateFilters.isWithoutKMGFilterActive = true;
            this.isOilResidueActive = false;
            if (!this.condolidatedButtons.includes(buttonName)) {
                this.changeDzoCompaniesList(dzoCompaniesInitial);
            } else {
                this.changeDzoCompaniesList(companiesListWithKMG);
            }
            if (!this.isOneDzoSelected){
                this.selectAllDzoCompanies();
            }
            this.setDzoCompaniesToInitial();
            this.disableTargetCompanyFilter();
            if (!childButton) {
                this.mainMenuButtonElementOptions = _.cloneDeep(mainMenuConfiguration);
                this.disableOilFilters();
            }
            this.selectedView = buttonName;
            this.chartHeadName = this.chartTranslateMapping[buttonName];
            this.chartSecondaryName = categoryName;
            this.selectedButtonName = buttonName;
            this.dzoCompaniesAssets['assetTitle'] = this.trans("visualcenter.summaryAssets");
            this.planFieldName = planFieldName;
            this.factFieldName = factFieldName;
            this.metricName = metricName;
            if (parentButton && childButton) {
                this.switchMainMenu(parentButton, childButton);
                this.changeAssets(childButton);
            } else {
                this.isMainMenuItemChanged = true;
            }
            this.changeDate();
        },

        changeDzoCompaniesList(companyList) {
            this.dzoCompanies = _.cloneDeep(companyList);
            this.dzoCompaniesTemplate = _.cloneDeep(companyList);
        },

        switchMainMenu(parentButton, childButton,chartName) {
            this.chartHeadName = this.chartTranslateMapping[childButton];
            this.selectAllDzoCompanies();
            this.disableTargetCompanyFilter();
            let self = this;
            this.isMainMenuItemChanged = false;
            this.isOilResidueActive = childButton === 'oilResidue' && !this.isOilResidueActive;
            let currentFilterOptions = this.mainMenuButtonElementOptions[parentButton].childItems[childButton];
            if (this.categoryMenuPreviousParent !== parentButton) {
                _.forEach(Object.keys(this.mainMenuButtonElementOptions), function (button) {
                    self.disableMainMenuFlags(self.mainMenuButtonElementOptions[button]);
                });
            }
            this.categoryMenuPreviousParent = parentButton;
            this.switchButtonOptions(currentFilterOptions);
        },
        switchButtonOptions(elementOptions) {
            let enabledFlag = 'flagOn';
            let disabledFlag = 'flagOff'
            let highlightedButton = this.mainMenuButtonHighlighted;
            let normalButton = '';
            if (elementOptions.buttonClass !== highlightedButton) {
                elementOptions.buttonClass = highlightedButton;
            } else {
                elementOptions.buttonClass = normalButton;
            }
            if (elementOptions.flag !== enabledFlag) {
                elementOptions.flag = enabledFlag;
            } else {
                elementOptions.flag = disabledFlag;
            }
        },

        disableMainMenuFlags(menuCategory) {
            if (!menuCategory.childItems) {
                return;
            }
            _.forEach(Object.keys(menuCategory.childItems), function (childButton) {
                menuCategory.childItems[childButton]['flag'] = 'flagOff';
                menuCategory.childItems[childButton]['button'] = '';
            });
        },

        changeAssets(type,category,regionName) {
            this.dzoCompaniesAssets[type] = true;
            if (!this.dzoCompaniesAssets[type]) {
                this.dzoCompaniesAssets['isAllAssets'] = true;
            }
            this.dzoCompaniesAssets['assetTitle'] = this.assetTitleMapping[type];

            if (type === "opecRestriction") {
                this.isOpecFilterActive = !this.isOpecFilterActive;
            }  else {
                this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
                this.dzoCompaniesAssets[type] = !this.dzoCompaniesAssets[type];
                this.selectedDzoCompanies = this.getSelectedDzoCompanies(type,category,regionName);
                this.selectMultipleDzoCompanies(type,category,regionName);
            }
        },

        setColorToMainMenuButtons() {
            let self = this;
            _.forEach(Object.keys(this.mainMenuButtonElementOptions), function (button) {
                self[button] = self.getButtonClassForMainMenu(button);
            });
        },

        getButtonClassForMainMenu(buttonType) {
            if (buttonType === this.selectedButtonName) {
                return this.highlightedButton;
            } else {
                return "";
            }
        },

        getMainMenuButtonFlag(parentButton, childButton) {
            if (!this.mainMenuButtonElementOptions[parentButton]) {
                return this.flagOff;
            }
            let buttonOptions = this.mainMenuButtonElementOptions[parentButton].childItems[childButton];
            return this[buttonOptions.flag];
        },

        getThousandMetricNameByCategorySelected() {
            if (this.gasProductionButton) {
                return this.trans('visualcenter.thousand') + this.trans('visualcenter.meterCubicWithSpace');
            } else {
                return this.trans("visualcenter.dzoThousandTon");
            }
        },

        getMetricNameByCategorySelected() {
            if (this.gasProductionButton) {
                return this.trans('visualcenter.meterCubic');
            } else {
                return this.trans("visualcenter.tonWithSpace");
            }
        },

        assignOneCompanyToSelectedDzo(oneDzoNameSelected) {
            if (oneDzoNameSelected == 'ОМГ') {
                oneDzoNameSelected = [oneDzoNameSelected, 'ОМГК'];
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
            this.updateChemistryWidget();
            this.updateWellsWorkoverWidget();
            this.updateDrillingWidget();    
            this.updateProductionFondWidget();
            this.updateInjectionFondWidget();          
        },

        switchDropdownCategories(category) {
            this.dropdownMenu = _.mapValues(this.dropdownMenu, () => false);
            this.dropdownMenu[category] = !this.dropdownMenu[category];
        },
    },
}