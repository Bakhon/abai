import moment from "moment";

export default {
    data: function () {
        return {
            tdStyle: "index % 2 === 0 ? 'tdStyle' : 'tdNone'",
            tdStyleLight: "index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'",
        };
    },
    methods: {
        filterDzoInputForSeparateCompany(data, company) {
            return _.filter(data, function (item) {
                return (item.dzo === company);
            })
        },

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
            if (this.quantityRange < 2) {
                this.thousand = '';
                return new Intl.NumberFormat("ru-RU").format(Math.round(num));
            } else {
                this.thousand = this.trans("visualcenter.thousand");
                if (num >= 1000) {
                    num = (num / 1000).toFixed(0)
                } else if (num >= 100) {
                    num = Math.round((num / 1000) * 10) / 10
                } else if (num >= 10) {
                    num = Math.round((num / 1000) * 100) / 100
                } else if (num > 0) {
                    num = 0.01
                } else {
                    num = 0;
                }
                return new Intl.NumberFormat("ru-RU").format(num)
            }
        },

        ISODateString(d) {
            function pad(n) {
                return n < 10 ? '0' + n : n
            }

            return d.getUTCFullYear() + '-'
                + pad(d.getUTCMonth() + 1) + '-'
                + pad(d.getUTCDate()) + 'T'
                + pad(d.getUTCHours()) + ':'
                + pad(d.getUTCMinutes()) + ':'
                + pad(d.getUTCSeconds()) + '+06:00'
        },

        getDiffProcentLastBigN(a, b) {
            if (a != '') {
                return ((a / b) * 100).toFixed(2);
            } else {
                return 0
            }
        },

        getDifferencePercentBetweenLastValues(previous,current) {
            if (previous != '' && previous !== 0) {
                return ((current / previous - 1) * 100).toFixed(2);
            }
            return 0;
        },

        pad(n) {
            return n < 10 ? "0" + n : n;
        },

        getNameDzoFull: function (dzo) {
            if (typeof this.NameDzoFull[dzo] !== 'undefined') {
                return this.NameDzoFull[dzo]
            }
            return dzo;
        },

        getDaysCountInMonth(date) {
            return moment(date, "YYYY-MM").daysInMonth();
        },

        getQuarter(d) {
            return [parseInt(d.getMonth() / 3) + 1, d.getFullYear()];
        },

        getPreviousWorkday(){
            let workday = moment();
            let day = workday.day();
            let diff = 2;
            if (day === 0 || day === 1){
                diff = day + 2;
            }
            return workday.subtract(diff, 'days').endOf('day').format();
        },

        getPercentDifference(a, b) {
            if (a && b) {
                return new Intl.NumberFormat("ru-RU").format(Math.abs(((a - b) / b) * 100).toFixed(1))
            } else {
                return 0
            }
        },

        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
        },

        getColumnIndex(columnName) {
            return this.dzoColumns[this.currentDzoList].indexOf(columnName);
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

        getDataOrderedByAsc(data) {
            return _.orderBy(data,
                ["__time"],
                ["asc"]
            );
        },

        getCovidData(data) {
            return _.reduce(data, function (memo, item) {
                return memo + item['tb_covid_total'];
            }, 0);
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

        getProductionDataInPeriodRange(data, periodStart, periodEnd) {
            return _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        periodStart,
                        periodEnd
                    ),
                ]);
            });
        },

        getFilteredDataByOneDay(filteredDataByCompanies,dayType,periodStart,periodEnd) {
            let dayTypeMapping = {
                'today': {
                    'start': periodStart,
                    'end': periodEnd
                },
                'yesterday': {
                    'start': moment(new Date(periodStart)).subtract(1, 'days').valueOf(),
                    'end': periodStart
                }
            };
            let filteredDataByOneDay = this.getProductionDataInPeriodRange(filteredDataByCompanies,dayTypeMapping[dayType].start,dayTypeMapping[dayType].end);
            return this.getDataOrderedByAsc(filteredDataByOneDay);
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
        getIndicatorForStaffCovidParams(previosValue,currentValue) {
            if (previosValue > currentValue) {
                return this.trans("visualcenter.indicatorFall");
            } else if (previosValue < currentValue) {
                return this.trans("visualcenter.indicatorGrow");
            }
        },

        getFilteredDataByOneCompany(data) {
            let self = this;
            return _.filter(data, function (item) {
                return self.company == item.dzo;
            });
        },

        getDzoName(acronym,mapping) {
            return this.trans(mapping[acronym]);
        },

        getOilProductionKmgParticipationDzoTitle(percentParticipation){
            if (percentParticipation) {
                return " (" + percentParticipation * 100 + "%)";
            }
            return "";

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