import VGrid from "@revolist/vue-datagrid";
import initialRowsKOA from './dzoData/initial_rows_koa.json';
import initialRowsKTM from './dzoData/initial_rows_ktm.json';
import fieldsMapping from './dzoData/fields_mapping.json';
import formatMappingKOA from './dzoData/format_mapping_koa.json';
import formatMappingKTM from './dzoData/format_mapping_ktm.json';
import cellsMappingKOA from './dzoData/cells_mapping_koa.json';
import cellsMappingKTM from './dzoData/cells_mapping_ktm.json';
import moment from "moment";
import Visual from "./data_managers/visual";

const defaultDzoTicker = "KOA";
const dzoMapping = {
    "KOA" : {
        rows: initialRowsKOA,
        format: formatMappingKOA,
        cells: cellsMappingKOA
    },
    "KTM" : {
        rows: initialRowsKTM,
        format: formatMappingKTM,
        cells: cellsMappingKTM
    },
};

export default {
    data: function () {
        return {
            dzoCompanies: [
                {
                    ticker: 'KOA',
                    name: 'ТОО "Казахойл Актобе"'
                },
                {
                    ticker: 'KTM',
                    name: 'ТОО "Казахтуркмунай"'
                },
            ],
            status: this.trans("visualcenter.importForm.status.waitForData"),
            rows: _.cloneDeep(dzoMapping[defaultDzoTicker].rows),
            isDataExist: false,
            isDataReady: false,
            dzoPlans: [],
            selectedDzo: {
                ticker: defaultDzoTicker,
                plans: [],
            },
            currentMonthNumber: moment().format('M'),
            cellsMapping: _.cloneDeep(dzoMapping[defaultDzoTicker].cells),
            rowsFormatMapping: _.cloneDeep(dzoMapping[defaultDzoTicker].format.rowsFormatMapping),
            columnsFormatMapping: _.cloneDeep(dzoMapping[defaultDzoTicker].format.columnsFormatMapping),
            excelData: {
                downtimeReason: {},
                decreaseReason: {},
                fields: {}
            },
            isValidateError: false,
            inputDataCategories: ['downtimeReason','decreaseReason','fields'],
        };
    },
    async mounted() {
        this.dzoPlans = await this.getDzoMonthlyPlans();
        this.selectedDzo.plans = this.getSelectedDzoPlans();
        await this.sleep(1500);
        this.setTableFormat();
    },
    methods: {
        dzoChange($event) {
            let dzoTicker = $event.target.value;
            this.selectedDzo.ticker = dzoTicker;
            this.cellsMapping = _.cloneDeep(dzoMapping[dzoTicker].cells);
            this.rowsFormatMapping = _.cloneDeep(dzoMapping[dzoTicker].format.rowsFormatMapping);
            this.columnsFormatMapping = _.cloneDeep(dzoMapping[dzoTicker].format.columnsFormatMapping);
            this.rows = _.cloneDeep(dzoMapping[dzoTicker].rows);
            this.rowsCount = this.rows.length + 2;
        },
        chemistrySave() {
            this.status = this.trans("visualcenter.importForm.status.dataSaved");
            this.isChemistryNeeded = !this.isChemistryNeeded;
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
                this.setClassToElement($(selector),'cell__color-red');
                this.errorSelectors.push(selector);
                this.isValidateError = true;
                return false;
            }
            return true;
        },
        processStringCells(row,category) {
            for (let columnIndex = 1; columnIndex <= row.rowLength; columnIndex++) {
                let selector = 'div[data-col="'+ columnIndex + '"][data-row="' + row.rowIndex + '"]';
                let cellValue = $(selector).text().trim();
                if (this.isStringCell(columnIndex) && this.isStringCellValid(cellValue,selector)) {
                    this.excelData[category][row.fields[columnIndex-1]] = cellValue;
                    continue;
                }
                if (!this.isNumberCellValid(cellValue,selector)) {
                    continue;
                }
                this.setNumberValueForCategories(category,row.fields[columnIndex-1],cellValue);
            }
        },
        isStringCell(rowIndex) {
            return this.stringColumns.includes(rowIndex);
        },
        isStringCellValid(inputData,selector) {
            if (!inputData || typeof(inputData) === 'number' || inputData.length < 3) {
                this.setClassToElement($(selector),'cell__color-red');
                this.errorSelectors.push(selector);
                this.isValidateError = true;
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