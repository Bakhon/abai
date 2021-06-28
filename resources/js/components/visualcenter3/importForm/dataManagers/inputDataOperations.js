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
            errors: {
                'isSumByDzoEmpty': false
            }
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
        addListeners() {
            let self = this;
            document.querySelector('revo-grid').addEventListener('keyup', function(e) {
                self.rows[self.currentCellOptions.rowIndex]['column' + self.currentCellOptions.columnIndex] = e.target.value;
                self.refreshGridData();
                self.isDataExist = true;
                self.isDataReady = false;
            });
            document.querySelector('revo-grid').addEventListener('dblclick', function(e) {
                self.currentCellOptions.rowIndex = parseInt(e.target.dataset.row);
                self.currentCellOptions.columnIndex = parseInt(e.target.dataset.col) + 1;
            });
            document.querySelector('revo-grid').addEventListener('click', function(e) {
                self.currentCellOptions.rowIndex = parseInt(e.target.dataset.row);
                self.currentCellOptions.columnIndex = parseInt(e.target.dataset.col) + 1;
            });
        },
        refreshGridData() {
            document.querySelector('revo-grid').refresh('all');
        },

        formatCategoryByType(event,category,type) {
            if (event.target) {
                let value = this.getFormattedNumber(event.target.value);
                this[category][type] = value
            }
        },

        validateSummaryByOptions(options) {
            for (let i in options) {
                let fieldName = options[i];
                if (this.excelData[fieldName] === null) {
                   this.isFactSumValid(fieldName);
                }
                if (this.errors.isSumByDzoEmpty) {
                    return;
                }
            }
        },

        isFactSumValid(fieldName) {
            let factByFields = this.getSumByFields(fieldName);
            this.errors.isSumByDzoEmpty = factByFields > 0;
            return factByFields;
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