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

const defaultDzoTicker = "КТМ";

export default {
    data: function () {
        return {
            dzoMapping : {
                "КОА" : {
                    rows: initialRowsKOA,
                    format: formatMappingKOA,
                    cells: cellsMappingKOA,
                    id: 110
                },
                "КТМ" : {
                    rows: initialRowsKTM,
                    format: formatMappingKTM,
                    cells: cellsMappingKTM,
                    id: 107
                },
                "КБМ" : {
                    rows: initialRowsKBM,
                    format: formatMappingKBM,
                    cells: cellsMappingKBM,
                    id: 106
                },
                "КГМ" : {
                    rows: initialRowsKGM,
                    format: formatMappingKGM,
                    cells: cellsMappingKGM,
                    id: 108
                },
                "ММГ" : {
                    rows: initialRowsMMG,
                    format: formatMappingMMG,
                    cells: cellsMappingMMG,
                    id: 109
                },
                "ОМГ" : {
                    rows: initialRowsOMG,
                    format: formatMappingOMG,
                    cells: cellsMappingOMG,
                    id: 112
                },
                "УО" : {
                    rows: initialRowsYO,
                    format: formatMappingYO,
                    cells: cellsMappingYO,
                    id: 111
                },
                "ЭМГ" : {
                    rows: initialRowsEMG,
                    format: formatMappingEMG,
                    cells: cellsMappingEMG,
                    id: 113
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
                    name: 'АО "КАРАЖАНБАСМУНАЙ"'
                },
                {
                    ticker: 'КГМ',
                    name: 'ТОО СП "КАЗГЕРМУНАЙ"'
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
                name: 'ТОО "Казахтуркмунай"',
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
        };
    },
    props: ['userId'],
    async mounted() {
        let currentDayNumber = moment().date();
        if (this.daysWhenChemistryNeeded.includes(currentDayNumber)) {
            this.isChemistryButtonVisible = true;
        }
        this.selectedDzo.ticker = this.getDzoTicker();
        if (!this.selectedDzo.ticker) {
            this.selectedDzo.ticker = defaultDzoTicker;
        }
        if ( this.selectedDzo.ticker === 'КОА') {
            this.addColumnsToGrid();
        }

        this.selectedDzo.name = this.getDzoName();
        this.changeDefaultDzo();
        this.dzoPlans = await this.getDzoMonthlyPlans();
        this.selectedDzo.plans = this.getSelectedDzoPlans();
        await this.sleep(2000);
        this.setTableFormat();
        await this.updateCurrentData();
        this.addListeners();
    },
    methods: {
        addColumnsToGrid() {
            for (let i = 7; i < 9; i++) {
                this.columns.push(
                    {
                        prop: "column" + i,
                        size: 280,
                        cellProperties: ({prop, model, data, column}) => {
                            return {
                                style: {
                                    border: '1px solid #F4F4F6'
                                },
                            };
                        },
                    }
                );
            }
        },
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
            this.rowsFormatMapping = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].format.rowsFormatMapping);
            this.columnsFormatMapping = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].format.columnsFormatMapping);
            this.rowsCount = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].rows).length + 2;
            this.rows = _.cloneDeep(this.dzoMapping[this.selectedDzo.ticker].rows);
            await this.sleep(100);
            this.disableHighlightOnCells();
            this.setTableFormat();
        },
        async wellWorkoverSave() {
            if (parseFloat(this.wellWorkover.otm_well_workover_fact) > 0 && parseFloat(this.wellWorkover.otm_underground_workover) > 0) {
                await this.storeWellWorkoverData();
            }
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
            this.wellWorkover['date'] = moment().format("YYYY-MM-DD HH:mm:ss");
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
            this.chemistryData['date'] = moment().format("YYYY-MM-DD HH:mm:ss");

            let uri = this.localeUrl("/dzo_chemistry_excel_form");

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
            } else {
                this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
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
                if (!this.isNumberCellValid(cellValue,selector)) {
                    this.turnErrorForCell(selector);
                    continue;
                }
                if (cellValue.trim().length === 0) {
                    cellValue = null;
                }
                if (cellValue) {
                    cellValue = this.getFormattedNumber(cellValue);
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
            this.setClassToElement($(selector),'cell__color-red');
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
            await this.storeData();
            this.isDataReady = !this.isDataReady;
        },
        storeData() {
            this.excelData['dzo_name'] = this.selectedDzo.ticker;
            this.excelData['date'] = this.currentDateDetailed;

            let uri = this.localeUrl("/dzo_excel_form");

            this.axios.post(uri, this.excelData).then((response) => {
                if (response.status === 200) {
                    this.status = this.trans("visualcenter.importForm.status.dataSaved");
                } else {
                    this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                }
            });
        },
    },
    components: {
        VGrid,
    },
    mixins: [Visual,TodayDzoData,InputDataOperations],
};