export default {
    data: function () {
        return {
            currentCellOptions: {
                rowIndex: 0,
                columnIndex: 0
            },
            dzoFieldsMapping: {
                'ЭМГ': [
                    'oil_production_fact',
                    'oil_delivery_fact',
                    'condensate_production_fact',
                    'condensate_delivery_fact',
                    'stock_of_goods_delivery_fact',
                    'natural_gas_production_fact',
                    'natural_gas_delivery_fact',
                    'natural_gas_expenses_for_own_fact',
                    'natural_gas_processing_fact',
                    'natural_gas_flaring_fact',
                    'associated_gas_production_fact',
                    'associated_gas_delivery_fact',
                    'associated_gas_expenses_for_own_fact',
                    'associated_gas_processing_fact',
                    'associated_gas_flaring_fact',
                    'agent_upload_total_water_injection_fact',
                    'agent_upload_seawater_injection_fact',
                    'agent_upload_waste_water_injection_fact',
                    'agent_upload_albsenomanian_water_injection_fact',
                    'agent_upload_stream_injection_fact',
                    'otm_wells_commissioning_from_drilling_fact',
                    'otm_drilling_fact'
                ],
            },
        };
    },
    methods: {
        async pasteClipboardContent() {
            let clipText = await navigator.clipboard.readText();
            let clipRows = clipText.split(String.fromCharCode(13));

            for (let i = 0; i < clipRows.length; i++) {
                clipRows[i] = clipRows[i].split(String.fromCharCode(9));
            }

            if (clipRows.length < 40) {
                this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                return;
            }
            let self = this;
            _.forEach(this.rows, function (row,index) {
                self.setColumnValues(row,clipRows,index);
            });
            this.refreshGridData();
            this.isDataExist = true;
        },
        setColumnValues(row,clipRows,rowIndex) {
          _.forEach(Object.keys(row), function(key) {
              let colIndex = parseInt(key.replace(/\D+/g, '')) - 1;
              row[key] = clipRows[rowIndex][colIndex];
          });
        },
        beforeRangeEdit(e) {
            this.setTableFormat();
            this.isDataExist = true;
            this.isDataReady = false;
        },
        beforeEdit(e) {
            let cell = e.detail;
            console.log(cell)
            let rowIndex = cell.rowIndex;
            let colIndex = cell.prop.replace(/\D/g, "") - 1;
            let value = cell.val.replace(',','.');
            value = parseFloat(value);
            this.disableErrorHighlight(rowIndex,colIndex);
            if (isNaN(value) || value < 0) {
                this.setClassToElement($('#factGrid').find('div[data-row="' + rowIndex + '"][data-col="' + colIndex + '"]'),'cell__color-red');
                this.isPlanValidateError = true;
            }
        },
        addListeners() {
            let self = this;
            document.querySelector('#factGrid').addEventListener('keyup', function(e) {
                self.rows[self.currentCellOptions.rowIndex]['column' + self.currentCellOptions.columnIndex] = e.target.value;
                self.refreshGridData();
                self.isDataExist = true;
                self.isDataReady = false;
            });
        },
        beforeFocus(e) {
            let cell = e.detail;
            let rowIndex = cell.rowIndex;
            let colIndex = cell.prop.replace(/\D/g, "");
            this.currentCellOptions.rowIndex = rowIndex;
            this.currentCellOptions.columnIndex = colIndex;
        },
        refreshGridData() {
            if (document.querySelector('#factGrid')) {
                document.querySelector('#factGrid').refresh('all');
            }
        },

        formatCategoryByType(event,category,type) {
            let value = 0;
            if (event.target) {
                value = this.getFormattedNumber(event.target.value);
            }
            if (isNaN(value)) {
                value = 0;
            }
            this[category][type] = value;
        },

        isValidSummary(options) {
            for (let i in options) {
                let fieldName = options[i];
                if (this.excelData[fieldName] === null) {
                    let factByFields = this.getSumByFields(fieldName);
                    if (factByFields > 0) {
                        return false;
                    }
                }
            }
            return true;
        },

        getSumByFields(fieldName) {
            let totalFact = 0;
            _.forEach(this.excelData.fields, function(field) {
                totalFact += field[fieldName];
            });
            return totalFact;
        }
    }
}