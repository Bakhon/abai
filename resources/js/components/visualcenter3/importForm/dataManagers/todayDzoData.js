export default {
    data: function () {
        return {
            todayData: {}
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
            let self = this;
            console.log(this.todayData)
            _.forEach(Object.keys(this.cellsMapping), function(key) {
                if (self.inputDataCategories.includes(key)) {
                    //process decrease, downtime, fields
                } else {
                    self.processDataBlock(self.cellsMapping[key]);
                }
            });
        },
        processDataBlock(block) {
            let self = this;
            _.forEach(block.fields, function(fieldName, index) {
                self.setDataToTable(self.todayData[fieldName],block.rowIndex,(index + 1));
            });
        },
        setDataToTable(cellValue, rowIndex, columnIndex) {
            let selector = $('div[data-col="'+ columnIndex + '"][data-row="' + rowIndex + '"]');
            selector.text(cellValue);
        },
    }
}