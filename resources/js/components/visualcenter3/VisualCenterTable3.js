import {EventBus} from "../../event-bus.js";
import moment from "moment";
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import {isString} from "lodash";
import dzoCompaniesInitial from './dzo_companies_initial.json';
import mainMenuConfiguration from './main_menu_configuration.json';

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
            WellsDataAll: '',
            accidentTotal: '',
            noData: '',
            tdStyle: "index % 2 === 0 ? 'tdStyle' : 'tdNone'",
            tdStyleLight: "index % 2 === 0 ? 'tdStyleLight' : 'tdStyleLight2'",
            opecDataSummMonth: 0,
            opecDataSumm: 0,
            opecData: 0,
            scroll: '',
            opec: 'утв.',
            quarter1: 0,
            quarter2: 0,
            oneDate: '',
            lastDate1: 0,
            lastDate2: 0,
            timeSelectOld: '',
            thousand: 'тыс.',
            staffPercent: 0,
            staff: 0,
            flagOn: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.4791 0.469238H2.31923C1.20141 0.469238 0.297516 1.38392 0.297516 2.50136L0.287109 18.7576L7.39917 15.7094L14.5112 18.7576V2.50136C14.5112 1.38392 13.5969 0.469238 12.4791 0.469238Z" fill="#2E50E9"/>' +
                '</svg>',
            flagOff: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg"> \n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.8448 0.286987H2.68496C1.56713 0.286987 0.663191 1.20167 0.663191 2.31911L0.652832 18.5754L7.76489 15.5272L14.877 18.5754V2.31911C14.877 1.20167 13.9627 0.286987 12.8448 0.286987Z" fill="#656A8A"/>' +
                '</svg>',
            inj_wells_idlePercent: 0,
            inj_wells_workPercent: 0,
            prod_wells_workPercent: 0,
            prod_wells_idlePercent: 0,
            personalFact: '',
            covidPercent: '',
            covid: '',
            usdRatesData: {
                for_chart: [],
                for_table: []
            },
            oilRatesData: {
                for_chart: [],
                for_table: []
            },
            chartSecondaryName: this.trans('visualcenter.getoil'),
            // 'Добыча нефти',
            oilChartHeadName: this.trans('visualcenter.getoildynamic'),
            // 'Динамика добычи нефти',
            injectionWells: [
                {name: "ЭФ", value: 603, value2: 101},
                {name: "ДФ", value: 98, value2: 56},
                {name: "В работе добывающие скважины", value: 45, value2: 31},
                {name: "БД", value: 121, value2: 108},
                {name: "Освоение", value: 143, value2: 114},
                {name: "ОФЛС", value: 98, value2: 36},
                {name: "Простой добывающих скважин", value: 86, value2: 54}
            ],
            productionWells: '',
            innerWells2SelectedRow: 'fond_neftedob_ef',
            innerWells2ChartData: [],
            innerWellsSelectedRow: 'fond_nagnetat_ef',
            innerWellsChartData: [],
            otmData: [],
            otmSelectedRow: 'otm_iz_burenia_skv_fact',
            otmChartData: [],
            chemistryData: [],
            chemistrySelectedRow: 'chem_prod_zakacka_demulg_fact',
            chemistryChartData: [],
            prod_wells_work: 0,
            prod_wells_idle: 0,
            inj_wells_idle: 0,
            inj_wells_work: 0,
            productionFactPercentOneDzo: '',
            productionFactPercentSumm: '',
            quantityRange: '',
            productionFactPersent: '',
            productionPlanPersent: '',
            quantityGetProductionOilandGas: "",
            /*calendar*/
            range: {
                /* start: "2020-12-18T06:00:00+06:00",
                 end: "2020-12-18T09:00:00+06:00",*/
            },
            modelConfig: {
                start: {
                    timeAdjust: '00:00:00',
                    type: 'string',
                    mask: 'YYYY-MM-DDTHH:mm:ssXXX',
                },
                end: {
                    timeAdjust: '23:59:00',
                    type: 'string',
                    mask: 'YYYY-MM-DDTHH:mm:ssXXX',
                },
            },
            /*calendar*/
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
            selectedDate: "",
            tableHover1: "",
            tableHover2: "",
            tableHover3: "",
            tableHover4: "",
            tableHover5: "",
            tableHover6: "",
            Table1: "display:block;",
            Table2: "display:none;",
            Table3: "display:none;",
            Table4: "display:none;",
            Table5: "display:none;",
            Table6: "display:none;",
            Table7: "display:none;",
            //oil and currency down
            currencyNow: "",
            currencyChartData: "",
            currencyNowUsd: "",
            selectedUsdPeriod: 0,
            selectedDMY: 0,
            periodSelectOil: "",
            oilPeriod: 7,
            usdPeriod: 7,
            defaultOilPeriod: 7,
            period: 0,
            timeSelect: "",
            prices: {
                'oil': {},
                'usd': {}
            },
            oilChart: "",
            //oil and currency up
            index: "",
            widthProgress: "90",
            DMY: this.trans("visualcenter.day"),
            planFieldName: "oil_plan",
            factFieldName: "oil_fact",
            chartHeadName: this.trans("visualcenter.getoil"),
            metricName: this.trans("visualcenter.chemistryMetricTon"),
            tables: "",
            showTable2: "Yes",
            displayChart: "display: none;",
            showTableOn: "",
            buttonNormalTab: "",
            highlightedButton: "button-tab-highlighted",
            oilProductionButton: "",
            oilDeliveryButton: "",
            gasProductionButton: "",
            condensateProductionButton: "",
            waterInjectionButton: "",
            buttonDailyTab: "button-tab-highlighted",
            buttonMonthlyTab: "",
            buttonYearlyTab: "",
            buttonPeriodTab: "",
            buttonHoverProdInnerWells: "",

            tableHover7: "",
            tableHover8: "",
            tableHover9: "",
            tableHover10: "",
            tableHover11: "",
            tableHover12: "",

            month: new Date().getMonth() + 1,
            year: new Date().getFullYear(),
            currentMonth: [],
            ChartTable: "График",
            date2: new Date().toLocaleString("ru", {
                hour: "numeric",
                minute: "numeric",
            }),

            date3: new Date().toLocaleString("ru", {
                weekday: "long",
            }),
            dFirstMonth: "0",
            day: ["Mn", "Tu", "We", "Th", "Fr", "Sa", "Su"],
            monthes: [
                "ЯНВАРЬ",
                "ФЕВРАЛЬ",
                "МАРТ",
                "АПРЕЛЬ",
                "МАЙ",
                "ИЮНЬ",
                "ИЮЛЬ",
                "АВГУСТ",
                "СЕНТЯБРЬ",
                "ОКТЯБРЬ",
                "НОЯБРЬ",
                "ДЕКАБРЬ",
            ],
            monthes3: [
                "",
                "январь",
                "февраль",
                "март",
                "апрель",
                "май",
                "июнь",
                "июль",
                "август",
                "сентябрь",
                "октябрь",
                "ноябрь",
                "декабрь",
            ],
            monthes2: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],

            NameDzoFull: {
                0: "Всего добыча нефти с учётом доли участия АО НК КазМунайГаз",
                1: "(конденсат)(100%)",
                2: "в т.ч.:газовый конденсат",
                3: 'АО ПетроКазахстан Инк',
                'ОМГ': this.trans("visualcenter.omg"),
                // 'АО "Озенмунайгаз"'
                'ЭМГ': this.trans("visualcenter.emg"),
                // 'АО "Эмбамунайгаз"',
                'КБМ': this.trans("visualcenter.kbm"),
                // 'АО "Каражанбасмунай"',
                'КГМ': this.trans("visualcenter.kgm"),
                // 'ТОО "Казгермунай"',
                'ТШ': this.trans("visualcenter.tsho"),
                // "ТОО «Тенгизшевройл»",
                'ТШО': this.trans("visualcenter.tsho"),
                // "ТОО «Тенгизшевройл»",
                'ММГ': this.trans("visualcenter.mmg"),
                // 'АО "Мангистаумунайгаз"',
                'КТМ': this.trans("visualcenter.ktm"),
                // 'ТОО "Казахтуркмунай"',
                'КОА': this.trans("visualcenter.koa"),
                // 'ТОО "Казахойл Актобе"',
                'ПКИ': this.trans("visualcenter.pki"),
                // '"ПетроКазахстан Инк."',
                'АМГ': this.trans("visualcenter.ag"),
                // '"Амангельды Газ"',
                'АГ': this.trans("visualcenter.ag"),
                // '"Амангельды Газ"',
                'КПО': this.trans("visualcenter.kpo"),
                // "«Карачаганак Петролеум Оперейтинг б.в.»",
                'НКО': this.trans("visualcenter.nko"),
                // "«Норт Каспиан Оперейтинг Компани н.в.»",
                'ТП': this.trans("visualcenter.tp"),
                // 'АО "Тургай-Петролеум"',
                'УО': this.trans("visualcenter.uo"),
                // 'Урихтау Оперейтинг',
                'ПКК': this.trans("visualcenter.pkk"),
                // 'АО ПетроКазахстан Кумколь Ресорсиз',
            },
            date: new Date(),
            selectedDay: undefined,
            selectedMonth: undefined,
            selectedYear: undefined,
            selectedPeriod: 0,

            wells: [""],
            wells2: [""],
            bigTable: [],
            displayTable: "display:  none;",
            displayHeadTables: "display: block;",
            starts: [""],
            test: [""],
            series: ["", ""],
            display: "none",
            company: "all",
            factYearSumm: "",
            planYearSumm: "",
            planMonthSumm: "",
            factMonthSumm: "",
            factDaySumm: "",
            planDaySumm: "",
            timestampToday: "",
            timestampEnd: "",
            dailyCurrencyChangeUsd: 0,
            dailyCurrencyChangeIndexUsd: '',
            dailyOilPriceChange: '',
            isPricesChartLoading: false,
            currencyTimeSelect: new Date().toLocaleDateString(),
            currentDzoList: 'daily',
            dzoColumns: {
                daily: ['companyName', 'plan', 'fact', 'difference', 'percent'],
                monthly: ['companyName', 'monthlyPlan', 'plan', 'fact', 'difference', 'percent'],
                yearly: ['companyName', 'yearlyPlan', 'plan', 'fact', 'difference', 'percent'],
            },
            dzoCompanies: dzoCompaniesInitial,
            buttonDzoDropdown: "",
            dzoCompanySummary: this.bigTable,
            dzoCompaniesSummaryInitial: {
                plan: 0,
                periodPlan: 0,
                fact: 0,
                difference: 0,
                percent: 0,
            },
            dzoCompaniesSummary: {},
            isDzoCompaniesListSelectorOpened: false,
            isMultipleDzoCompaniesSelected: true,
            dzoCompaniesSummaryForChart: {},
            mainMenuButtonHighlighted: "color: #fff;background: #237deb;font-weight:bold;",
            mainMenuButtonElementOptions: {},
            categoryMenuPreviousParent: '',
            dzoCompaniesAssetsInitial: {
                isAllAssets: true,
                isOperating: false,
                isNonOperating: false,
                isOpecRestriction: false,
                assetTitle: this.trans("visualcenter.summaryAssets"),
            },
            dzoCompaniesAssets: {},
            selectedDzoCompanies: [],
            assetTitleMapping: {
                isOperating: this.trans("visualcenter.summaryOperatingAssets"),
                isNonOperating: this.trans("visualcenter.summaryNonOperatingAssets"),
                isAllAssets: this.trans("visualcenter.summaryAssets"),
            },
            kmgParticipationPercent: {
                'АО "Каражанбасмунай"': 0.5,
                'ТОО "Казгермунай"': 0.5,
                'АО ПетроКазахстан Кумколь Ресорсиз': 0.33,
                'ПетроКазахстан Инк.': 0.33,
                'АО "Тургай-Петролеум"': 0.5 * 0.33,
                "ТОО «Тенгизшевройл»": 0.2,
                'АО "Мангистаумунайгаз"': 0.5,
                'ТОО "Казахойл Актобе"': 0.5,
                "«Карачаганак Петролеум Оперейтинг б.в.»": 0.1,
                "«Норт Каспиан Оперейтинг Компани н.в.»": 0.1688
            },
            isOpecFilterActive: false,
            isKmgParticipationFilterActive: false,
            wellStockIdleButtons: {
                isProductionIdleButtonActive: false,
                isInjectionIdleButtonActive: false,
            },
            fondNamesByDBFields: {
                'fond_neftedob_df': 'operatingFond',
                'fond_neftedob_bd': 'nonOperatingFond',
                'fond_neftedob_osvoenie': 'masteringFond',
                'fond_neftedob_ofls': 'liquidationFond',
                'fond_neftedob_konv': 'conservationFond',
                'fond_neftedob_prs': 'undergroundRepairFond',
                'fond_neftedob_oprs': 'waitingUndergroundRepairFond',
                'fond_neftedob_krs': 'overhaulFond',
                'fond_neftedob_okrs': 'waitingOverhaulFond',
                'fond_neftedob_well_survey': 'researchFond',
                'fond_neftedob_others': 'othersFond',
                'fond_neftedob_ef': 'exploitationFond',
                'fond_nagnetat_df': 'operatingFond',
                'fond_nagnetat_bd': 'nonOperatingFond',
                'fond_nagnetat_osvoenie': 'masteringFond',
                'fond_nagnetat_ofls': 'liquidationFond',
                'fond_nagnetat_konv': 'conservationFond',
                'fond_nagnetat_prs': 'undergroundRepairFond',
                'fond_nagnetat_oprs': 'waitingUndergroundRepairFond',
                'fond_nagnetat_krs': 'overhaulFond',
                'fond_nagnetat_okrs': 'waitingOverhaulFond',
                'fond_nagnetat_well_survey': 'researchFond',
                'fond_nagnetat_others': 'othersFond',
                'fond_nagnetat_ef': 'exploitationFond',
            },
            productionFonds: [
                'fond_neftedob_ef',
                'fond_neftedob_df',
                'fond_neftedob_bd',
                'fond_neftedob_osvoenie',
                'fond_neftedob_ofls',
                'fond_neftedob_prs',
                'fond_neftedob_oprs',
                'fond_neftedob_krs',
                'fond_neftedob_okrs',
                'fond_neftedob_well_survey',
                'fond_neftedob_nrs',
                'fond_neftedob_others'
            ],
            injectionFonds: [
                'fond_nagnetat_ef',
                'fond_nagnetat_df',
                'fond_nagnetat_bd',
                'fond_nagnetat_osvoenie',
                'fond_nagnetat_ofls',
                'fond_nagnetat_konv',
                'fond_nagnetat_prs',
                'fond_nagnetat_oprs',
                'fond_nagnetat_krs',
                'fond_nagnetat_okrs',
                'fond_nagnetat_well_survey',
                'fond_nagnetat_others'
            ],
            isMainMenuItemChanged: false,
            opecFieldNameForChart: '',
        };
    },
    methods: {
        switchCategory(planFieldName,factFieldName,metricName,categoryName,parentButton,childButton) {
            this.planFieldName = planFieldName;
            this.factFieldName = factFieldName;
            this.metricName = metricName;
            if (parentButton && childButton) {
                this.switchMainMenu(parentButton,childButton);
                this.changeAssets(childButton);
            } else {
                this.isMainMenuItemChanged = true;
            }
            this.changeDate();
        },

        selectAllDzoCompanies() {
            this.selectDzoCompanies();
        },

        selectDzoCompanies() {
            this.selectCompany('all');
            this.isMultipleDzoCompaniesSelected = true;
            this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);

            this.buttonDzoDropdown = "";
            _.map(this.dzoCompanies, function (company) {
                company.selected = true;
            });
            this.dzoCompanySummary = this.bigTable;
            this.calculateDzoCompaniesSummary();
        },

        calculateDzoCompaniesSummary() {
            let summary = _.cloneDeep(this.dzoCompaniesSummaryInitial);
            _.map(this.dzoCompanySummary, function (company) {
                summary.plan = parseInt(summary.plan) + parseInt(company.planMonth);
                summary.fact = parseInt(summary.fact) + parseInt(company.factMonth);
                summary.periodPlan = parseInt(summary.periodPlan) + parseInt(company.periodPlan);
            });
            summary.difference = this.formatDigitToThousand(
                summary.plan - summary.fact);
            summary.percent = new Intl.NumberFormat("ru-RU")
                .format(((summary.plan - summary.fact) /
                    summary.fact * 100).toFixed(1));
            summary.plan = this.formatDigitToThousand(summary.plan);
            summary.fact = this.formatDigitToThousand(summary.fact);
            summary.periodPlan = this.formatDigitToThousand(summary.periodPlan);
            this.dzoCompaniesSummary = summary;
        },

        selectOneDzoCompany(companyTicker) {
            this.disableDzoCompaniesVisibility();
            this.selectDzoCompany(companyTicker);
        },

        disableDzoCompaniesVisibility() {
            _.forEach(this.dzoCompanies, function (dzo) {
                _.set(dzo, 'selected', false);
            });
        },

        selectDzoCompany(companyTicker) {
            this.selectCompany(companyTicker);
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.buttonDzoDropdown = this.highlightedButton;
            _.map(this.dzoCompanies, function (company) {
                if (company.ticker === companyTicker) {
                    company.selected = !company.selected;
                }
            });
            let selectedCompanies = this.dzoCompanies.filter(row => row.selected === true).map(row => row.ticker);
            this.dzoCompanySummary = this.bigTable.filter(row => selectedCompanies.includes(row.dzoMonth));
            this.isMultipleDzoCompaniesSelected = this.dzoCompanySummary.length > 1;
            this.calculateDzoCompaniesSummary();
        },

        getDzoColumnsClass(rowIndex, columnName) {
            if (this.getColumnIndex(columnName) % 2 === 0) {
                return this.getDarkColorClass(rowIndex);
            } else {
                return this.getLightColorClass(rowIndex);
            }
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

        selectCompany(com) {
            this.company = com;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.nameLeftChart);
        },
        changeTable(change) {
            this.company = "all";
            this.Table1 = "display:none";
            this.Table2 = "display:none";
            this.Table3 = "display:none";
            this.Table4 = "display:none";
            this.Table5 = "display:none";
            this.Table6 = "display:none";
            this.Table7 = "display:none";

            this.tableHover1 = "";
            this.tableHover2 = "";
            this.tableHover3 = "";
            this.tableHover4 = "";
            this.tableHover5 = "";
            this.tableHover6 = "";
            this.tableHover7 = "";
            var buttonHover2 = " background: #0d2792";

            if (change == "1") {
                this.Table1 = "display:block";
                this.tableHover1 = buttonHover2;
                this.changeMenu2(1);
            } else if (change == "2") {
                this.Table2 = "display:block";
                this.tableHover2 = buttonHover2;
            } else if (change == "3") {
                this.Table3 = "display:block";
                this.tableHover3 = buttonHover2;
            } else if (change == "4") {
                this.Table4 = "display:block";
                this.tableHover4 = buttonHover2;
            } else if (change == "5") {
                this.Table5 = "display:block";
                this.tableHover5 = buttonHover2;
            } else if (change == "6") {
                this.Table6 = "display:block";
                this.tableHover6 = buttonHover2;
            } else if (change == "7") {
                this.Table7 = "display:block";
                this.tableHover7 = buttonHover2;

                this.range = {
                    start: this.ISODateString(new Date('2020-08-01T06:00:00+06:00')),
                    end: this.ISODateString(new Date('2020-08-31T06:00:00+06:00')),
                    formatInput: true,
                };
                this.changeDate();
            }
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.nameLeftChart);
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

        disableMainMenuFlags(menuCategory) {
            if (!menuCategory.childItems) {
                return;
            }
            _.forEach(Object.keys(menuCategory.childItems), function (childButton) {
                menuCategory.childItems[childButton]['flag'] = 'flagOff';
                menuCategory.childItems[childButton]['button'] = '';
            });
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

        getMainMenuButtonFlag(parentButton, childButton) {
            if (!this.mainMenuButtonElementOptions[parentButton]) {
                return this.flagOff;
            }
            let buttonOptions = this.mainMenuButtonElementOptions[parentButton].childItems[childButton];
            return this[buttonOptions.flag];
        },

        dayClicked() {
            this.changeMenu2('4');
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

        changeMenu2(change) {
            if (change === 1) {
                this.currentDzoList = 'daily';
                this.buttonDailyTab = this.highlightedButton;
                this.range = {
                    start: moment().startOf('day').subtract(1, "days").format(),
                    end: moment().endOf('day').subtract(1, "days").format(),
                    formatInput: true,
                };
                this.changeDate();
                this.calculateDzoCompaniesSummary();
            } else {
                this.buttonDailyTab = "";
            }

            if (change === 2) {
                this.buttonMonthlyTab = this.highlightedButton;
                this.currentDzoList = 'monthly';
                let periodStart = moment().startOf('month').format();
                let periodEnd = moment().subtract(1, "days").endOf('day').format();
                if (periodStart > periodEnd) {
                    periodStart = this.getPreviousWorkday();
                }
                this.range = {
                    start: periodStart,
                    end: periodEnd,
                    formatInput: true,
                };

                this.changeDate();
            } else {
                this.buttonMonthlyTab = "";
            }

            if (change === 3) {
                this.buttonYearlyTab = this.highlightedButton;
                this.currentDzoList = 'yearly';
                this.range = {
                    start: moment().startOf('year').format(),
                    end: moment().endOf('day').format(),
                    formatInput: true,
                };
                this.changeDate();
            } else {
                this.buttonYearlyTab = "";
            }

            if (change === 4) {
                this.buttonPeriodTab = this.highlightedButton;
            } else {
                this.buttonPeriodTab = "";
            }
        },

        changeAssets(type) {
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
                _.map(this.dzoCompanies, function (company) {
                    company.selected = false;
                });
                this.selectedDzoCompanies = this.getSelectedDzoCompanies(type);
            }
        },

        getSelectedDzoCompanies(type) {
            return _.cloneDeep(dzoCompaniesInitial).filter(company => company.type === type).map(company => company.ticker);
        },

        periodSelect() {
            if (this.period === 0) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(7, 'days'), 'days') + 1;
            }
            if (this.period === 1) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(1, 'months'), 'days') + 1;
            }
            if (this.period === 2) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(3, 'months'), 'days') + 1;
            }
            if (this.period === 3) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(1, 'years'), 'days') + 1;
            }
            if (this.period === 4) {
                return null;
            }
        },

        getCurrencyNow(dates) {


            let uri = this.localeUrl("/getcurrency?fdate=") + dates + "";

            this.axios.get(uri).then((response) => {
                let data = response.data;


                if (data) {
                    this.currencyNow = parseInt(data.description * 10) / 10;
                    this.currencyNowUsd = parseInt(data.description * 10) / 10;
                    this.dailyCurrencyChangeUsd = Math.abs(parseFloat(data.change));
                    this.dailyCurrencyChangeIndexUsd = data.index;
                } else {
                    console.log("No data");
                }
            });
        },

        updateCurrentOilPrices(period) {
            this.isPricesChartLoading = true;
            this.oilPeriod = period;
            this.usdPeriod = period;
            let uri = this.localeUrl("/get-oil-rates");
            this.setDataAndChart(uri, 'oil');
            this.isPricesChartLoading = false;
        },

        setDataAndChart(uri, type) {
            let ratesData;
            this.axios.get(uri).then((response) => {
                let data = response.data;
                if (!data) {
                    console.log("No data");
                    return;
                }
                ratesData = this.getRatesData(data, ratesData);
                this.setQuotes(type, ratesData.for_chart);
                if (type === 'oil') {
                    this.setOilPlacements(ratesData);
                } else {
                    this.setUsdPlacements(ratesData);
                }
            });
        },

        getRatesData(data, ratesData) {
            ratesData = {
                for_chart: [],
                for_table: []
            };
            let previousPrice = 0.00;
            let self = this;
            _.forEach(data, function (item) {
                let changeValue = parseFloat(((item['value'] - previousPrice) / item['value']) * 100).toFixed(2);
                self.pushRatesData(item, changeValue, ratesData);
                self.pushRatesChart(item, ratesData);
                previousPrice = parseFloat(item['value']);
            });
            return ratesData;
        },

        pushRatesData(item, changeValue, ratesData) {
            ratesData.for_table.push({
                date_string: this.$moment(item['date']).format('DD.MM.YYYY'),
                value: parseFloat(item['value']),
                change: Math.abs(changeValue),
                index: changeValue > 0 ? 'UP' : 'DOWN'
            });
        },

        pushRatesChart(item, ratesData) {
            ratesData.for_chart.push([
                new Date(item['date']).getTime(),
                parseFloat(item['value']),
            ]);
        },

        getSortedQuotesData(chartData) {
            return _.orderBy(
                chartData,
                [0],
                ["desc"]
            );
        },

        setQuotes(type, chartData) {
            let sortedData = this.getSortedQuotesData(chartData);
            this.setPrices(type, 'current', sortedData[0][1]);
            this.setPrices(type, 'previous', sortedData[1][1]);
            this.setPrices(type, 'previousFetchDate', sortedData[1][0]);
        },

        setPrices(type, pricesKey, value) {
            this.prices[type][pricesKey] = value;
        },

        setDailyOilPriceChange(currentPrice, previousPrice) {
            if (currentPrice > previousPrice) {
                this.dailyOilPriceChange = 'UP';
            } else {
                this.dailyOilPriceChange = 'DOWN';
            }
        },

        setOilPlacements(ratesData) {
            this.oilRatesData = ratesData;
            this.setDailyOilPriceChange(this.prices['oil']['current'], this.prices['oil']['previous']);
            if (this.period === 0) {
                this.oilPeriod = this.defaultOilPeriod;
            }
            this.oilRatesData.for_chart = this.oilRatesDataChartForCurrentPeriod();
        },

        setUsdPlacements(ratesData) {
            this.usdRatesData = ratesData;
            if (this.period === 0) {
                this.usdPeriod = this.defaultOilPeriod;
            }
            this.usdRatesData.for_chart = this.usdRatesDataChartForCurrentPeriod();
        },

        oilRatesDataChartForCurrentPeriod() {
            return this.oilRatesData.for_chart.slice(this.oilPeriod * -1);
        },

        usdRatesDataChartForCurrentPeriod() {
            return this.usdRatesData.for_chart.slice(this.usdPeriod * -1);
        },

        updatePrices(period) {
            this.updateCurrentUsdPrices(period);
            this.updateCurrentOilPrices(period);
        },

        updateCurrentUsdPrices(period) {
            this.isPricesChartLoading = true;
            this.usdPeriod = period;
            let uri = this.localeUrl("/get-usd-rates");
            this.setDataAndChart(uri, 'usd');
            this.isPricesChartLoading = false;
        },

        //currency and oil up
        pushBign(bign) {
            switch (bign) {
                case "bign1":
                    break;
            }
            this.$modal.show(bign);
        },
        displaynumbers: function (event) {
            return this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.nameLeftChart);
        },

        getDiffProcentLastBigN(a, b) {
            if (a != '') {
                return ((a / b) * 100).toFixed(2);
            } else {
                return 0
            }
        },

        getDiffProcentLastP(a, b, c) {
            if (c) {
                if (a > b) {
                    return this.trans("visualcenter.decrease")
                    // 'Снижение'
                } else if (a < b) {
                    return this.trans("visualcenter.rise")
                    // 'Рост'
                }
                ;
            } else {
                if (b == 0) {
                    return 0
                } else if (a == 0) {
                    return 0
                }
                {
                    if (a != '') return ((b / a - 1) * 100).toFixed(2)
                }
            }
        },

        getColor2(i) {
            if (i < 0) return "arrow";
            if (i > 0) return "arrow2";
        },


        menuDMY() {
            var DMY = ["День", "Месяц", "Год"];
            var menuDMY = [];
            var id = 0;
            for (let i = 0; i <= 2; i++) {
                var a = {index: i, id: i};
                a.DMY = DMY[i];
                menuDMY.push(a);
                if (this.selectedPeriod == i) {
                    a.current = "#1D70B7";
                    this.DMY = menuDMY[i]["DMY"];
                }
            }

            localStorage.setItem("selectedPeriod", this.selectedPeriod);
            return menuDMY;
        },
        pad(n) {
            return n < 10 ? "0" + n : n;
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
                            timestampEnd + 10// 86400000
                        ),
                    ]);
                });

                var quantityGetProductionOilandGas = Object.keys(_.filter(dataWithMay, _.iteratee({dzo: dataWithMay[0].dzo}))).length;//k1q
                this.quantityGetProductionOilandGas = quantityGetProductionOilandGas;


                //Summ plan and fact from dzo
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
                //Summ plan and fact from dzo
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

        changeOilProductionFilters() {
            if (this.isOpecFilterActive) {
                this.planFieldName = 'oil_opek_plan';
                this.opec = this.trans("visualcenter.dzoOpec");
                this.opecFieldNameForChart = 'oil_plan';
                this.chartSecondaryName = this.trans("visualcenter.getoil");
            } else {
                this.opec = this.trans("visualcenter.utv");
                this.planFieldName = 'oil_plan';
                this.dzoCompaniesAssets['isOpecRestriction'] = false;
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

            //get data by Month
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
            this.injectionWells = this.getSummaryWells(dataWithMay,this.wellStockIdleButtons.isInjectionIdleButtonActive,this.injectionFonds)
            this.innerWellsChartData = this.getSummaryInjectionWellsForChart(dataWithMay);
            this.productionWells = this.getSummaryWells(dataWithMay, this.wellStockIdleButtons.isProductionIdleButtonActive,this.productionFonds);
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
                this.updateProductionData(planFieldName, factFieldName, chartHeadName, metricName, chartSecondaryName, this.chartSecondaryName);
            } else {
                this.noData = "";
            }
            this.tables = summForTables;
        },

        calculateKmgParticipationFilter(planAndFactSummary, dzoFieldName,factFieldName,planFieldName) {
            return planAndFactSummary.map(item => {
                if (typeof this.kmgParticipationPercent[this.getNameDzoFull(item[dzoFieldName])] !== 'undefined') {
                    item[factFieldName] = item[factFieldName] * this.kmgParticipationPercent[this.getNameDzoFull(item[dzoFieldName])]
                    item[planFieldName] = item[planFieldName] * this.kmgParticipationPercent[this.getNameDzoFull(item[dzoFieldName])]
                }
                return item;
            });
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
            this.injectionWells = this.getSummaryWells(dataWithMay,this.wellStockIdleButtons.isInjectionIdleButtonActive,_.cloneDeep(this.injectionFonds));
            this.innerWellsChartData = this.getSummaryInjectionWellsForChart(dataWithMay);
            this.productionWells = this.getSummaryWells(dataWithMay, this.wellStockIdleButtons.isProductionIdleButtonActive,_.cloneDeep(this.productionFonds));
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
                        //item.dateSimple,
                        item.__time,
                        timestampEnd - 86400000,// * Number(period),
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

            //delete after paste data for dzo

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

        addOpecToDzoSummary(inputData, mainTableData) {
            let opecData = _.cloneDeep(this.opecData);
            let self = this;
            if (this.buttonMonthlyTab) {
                opecData = this.getOpecMonth(inputData);
            }

            opecData = _.orderBy(
                opecData,
                ["dzoMonth"],
                ["asc"]
            );
            _.forEach(opecData, function(dzoOpec, i) {
                let opecDzoName = dzoOpec.dzoMonth;
                let opecDzoPeriodPlan = dzoOpec.periodPlan;
                self.addPeriodPlanData(mainTableData, opecDzoName, opecDzoPeriodPlan);
            });
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

        exportDzoCompaniesSummaryForChart() {
            this.$store.commit('globalloading/SET_LOADING', false);
            this.$emit("data", {
                dzoCompaniesSummaryForChart: this.dzoCompaniesSummaryForChart,
                opec: this.opec,
            });
        },

        filterDzoInputForSeparateCompany(data, company) {
            return _.filter(data, function (item) {
                return (item.dzo === company);
            })
        },

        getProductionPercentCovid(data) {
            var timestampToday = this.timestampToday;
            var timestampEnd = this.timestampEnd;
            var quantityRange = this.quantityRange;

            var dataWithMay = new Array();
            dataWithMay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        timestampToday - quantityRange * 86400000,
                        (timestampToday - (quantityRange * 86400000)) + 86400000
                    ),
                ]);
            });


            this.covidPercent = _.reduce(
                dataWithMay,
                function (memo, item) {
                    return memo + item['tb_covid_total'];
                },
                0
            );
        },


        getProductionPercentWells(data) {
            let inj_wells_idle = [];
            let inj_wells_work = [];
            let prod_wells_work = [];
            let prod_wells_idle = [];
            let timestampToday = this.timestampToday;
            let timestampEnd = this.timestampEnd;
            let quantityRange = this.quantityRange;

            let dataWithMay = new Array();
            dataWithMay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        timestampToday - quantityRange * 86400000,
                        timestampToday
                    ),
                ]);
            });


            let productionPlanAndFactMonthWells = _(dataWithMay)
                .groupBy("data")
                .map((__time, id) => ({
                    __time: id,
                    inj_wells_idle: (_.sumBy(__time, 'inj_wells_idle')) / this.quantityRange,
                    inj_wells_work: (_.sumBy(__time, 'inj_wells_work')) / this.quantityRange,
                    prod_wells_work: (_.sumBy(__time, 'prod_wells_work')) / this.quantityRange,
                    prod_wells_idle: (_.sumBy(__time, 'prod_wells_idle')) / this.quantityRange,
                }))
                .value();

            this.inj_wells_idlePercent = productionPlanAndFactMonthWells[0]['inj_wells_idle'];
            this.inj_wells_workPercent = productionPlanAndFactMonthWells[0]['inj_wells_work'];
            this.prod_wells_workPercent = productionPlanAndFactMonthWells[0]['prod_wells_work'];
            this.prod_wells_idlePercent = productionPlanAndFactMonthWells[0]['prod_wells_idle'];
        },


        getProductionPercent(data) {
            var timestampToday = this.timestampToday;
            var timestampEnd = this.timestampEnd
            var quantityRange = this.quantityRange;


            var productionPlan = this.planFieldName;
            var productionFact = this.factFieldName;


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


            return _(dataWithMay)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzoPercent: id,
                    productionFactPercent: _.round(_.sumBy(dzo, productionFact), 0),
                    productionPlanPercent: _.round(_.sumBy(dzo, productionPlan), 0),
                }))
                .value();
        },

        changeButton(showTableItem, changeButton) {
            var a;
            if (changeButton == "Yes") {
                if (showTableItem == "Yes") {
                    a = "No";
                } else {
                    a = "Yes";
                }
                this.showTable2 = a;
                localStorage.setItem("changeButton", a);
            }
            this.showTable(localStorage.getItem("changeButton"));
        },

        showTable(showTableItem, changeButton) {
            var showTableOn =
                " border: none;" +
                "color: white;" +
                "background: url(../img/level1/button-on.png) no-repeat;" +
                "background-size: 16% auto;" +
                "background-position: 80% 50%;" +
                "outline: none;";

            if (showTableItem == "Yes") {
                this.ChartTable = "График";
                this.displayChart = "display:none;";

                if (this.company == "all") {
                    this.displayTable = "display:none;";
                } else {
                    this.displayTable = "d-flex;";
                    this.displayHeadTables = "display: none";
                }
                this.showTableOn = "";
            } else if (showTableItem == "No") {
                this.displayTable = "display:none;";
                this.displayChart = "display:block;";
                this.ChartTable = "Таблица";


                this.showTableOn = showTableOn; //colour button
            }
        },

        changeDate() {
            this.selectedDay = 0;
            this.timestampToday = new Date(this.range.start).getTime();
            this.timestampEnd = new Date(this.range.end).getTime();
            let differenceBetweenDates = this.timestampEnd - this.timestampToday;
            this.quantityRange = Math.trunc((Math.abs(differenceBetweenDates) / 86400000) + 1);
            let nowDate = new Date(this.range.start).toLocaleDateString();
            let oldDate = new Date(this.range.end).toLocaleDateString();
            this.timeSelect = nowDate;
            this.timeSelectOld = oldDate;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
            this.getCurrencyNow(new Date().toLocaleDateString());
            this.getAccidentTotal();
            this.updatePrices(this.period);

        },


        calculateInjectionWellsData() {
            this.wellStockIdleButtons.isInjectionIdleButtonActive = !this.wellStockIdleButtons.isInjectionIdleButtonActive;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },


        WellsData(arr) {
            var productionPlanAndFactMonthWells = _(arr)
                .groupBy("data")
                .map((__time, id) => ({
                    __time: id,
                    inj_wells_idle: (_.sumBy(__time, 'inj_wells_idle')) / this.quantityRange,
                    inj_wells_work: (_.sumBy(__time, 'inj_wells_work')) / this.quantityRange,
                    prod_wells_work: (_.sumBy(__time, 'prod_wells_work')) / this.quantityRange,
                    prod_wells_idle: (_.sumBy(__time, 'prod_wells_idle')) / this.quantityRange,
                }))
                .value();
            var productionPlanAndFactMonthWellsName = [];

            this.inj_wells_idle = productionPlanAndFactMonthWells[0]['inj_wells_idle'];
            this.inj_wells_work = productionPlanAndFactMonthWells[0]['inj_wells_work'];
            this.prod_wells_work = productionPlanAndFactMonthWells[0]['prod_wells_work'];
            this.prod_wells_idle = productionPlanAndFactMonthWells[0]['prod_wells_idle'];

        },

        getSummaryInjectionWellsForChart(inputData) {
            let innerWells = _.groupBy(inputData, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD");
            });

            let result = {};

            if (typeof innerWells !== 'undefined') {
                for (let i in innerWells) {
                    result[i] = {
                        fond_nagnetat_ef: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_ef'), 0),
                        fond_nagnetat_df: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_df'), 0),
                        fond_nagnetat_bd: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_bd'), 0),
                        fond_nagnetat_osvoenie: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_osvoenie'), 0),
                        fond_nagnetat_ofls: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_ofls'), 0),
                        fond_nagnetat_konv: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_konv'), 0),
                        fond_nagnetat_prs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_prs'), 0),
                        fond_nagnetat_oprs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_oprs'), 0),
                        fond_nagnetat_krs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_krs'), 0),
                        fond_nagnetat_okrs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_okrs'), 0),
                        fond_nagnetat_well_survey: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_well_survey'), 0),
                        fond_nagnetat_others: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_others'), 0),
                    }
                }
            }
            return result;
        },

        innerWellsNagMetOnChange($event) {
            this.company = $event.target.value;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },


        calculateProductionWellsData() {
            this.wellStockIdleButtons.isProductionIdleButtonActive = !this.wellStockIdleButtons.isProductionIdleButtonActive;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },

        getSummaryWells(inputData, isIdleActive, fonds) {
            let self = this;
            let productionPlanAndFactMonthWells = _(inputData)
                .groupBy("data")
                .map((__time, id) => (this.$_getSummaryFonds(fonds,__time,id)))
                .value();
            let halfOfProductionFondsLength = Math.ceil(fonds.length / 2);
            let productionFondsForIterations = [];
            let productionFondsSummary = [];
            if (!isIdleActive) {
                productionFondsForIterations = fonds.splice(0,halfOfProductionFondsLength);
            } else {
                productionFondsForIterations = fonds.splice(halfOfProductionFondsLength,fonds.length);
            }
            _.forEach(productionFondsForIterations, function(fondName) {
                let translationName = "visualcenter." + self.fondNamesByDBFields[fondName];
                productionFondsSummary.push(
                    {
                        value: productionPlanAndFactMonthWells[0][fondName],
                        name: self.trans(translationName),
                        code: fondName
                    }
                );
            });
            return productionFondsSummary;
        },

        $_getSummaryFonds(fonds,time, id) {
            let summaryWells = {__time: id};
            let self = this;
            _.forEach(fonds, function(fond) {
                summaryWells[fond] = (_.sumBy(time, fond)) / self.quantityRange;
            });
            return summaryWells;
        },

        getSummaryProductionWellsForChart(inputData) {
            let innerWells = _.groupBy(inputData, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD")//.format('D')
            });

            let result = {}
            if (typeof innerWells !== 'undefined') {
                for (let i in innerWells) {
                    result[i] = {
                        fond_neftedob_ef: _.round(_.sumBy(innerWells[i], 'fond_neftedob_ef'), 0),
                        fond_neftedob_df: _.round(_.sumBy(innerWells[i], 'fond_neftedob_df'), 0),
                        fond_neftedob_bd: _.round(_.sumBy(innerWells[i], 'fond_neftedob_bd'), 0),
                        fond_neftedob_osvoenie: _.round(_.sumBy(innerWells[i], 'fond_neftedob_osvoenie'), 0),
                        fond_neftedob_ofls: _.round(_.sumBy(innerWells[i], 'fond_neftedob_ofls'), 0),
                        fond_neftedob_prs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_prs'), 0),
                        fond_neftedob_oprs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_oprs'), 0),
                        fond_neftedob_krs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_krs'), 0),
                        fond_neftedob_okrs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_okrs'), 0),
                        fond_neftedob_well_survey: _.round(_.sumBy(innerWells[i], 'fond_neftedob_well_survey'), 0),
                        fond_neftedob_nrs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_nrs'), 0),
                        fond_neftedob_others: _.round(_.sumBy(innerWells[i], 'fond_neftedob_others'), 0),
                    }
                }
            }
            return result;
        },

        getOtmData(arr) {
            let otmData = _(arr)
                .groupBy("data")
                .map((__time, id) => ({
                    __time: id,
                    otm_iz_burenia_skv_plan: _.round(_.sumBy(__time, 'otm_iz_burenia_skv_plan'), 0),
                    otm_iz_burenia_skv_fact: _.round(_.sumBy(__time, 'otm_iz_burenia_skv_fact'), 0),
                    otm_burenie_prohodka_plan: _.round(_.sumBy(__time, 'otm_burenie_prohodka_plan'), 0),
                    otm_burenie_prohodka_fact: _.round(_.sumBy(__time, 'otm_burenie_prohodka_fact'), 0),
                    otm_krs_skv_plan: _.round(_.sumBy(__time, 'otm_krs_skv_plan'), 0),
                    otm_krs_skv_fact: _.round(_.sumBy(__time, 'otm_krs_skv_fact'), 0),
                    otm_prs_skv_plan: _.round(_.sumBy(__time, 'otm_prs_skv_plan'), 0),
                    otm_prs_skv_fact: _.round(_.sumBy(__time, 'otm_prs_skv_fact'), 0),
                }))
                .value();

            let result = [];

            result.push(
                {
                    name:
                    // 'Скважин из бурения',
                        this.trans("visualcenter.otm_iz_burenia_skv_fact"),
                    code: 'otm_iz_burenia_skv_fact',
                    plan: otmData[0]['otm_iz_burenia_skv_plan'],
                    fact: otmData[0]['otm_iz_burenia_skv_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
                {
                    name:
                    // 'Бурение проходка',
                        this.trans("visualcenter.otm_burenie_prohodka_fact"),
                    code: 'otm_burenie_prohodka_fact',
                    plan: otmData[0]['otm_burenie_prohodka_plan'],
                    fact: otmData[0]['otm_burenie_prohodka_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemMeter"),
                },
                {
                    name:
                    // 'КРС',
                        this.trans("visualcenter.otm_krs_skv_fact"),
                    code: 'otm_krs_skv_fact',
                    plan: otmData[0]['otm_krs_skv_plan'],
                    fact: otmData[0]['otm_krs_skv_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
                {
                    name:
                    // 'ПРС',
                        this.trans("visualcenter.otm_prs_skv_fact"),
                    code: 'otm_prs_skv_fact',
                    plan: otmData[0]['otm_prs_skv_plan'],
                    fact: otmData[0]['otm_prs_skv_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
            )

            return result
        },

        getOtmChartData(arr) {
            let otmData
            otmData = _.groupBy(arr, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD")//.format('D')
            })

            let result = {}

            if (typeof otmData !== 'undefined') {
                for (let i in otmData) {
                    result[i] = {
                        otm_iz_burenia_skv_fact: _.round(_.sumBy(otmData[i], 'otm_iz_burenia_skv_fact'), 0),
                        otm_burenie_prohodka_fact: _.round(_.sumBy(otmData[i], 'otm_burenie_prohodka_fact'), 0),
                        otm_krs_skv_fact: _.round(_.sumBy(otmData[i], 'otm_krs_skv_fact'), 0),
                        otm_prs_skv_fact: _.round(_.sumBy(otmData[i], 'otm_prs_skv_fact'), 0),
                    }
                }
            }


            return result
        },
        getChemistryData(arr) {
            let chemistryData = _(arr)
                .groupBy("data")
                .map((__time, id) => ({
                    __time: id,
                    chem_prod_zakacka_demulg_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_demulg_plan'), 0),
                    chem_prod_zakacka_demulg_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_demulg_fact'), 0),
                    chem_prod_zakacka_bakteracid_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_bakteracid_plan'), 0),
                    chem_prod_zakacka_bakteracid_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_bakteracid_fact'), 0),
                    chem_prod_zakacka_ingibator_korrozin_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_korrozin_plan'), 0),
                    chem_prod_zakacka_ingibator_korrozin_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_korrozin_fact'), 0),
                    chem_prod_zakacka_ingibator_soleotloj_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_soleotloj_plan'), 0),
                    chem_prod_zakacka_ingibator_soleotloj_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_soleotloj_fact'), 0),
                }))
                .value();

            let result = [];

            result.push(
                {
                    name:
                    // 'Деэмульгатор',
                        this.trans("visualcenter.chem_prod_zakacka_demulg_fact"),
                    code: 'chem_prod_zakacka_demulg_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_demulg_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_demulg_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name:
                    // 'Бактерицид',
                        this.trans("visualcenter.chem_prod_zakacka_bakteracid_fact"),
                    code: 'chem_prod_zakacka_bakteracid_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_bakteracid_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_bakteracid_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name:
                    // 'Ингибитор коррозии',
                        this.trans("visualcenter.chem_prod_zakacka_ingibator_korrozin_fact"),
                    code: 'chem_prod_zakacka_ingibator_korrozin_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_ingibator_korrozin_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_ingibator_korrozin_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name:
                    // 'Ингибитор солеотложения',
                        this.trans("visualcenter.chem_prod_zakacka_ingibator_soleotloj_fact"),
                    code: 'chem_prod_zakacka_ingibator_soleotloj_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_ingibator_soleotloj_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_ingibator_soleotloj_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
            )

            return result
        },
        getChemistryChartData(arr) {
            let chemistryData = _.groupBy(arr, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD")//.format('D')
            })

            let result = {}

            if (typeof chemistryData !== 'undefined') {
                for (let i in chemistryData) {
                    result[i] = {
                        chem_prod_zakacka_demulg_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_demulg_fact'), 0),
                        chem_prod_zakacka_bakteracid_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_bakteracid_fact'), 0),
                        chem_prod_zakacka_ingibator_korrozin_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_ingibator_korrozin_fact'), 0),
                        chem_prod_zakacka_ingibator_soleotloj_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_ingibator_soleotloj_fact'), 0),
                    }
                }
            }

            return result
        },

        innerWellsProdMetOnChange($event) {
            this.company = $event.target.value;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },


        getNameDzoFull: function (dzo) {
            if (typeof this.NameDzoFull[dzo] !== 'undefined') {
                return this.NameDzoFull[dzo]
            }
            return dzo;
        },

        getStaff() {
            let uri = this.localeUrl("/visualcenter3GetDataStaff");
            this.axios.get(uri).then((response) => {
                let data = response.data;
                if (data) {
                    var staff = _(data)
                        .groupBy("date")
                        .map((date, id) => ({
                            date: id,
                            staff_number: _.round(_.sumBy(date, 'staff_number'), 0),

                        }))
                        .value();
                    staff = _.orderBy(
                        staff,
                        ["date"],
                        ["desc"]
                    );
                    this.staff = staff[0]['staff_number'];
                    this.staffPercent = staff[1]['staff_number'];

                    this.quarter1 = this.getQuarter(new Date(staff[0]['date']));
                    this.quarter2 = this.getQuarter(new Date(staff[1]['date']));

                } else {
                    console.log('No data Personal')
                }

            });
        },

        getProductionForChart(data) {
            let summary = data.filter(row => this.selectedDzoCompanies.includes(row.dzo));
            if (summary.length === 0) {
                summary = data;
            }

            let productionPlan = this.planFieldName;
            let productionFact = this.factFieldName;

            return _(summary)
                .groupBy("__time")
                .map((__time, id) => ({
                    time: id,
                    dzo: 'dzo',
                    productionFactForChart: _.round(_.sumBy(__time, productionFact), 0),
                    productionPlanForChart: _.round(_.sumBy(__time, productionPlan), 0),
                    productionPlanForChart2: _.round(_.sumBy(__time, this.opecFieldNameForChart), 0),
                }))
                .value();
        },

        getQuarter(d) {
            return [parseInt(d.getMonth() / 3) + 1, d.getFullYear()];
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

        getOpecDataForYear() {
            let uri = this.localeUrl("/visualcenter3GetDataOpec");

            this.axios.get(uri).then((response) => {
                let data = response.data;
                if (data) {

                    //Summ plan dzo year
                    let SummFromRange = _(data)
                        .groupBy("dzo")
                        .map((dzo, id) => ({
                            dzoMonth: id,
                            periodPlan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
                        }))

                        .value();
                    let opecDataSumm = _.reduce(
                        SummFromRange,
                        function (memo, item) {
                            return memo + item.periodPlan;
                        },
                        0
                    );

                    this.opecData = SummFromRange;
                    this.opecDataSumm = opecDataSumm;

                } else {
                    console.log('Not opec data');
                }
            });
        },
        getPreviousWorkday(){
            let workday = moment();
            let day = workday.day();
            let diff = 1;
            if (day === 0 || day === 1){
                diff = day + 2;
            }
            return workday.subtract(diff, 'days').format();
        },

        getOpecMonth(data) {

            let dataWithMay = _.filter(data, _.iteratee({date: (this.year + '-' + this.pad(this.month) + '-01' + ' 00:00:00')}));
            if (dataWithMay.length === 0) {
                let dateFormat = 'YYYY-MM-DD HH:mm:ss';
                let lastWorkingDay = this.getPreviousWorkday();
                let lastSynchronizeDay = moment(lastWorkingDay).startOf('day').add(1, "days").format(dateFormat);
                dataWithMay = _.filter(data, _.iteratee({date: lastSynchronizeDay}));
            }
            let oil;
            if (this.opec === "ОПЕК+") {
                oil = 'oil_opek_plan';
            } else {
                oil = 'oil_plan';
            }

            let SummFromRange = _(dataWithMay)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzoMonth: id,
                    periodPlan: (_.sumBy(dzo, oil)) * moment().daysInMonth(),
                }))

                .value();

            let opecDataSumm = _.reduce(
                SummFromRange,
                function (memo, item) {
                    return memo + item.periodPlan;
                },
                0
            );

            this.opecDataSummMonth = opecDataSumm;

            return SummFromRange;
        },

        formatVisTableNumber3(a, b) {
            if (a && b) {
                return new Intl.NumberFormat("ru-RU").format(Math.abs(((a - b) / b) * 100).toFixed(1))
            } else {
                return 0
            }
        },


        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
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
        }
    },

    created() {

    },

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
    },
    watch: {
        bigTable: function () {
            this.dzoCompanySummary = this.bigTable;
            this.calculateDzoCompaniesSummary();
        },
    },
    computed: {
        exactDateSelected() {
            return ((this.factFieldName === 'oil_fact' || this.factFieldName === 'oil_div_fact') && this.oneDate === 1);
        },

        periodSelectFunc() {
            let DMY = [
                // "Неделя",
                this.trans("visualcenter.week"),
                // "Месяц",
                this.trans("visualcenter.Month"),
                // "Квартал",
                this.trans("visualcenter.Quarter"),
                // "Год",
                this.trans("visualcenter.Year"),
                // "Всё"
                this.trans("visualcenter.All")
            ];
            let DMY_titles = [
                // "За последние 7 дней",
                this.trans("visualcenter.kurs7day"),
                // "За последний месяц",
                this.trans("visualcenter.kurslastmonth"),
                // "За последние 3 месяца",
                this.trans("visualcenter.kurs3month"),
                // "За последний год",
                this.trans("visualcenter.kurslastyear"),
                // "За всё время"
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
        usdRatesDataTableForCurrentPeriod() {
            this.sortUsdRatesDataForTable;
            return this.usdRatesData.for_table.slice(0, this.usdPeriod);
        },

        sortUsdRatesDataForTable() {
            this.usdRatesData.for_table.sort((a, b) => {
                return moment(b.date_string, 'DD.MM.YYYY') - moment(a.date_string, 'DD.MM.YYYY');
            });
        },

        oilRatesDataTableForCurrentPeriod() {
            this.sortOilRatesDataForTable;
            return this.oilRatesData.for_table.slice(0, this.oilPeriod);
        },

        innerWellsNagDataForChart() {
            let series = []
            let labels = []
            for (let i in this.innerWellsChartData) {
                series.push(this.innerWellsSelectedRow ? this.innerWellsChartData[i][this.innerWellsSelectedRow] : this.innerWellsChartData[i]['fond_nagnetat_ef'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },


        innerWellsProd2DataForChart() {
            let series = []
            let labels = []
            for (let i in this.innerWells2ChartData) {
                series.push(this.innerWells2SelectedRow ? this.innerWells2ChartData[i][this.innerWells2SelectedRow] : this.innerWells2ChartData[i]['fond_neftedob_ef'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },


        otmDataForChart() {
            let series = []
            let labels = []
            for (let i in this.otmChartData) {
                series.push(this.otmSelectedRow ? this.otmChartData[i][this.otmSelectedRow] : this.otmChartData[i]['otm_iz_burenia_skv_fact'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
        chemistryDataForChart() {
            let series = []
            let labels = []
            for (let i in this.chemistryChartData) {
                series.push(this.chemistrySelectedRow ? this.chemistryChartData[i][this.chemistrySelectedRow] : this.chemistryChartData[i]['chem_prod_zakacka_demulg_fact'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
        sortOilRatesDataForTable() {
            this.oilRatesData.for_table.sort((a, b) => {
                return moment(b.date_string, 'DD.MM.YYYY') - moment(a.date_string, 'DD.MM.YYYY');
            });
        },
    },
};
