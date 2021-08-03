import initialRowsKOA from "../dzoData/initial_rows_koa.json";

export default {
    data: function () {
        return {
            todayData: {},
            fieldsCategory: 'fields',
            otherCategories: ['downtimeReason','decreaseReason'],
            tablesMapping: {
                'downtimeReason': 'import_downtime_reason',
                'decreaseReason': 'import_decrease_reason'
            },
            currentChemistry: {},
            currentOtm: {},
            todayDataOptions: {
                otm: {
                    url: this.localeUrl("/get-dzo-current-otm"),
                    name: 'wellWorkover'
                },
                chemistry: {
                    url: this.localeUrl("/get-dzo-current-chemistry"),
                    name: 'chemistryData'
                },
            }
        };
    },
    methods: {
        async updateCurrentData() {
            let self = this;
            _.forEach(Object.keys(this.todayDataOptions), async function(key) {
                let uri = self.todayDataOptions[key]['url'] + '?dzoName=' + self.selectedDzo.ticker;
                let inputData = await self.getCurrentData(uri);
                if (Object.keys(inputData).length > 0) {
                    let dataset = self[self.todayDataOptions[key]['name']];
                    self.processCurrentData(inputData,dataset);
                }
            });
            let queryOptions = {
                'dzoName': this.selectedDzo.ticker,
                'isCorrected': false,
            };
            this.todayData = await this.getDzoTodayData(queryOptions);
            this.processTodayData();
        },
        async getCurrentData(uri) {
            const response = await axios.get(uri);
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },
        async processCurrentData(inputData,localData) {
            _.forEach(Object.keys(localData), function(key) {
                localData[key] = inputData[key];
            });
        },
        async getDzoTodayData(queryOptions) {
            let uri = this.localeUrl("/get-dzo-today-data");
            const response = await axios.get(uri, {params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },
        processTodayData() {
            if (Object.keys(this.todayData).length === 0) {
                return;
            }
            this.isDataExist = true;
            let self = this;
            _.forEach(Object.keys(this.cellsMapping), function (key) {
                if (self.otherCategories.includes(key)) {
                    self.processCategory(self.cellsMapping[key],key);
                } else if (key == self.fieldsCategory) {
                    self.processFieldsCategory(self.cellsMapping[key],key);
                } else {
                    self.processDataBlock(self.cellsMapping[key]);
                }
            });
            document.querySelector('revo-grid').refresh('all');
        },
        processCategory(categoryBlock,categoryName) {
            let self = this;
            let mappedCategoryName = this.tablesMapping[categoryName];
            _.forEach(categoryBlock, function (block) {
                self.processDataBlock(block,categoryName,_.cloneDeep(self.todayData[mappedCategoryName]));
            });
        },
        processDataBlock(block,categoryName,formattedTodayData) {
            let self = this;
            _.forEach(block.fields, function(fieldName, index) {
                if (!categoryName && !formattedTodayData) {
                    self.setDataToTable(self.todayData[fieldName],block.rowIndex,(index + 2));
                } else {
                    self.setDataToTable(formattedTodayData[fieldName],block.rowIndex,(index + 2));
                }
            });
        },
        setDataToTable(cellValue, rowIndex, columnIndex) {
            this.rows[rowIndex]['column' + columnIndex] = cellValue;
        },
        processFieldsCategory(categoryBlock,categoryName) {
            let self = this;
            _.forEach(categoryBlock, function (block) {
                self.processFields(block,categoryName);
            });
        },
        processFields(fieldsBlock,categoryName) {
            let self = this;
            _.forEach(Object.keys(fieldsBlock), function (key) {
                self.processDataBlock(fieldsBlock[key],categoryName,self.todayData[categoryName][key]);
            });
        },
    }
}