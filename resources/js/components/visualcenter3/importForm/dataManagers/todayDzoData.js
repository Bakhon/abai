export default {
    data: function () {
        return {
            todayData: {},
            fieldsCategory: 'fields',
            otherCategories: ['downtimeReason','decreaseReason'],
            tablesMapping: {
                'downtimeReason': 'import_downtime_reason',
                'decreaseReason': 'import_decrease_reason'
            }
        };
    },
    methods: {
        async getDzoTodayData() {
            let uri = this.localeUrl("/get-dzo-today-data") + '?dzoName=' + this.selectedDzo.ticker;
            const response = await axios.get(uri);
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
        beforeEdit(e) {
            console.log(e);
        },
    }
}