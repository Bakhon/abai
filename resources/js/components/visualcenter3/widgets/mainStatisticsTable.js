import moment from "moment";

export default {
    data: function () {
        return {
            buttonDailyTab: "button-tab-highlighted",
            buttonMonthlyTab: "",
            buttonYearlyTab: "",
            buttonPeriodTab: "",
            scroll: '',
            tables: "",
            buttonNormalTab: "",
            highlightedButton: "button-tab-highlighted",
            display: "none",
            assetTitleMapping: {
                isOperating: this.trans("visualcenter.summaryOperatingAssets"),
                isNonOperating: this.trans("visualcenter.summaryNonOperatingAssets"),
                isAllAssets: this.trans("visualcenter.summaryAssets"),
                opecRestriction: this.trans("visualcenter.opek"),
                kmgParticipation: this.trans("visualcenter.dolyaUchast"),
                isRegion: this.trans("visualcenter.summaryByRegion"),
            },
            oilProductionButton: "",
            oilDeliveryButton: "",
            gasProductionButton: "",
            condensateProductionButton: "",
            minimalDaysCountInPeriodForChart: 1,
            oilCondensateProductionButton: "button-tab-highlighted",
            oilCondensateDeliveryButton: '',
            tableMapping: {
                'productionDetails': {
                    'class': '',
                    'hover': '',
                },
                'oilRate': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'usdRate': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'productionWells': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'injectionWells': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'otmDrilling': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'chemistry': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'otmWorkover': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'emergencyInfo': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
            }
        };
    },
    methods: {
        changeTable(tableName, isWidgetClosed) {
            _.forEach(this.tableMapping, function (item) {
                _.set(item, 'class', 'hide-company-list');
                _.set(item, 'hover', '');
            });
            if (isWidgetClosed) {
                this.chemistrySelectedCompany = 'all';
                this.wellsWorkoverSelectedCompany = 'all';
                this.drillingSelectedCompany = 'all';
                this.productionFondSelectedCompany = 'all';
                this.injectionFondSelectedCompany = 'all';
                this.updateChemistryWidget();
                this.updateWellsWorkoverWidget();
                this.updateDrillingWidget();
                this.updateProductionFondWidget();
                this.updateInjectionFondWidget();
            }
            this.tableMapping[tableName]['class'] = 'show-company-list';
            this.tableMapping[tableName]['hover'] = 'button_hover';
        },
    }
}