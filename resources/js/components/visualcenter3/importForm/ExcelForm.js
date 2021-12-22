import VGrid from "@revolist/vue-datagrid";
import initialRowsKOA from './dzoData/initial_rows_koa.json';
import initialRowsKTM from './dzoData/initial_rows_ktm.json';
import initialRowsKBM from './dzoData/initial_rows_kbm.json';
import initialRowsKGM from './dzoData/initial_rows_kgm.json';
import initialRowsMMG from './dzoData/initial_rows_mmg.json';
import initialRowsOMG from './dzoData/initial_rows_omg.json';
import initialRowsYO from './dzoData/initial_rows_yo.json';
import initialRowsEMG from './dzoData/initial_rows_emg.json';
import initialRowsTSHO from './dzoData/initial_rows_tsho.json';
import initialRowsNKO from './dzoData/initial_rows_nko.json';
import initialRowsKPO from './dzoData/initial_rows_kpo.json';
import initialRowsPKK from './dzoData/initial_rows_pkk.json';
import initialRowsTP from './dzoData/initial_rows_tp.json';
import initialRowsAG from './dzoData/initial_rows_ag.json';
import formatMappingKOA from './dzoData/format_mapping_koa.json';
import formatMappingKTM from './dzoData/format_mapping_ktm.json';
import formatMappingKBM from './dzoData/format_mapping_kbm.json';
import formatMappingKGM from './dzoData/format_mapping_kgm.json';
import formatMappingMMG from './dzoData/format_mapping_mmg.json';
import formatMappingOMG from './dzoData/format_mapping_omg.json';
import formatMappingYO from './dzoData/format_mapping_yo.json';
import formatMappingEMG from './dzoData/format_mapping_emg.json';
import formatMappingTSHO from './dzoData/format_mapping_tsho.json';
import formatMappingKPO from './dzoData/format_mapping_kpo.json';
import formatMappingNKO from './dzoData/format_mapping_nko.json';
import formatMappingPKK from './dzoData/format_mapping_pkk.json';
import formatMappingTP from './dzoData/format_mapping_tp.json';
import formatMappingAG from './dzoData/format_mapping_ag.json';
import cellsMappingKOA from './dzoData/cells_mapping_koa.json';
import cellsMappingKTM from './dzoData/cells_mapping_ktm.json';
import cellsMappingKBM from './dzoData/cells_mapping_kbm.json';
import cellsMappingKGM from './dzoData/cells_mapping_kgm.json';
import cellsMappingMMG from './dzoData/cells_mapping_mmg.json';
import cellsMappingOMG from './dzoData/cells_mapping_omg.json';
import cellsMappingYO from './dzoData/cells_mapping_yo.json';
import cellsMappingEMG from './dzoData/cells_mapping_emg.json';
import cellsMappingTSHO from './dzoData/cells_mapping_tsho.json';
import cellsMappingNKO from './dzoData/cells_mapping_nko.json';
import cellsMappingKPO from './dzoData/cells_mapping_kpo.json';
import cellsMappingPKK from './dzoData/cells_mapping_pkk.json';
import cellsMappingTP from './dzoData/cells_mapping_tp.json';
import cellsMappingAG from './dzoData/cells_mapping_ag.json';
import moment from "moment";
import Visual from "./dataManagers/visual";
import TodayDzoData from "./dataManagers/todayDzoData";
import InputDataOperations from "./dataManagers/inputDataOperations";
import Archieve from "./dataManagers/archieve";
import {globalloadingMutations} from '@store/helpers';
import Plans from "./dataManagers/plans";
import CloseMonth from "./dataManagers/closeMonth";

const defaultDzoTicker = "ЭМГ";

