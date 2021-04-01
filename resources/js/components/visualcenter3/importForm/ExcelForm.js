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

export default {
    data: function () {
        let defaultDzoTicker = "ЕМГ";
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
                "ЕМГ" : {
                    rows: initialRowsEMG,
                    format: formatMappingEMG,
                    cells: cellsMappingEMG,
                    id: 113
                },
            },
            dzoCompanies: [
                {
                    ticker: 'ЕМГ',
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
            chemistryDataMapping: {
                demulsifier: this.trans("visualcenter.chemProdZakackaDemulg"),
                bactericide: this.trans("visualcenter.chemProdZakackaBakteracid"),
                corrosion_inhibitor: this.trans("visualcenter.chemProdZakackaIngibatorKorrozin"),
                scale_inhibitor: this.trans("visualcenter.chemProdZakackaIngibatorSoleotloj"),
            },
            chemistryErrorFields: [],
        };
    },
    props: ['userId'],
    async mounted() {
        this.selectedDzo.ticker = this.getDzoTicker();
        if (!this.selectedDzo.ticker) {
            this.selectedDzo.ticker = defaultDzoTicker;
        }
        this.changeDefaultDzo();
        this.dzoPlans = await this.getDzoMonthlyPlans();
        this.selectedDzo.plans = this.getSelectedDzoPlans();
        await this.sleep(2000);
        this.setTableFormat();
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
                    self.processStringCells(block[key],category);
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
                let cellValue = parseFloat($(selector).text());
                if (!this.isNumberCellValid(cellValue,selector)) {
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
            if (isNaN(inputData) || inputData < 0) {
                return false;
            }
            return true;
        },
        turnErrorForCell(selector) {
            this.setClassToElement($(selector),'cell__color-red');
            this.errorSelectors.push(selector);
            this.isValidateError = true;
        },
        processStringCells(row,category) {
            for (let columnIndex = 1; columnIndex <= row.rowLength; columnIndex++) {
                let selector = 'div[data-col="'+ columnIndex + '"][data-row="' + row.rowIndex + '"]';
                let cellValue = $(selector).text().trim();
                if (this.isStringCell(columnIndex) && this.checkErrorsStringCell(cellValue,selector)) {
                    this.excelData[category][row.fields[columnIndex-1]] = cellValue;
                    continue;
                }
                if (!this.isNumberCellValid(cellValue,selector)) {
                    this.turnErrorForCell(selector);
                    continue;
                }
                this.setNumberValueForCategories(category,row.fields[columnIndex-1],cellValue);
            }
        },
        isStringCell(rowIndex) {
            return this.stringColumns.includes(rowIndex);
        },
        checkErrorsStringCell(cellValue,selector) {
          if (!this.isStringCellValid(cellValue,selector)) {
              this.turnErrorForCell(selector);
              return false;
          }
          return true;
        },
        isStringCellValid(inputData,selector) {
            if (!inputData || typeof(inputData) === 'number' || inputData.length < 6) {
                return false;
            }
            return true;
        },
        async handleSave() {
            await this.storeData();
            this.isDataReady = !this.isDataReady;
        },
        storeData() {
            this.excelData['dzo_name'] = this.selectedDzo.ticker;
            this.excelData['date'] = moment().format("YYYY-MM-DD HH:mm:ss");

            let uri = this.localeUrl("/dzo_excel_form");

            this.axios.post(uri, this.excelData).then((response) => {
                if (response.status === 200) {
                    this.status = this.trans("visualcenter.importForm.status.dataSaved");
                } else {
                    this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                }
            });
        },
        beforeRangeEdit(e) {
            this.setTableFormat();
            this.isDataExist = true;
        },
    },
    components: {
        VGrid,
    },
    mixins: [Visual],
};