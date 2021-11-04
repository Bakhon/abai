import moment from "moment-timezone";

export default {
    data: function () {
        return {
            monthColumns: [],
            monthRows: [],
            monthFact: [],
            companiesWithCondensate: ['КОА','ОМГ','АГ'],
            companiesWithOil: ['КОА','ОМГ','ТШО','ПКИ','НКО','КПО','ТП','ПКК','КГМ','УО','ММГ','КБМ','КТМ','ЭМГ'],
            monthColumnsCount: 5,
            monthDate: moment(),
            monthlyFact: [],
            factFieldsMapping: {},
            isMonthValidateError: false,
            isMonthFactFilled: false,
            changedRows: []
        };
    },
    methods: {
        async getDzoFactByPeriod() {
            let uri = this.localeUrl("/get-fact-by-month");
            let queryOptions = {
                'dzo': this.selectedDzo.ticker,
                'year': this.monthDate.year(),
                'month': this.monthDate.month()+1,
            };
            const response = await axios.get(uri, {params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },
        fillMonthColumns() {
            for (let i=1;i<=this.monthColumnsCount;i++) {
                let backgroundColor = '';
                let color = 'black';
                let size = 200;
                if (i === 1) {
                    backgroundColor = '#575975';
                    color = 'white';
                    size = 280;
                }
                let column = {
                    prop: "column"+i,
                    size: size,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6',
                                backgroundColor: backgroundColor,
                                color: color,
                                fontSize: '14px',
                                textAlign: 'center',
                                lineHeight: '30px'
                            },
                        };
                    },
                };
                this.monthColumns.push(column);
            }
        },
        fillMonthRows() {
            this.monthRows = [];
            let header = {
                "column1": "Дата"
            };
            if (this.companiesWithOil.includes(this.selectedDzo.ticker)) {
                header['column2'] = 'Добыча нефти';
                header['column3'] = 'Сдача нефти';
                this.factFieldsMapping['2'] = 'oil_production_fact';
                this.factFieldsMapping['3'] = 'oil_delivery_fact';

            }
            if (this.companiesWithCondensate.includes(this.selectedDzo.ticker)) {
                let currentIndex = Object.keys(header).length + 1;
                header['column'+(Object.keys(header).length + 1)] = 'Добыча конденсата';
                this.factFieldsMapping[Object.keys(header).length] = 'condensate_production_fact';
                header['column'+(Object.keys(header).length + 1)] = 'Сдача конденсата';
                this.factFieldsMapping[Object.keys(header).length] = 'condensate_delivery_fact';
            }
            this.monthColumnsCount = (Object.keys(header).length + 1);
            this.monthRows.push(header);
            let currentDate = moment();
            let daysCount = this.monthDate.daysInMonth();
            if (this.monthDate.date() > 10 && this.monthDate.month() === moment().month()) {
                daysCount = this.monthDate.clone().subtract(1,'days').date();
            } else if (this.monthDate.month() === moment().month()) {
                daysCount = moment().subtract(1,'days').date();
            }

            for (let i=1;i<=daysCount;i++) {
                let row = {
                    'column1': this.monthDate.clone().date(i).format('DD.MM.YYYY')
                };
                for (let y=2; y < this.monthColumnsCount; y++) {
                    row['column'+y] = 0;
                }
                this.monthRows.push(row);
            }
        },
        handleMonthFact() {
            for (let i=1;i<this.monthRows.length; i++) {
                let row = this.monthRows[i];
                let cellDate = moment(row['column1'],'DD.MM.YYYY');
                for (let y=2;y<=Object.keys(row).length;y++) {
                     let fact = this.monthlyFact.find(month => moment(month.date).date() === cellDate.date());
                     if (fact) {
                         row['column'+y] = fact[this.factFieldsMapping[y]];
                     }
                }
            }
        },
        validateMonthlyFact() {
            let systemColumns = ['column1'];
            this.monthFact = this.getValidatedMonthlyFact();
            if (this.isMonthValidateError) {
                this.isMonthFactFilled = false;
                this.showToast(this.trans("visualcenter.excelFormPlans.fillFieldsBody"), this.trans("visualcenter.excelFormPlans.errorTitle"), 'danger');
            } else {
                this.showToast(this.trans("visualcenter.excelFormPlans.saveBody"), this.trans("visualcenter.excelFormPlans.validateTitle"), 'Success');
                this.isMonthFactFilled = true;
            }
            this.isMonthValidateError = false;
        },

        getValidatedMonthlyFact() {
            let output = [];
            for (let row in this.monthRows) {
                if (row == 0 || !this.changedRows.includes(parseInt(row))) {
                    continue;
                }
                let correctedDate = this.monthRows[row].column1;
                let original = this.monthlyFact.find(obj => {
                    return moment(obj.date).format('DD.MM.YYYY') === correctedDate;
                });
                let fields = original;
                fields['user_name'] = this.userName;
                fields['user_position'] = this.userPosition;
                fields['change_reason'] = this.changeReason;
                fields['is_corrected'] = true;
                fields['is_approved'] = false;
                fields['toList'] = ['firstMaster','secondMaster','mainMaster'];
                delete fields.id;
                delete fields.created_at;
                delete fields.updated_at;
                for (let field in this.monthRows[row]) {
                    let columnIndex = field.replace(/\D/g, "");
                    if (this.factFieldsMapping[columnIndex]) {
                        fields[this.factFieldsMapping[columnIndex]] = this.monthRows[row][field];
                    }
                }
                output.push(fields);
            }
            return output;
        },
        async saveMonthlyFact() {
            let uri = this.localeUrl("/store-corrected-production");
            this.SET_LOADING(true);
            for (let i in this.monthFact) {
                await axios.post(uri, this.monthFact[i]);
            }
            this.SET_LOADING(false);
            this.isMonthFactFilled = false;
            this.showToast(this.trans("visualcenter.excelFormPlans.successfullySavedBody"), this.trans("visualcenter.excelFormPlans.saveTitle"), 'Success');
        },
        beforeMonthEdit(e) {
            let cell = e.detail;
            console.log(cell)
            let rowIndex = cell.rowIndex;
            this.changedRows.push(rowIndex);
            let colIndex = cell.prop.replace(/\D/g, "") - 1;
            let value = cell.val.replace(',','.');
            value = parseFloat(value);
            this.disableErrorHighlightByMonth(rowIndex,colIndex);
            console.log(value)
            if (isNaN(value) || value < 0) {
                this.setClassToElement($('#monthGrid').find('div[data-row="' + rowIndex + '"][data-col="' + colIndex + '"]'),'cell__color-red');
                this.isMonthValidateError = true;
            }
            e.detail.val = value;
        },
        beforeMonthRangeEdit(e) {
            let cellOptions = e.detail.data;
            if (!cellOptions) {
                return;
            }
            let row = parseInt(Object.keys(cellOptions)[0]);
            this.changedRows.push(row);
            let column = Object.keys(cellOptions[row]);
            let columnName = Object.keys(cellOptions[row]).toString();
            column = column.toString().replace(/\D/g, "") - 1;
            let value = Object.values(cellOptions[row])[0];
            value = value.replace(/ /g, '');
            value = value.replace(',', '.');
            value = parseFloat(value);
            this.disableErrorHighlightByMonth(row,column);
            if (isNaN(value) || value < 0) {
                this.setClassToElement($('#monthGrid').find('div[data-row="' + row + '"][data-col="' + column + '"]'),'cell__color-red');
                this.isMonthValidateError = true;
            }
            e.detail.data[row][columnName] = value;
        },
        disableErrorHighlightByMonth(row,col) {
            this.removeClassFromElement($('#monthGrid').find('div[data-row="' + row + '"][data-col="' + col + '"]'),'cell__color-red');
        },
        disableColumnHighlightByMonth() {
            for (let i=1; i <=this.monthColumnsCount; i++) {
                this.removeClassFromElement($('#monthGrid').find('div[data-col="'+ i + '"][data-row="0"]'),'cell-title');
            }
        },
        async handleMonthChange() {
            this.monthDate = moment(this.monthDate);
            this.SET_LOADING(true);
            this.monthlyFact = await this.getDzoFactByPeriod();
            this.fillMonthRows();
            if (this.monthlyFact.length > 0) {
                this.handleMonthFact();
            }
            document.querySelector('#monthGrid').refresh('all');
            this.SET_LOADING(false);
        },
    }
}
