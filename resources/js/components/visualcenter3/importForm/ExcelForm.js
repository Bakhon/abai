import VGrid from "@revolist/vue-datagrid";
import initialRowsKOA from './dzoData/initial_rows_koa.json';
import initialRowsKTM from './dzoData/initial_rows_ktm.json';
import initialRowsKBM from './dzoData/initial_rows_kbm.json';
import initialRowsKGM from './dzoData/initial_rows_kgm.json';
import initialRowsMMG from './dzoData/initial_rows_mmg.json';
import initialRowsOMG from './dzoData/initial_rows_omg.json';
import initialRowsYO from './dzoData/initial_rows_yo.json';
import initialRowsEMG from './dzoData/initial_rows_emg.json';
import formatMappingKOA from './dzoData/format_mapping_koa.json';
import formatMappingKTM from './dzoData/format_mapping_ktm.json';
import formatMappingKBM from './dzoData/format_mapping_kbm.json';
import formatMappingKGM from './dzoData/format_mapping_kgm.json';
import formatMappingMMG from './dzoData/format_mapping_mmg.json';
import formatMappingOMG from './dzoData/format_mapping_omg.json';
import formatMappingYO from './dzoData/format_mapping_yo.json';
import formatMappingEMG from './dzoData/format_mapping_emg.json';
import cellsMappingKOA from './dzoData/cells_mapping_koa.json';
import cellsMappingKTM from './dzoData/cells_mapping_ktm.json';
import cellsMappingKBM from './dzoData/cells_mapping_kbm.json';
import cellsMappingKGM from './dzoData/cells_mapping_kgm.json';
import cellsMappingMMG from './dzoData/cells_mapping_mmg.json';
import cellsMappingOMG from './dzoData/cells_mapping_omg.json';
import cellsMappingYO from './dzoData/cells_mapping_yo.json';
import cellsMappingEMG from './dzoData/cells_mapping_emg.json';
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
                    }
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
                    }
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
                    }
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
                    }
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
                    }
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
                    }
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
                    }
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
                    ticker: 'ОМГ',
                    name: 'АО "ОзенМунайГаз"'
                },
                {
                    ticker: 'УО',
                    name: 'ТОО "Урихтау Оперейтинг"'
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
                'ОМГ': {
                    'fields': [
                        'natural_gas_production_fact',
                        'natural_gas_delivery_fact',
                        'associated_gas_production_fact',
                        'associated_gas_delivery_fact',
                        'agent_upload_total_water_injection_fact',
                        'agent_upload_seawater_injection_fact',
                        'agent_upload_waste_water_injection_fact'],
                    'formula': (value) => value * 1000
                }
            },
            dzoUsers: [],
            requiredRows: 0,
            isNotNullRows: {}
        };
    },
    props: ['userId'],
    async mounted() {
        this.SET_LOADING(true);
        this.dzoUsers = Object.keys(this.dzoMapping).map(k => this.dzoMapping[k].id);
        let currentDayNumber = moment().date();
        if (this.daysWhenChemistryNeeded.includes(currentDayNumber)) {
            this.isChemistryButtonVisible = true;
            this.$modal.show('additionalParamsReminder');
        }
        this.selectedDzo.ticker = this.getDzoTicker();
        if (!this.selectedDzo.ticker) {
            this.selectedDzo.ticker = defaultDzoTicker;
        }
        this.planRows = _.cloneDeep(this.planDzoMapping[this.selectedDzo.ticker]);
        this.fillPlanColumns();
        this.fillPlanRows();
        this.plans = await this.getDzoPlans();
        this.handlePlans();
        this.fillMonthColumns();
        this.fillMonthRows();
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
        handleValidate() {
            this.isValidateError = false;
            this.isDataReady = false;
            this.turnOffErrorHighlight();
            this.processTableData();
            if (!this.isValidateError) {
                this.isDataExist = false;
                this.isDataReady = true;
                this.status = this.trans("visualcenter.importForm.status.dataValid");
                this.showToast(this.trans("visualcenter.excelFormPlans.saveBody"), this.trans("visualcenter.excelFormPlans.validateTitle"), 'Success');
            } else {
                this.showToast(this.trans("visualcenter.excelFormPlans.fillFieldsBody"), this.trans("visualcenter.excelFormPlans.errorTitle"), 'danger');
                this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
            }
            if (this.dzoFieldsMapping[this.selectedDzo.ticker] && !this.isValidSummary(this.dzoFieldsMapping[this.selectedDzo.ticker])) {
                this.status = this.trans("visualcenter.importForm.status.verifySumByDzo");
            }
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

            this.axios.post(uri, this.excelData)
                .then((response) => {
                    if (response.status === 200) {
                        this.showToast(this.trans("visualcenter.excelFormPlans.successfullySavedBody"), this.trans("visualcenter.excelFormPlans.saveTitle"), 'Success');
                        this.status = this.trans("visualcenter.importForm.status.dataSaved");
                    }
                })
                .catch((error) => {
                    this.showToast(this.trans("visualcenter.excelFormPlans.fillFieldsBody"), this.trans("visualcenter.excelFormPlans.errorTitle"), 'danger');
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
