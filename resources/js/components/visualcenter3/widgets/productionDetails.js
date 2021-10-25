import moment from "moment";

export default {
    data: function () {
        return {
            currentMonthDateStart: moment().subtract(2,'months').format('MMMM YYYY'),
            currentMonthDateEnd: moment().subtract(1,'months').format('MMMM YYYY'),
            selectedWidget: 'productionDetails',
            datePickerOptions: {
                disabledDate (date) {
                    return moment(date).startOf('month') >= moment().startOf('month')
                }
            },
            datePickerConfig: {
                start: {
                    type: 'string',
                    mask: 'DD.MM.YYYY',
                },
                end: {
                    type: 'string',
                    mask: 'DD.MM.YYYY',
                },
            },
            dzoMenu: {
                'chemistry': [],
                'wellsWorkover': [],
                'drilling': [],
                'productionFond': [],
                'injectionFond': [],
            },
        };
    },
    methods: {
        async switchWidget(widgetName) {
            this.SET_LOADING(true);
            _.forEach(this.tableMapping, function (item) {
                _.set(item, 'class', 'hide-company-list');
                _.set(item, 'hover', '');
            });
            this.tableMapping[widgetName]['class'] = 'show-company-list';
            this.tableMapping[widgetName]['hover'] = 'button_hover';
            this.updateChemistryWidget();
            this.updateWellsWorkoverWidget();
            this.updateDrillingWidget();
            if (widgetName === 'productionWells') {
                await this.updateProductionFondWidget();
            }
            if (widgetName === 'injectionWells') {
                await this.updateInjectionFondWidget();
            }
            this.SET_LOADING(false);
        },

        updateDzoMenu() {
            let self = this;
            if (this.isOneDzoSelected) {
                self.injectionWellsOptions = _.filter(self.injectionWellsOptions, function (item) {
                    let selectedDzoCompanies = self.selectedDzoCompanies;
                    if (Array.isArray(selectedDzoCompanies)) {
                        selectedDzoCompanies = selectedDzoCompanies['0']
                    }
                    if (item.ticker === selectedDzoCompanies) {
                        return item
                    }
                })
            }
            this.dzoMenu = _.mapValues(this.dzoMenu, () => _.cloneDeep(this.injectionWellsOptions));
            if (!this.isOneDzoSelected) {
                this.dzoMenu.productionFond.push({
                    ticker: 'УО',
                    name: this.trans("visualcenter.uo")
                });
            }
        },
    }
}