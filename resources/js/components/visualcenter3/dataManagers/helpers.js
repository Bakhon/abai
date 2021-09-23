import moment from "moment";

export default {
    data: function () {
        return {
            tdStyle: "index % 2 === 0 ? 'tdStyle' : 'tdNone'",
            tdStyleLight: "index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'",
        };
    },
    methods: {
        getDzoColumnsClass(rowIndex, columnName) {
            if (this.getColumnIndex(columnName) % 2 === 0) {
                return this.getDarkColorClass(rowIndex);
            } else {
                return this.getLightColorClass(rowIndex);
            }
        },

        formatDigitToThousand(num) {
            if (num == null) {
                return 0;
            }
            if (this.periodRange === 0) {
                this.thousand = '';
                return new Intl.NumberFormat("ru-RU").format(Math.round(num));
            } else {
                this.thousand = this.trans("visualcenter.thousand");
                if (num >= 1000) {
                    num = (num / 1000).toFixed(0)
                } else if (num >= 10) {
                    num = num / 1000;
                } else if (num > 0) {
                    num = 0.01;
                } else {
                    num = 0;
                }
                return new Intl.NumberFormat("ru-RU").format(num);
            }
        },

        getDiffProcentLastBigN(a, b) {
            if (a != '') {
                return ((a / b) * 100).toFixed(2);
            } else {
                return 0
            }
        },

        getDifferencePercentBetweenLastValues(current,previous) {
            if (previous != '' && previous !== 0) {
                return ((current / previous - 1) * 100).toFixed(2);
            }
            return 0;
        },

        getNameDzoFull: function (dzo) {
            if (Array.isArray(dzo)) {
                dzo = dzo['0']
            }
            if (typeof this.NameDzoFull[dzo] !== 'undefined') {
                return this.NameDzoFull[dzo]
            }
            return dzo;
        },

        getDaysCountInMonth(date) {
            return moment(date, "YYYY-MM").daysInMonth();
        },

        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
        },

        getColumnIndex(columnName) {
            return this.dzoColumns.indexOf(columnName);
        },

        getDarkColorClass(rowIndex) {
            if (rowIndex % 2 === 0) {
                return 'tdStyle'
            } else {
                return 'tdNone'
            }
        },

        getLightColorClass(rowIndex) {
            if (rowIndex % 2 === 0) {
                return 'tdStyleLight'
            } else {
                return 'tdStyleLight2'
            }
        },

        getDarkerClass(rowIndex) {
            if (rowIndex % 2 === 0) {
                return 'tdStyle3'
            } else {
                return 'tdNone'
            }
        },

        getLighterClass(rowIndex) {
            if (rowIndex % 2 === 0) {
                return 'tdStyleLight3'
            } else {
                return 'tdStyleLight2'
            }
        },

        getColorClassBySelectedPeriod(index) {
            if (this.buttonMonthlyTab || this.buttonYearlyTab) {
                return this.getLighterClass(index);
            } else {
                return this.getDarkerClass(index);
            }
        },

        getGrowthIndicatorByDifference(previous,current) {
            let difference = this.getDifferencePercentBetweenLastValues(previous,current);
            if (difference < 0) {
                return "indicator-grow";
            }
            if (difference > 0) {
                return "indicator-fall";
            }
        },

        getFilteredData(data, type) {
            _.forEach(this.dzoType[type], function (dzoName) {
                data = _.reject(data, _.iteratee({dzo: dzoName}));
            });
            return data;
        },

        disableDzoRegions() {
            _.forEach(this.dzoRegionsMapping, function(region) {
                _.set(region, 'isActive', false);
            });
        },

        getFormattedNumberToThousand(plan,fact) {
            let formattedPlan = this.formatDigitToThousand(plan);
            let formattedFact = this.formatDigitToThousand(fact);
            if (formattedPlan) {
                formattedPlan = this.getNumberFromString(formattedPlan);
            }
            if (formattedFact) {
                formattedFact = this.getNumberFromString(formattedFact);
            }
            let diff = formattedPlan - formattedFact;
            let formattedNumber = Math.abs(Math.round(diff));
            return new Intl.NumberFormat("ru-RU").format(formattedNumber);
        },

        getNumberFromString(inputString) {
            return parseInt(inputString.replace(/\s/g, ''));
        },

        getIndicatorClassForReverseParams(i) {
            let arrowClass = '';
            if (i < 0) {
                arrowClass = "fond-indicator-grow";
            } else if (i > 0) {
                arrowClass = "fond-indicator-fall";
            }
            return arrowClass;
        },

        getDzoName(acronym,mapping) {
            if (!mapping[acronym]) {
                return acronym;
            }
            return this.trans(mapping[acronym]);
        },

        getProductionTableClass() {
            let classes = 'table4 production-table';
            if (!this.mainMenu.oilCondensateDeliveryOilResidue) {
                classes += ' w-100';
            }
            if (!this.buttonDailyTab) {
                classes += ' mh-30';
            }
            return classes;
        },

        isConsolidatedCategoryActive() {
            return this.mainMenu.oilCondensateProduction || this.mainMenu.oilCondensateDelivery;
        },

        getNumberFormat(num) {
            return (new Intl.NumberFormat("ru-RU").format(num))
        },

        getIndicatorClass(plan,fact) {
            if (fact < plan) {
                return 'triangle fall-indicator-production-data';
            }
            return 'triangle growth-indicator-production-data';
        },

        getHighlightClassForSummary(isEven) {
            if (isEven) {
                return 'tdStyle3';
            } else {
                return 'tdStyleLight3';
            }
        },

        getMetricNameByCategorySelected() {
            if (!this.isConsolidatedCategoryActive()) {
                return this.trans('visualcenter.meterCubic');
            } else {
                return this.trans("visualcenter.tonWithSpace");
            }
        },

        getThousandMetricNameByCategorySelected() {
            if (!this.isConsolidatedCategoryActive()) {
                return this.trans('visualcenter.thousand') + this.trans('visualcenter.meterCubicWithSpace');
            } else {
                return this.trans("visualcenter.dzoThousandTon");
            }
        },

        getFilteredTableData() {
            return _.filter(_.cloneDeep(this.productionTableData), (item) => {
                return this.selectedDzoCompanies.includes(item.name);
            });
        },
    },
    computed: {
        periodSelectFunc() {
            let DMY = [
                this.trans("visualcenter.week"),
                this.trans("visualcenter.Month"),
                this.trans("visualcenter.Quarter"),
                this.trans("visualcenter.Year"),
                this.trans("visualcenter.All")
            ];
            let DMY_titles = [
                this.trans("visualcenter.kurs7day"),
                this.trans("visualcenter.kurslastmonth"),
                this.trans("visualcenter.kurs3month"),
                this.trans("visualcenter.kurslastyear"),
                this.trans("visualcenter.kursalltime"),
            ];

            let menuDMY = [];
            let id = 0;

            for (let i = 0; i <= 4; i++) {
                let a = {
                    index: i,
                    id: i,
                    active_oil: false,
                    active_usd: false,
                };

                a.DMY = DMY[i];
                a.DMY_title = DMY_titles[i];
                menuDMY.push(a);

                if (this.period === i) {
                    a.active = true;
                    this.DMY = menuDMY[i]["DMY"];
                }
            }
            return menuDMY;
        },
    },
}