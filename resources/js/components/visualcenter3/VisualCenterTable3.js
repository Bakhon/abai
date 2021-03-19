import {EventBus} from "../../event-bus.js";
import moment from "moment";
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import {isString} from "lodash";

import mainMenuConfiguration from './main_menu_configuration.json';
import {dzoMapState, dzoMapActions} from '@store/helpers';

import mainMenu from './widgets/mainMenu';
import сompaniesDzo from './data_managers/dzoCompanies';
import helpers from './data_managers/helpers';
import otm from './data_managers/otm';
import chemistry from './data_managers/chemistry';
import oilRates from './widgets/oilRates';
import usdRates from './widgets/usdRates';
import injectionWells from './widgets/injectionWells';
import productionWells from './widgets/productionWells';
import companyStaff from './widgets/companyStaff';
import mainStatisticsTable from './widgets/mainStatisticsTable';
import wells from './data_managers/wells';
import rates from './data_managers/rates';
import dates from './data_managers/dates';
import oilProductionFilters from './data_managers/oilProductionFilters';


Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);
import Vue from "vue";



export default {
    components: {
        Calendar,
        DatePicker
    },
    data: function () {
        return {
            accidentTotal: '',
            noData: '',
            lastDate1: 0,
            lastDate2: 0,
            thousand: 'тыс.',
            personalFact: '',
            oilChartHeadName: this.trans('visualcenter.getoildynamic'),
            productionFactPercentOneDzo: '',
            productionFactPercentSumm: '',
            quantityRange: '',
            productionFactPersent: '',
            productionPlanPersent: '',
            quantityGetProductionOilandGas: "",
            oil_factDayPercent: "",
            oil_dlv_factDayPercent: "",
            gas_factDayPercent: "",
            oil_factDay: "",
            oil_planDay: "",
            oil_dlv_factDay: "",
            oil_dlv_planDay: "",
            gas_factDay: "",
            gas_planDay: "",
            oil_dlv_factDayProgressBar: "",
            oil_factDayProgressBar: "",
            gas_factDayProgressBar: "",
            index: "",
            widthProgress: "90",
            NameDzoFull: {
                0: "Всего добыча нефти с учётом доли участия АО НК КазМунайГаз",
                1: "(конденсат)(100%)",
                2: "в т.ч.:газовый конденсат",
                3: 'АО ПетроКазахстан Инк',
                'ОМГ': this.trans("visualcenter.omg"),
                'ЭМГ': this.trans("visualcenter.emg"),
                'КБМ': this.trans("visualcenter.kbm"),
                'КГМ': this.trans("visualcenter.kgm"),
                'ТШ': this.trans("visualcenter.tsho"),
                'ТШО': this.trans("visualcenter.tsho"),
                'ММГ': this.trans("visualcenter.mmg"),
                'КТМ': this.trans("visualcenter.ktm"),
                'КОА': this.trans("visualcenter.koa"),
                'ПКИ': this.trans("visualcenter.pki"),
                'АМГ': this.trans("visualcenter.ag"),
                'АГ': this.trans("visualcenter.ag"),
                'КПО': this.trans("visualcenter.kpo"),
                'НКО': this.trans("visualcenter.nko"),
                'ТП': this.trans("visualcenter.tp"),
                'УО': this.trans("visualcenter.uo"),
                'ПКК': this.trans("visualcenter.pkk"),
            },
            bigTable: [],
            starts: [""],
            series: ["", ""],
            factYearSumm: "",
            planYearSumm: "",
            planMonthSumm: "",
            factMonthSumm: "",
            factDaySumm: "",
            planDaySumm: "",
            timestampToday: "",
            timestampEnd: "",
            isPricesChartLoading: false,
            chartHeadName: this.trans("visualcenter.getoil"),
            chartSecondaryName: this.trans('visualcenter.getoil'),
            planFieldName: "oil_plan",
            factFieldName: "oil_fact",
            metricName: this.trans("visualcenter.chemistryMetricTon"),
        };
    },
    methods: {
        ...dzoMapActions([
            'getYearlyPlan'
        ]),

        async getDzoYearlyPlan() {
            await this.getYearlyPlan();
        },

        disableDzoRegions() {
          _.forEach(this.dzoRegionsMapping, function(region) {
              _.set(region, 'isActive', false);
          });
        },

        getProductionOilandGas(data) {
            if (data) {
                var timestampToday = this.timestampToday;
                var timestampEnd = this.timestampEnd;
                var company = this.company;
                if (company != "all") {
                    data = _.filter(data, _.iteratee({dzo: company}));
                }
                var dataWithMay = new Array();
                dataWithMay = _.filter(data, function (item) {
                    return _.every([
                        _.inRange(
                            item.__time,
                            timestampToday,
                            timestampEnd + 10
                        ),
                    ]);
                });

                var quantityGetProductionOilandGas = Object.keys(_.filter(dataWithMay, _.iteratee({dzo: dataWithMay[0].dzo}))).length;//k1q
                this.quantityGetProductionOilandGas = quantityGetProductionOilandGas;


                var SummFromRange = _(dataWithMay)
                    .groupBy("dzo")
                    .map((dzo, id) => ({
                        dzo: id,
                        oil_plan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
                        oil_fact: _.round(_.sumBy(dzo, 'oil_fact'), 0),
                        oil_dlv_plan: _.round(_.sumBy(dzo, 'oil_dlv_plan'), 0),
                        oil_dlv_fact: _.round(_.sumBy(dzo, 'oil_dlv_fact'), 0),
                        gas_plan: _.round(_.sumBy(dzo, 'gas_plan'), 0),
                        gas_fact: _.round(_.sumBy(dzo, 'gas_fact'), 0),
                    }))

                    .value();


                var oil_planSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_plan;
                    },
                    0
                );


                var oil_factSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_fact;
                    },
                    0
                );


                var oil_dlv_planSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_dlv_plan;
                    },
                    0
                );


                var oil_dlv_factSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_dlv_fact;
                    },
                    0
                );


                var gas_planSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.gas_plan;
                    },
                    0
                );


                var gas_factSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.gas_fact;
                    },
                    0
                );

                if (oil_factSumm) {
                    this.oil_factDay = oil_factSumm;
                }
                if (oil_planSumm) {
                    this.oil_planDay = oil_planSumm;
                }
                if (oil_factSumm || oil_planSumm) {
                    this.oil_factDayProgressBar = (oil_factSumm / oil_planSumm) * 100;
                }

                if (oil_dlv_factSumm) {
                    this.oil_dlv_factDay = oil_dlv_factSumm;
                }
                if (oil_dlv_planSumm) {
                    this.oil_dlv_planDay = oil_dlv_planSumm;
                }
                if (oil_dlv_factSumm || oil_dlv_planSumm) {
                    this.oil_dlv_factDayProgressBar = (oil_dlv_factSumm / oil_dlv_planSumm) * 100;
                }

                if (gas_factSumm) {
                    this.gas_factDay = gas_factSumm;
                }
                if (gas_planSumm) {
                    this.gas_planDay = gas_planSumm;
                }
                if (gas_factSumm || gas_planSumm) {
                    this.gas_factDayProgressBar = (gas_factSumm / gas_planSumm) * 100;
                }

            }
        },

        getProductionOilandGasPercent(data) {
            if (data) {
                var timestampToday = this.timestampToday;
                var timestampEnd = this.timestampEnd;
                var company = this.company;
                if (company != "all") {
                    data = _.filter(data, _.iteratee({dzo: company}));
                }

                var quantityRange = this.quantityRange;

                var dataWithMay = new Array();
                dataWithMay = _.filter(data, function (item) {
                    return _.every([
                        _.inRange(
                            item.__time,
                            timestampToday - quantityRange * 86400000,
                            timestampToday
                        ),
                    ]);
                });
                this.lastDate1 = new Date(timestampToday - quantityRange * 86400000).toLocaleDateString();
                this.lastDate2 = new Date(timestampToday - 86400000).toLocaleDateString();

                var SummFromRange = _(dataWithMay)
                    .groupBy("dzo")
                    .map((dzo, id) => ({
                        dzo: id,
                        oil_plan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
                        oil_fact: _.round(_.sumBy(dzo, 'oil_fact'), 0),
                        oil_dlv_plan: _.round(_.sumBy(dzo, 'oil_dlv_plan'), 0),
                        oil_dlv_fact: _.round(_.sumBy(dzo, 'oil_dlv_fact'), 0),
                        gas_plan: _.round(_.sumBy(dzo, 'gas_plan'), 0),
                        gas_fact: _.round(_.sumBy(dzo, 'gas_fact'), 0),
                    }))

                    .value();

                var oil_planSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_plan;
                    },
                    0
                );

                var oil_factSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_fact;
                    },
                    0
                );

                var oil_dlv_planSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_dlv_plan;
                    },
                    0
                );

                var oil_dlv_factSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.oil_dlv_fact;
                    },
                    0
                );

                var gas_planSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.gas_plan;
                    },
                    0
                );

                var gas_factSumm = _.reduce(
                    SummFromRange,
                    function (memo, item) {
                        return memo + item.gas_fact;
                    },
                    0
                );

                this.oil_factDayPercent = oil_factSumm;
                this.gas_factDayPercent = gas_factSumm;
                this.oil_dlv_factDayPercent = oil_dlv_factSumm;

            }
        },

        updateProductionData(planFieldName, factFieldName, chartHeadName, metricName, chartSecondaryName) {
            if (this.isMainMenuItemChanged) {
                this.mainMenuButtonElementOptions = _.cloneDeep(mainMenuConfiguration);
            }

            this.$store.commit('globalloading/SET_LOADING', true);
            let start = new Date(this.range.start).toLocaleString("ru", {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
            });

            let end = new Date(this.range.end).toLocaleString("ru", {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
            });
            if (start === end) {
                this.oneDate = 1;
                this.scroll = "main-table__scroll";
            } else {
                this.oneDate = '';
                this.scroll = "";
            }
            var timestampToday = this.timestampToday;
            var timestampEnd = this.timestampEnd;
            this.planFieldName = planFieldName;
            this.factFieldName = factFieldName;
            this.chartHeadName = chartHeadName;
            this.metricName = metricName;
            this.chartSecondaryName = chartSecondaryName;

            let oilProductionFieldsNames = ['oil_plan','oil_opek_plan'];
            if (oilProductionFieldsNames.includes(this.planFieldName)) {
                this.changeOilProductionFilters();
            } else {
                this.isOpecFilterActive = false;
                this.isKmgParticipationFilterActive = false;
            }

            if (this.company === null) {
                alert("Сначала выберите название компании");
            }

            let uri = this.localeUrl("/visualcenter3GetData?timestampToday=") + this.timestampToday + "&timestampEnd=" + this.timestampEnd + " ";

            this.axios.get(uri).then((response) => {
                let data = response.data;
                if (data && Object.keys(data).length > 0) {
                    if (this.company === "all") {
                        data = this.processDataForAllCompanies(data, timestampToday, timestampEnd, start, end, this.planFieldName, this.factFieldName, this.chartHeadName);
                    } else {
                        this.processDataForSpecificCompany(data, timestampToday, timestampEnd, start, end, this.factFieldName, this.planFieldName, this.chartHeadName, metricName, chartSecondaryName);
                    }
                    this.setColorToMainMenuButtons(planFieldName);
                    this.getProductionOilandGas(data);
                    this.getProductionOilandGasPercent(data);
                } else {
                    console.log("No data");
                }
                this.$store.commit('globalloading/SET_LOADING', false);
            });
        },

        processDataForSpecificCompany(data, timestampToday, timestampEnd, start, end, factFieldName, planFieldName, chartHeadName, metricName, chartSecondaryName) {
            var arrdata = new Array();
            arrdata = _.filter(data, _.iteratee({dzo: this.company}));

            var dataWithMay = new Array();
            dataWithMay = _.filter(arrdata, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        timestampToday,
                        timestampEnd + 10//86400000 //* dayInMonth
                    ),
                ]);
            });

            dataWithMay = _.orderBy(
                dataWithMay,
                ["__time"],
                ["asc"]
            );


            this.getProductionPercentCovid(dataWithMay);
            this.covid = _.reduce(
                dataWithMay,
                function (memo, item) {
                    return memo + item['tb_covid_total'];
                },
                0
            );

            this.WellsDataAll = this.WellsData(dataWithMay);
            this.injectionWells = this.getSummaryWells(dataWithMay,this.wellStockIdleButtons.isInjectionIdleButtonActive,'injectionFonds')
            this.innerWellsChartData = this.getSummaryInjectionWellsForChart(dataWithMay);
            this.productionWells = this.getSummaryWells(dataWithMay, this.wellStockIdleButtons.isProductionIdleButtonActive,'productionFonds');
            this.innerWells2ChartData = this.getSummaryProductionWellsForChart(dataWithMay);
            this.otmData = this.getOtmData(dataWithMay)
            this.otmChartData = this.getOtmChartData(dataWithMay)
            this.chemistryData = this.getChemistryData(dataWithMay)
            this.chemistryChartData = this.getChemistryChartData(dataWithMay)

            if (start === end) {
                let dataWithMay2 = new Array();
                dataWithMay2 = _.filter(arrdata, function (item) {
                    return _.every([
                        _.inRange(
                            item.__time,
                            timestampToday - 2 * 86400000,
                            timestampToday + 86400000
                        ),
                    ]);
                });

                let dataWithMay3 = _.orderBy(
                    dataWithMay2,
                    ["__time"],
                    ["asc"]
                );

                this.dzoCompaniesSummaryForChart = this.getProductionForChart(dataWithMay3);
            } else {

                this.dzoCompaniesSummaryForChart = this.getProductionForChart(dataWithMay);
            }

            this.getProductionPercentWells(arrdata);
            this.exportDzoCompaniesSummaryForChart();

            let accident = this.filterDzoInputForSeparateCompany(dataWithMay, this.company);

            let summForTables = _(accident)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzo: id,
                    opec: _.sumBy(dzo, 'opec2'),
                    impulses: _.sumBy(dzo, 'impulses'),
                    landing: _.sumBy(dzo, 'landing'),
                    accident: _.sumBy(dzo, 'accident'),
                    restrictions: _.sumBy(dzo, 'restrictions'),
                    otheraccidents: _.sumBy(dzo, 'otheraccidents'),
                    productionFactForMonth: _.round(_.sumBy(dzo, factFieldName), 0),
                    productionPlanForMonth: _.round(_.sumBy(dzo, planFieldName), 0),
                }))
                .value();

            if ((summForTables['0']['productionFactForMonth'] + summForTables['0']['productionPlanForMonth']) === 0) {
                this.noData = "Данных нет";
                this.company = "all";
                this.updateProductionData(planFieldName, factFieldName, chartHeadName, metricName, chartSecondaryName);
            } else {
                this.noData = "";
            }
            this.tables = summForTables;
        },

        processDataForAllCompanies(data, timestampToday, timestampEnd, start, end, planFieldName, factFieldName, chartSecondaryName) {
            var dzo = [];
            var factYear = [];
            var planYear = [];

            var dataWithMay = new Array();

            dataWithMay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        timestampToday,
                        timestampEnd
                    ),
                ]);
            });

            dataWithMay = _.orderBy(
                dataWithMay,
                ["__time"],
                ["asc"]
            );

            if (start === end) {
                let dataWithMay2 = new Array();
                dataWithMay2 = _.filter(data, function (item) {
                    return _.every([
                        _.inRange(
                            item.__time,
                            timestampToday - 2 * 86400000,
                            timestampToday + 86400000
                        ),
                    ]);
                });

                dataWithMay2 = _.orderBy(
                    dataWithMay2,
                    ["__time"],
                    ["asc"]
                );

                this.dzoCompaniesSummaryForChart = this.getProductionForChart(dataWithMay2);
            } else {
                this.dzoCompaniesSummaryForChart = this.getProductionForChart(dataWithMay);
            }

            let productionPlanAndFactMonth = this.getProductionPlanAndFactForMonth(dataWithMay, planFieldName, factFieldName);

            this.WellsDataAll = this.WellsData(dataWithMay);
            this.injectionWells = this.getSummaryWells(dataWithMay,this.wellStockIdleButtons.isInjectionIdleButtonActive,'injectionFonds');
            this.innerWellsChartData = this.getSummaryInjectionWellsForChart(dataWithMay);
            this.productionWells = this.getSummaryWells(dataWithMay, this.wellStockIdleButtons.isProductionIdleButtonActive,'productionFonds');
            this.innerWells2ChartData = this.getSummaryProductionWellsForChart(dataWithMay);
            this.otmData = this.getOtmData(dataWithMay)
            this.otmChartData = this.getOtmChartData(dataWithMay)
            this.chemistryData = this.getChemistryData(dataWithMay)
            this.chemistryChartData = this.getChemistryChartData(dataWithMay)

            var dzo2 = [];
            var planMonth = [];
            var factMonth = [];
            var oil_fact = [];
            var oil_plan = [];

            var e = [];
            var f = [];
            var p = [];
            var getMonthBigTable = [];


            _.forEach(dataWithMay, function (item) {
                e = {dzo2: item.dzo};
                f = {factMonth: Math.ceil(item[factFieldName])};
                p = {planMonth: Math.ceil(item[planFieldName])};
                oil_fact = {oil_fact: item.oil_fact};
                oil_plan = {oil_plan: item.oil_plan};
                getMonthBigTable.push([e, f, p, oil_fact, oil_plan]);
            });

            var factMonth = _.reduce(
                factMonth,
                function (memo, item) {
                    return memo + item.productionFact;
                },
                0
            );

            var planMonth = _.reduce(
                planMonth,
                function (memo, item) {
                    return memo + item[planFieldName];
                },
                0
            );

            var dataDay = [];


            dataDay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        timestampEnd - 86400000,
                        timestampEnd
                    ),
                ]);
            });

            dataDay = _.orderBy(dataDay, ["dzo"], ["desc"]);


            var dzoDay = [];
            var factDay = [];
            var planDay = [];
            var inj_wells_idle = [];
            var inj_wells_work = [];
            var prod_wells_work = [];
            var prod_wells_idle = [];
            var starts_krs = [];
            var starts_prs = [];
            var starts_drl = [];
            var NameDzoFull = this.NameDzoFull;
            var dzoBriefly = [];
            var dzoPercent = [];
            var productionFactPercent = [];
            var dataDayLast = [];


            _.forEach(dataDay, function (item) {


                dzoBriefly.push({dzoBriefly: item.dzo});
                e = {dzoDay: name};
                f = {factDay: Math.ceil(item[factFieldName])};
                p = {planDay: Math.ceil(item[planFieldName])};

                dzoDay.push(e);
                factDay.push(f);
                planDay.push(p);
            });

            this.getProductionPercentWells(data);


            var dzoMonth = [];
            var factMonth = [];
            var planMonth = [];


            if (this.dzoCompaniesAssets['isOperating']) {
                productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({dzo: "ТШО"}));
                productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({dzo: "НКО"}));
                productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({dzo: "КПО"}));
                productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({dzo: "ТП"}));
                productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({dzo: "ПКК"}));
                productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({dzo: "ПКИ"}));

                data = _.reject(data, _.iteratee({dzo: "ТШО"}));
                data = _.reject(data, _.iteratee({dzo: "НКО"}));
                data = _.reject(data, _.iteratee({dzo: "КПО"}));
                data = _.reject(data, _.iteratee({dzo: "ТП"}));
                data = _.reject(data, _.iteratee({dzo: "ПКК"}));
                data = _.reject(data, _.iteratee({dzo: "ПКИ"}));


            }

            if (this.dzoCompaniesAssets['isNonOperating']) {

                let dzoToShow = [
                    "ТОО «Тенгизшевройл»",
                    "«Карачаганак Петролеум Оперейтинг б.в.»",
                    "«Норт Каспиан Оперейтинг Компани н.в.»"
                ]

                productionPlanAndFactMonth = productionPlanAndFactMonth.filter(item => {
                    let fullName = this.getNameDzoFull(item.dzo)
                    return dzoToShow.indexOf(fullName) > -1
                })

                data = dataWithMay.filter(item => {
                    let fullName = this.getNameDzoFull(item.dzo)
                    return dzoToShow.indexOf(fullName) > -1
                })

            }

            if (this.dzoCompaniesAssets['isRegion']) {
                let self = this;
                productionPlanAndFactMonth = _.filter(productionPlanAndFactMonth, function(row) {
                    return self.selectedDzoCompanies.includes(row.dzo);
                });
                data = _.filter(data, function(row) {
                    return self.selectedDzoCompanies.includes(row.dzo);
                });
            }

            if (this.isKmgParticipationFilterActive) {
                productionPlanAndFactMonth = this.calculateKmgParticipationFilter(productionPlanAndFactMonth,
                    'dzo','productionFactForChart',
                    'productionPlanForChart');
            }

            let opec = [];
            let impulses = [];
            let landing = [];
            let accident = [];
            let restrictions = [];
            let otheraccidents = [];

            _.forEach(productionPlanAndFactMonth, function (item) {
                factMonth.push({factMonth: item.productionFactForChart});
                planMonth.push({planMonth: item.productionPlanForChart});
                dzoMonth.push({dzoMonth: item.dzo});
                opec.push({opec: item.opec});
                impulses.push({impulses: item.impulses});
                landing.push({landing: item.landing})
                accident.push({accident: item.accident});
                restrictions.push({restrictions: item.restrictions});
                otheraccidents.push({otheraccidents: item.otheraccidents});
            });

            var factYearSumm = _.reduce(
                factYear,
                function (memo, item) {
                    return memo + item.factYear;
                },
                0
            );

            var planYearSumm = _.reduce(
                planYear,
                function (memo, item) {
                    return memo + item.planYear;
                },
                0
            );

            var planMonthSumm = _.reduce(
                planMonth,
                function (memo, item) {
                    return memo + item.planMonth;
                },
                0
            );

            var factMonthSumm = _.reduce(
                factMonth,
                function (memo, item) {
                    return memo + item.factMonth;
                },
                0
            );

            var factDaySumm = _.reduce(
                factDay,
                function (memo, item) {
                    return memo + item.factDay;
                },
                0
            );

            var planDaySumm = _.reduce(
                planDay,
                function (memo, item) {
                    return memo + item.planDay;
                },
                0
            );

            this.factYearSumm = factYearSumm;
            this.planYearSumm = planYearSumm;
            this.planMonthSumm = planMonthSumm;
            this.factMonthSumm = factMonthSumm;
            this.factDaySumm = factDaySumm;
            this.planDaySumm = planDaySumm;


            this.personalFact = _.reduce(
                dataDay,
                function (memo, item) {
                    return memo + item['tb_personal_fact'];
                },
                0
            );

            this.getProductionPercentCovid(data);
            this.covid = _.reduce(
                dataDay,
                function (memo, item) {
                    return memo + item['tb_covid_total'];
                },
                0
            );

            var bigTable = _.zipWith(
                opec,
                impulses,
                landing,
                accident,
                restrictions,
                otheraccidents,
                productionFactPercent,
                dzoPercent,
                dzoMonth,
                dzo,
                dzo2,
                planMonth,
                factMonth,
                (opec,
                 impulses,
                 landing,
                 accident,
                 restrictions,
                 otheraccidents,
                 productionFactPercent,
                 dzoPercent,
                 dzoMonth,
                 dzo,
                 dzo2,
                 planMonth,
                 factMonth,
                ) =>
                    _.defaults(
                        opec,
                        impulses,
                        landing,
                        accident,
                        restrictions,
                        otheraccidents,
                        productionFactPercent,
                        dzoPercent,
                        dzoMonth,
                        dzo,
                        dzo2,
                        planMonth,
                        factMonth,
                    )
            );


            let tmpArrayToSort = [
                'АО "Озенмунайгаз"',
                'АО "Эмбамунайгаз"',
                'АО "Каражанбасмунай"',
                'ТОО "Казгермунай"',
                'АО ПетроКазахстан Инк',
                'АО ПетроКазахстан Кумколь Ресорсиз',
                '"ПетроКазахстан Инк."',
                'АО "Тургай-Петролеум"',
                '"Амангельды Газ"',
                "ТОО «Тенгизшевройл»",
                'АО "Мангистаумунайгаз"',
                'ТОО "Казахойл Актобе"',
                'ТОО "Казахтуркмунай"',
                "«Карачаганак Петролеум Оперейтинг б.в.»",
                "«Норт Каспиан Оперейтинг Компани н.в.»",
                'Урихтау Оперейтинг',
            ]

            bigTable = _.orderBy(
                bigTable,
                ["dzoMonth"],
                ["asc"]
            );

            this.addOpecToDzoSummary(dataWithMay, bigTable)

            bigTable
                .sort((a, b) => {
                    return tmpArrayToSort.indexOf(this.getNameDzoFull(a.dzoMonth)) > tmpArrayToSort.indexOf(this.getNameDzoFull(b.dzoMonth)) ? 1 : -1
                });

            this.bigTable = bigTable.filter(row => row.factMonth > 0 || row.planMonth > 0)
            this.clearNullAccidentCases();
            this.exportDzoCompaniesSummaryForChart();

            return data;
        },

        addPeriodPlanData(mainTableData, opecDzoName, opecDzoPeriodPlan) {
            _.forEach(mainTableData, function (parentDzo) {
                if (parentDzo.dzoMonth === opecDzoName) {
                    parentDzo.periodPlan = opecDzoPeriodPlan;
                }
            });
        },

        getProductionPlanAndFactForMonth(inputData, productionPlan, productionFact) {
            let productionData = _(inputData)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzo: id,
                    opec: _.sumBy(dzo, 'opec2'),
                    impulses: _.sumBy(dzo, 'impulses'),
                    landing: _.sumBy(dzo, 'landing'),
                    accident: _.sumBy(dzo, 'accident'),
                    restrictions: _.sumBy(dzo, 'restrictions'),
                    otheraccidents: _.sumBy(dzo, 'otheraccidents'),
                    productionFactForChart: _.round(_.sumBy(dzo, productionFact), 0),
                    productionPlanForChart: _.round(_.sumBy(dzo, productionPlan), 0),
                }))
                .value();

            return _.orderBy(
                productionData,
                ["dzo"],
                ["desc"]
            );
        },

        clearNullAccidentCases() {
            _.forEach(this.bigTable, function (item) {
                if (item.accident && typeof (item.accident) !== 'number') {
                    item.accident = item.accident.toString().replace(/null/g, '');
                }
                if (item.restrictions && typeof (item.restrictions) !== 'number') {
                    item.restrictions = item.restrictions.toString().replace(/null/g, '');
                }
            })
        },

        getProductionForChart(data) {
            let summary = data.filter(row => this.selectedDzoCompanies.includes(row.dzo));
            if (summary.length === 0) {
                summary = data;
            }

            let summaryForChart = _(summary)
                .groupBy("__time")
                .map((__time, id) => ({
                    time: id,
                    dzo: 'dzo',
                    productionFactForChart: _.round(_.sumBy(__time, this.factFieldName), 0),
                    productionPlanForChart: _.round(_.sumBy(__time, this.planFieldName), 0),
                    productionPlanForChart2: _.round(_.sumBy(__time, this.opecFieldNameForChart), 0),
                }))
                .value();

            let summaryFact = this.getDzoFactSummary(summaryForChart);
            let dailyPlan = this.getDzoDailyPlan(summaryFact);

            _.forEach(summaryForChart, function (row) {
                _.set(row, 'dailyPlan', parseInt(dailyPlan));
            });

            return summaryForChart;
        },

        getDzoDailyPlan(summaryFact) {
            let filteredDzoYearlyPlan = this.getFilteredDzoYearlyPlan();
            let dzoYearlyPlanSum = _.sumBy(filteredDzoYearlyPlan,this.planFieldName);
            let dzoPlanFactDifference = dzoYearlyPlanSum - summaryFact;
            let daysCountInYear = this.getDaysCountInYear();
            return dzoPlanFactDifference / daysCountInYear;
        },

        getAccidentTotal() {
            let year = new Date(this.range.end).getFullYear();
            let uri = this.localeUrl("/visualcenter3GetDataAccident?") + "year=" + year + " ";
            this.axios.get(uri).then((response) => {
                let data = Array();
                data = response.data;
                let accidentTotal = [];
                if (data) {
                    _.forEach(data, function (item) {
                        accidentTotal.push(item.tb_accident_total);
                    });
                    this.accidentTotal = accidentTotal[0];
                } else {
                    console.log('No data Accident')
                }
            });
        },
    },
    mixins: [
        mainMenu,
        сompaniesDzo,
        helpers,
        otm,
        chemistry,
        oilRates,
        usdRates,
        injectionWells,
        productionWells,
        companyStaff,
        mainStatisticsTable,
        wells,
        rates,
        dates,
        oilProductionFilters
    ],
    async mounted() {
        this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
        this.getOpecDataForYear();
        this.chartHeadName = this.oilChartHeadName;

        if (window.location.host === 'dashboard') {
            this.range = {
                start: moment().startOf('day').subtract(1, "days").format(),
                end: moment().endOf('day').subtract(1, "days").format(),
                formatInput: true,
            };
        } else {
            this.range = {
                start: moment().startOf('day').subtract(1, "days").format(),
                end: moment().endOf('day').subtract(1, "days").format(),
                formatInput: true,
            };
        }
        localStorage.setItem("changeButton", "Yes");
        var nowDate = new Date().toLocaleDateString();
        this.timeSelect = nowDate;
        this.timestampToday = new Date(this.range.start).getTime();
        this.timestampEnd = new Date(this.range.end).getTime();

        this.selectedYear = this.year;

        localStorage.setItem("selectedPeriod", "undefined");
        this.getCurrencyNow(this.timeSelect);
        this.updatePrices(this.period);

        this.changeAssets('isAllAssets');
        this.changeDate();
        this.changeMenu2();
        this.getStaff();

        this.buttonDailyTab = "button-daily-tab";
        this.getAccidentTotal();
        this.mainMenuButtonElementOptions = _.cloneDeep(mainMenuConfiguration);
        this.getDzoYearlyPlan();
        this.selectedDzoCompanies = this.getAllDzoCompanies();
    },
    watch: {
        bigTable: function () {
            this.dzoCompanySummary = this.bigTable;
            this.calculateDzoCompaniesSummary();
        },
    },
    computed: {
        ...dzoMapState([
            'yearlyPlan'
        ]),
        exactDateSelected() {
            return ((this.factFieldName === 'oil_fact' || this.factFieldName === 'oil_div_fact') && this.oneDate === 1);
        },
    },
};