export default {
    data: function () {
        return {
            dzoMapping : {
                "КОА" : {
                    rows: initialRowsKOA,
                    format: formatMappingKOA,
                    cells: cellsMappingKOA,
                    id: 110,
                    requiredRows: [1,6,11,16,21,26],
                    isNotNull: {
                        1: 1,
                        6: 1,
                        11: 1,
                        16: 1,
                        21: 1,
                    },
                    dailyReasonRow: 73,
                    monthlyReasonRow: 80,
                    yearlyReasonRow: 87,
                },
                "КТМ" : {
                    rows: initialRowsKTM,
                    format: formatMappingKTM,
                    cells: cellsMappingKTM,
                    id: 107,
                    requiredRows: [1,6,11,16,21],
                    isNotNull: {
                        1: 1,
                        6: 1,
                        11: 1,
                        16: 1
                    },
                    dailyReasonRow: 68,
                    monthlyReasonRow: 75,
                    yearlyReasonRow: 82,
                },
                "КБМ" : {
                    rows: initialRowsKBM,
                    format: formatMappingKBM,
                    cells: cellsMappingKBM,
                    id: 106,
                    requiredRows: [1,4,7,10,13],
                    isNotNull: {
                        1: 1,
                        4: 1,
                        7: 1,
                        10: 1,
                        10: 3,
                    },
                    dailyReasonRow: 58,
                    monthlyReasonRow: 65,
                    yearlyReasonRow: 72,
                },
                "ММГ" : {
                    rows: initialRowsMMG,
                    format: formatMappingMMG,
                    cells: cellsMappingMMG,
                    id: 109,
                    requiredRows: [1,6,11,15,20,25],
                    isNotNull: {
                        1: 1,
                        6: 1,
                        11: 1,
                        15: 1,
                        20: 1,
                    },
                    dailyReasonRow: 72,
                    monthlyReasonRow: 79,
                    yearlyReasonRow: 86,
                },
                "ОМГ" : {
                    rows: initialRowsOMG,
                    format: formatMappingOMG,
                    cells: cellsMappingOMG,
                    id: 112,
                    requiredRows: [1,4,7,10,13,16,19],
                    isNotNull: {
                        1: 1,
                        4: 1,
                        7: 1,
                        10: 1,
                        13: 1,
                        16: 1,
                    },
                    dailyReasonRow: 64,
                    monthlyReasonRow: 71,
                    yearlyReasonRow: 78,
                },
                "УО" : {
                    rows: initialRowsYO,
                    format: formatMappingYO,
                    cells: cellsMappingYO,
                    id: 111,
                    requiredRows:[1,7,12,18],
                    isNotNull: {
                        1: 1,
                        7: 1,
                        12: 1
                    },
                    dailyReasonRow: 67,
                    monthlyReasonRow: 74,
                    yearlyReasonRow: 81,
                },
                "ЭМГ" : {
                    rows: initialRowsEMG,
                    format: formatMappingEMG,
                    cells: cellsMappingEMG,
                    id: 113,
                    requiredRows: [1,8,15,22,29],
                    isNotNull: {
                        1: 1,
                        8: 1,
                        15: 1,
                        22: 1
                    },
                    dailyReasonRow: 78,
                    monthlyReasonRow: 85,
                    yearlyReasonRow: 92,
                },
                "ТШО" : {
                    rows: initialRowsTSHO,
                    format: formatMappingTSHO,
                    cells: cellsMappingTSHO,
                    id: 259,
                    requiredRows: [1,4],
                    isNotNull: {
                        1: 1,
                    },
                    dailyReasonRow: 7,
                    monthlyReasonRow: 14,
                    yearlyReasonRow: 21,
                },
                "НКО" : {
                    rows: initialRowsNKO,
                    format: formatMappingNKO,
                    cells: cellsMappingNKO,
                    id: 262,
                    requiredRows: [1,4],
                    isNotNull: {
                        1: 1,
                    },
                    dailyReasonRow: 7,
                    monthlyReasonRow: 14,
                    yearlyReasonRow: 21,
                },
                "КПО" : {
                    rows: initialRowsKPO,
                    format: formatMappingKPO,
                    cells: cellsMappingKPO,
                    id: 260,
                    requiredRows: [1,4],
                    isNotNull: {
                        1: 1,
                    },
                    dailyReasonRow: 7,
                    monthlyReasonRow: 14,
                    yearlyReasonRow: 21,
                },
                "КГМ" : {
                    rows: initialRowsKGM,
                    format: formatMappingKGM,
                    cells: cellsMappingKGM,
                    id: 108,
                    requiredRows: [1,4,10],
                    isNotNull: {
                        1: 1,
                        4: 1,
                        10: 1
                    },
                    dailyReasonRow: 61,
                    monthlyReasonRow: 68,
                    yearlyReasonRow: 75,
                },
                "ПКК" : {
                    rows: initialRowsPKK,
                    format: formatMappingPKK,
                    cells: cellsMappingPKK,
                    id: 0,
                    requiredRows: [],
                    isNotNull: {},
                    dailyReasonRow: 4,
                    monthlyReasonRow: 11,
                    yearlyReasonRow: 18,
                },
                "ТП" : {
                    rows: initialRowsTP,
                    format: formatMappingTP,
                    cells: cellsMappingTP,
                    id: 0,
                    requiredRows: [],
                    isNotNull: {},
                    dailyReasonRow: 4,
                    monthlyReasonRow: 11,
                    yearlyReasonRow: 18,
                },
                "АГ" : {
                    rows: initialRowsAG,
                    format: formatMappingAG,
                    cells: cellsMappingAG,
                    id: 0,
                    requiredRows: [],
                    isNotNull: {},
                    dailyReasonRow: 4,
                    monthlyReasonRow: 11,
                    yearlyReasonRow: 18,
                },
            },
            dzoCompanies: [
                {
                    ticker: 'ЭМГ',
                    name: 'АО "Эмбамунайгаз"'
                },
                {
                    ticker: 'КОА',
                    name: 'ТОО "Казахойл Актобе"'
                },
                {
                    ticker: 'КТМ',
                    name: 'ТОО "Казахтуркмунай"'
                },
                {
                    ticker: 'КБМ',
                    name: 'АО "Каражанбасмунай"'
                },
                {
                    ticker: 'ММГ',
                    name: 'АО "Мангистаумунайгаз"'
                },
                {
                    ticker: 'КГМ',
                    name: 'ТОО "СП "Казгермунай"'
                },
                {
                    ticker: 'ОМГ',
                    name: 'АО "Озенмунайгаз"'
                },
                {
                    ticker: 'УО',
                    name: 'ТОО "Урихтау Оперейтинг"'
                },
                {
                    ticker: 'ТШО',
                    name: 'ТОО "Тенгизшевройл"'
                },
                {
                    ticker: 'НКО',
                    name: 'Норт Каспиан Оперейтинг Компани н.в.'
                },
                {
                    ticker: 'КПО',
                    name: 'Карачаганак Петролеум Оперейтинг б.в.'
                },
                {
                    ticker: 'ПКК',
                    name: 'АО "ПетроКазахстан Кумколь Ресорсиз"'
                },
                {
                    ticker: 'ТП',
                    name: 'АО "Тургай-Петролеум"'
                },
                {
                    ticker: 'АГ',
                    name: 'ТОО "Амангельды Газ"'
                },
            ],
            selectedDzo: {
                ticker: defaultDzoTicker,
                name: 'АО "Эмбамунайгаз"',
                plans: [],
            },
            status: this.trans("visualcenter.importForm.status.waitForData"),
            rows: _.cloneDeep(initialRowsKOA),
            isDataExist: false,
            isDataReady: false,
            dzoPlans: [],
            currentMonthNumber: moment().format('M'),
            cellsMapping: _.cloneDeep(cellsMappingKOA),
            rowsFormatMapping: _.cloneDeep(formatMappingKOA.rowsFormatMapping),
            columnsFormatMapping: _.cloneDeep(formatMappingKOA.columnsFormatMapping),
            excelData: {
                downtimeReason: {},
                decreaseReason: {},
                fields: {}
            },
            isValidateError: false,
            inputDataCategories: ['downtimeReason','decreaseReason','fields'],
            chemistryData: {
                demulsifier: 0,
                bactericide: 0,
                corrosion_inhibitor: 0,
                scale_inhibitor: 0
            },
            wellWorkover: {
                otm_well_workover_fact: 0,
                otm_underground_workover: 0
            },
            chemistryDataMapping: {
                demulsifier: this.trans("visualcenter.chemProdZakackaDemulg"),
                bactericide: this.trans("visualcenter.chemProdZakackaBakteracid"),
                corrosion_inhibitor: this.trans("visualcenter.chemProdZakackaIngibatorKorrozin"),
                scale_inhibitor: this.trans("visualcenter.chemProdZakackaIngibatorSoleotloj"),
            },
            chemistryErrorFields: [],
            currentDateDetailed: moment().subtract(1, 'days').format("YYYY-MM-DD HH:mm:ss"),
            factorOptions: {
                'КТМ': {
                    'fields': ['agent_upload_waste_water_injection_fact'],
                    'formula': (totalWaterFact,albsenomanianWaterFact) => totalWaterFact - albsenomanianWaterFact
                },
            },
            dzoUsers: [],
            requiredRows: 0,
            isNotNullRows: {},
            bigDzo: ['ТШО','КПО','НКО','ПКК','АГ','ТП','КГМ'],
            dzoListByCondensate: ['АГ'],
            factValidationMapping: {
                'oil': 'oil_production_fact',
                'condensate': 'condensate_production_fact'
            },
            toastOptions: {
                title: '',
                variant: '',
                solid: true,
                noAutoHide: true,
            },
            dailyLossesField: [
                'daily_reason_1_losses',
                'daily_reason_2_losses',
                'daily_reason_3_losses',
                'daily_reason_4_losses',
                'daily_reason_5_losses'
            ],
            monthlyLossesField: [
                'monthly_reason_1_losses',
                'monthly_reason_2_losses',
                'monthly_reason_3_losses',
                'monthly_reason_4_losses',
                'monthly_reason_5_losses'
            ],
            yearlyLossesField: [
                'yearly_reason_1_losses',
                'yearly_reason_2_losses',
                'yearly_reason_3_losses',
                'yearly_reason_4_losses',
                'yearly_reason_5_losses'
            ],
            yearlyUpdateLimit: {
                'month': 0,
                'day': 10
            }
        };
    },
    props: ['userId'],
    async mounted() {
        this.SET_LOADING(true);
        this.dzoUsers = Object.keys(this.dzoMapping).map(k => this.dzoMapping[k].id);
        let currentDayNumber = moment().date();
        this.selectedDzo.ticker = this.getDzoTicker();
        if (!this.selectedDzo.ticker) {
            this.selectedDzo.ticker = defaultDzoTicker;
        }
        if (this.daysWhenChemistryNeeded.includes(currentDayNumber) && !this.bigDzo.includes(this.selectedDzo.ticker)) {
            this.isChemistryButtonVisible = true;
            this.$modal.show('additionalParamsReminder');
        }
        if (moment().date() === this.yearlyUpdateLimit.day) {
            this.$modal.show('yearlyReasonsReminder');
        }
        this.planRows = _.cloneDeep(this.planDzoMapping[this.selectedDzo.ticker]);
        this.fillPlanColumns();
        this.fillPlanRows();
        this.plans = await this.getDzoPlans();
        this.handlePlans();
        if (this.monthDate.date() <= 10) {
            this.monthDate = this.monthDate.subtract(1,'month').endOf('month');
        }
        this.fillMonthColumns();
        this.fillMonthRows();
        this.monthlyFact = await this.getDzoFactByPeriod();
        this.handleMonthFact();
        this.selectedDzo.name = this.getDzoName();
        this.changeDefaultDzo();
        this.dzoPlans = await this.getDzoMonthlyPlans();
        this.selectedDzo.plans = this.getSelectedDzoPlans();
        await this.sleep(2000);
        this.setTableFormat();
        await this.updateCurrentData();
        this.addListeners();
        this.SET_LOADING(false);
    },
    methods: {
        getDzoTicker() {
            let dzoTicker = '';
            let self = this;
            _.forEach(Object.keys(this.dzoMapping), function(key) {
                if (parseInt(self.dzoMapping[key].id) === parseInt(self.userId)) {
                    dzoTicker = key;
                }
            });
            return dzoTicker;
        },
        getDzoName() {
            let dzoName = '';
            let self = this;
            _.forEach(this.dzoCompanies, function(dzo) {
                if (dzo.ticker === self.selectedDzo.ticker) {
                    dzoName = dzo.name;
                }
            });
            return dzoName;
        },
        async changeDefaultDzo() {
            this.cellsMapping = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].cells);
            this.requiredRows = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].requiredRows);
            this.isNotNullRows = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].isNotNull);
            this.rowsFormatMapping = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].format.rowsFormatMapping);
            this.columnsFormatMapping = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].format.columnsFormatMapping);
            this.rowsCount = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].rows).length + 2;
            this.rows = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].rows);
            await this.sleep(100);
            this.disableHighlightOnCells();
            this.setTableFormat();
        },
        async wellWorkoverSave() {
            await this.storeWellWorkoverData();
        },
        async chemistrySave() {
            this.chemistryErrorFields = [];
            let self = this;
            _.forEach(Object.keys(this.chemistryData), function(key) {
                self.isChemistryNumberValid(self.chemistryData[key],key);
            });
            if (this.chemistryErrorFields.length === 0) {
                await this.storeChemistryData();
            }
        },
        isChemistryNumberValid(inputData,key) {
            if (isNaN(inputData) || inputData < 0) {
                this.chemistryErrorFields.push(this.chemistryDataMapping[key]);
                return false;
            }
            return true;
        },
        storeWellWorkoverData() {
            this.wellWorkover['dzo_name'] = this.selectedDzo.ticker;
            this.wellWorkover['date'] = moment().subtract(1, 'months').format("YYYY-MM-DD HH:mm:ss");
            let uri = this.localeUrl("/dzo-excel-otm");

            this.axios.post(uri, this.wellWorkover).then((response) => {
                if (response.status === 200) {
                    this.isWellsWorkoverNeeded = !this.isWellsWorkoverNeeded;
                    this.status = this.trans("visualcenter.importForm.status.dataSaved");
                } else {
                    this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                }
            });
        },
        storeChemistryData() {
            this.chemistryData['dzo_name'] = this.selectedDzo.ticker;
            this.chemistryData['date'] = moment().subtract(1, 'months').format("YYYY-MM-DD HH:mm:ss");

            let uri = this.localeUrl("/dzo-chemistry-excel-form");

            this.axios.post(uri, this.chemistryData).then((response) => {
                if (response.status === 200) {
                    this.isChemistryNeeded = !this.isChemistryNeeded;
                    this.status = this.trans("visualcenter.importForm.status.dataSaved");
                } else {
                    this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                }
            });
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        getSelectedDzoPlans() {
            let self = this;
            return _.filter(this.dzoPlans, function(row) {
                let rowMonthNumber = moment(row.date).format('M');
                return (rowMonthNumber === self.currentMonthNumber && row.dzo === self.selectedDzo.ticker);
            });
        },
        async getDzoMonthlyPlans() {
            let uri = this.localeUrl("/get-dzo-monthly-plans");
            const response = await axios.get(uri);
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },
        async handleValidate() {
            this.isValidateError = false;
            this.isDataReady = false;
            this.turnOffErrorHighlight();
            this.disableHightLightForReasons();
            this.processTableData();
            let isError = false;
            if (await this.isFactBelowPlan()) {
                isError = true;
            }
            if (!this.isValidateError && !isError) {
                this.isDataExist = false;
                this.isDataReady = true;
                this.status = this.trans("visualcenter.importForm.status.dataValid");
            } else {
                this.showToast(this.trans("visualcenter.excelFormPlans.fillFieldsBody"), this.trans("visualcenter.excelFormPlans.errorTitle"), 'danger');
                this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
            }
            if (this.dzoFieldsMapping[this.selectedDzo.ticker] && !this.isValidSummary(this.dzoFieldsMapping[this.selectedDzo.ticker])) {
                this.status = this.trans("visualcenter.importForm.status.verifySumByDzo");
            }
        },
        async isFactBelowPlan() {
            let planField = 'plan_oil';
            let factField = 'oil';
            if (this.dzoListByCondensate.includes(this.selectedDzo.ticker)) {
                planField = 'plan_kondensat';
                factField = 'condensate';
            }
            if (!this.excelData['decreaseReason']) {
                this.excelData['decreaseReason'] = {};
            }

            let isError = false;
            if (!this.excelData['decreaseReason']['daily_reason_1_explanation'] && await this.isDailyDifferenceAbnormal(planField,factField)) {
                isError = true;
            }
            if (!this.isAllOilLossesFilled('dailyLossesField','dailyReasonRow')) {
                isError = true;
            }

            let monthlyFact = await this.getSummaryFactByDzo('monthly');
            if (!this.isAllOilLossesFilled('monthlyLossesField','monthlyReasonRow') || await this.isMonthlyDifferenceAbnormal(monthlyFact,factField)) {
                isError = true;
            }

            let yearlyFact = await this.getSummaryFactByDzo('yearly');
            if (!this.isAllOilLossesFilled('yearlyLossesField','yearlyReasonRow') || (moment().date() === this.yearlyUpdateLimit.day && await this.isYearlyDifferenceAbnormal(yearlyFact))) {
                isError = true;
            }
            return isError;
        },

        isAllOilLossesFilled(type,rows) {
            let isError = true;
            _.forEach(this[type], (field, index) => {
                let explanationField = field.replace('losses','explanation');
                let currentRow = this.dzoMapping[this.selectedDzo.ticker][rows];
                currentRow = currentRow + index;
                if (this.excelData['decreaseReason'][explanationField] !== '' && this.excelData['decreaseReason'][field] === '') {
                    this.setClassToElement($('#factGrid').find('div[data-row="' + currentRow + '"][data-col="5"]'),'cell__color-red');
                    isError = false;
                }
            });
            return isError;
        },
        async isDailyDifferenceAbnormal(planField,factField) {
            let toastOptions = _.cloneDeep(this.toastOptions);
            let dailyPlan = await this.getSummaryPlanByDzo('daily');
            let isDailyAbnormal = this.excelData[this.factValidationMapping[factField]] < dailyPlan[planField];

            if (isDailyAbnormal) {
                let dailyRow = this.dzoMapping[this.selectedDzo.ticker].dailyReasonRow;
                for (let i=1;i<6;i++) {
                    this.setClassToElement($('#factGrid').find('div[data-row="' + dailyRow + '"][data-col="' + i + '"]'),'cell__color-red');
                }
                toastOptions.variant = 'danger';
                toastOptions.title = this.trans("visualcenter.excelFormPlans.factBelowPlanTitle");
                let message = `Добыча за сутки меньше запланированного.
                    Ожидаемая суточная добыча: ${this.getFormattedNumberByThousand(dailyPlan[planField])} (т).
                    Заполните "Причины: СУТОЧНЫЕ"!`;
                this.$bvToast.toast(message, toastOptions);
            }

            return isDailyAbnormal;
        },
        async isMonthlyDifferenceAbnormal(monthlyFact,factField) {
            let toastOptions = _.cloneDeep(this.toastOptions);
            let monthlyPlan = await this.getSummaryPlanByDzo('monthly');
            let difference = Math.abs(monthlyPlan - (monthlyFact + this.excelData[this.factValidationMapping[factField]]));
            if (this.excelData['decreaseReason']['monthly_reason_1_explanation'] !== '' && this.isReasonSumCorrect(this.monthlyLossesField,difference)) {
                return false;
            }

            let isMonthlyPlanAbnormal = (monthlyFact + this.excelData[this.factValidationMapping[factField]]) < monthlyPlan;
            if (isMonthlyPlanAbnormal) {
                let monthlyRow = this.dzoMapping[this.selectedDzo.ticker].monthlyReasonRow;
                for (let i=1;i<6;i++) {
                    this.setClassToElement($('#factGrid').find('div[data-row="' + monthlyRow + '"][data-col="' + i + '"]'),'cell__color-red');
                }
                toastOptions.variant = 'danger';
                toastOptions.title = this.trans("visualcenter.excelFormPlans.factBelowPlanTitle");
                let message = `Добыча за месяц меньше запланированного.
                    Ожидаемая месячная добыча: ${this.getFormattedNumberByThousand(monthlyPlan)} (т).
                    Ожидаемые потери по нефти: ${this.getFormattedNumberByThousand(difference)} (т) за месяц.
                    Заполните "Причины: С НАЧАЛА МЕСЯЦА!"`;
                this.$bvToast.toast(message, toastOptions);
            }

            return isMonthlyPlanAbnormal;
        },
        async isYearlyDifferenceAbnormal(yearlyFact) {

            let toastOptions = _.cloneDeep(this.toastOptions);
            let yearlyPlan = await this.getSummaryPlanByDzo('yearly');
            let difference = Math.abs(yearlyPlan - yearlyFact);
            if (this.excelData['decreaseReason']['yearly_reason_1_explanation'] !== '' && this.isReasonSumCorrect(this.yearlyLossesField,difference)) {
                return false;
            }
            let isYearlyPlanAbnormal = yearlyFact < yearlyPlan;
            if (isYearlyPlanAbnormal) {
                let yearlyRow = this.dzoMapping[this.selectedDzo.ticker].yearlyReasonRow;
                for (let i=1;i<6;i++) {
                    this.setClassToElement($('#factGrid').find('div[data-row="' + yearlyRow + '"][data-col="' + i + '"]'),'cell__color-red');
                }
                toastOptions.variant = 'danger';
                toastOptions.title = this.trans("visualcenter.excelFormPlans.factBelowPlanTitle");
                let message = `Добыча за год меньше запланированного.
                    Ожидаемая годовая добыча: ${this.getFormattedNumberByThousand(yearlyPlan)} (т).
                    Ожидаемые потери по нефти: ${this.getFormattedNumberByThousand(difference)} (т) за год.
                    Заполните "Причины: С НАЧАЛА ГОДА!"`;
                this.$bvToast.toast(message, toastOptions);
            }
            return isYearlyPlanAbnormal;
        },

        isReasonSumCorrect(fields,difference) {
            let sum = 0;
            _.forEach(fields, (field) => {
               sum += this.excelData['decreaseReason'][field];
            });
            let min = difference + 5;
            let max = difference + 5;

            return sum >= min && sum <= max;
        },
        getFormattedNumberByThousand(num) {
            return (new Intl.NumberFormat("ru-RU").format(num))
        },
        disableHightLightForReasons() {
            for (let i=1;i<6;i++) {
                let dailyRow = this.dzoMapping[this.selectedDzo.ticker].dailyReasonRow;
                let monthlyRow = this.dzoMapping[this.selectedDzo.ticker].monthlyReasonRow;
                let yearlyRow = this.dzoMapping[this.selectedDzo.ticker].yearlyReasonRow;
                for (let y = 0; y < 5; y++) {
                    let dailySelector = $('#factGrid').find('div[data-col="'+ i + '"][data-row="' + (dailyRow + y) + '"]');
                    let monthlySelector = $('#factGrid').find('div[data-col="'+ i + '"][data-row="' + (monthlyRow + y) + '"]');
                    let yearlySelector = $('#factGrid').find('div[data-col="'+ i + '"][data-row="' + (yearlyRow + y) + '"]');
                    this.removeClassFromElement(dailySelector,'cell__color-red');
                    this.removeClassFromElement(monthlySelector,'cell__color-red');
                    this.removeClassFromElement(yearlySelector,'cell__color-red');
                }
            }
        },
        async getSummaryPlanByDzo(type) {
            let uri = this.localeUrl("/get-plan-by-import-form");
            let queryParams = {
                'date': this.currentDateDetailed,
                'dzo': this.selectedDzo.ticker,
                'type': type
            };
            const response = await axios.get(uri,{params: queryParams});
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },
        async getSummaryFactByDzo(type) {
            let uri = this.localeUrl("/get-fact-by-import-form");
            let queryParams = {
                'date': this.currentDateDetailed,
                'dzo': this.selectedDzo.ticker,
                'type': type
            };
            const response = await axios.get(uri,{params: queryParams});
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },
        processTableData() {
            let self = this;
            _.forEach(Object.keys(this.cellsMapping), function(key) {
                if (self.inputDataCategories.includes(key)) {
                    self.processBlock(self.cellsMapping[key],key);
                } else {
                    self.processNumberCells(self.cellsMapping[key],key);
                }
            });
        },
        processBlock(block,category) {
            let self = this;
            _.forEach(Object.keys(block), function(key) {
                if (category === self.inputDataCategories[1]) {
                    self.processDecreaseReasonCells(block[key],category);
                } else if (category === self.inputDataCategories[2]) {
                    self.processFieldsBlock(block[key],category,key);
                } else {
                    self.processNumberCells(block[key],category);
                }
            });
        },
        processFieldsBlock(row,category,key) {
            let self = this;
            _.forEach(Object.keys(row), function(fieldName) {
                self.processNumberCells(row[fieldName],category,fieldName)
            });
        },
        processNumberCells(row,category,fieldCategoryName) {
            for (let columnIndex = 1; columnIndex <= row.rowLength; columnIndex++) {
                let selector = 'div[data-col="'+ columnIndex + '"][data-row="' + row.rowIndex + '"]';
                let cellValue = $(selector).text();
                cellValue = this.getFormattedNumber(cellValue);
                cellValue = parseFloat(cellValue);
                if ((isNaN(cellValue) || cellValue < 0) && this.requiredRows.includes(row.rowIndex)) {
                    this.turnErrorForCell(selector);
                    continue;
                }
                if (this.isNotNullRows[row.rowIndex] && this.isNotNullRows[row.rowIndex] === columnIndex && !(cellValue > 0)) {
                    this.turnErrorForCell(selector);
                    continue;
                }
                if (fieldCategoryName) {
                    this.setNumberValueForCategories(category,row.fields[columnIndex-1],cellValue,fieldCategoryName);
                } else if (category === this.inputDataCategories[0]) {
                    this.excelData[category][row.fields[columnIndex-1]] = cellValue;
                } else {
                    this.excelData[row.fields[columnIndex-1]] = cellValue;
                }
            }
        },
        setNumberValueForCategories(category,fieldName,cellValue,key) {
            if (key) {
                this.setFieldData(category,key,fieldName,cellValue);
            } else {
                this.excelData[category][fieldName] = cellValue;
            }
        },
        setFieldData(category,groupName,fieldName,cellValue) {
            if (!this.excelData[category][groupName]) {
                this.excelData[category][groupName] = {};
            }
            this.excelData[category][groupName][fieldName] = cellValue;
        },
        isNumberCellValid(inputData,selector) {
            if (inputData.trim().length > 0) {
                return this.isNumber(inputData);
            }
            return true;
        },
        isNumber(inputData) {
            return !isNaN(parseFloat(inputData)) && parseFloat(inputData) >= 0 && !this.isContainsLetter(inputData);
        },
        isContainsLetter(inputData) {
            let regExp = /[a-zA-Zа-яА-Я]/g;
            return inputData.match(regExp) !== null;
        },
        turnErrorForCell(selector) {
            this.setClassToElement($('#factGrid').find(selector),'cell__color-red');
            this.errorSelectors.push(selector);
            this.isValidateError = true;
        },
        processDecreaseReasonCells(row,category) {
            for (let columnIndex = 1; columnIndex <= row.rowLength; columnIndex++) {
                let selector = 'div[data-col="'+ columnIndex + '"][data-row="' + row.rowIndex + '"]';
                let cellValue = $(selector).text().trim();
                if (cellValue && !this.stringColumns.includes(columnIndex)) {
                    cellValue = this.getFormattedNumber(cellValue);
                }
                this.excelData[category][row.fields[columnIndex-1]] = cellValue;
            }
        },
        getFormattedNumber(cellValue) {
            cellValue = cellValue.replace(',', '.');
            return parseFloat(cellValue);
        },
        async handleSave() {
            let uri = this.localeUrl("/dzo-excel-form");
            this.excelData['date'] = this.currentDateDetailed;
            await this.storeData(uri);
            this.isDataReady = !this.isDataReady;
        },
        storeData(uri) {
            this.excelData['dzo_name'] = this.selectedDzo.ticker;
            let troubledCompanies = Object.keys(this.factorOptions);
            if (troubledCompanies.includes(this.selectedDzo.ticker)) {
                this.updateTroubledCompaniesByFactorOptions();
            }
            this.SET_LOADING(true);
            this.axios.post(uri, this.excelData)
                .then((response) => {
                    if (response.status === 200) {
                        this.showToast(this.trans("visualcenter.excelFormPlans.successfullySavedBody"), this.trans("visualcenter.excelFormPlans.saveTitle"), 'Success');
                        this.status = this.trans("visualcenter.importForm.status.dataSaved");
                    }
                    this.SET_LOADING(false);
                })
                .catch((error) => {
                    this.showToast(this.trans("visualcenter.excelFormPlans.fillFieldsBody"), this.trans("visualcenter.excelFormPlans.errorTitle"), 'danger');
                    this.SET_LOADING(false);
                });
        },

        updateTroubledCompaniesByFactorOptions() {
            let self = this;
            if (this.selectedDzo.ticker === 'ОМГ') {
                _.forEach(this.factorOptions[this.selectedDzo.ticker].fields, function(fieldName) {
                    self.excelData[fieldName] = self.factorOptions[self.selectedDzo.ticker].formula(self.excelData[fieldName]);
                });
            }
            if (this.selectedDzo.ticker === 'КТМ') {
                _.forEach(this.factorOptions[this.selectedDzo.ticker].fields, function(fieldName) {
                    let totalWaterFact = self.excelData['agent_upload_total_water_injection_fact'];
                    let albsenWaterFact = self.excelData['agent_upload_albsenomanian_water_injection_fact'];
                    self.excelData[fieldName] = self.factorOptions[self.selectedDzo.ticker].formula(totalWaterFact,albsenWaterFact);
                });
            }
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
    },
    components: {
        VGrid
    },
    mixins: [Visual,TodayDzoData,InputDataOperations,Archieve,Plans,CloseMonth],
};
