import moment from "moment";

export default {
    data: function () {
        return {
            buttonDailyTab: "button-tab-highlighted",
            buttonMonthlyTab: "",
            buttonYearlyTab: "",
            buttonPeriodTab: "",
            highlightedButton: "button-tab-highlighted",
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
            },
            assetTitleMapping: {
                isOperating: this.trans("visualcenter.summaryOperatingAssets"),
                isNonOperating: this.trans("visualcenter.summaryNonOperatingAssets"),
                isAllAssets: this.trans("visualcenter.summaryAssets"),
                opecRestriction: this.trans("visualcenter.opek"),
                kmgParticipation: this.trans("visualcenter.dolyaUchast"),
                isRegion: this.trans("visualcenter.summaryByRegion"),
            },
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