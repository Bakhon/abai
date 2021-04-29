import mainMenuConfiguration from "../main_menu_configuration.json";

export default {
    data: function () {
        return {
            isMainMenuItemChanged: false,
            mainMenuButtonElementOptions: {},
            categoryMenuPreviousParent: '',
            mainMenuButtonHighlighted: "color: #fff;background: #237deb;font-weight:bold;",
            isOpecFilterActive: false,
            isKmgParticipationFilterActive: false,
            flagOn: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.4791 0.469238H2.31923C1.20141 0.469238 0.297516 1.38392 0.297516 2.50136L0.287109 18.7576L7.39917 15.7094L14.5112 18.7576V2.50136C14.5112 1.38392 13.5969 0.469238 12.4791 0.469238Z" fill="#2E50E9"/>' +
                '</svg>',
            flagOff: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg"> \n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.8448 0.286987H2.68496C1.56713 0.286987 0.663191 1.20167 0.663191 2.31911L0.652832 18.5754L7.76489 15.5272L14.877 18.5754V2.31911C14.877 1.20167 13.9627 0.286987 12.8448 0.286987Z" fill="#656A8A"/>' +
                '</svg>',
        };
    },
    methods: {
        switchCategory(planFieldName, factFieldName, metricName, categoryName, parentButton, childButton) {
            this.changeTargetCompanyFilter();
            if (!childButton) {
                this.mainMenuButtonElementOptions = _.cloneDeep(mainMenuConfiguration);
                this.disableOilFilters();
            }
            this.chartSecondaryName = categoryName;
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

        switchMainMenu(parentButton, childButton) {
            this.changeTargetCompanyFilter();
            let self = this;
            this.isMainMenuItemChanged = false;
            let currentFilterOptions = this.mainMenuButtonElementOptions[parentButton].childItems[childButton];
            if (this.categoryMenuPreviousParent !== parentButton || !this.isOilProductionMenu(parentButton,childButton)) {
                _.forEach(Object.keys(this.mainMenuButtonElementOptions), function (button) {
                    self.disableMainMenuFlags(self.mainMenuButtonElementOptions[button]);
                });
            }
            this.categoryMenuPreviousParent = parentButton;
            this.switchButtonOptions(currentFilterOptions);
        },
        isOilProductionMenu(parentButton,childButton) {
            let oilProductionSubMenuButtons = ['kmgParticipation','opecRestriction'];
            return parentButton === 'oilProductionButton' && oilProductionSubMenuButtons.includes(childButton);
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
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.dzoCompaniesAssets['assetTitle'] = this.assetTitleMapping[type];

            if (type === "opecRestriction") {
                this.isOpecFilterActive = !this.isOpecFilterActive;
            } else if (type === 'kmgParticipation') {
                this.chartSecondaryName = this.trans("visualcenter.dolyaUchast");
                this.isKmgParticipationFilterActive = !this.isKmgParticipationFilterActive;
            } else {
                this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
                this.dzoCompaniesAssets[type] = !this.dzoCompaniesAssets[type];
                this.selectedDzoCompanies = this.getSelectedDzoCompanies(type,category,regionName);
                this.selectMultipleDzoCompanies(type,category,regionName);
            }
        },

        setColorToMainMenuButtons() {
            let self = this;
            _.forEach(Object.keys(this.mainMenuButtonElementOptions), function (button) {
                self[button] = self.getButtonClassForMainMenu(self.planFieldName, button);
            });
        },

        getButtonClassForMainMenu(productionPlan, buttonType) {
            if (this.mainMenuButtonElementOptions[buttonType].tags.includes(productionPlan)) {
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
    },
}