
export default {
    data: function () {
        return {
            isMainMenuItemChanged: false,
            mainMenuButtonElementOptions: {},
            categoryMenuPreviousParent: '',
            mainMenuButtonHighlighted: "color: #fff;background: #237deb;font-weight:bold;",
            isOpecFilterActive: false,
            isKmgParticipationFilterActive: false,
        };
    },
    methods: {
        switchCategory(planFieldName, factFieldName, metricName, categoryName, parentButton, childButton) {
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
            let self = this;
            this.isMainMenuItemChanged = false;
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
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.dzoCompaniesAssets['assetTitle'] = this.assetTitleMapping[type];

            if (type === "opecRestriction") {
                this.isOpecFilterActive = !this.isOpecFilterActive;
            } else if (type === 'kmgParticipation') {
                this.chartSecondaryName = this.trans("visualcenter.dolyaUchast");
                this.isKmgParticipationFilterActive = !this.isKmgParticipationFilterActive;
            } else {
                if (regionName) {
                    this.dzoRegionsMapping[regionName].isActive = true;
                }
                this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
                this.dzoCompaniesAssets[type] = true;
                this.selectedDzoCompanies = this.getSelectedDzoCompanies(type,category,regionName);
                this.selectMultipleDzoCompanies(type,category,regionName);
            }
        },

        setColorToMainMenuButtons(productionPlan) {
            let self = this;
            _.forEach(Object.keys(this.mainMenuButtonElementOptions), function (button) {
                self[button] = self.getButtonClassForMainMenu(productionPlan, button);
            });
        },

        getButtonClassForMainMenu(productionPlan, buttonType) {
            if (this.mainMenuButtonElementOptions[buttonType].tags.includes(productionPlan)) {
                return this.highlightedButton;
            } else {
                return "";
            }
        },
    },
}