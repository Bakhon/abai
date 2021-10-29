import moment from "moment-timezone";

export default {
    data: function () {
        return {
            monthColumns: [],
            monthRows: [],
            monthFact: [],
            outputFixed: [],
            isOutputValidateError: false,
            isOutputFilled: false,
            monthCompanies: [
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
                {
                    ticker: 'КГМ',
                    name: 'ТОО "СП "Казгермунай"'
                },
                {
                    ticker: 'АГ',
                    name: 'ТОО "Амангельды Газ"'
                },
                {
                    ticker: 'ПКК',
                    name: 'АО "ПетроКазахстан Кумколь Ресорсиз"'
                },
                {
                    ticker: 'ТП',
                    name: 'АО "Тургай-Петролеум"'
                },
                {
                    ticker: 'КПО',
                    name: 'Карачаганак Петролеум Оперейтинг б.в.'
                },
                {
                    ticker: 'НКО',
                    name: 'Норт Каспиан Оперейтинг Компани н.в.'
                },
                {
                    ticker: 'ПКИ',
                    name: 'АО "ПетроКазахстан Инк"'
                },
                {
                    ticker: 'ТШО',
                    name: 'ТОО "Тенгизшевройл"'
                },
            ],
            companiesWithCondensate: ['КОА','ОМГ','АГ'],
            companiesWithOil: ['КОА','ОМГ','ТШО','ПКИ','НКО','КПО','ТП','ПКК','КГМ','УО','ММГ','КБМ','КТМ','ЭМГ'],
            monthColumnsCount: 5,
            monthDate: moment()
        };
    },
    methods: {
        async getDzoFactByPeriod() {
            let uri = this.localeUrl("/get-plans-by-dzo");
            let queryOptions = {
                'dzo': this.selectedDzo.ticker,
                'year': this.currentPlan.year.year()
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
            }
            if (this.companiesWithCondensate.includes(this.selectedDzo.ticker)) {
                let currentIndex = Object.keys(header).length + 1;
                header['column'+(Object.keys(header).length + 1)] = 'Добыча конденсата';
                header['column'+(Object.keys(header).length + 1)] = 'Сдача конденсата';
            }
            this.monthColumnsCount = (Object.keys(header).length + 1);
            console.log(this.monthColumnsCount);
            console.log(header);
            this.monthRows.push(header);
            let currentDate = moment();
            let daysCount = currentDate.subtract(1,'days').date();
            if (currentDate.date() <= 10) {
                currentDate = currentDate.subtract(1,'month').startOf('month');
                daysCount = currentDate.daysInMonth();
            }

            for (let i=1;i<=daysCount;i++) {
                let row = {
                    'column1': currentDate.date(i).format('DD.MM.YYYY')
                };
                for (let y=2; y < this.monthColumnsCount; y++) {
                    row['column'+y] = 0;
                }
                //row['fieldName'] = this.planRows[y];
                this.monthRows.push(row);
            }
        },
        handlePlans() {
            for (let i=1;i<this.currentPlan.rows.length; i++) {
                let row = this.currentPlan.rows[i];
                for (let y=2;y<Object.keys(row).length;y++) {
                    let plan = this.plans.find(month => moment(month.date).month()+1 === y-1);
                    let daysCount = moment().year(this.currentPlan.year.year()).month(y-2).daysInMonth();
                    row['column'+y] = Math.round(plan[row['fieldName']] * daysCount);
                }
            }
        },
        validatePlan() {
            let systemColumns = ['column1', 'fieldName'];
            this.outputPlans = this.getValidatedPlan();
            if (this.isPlanValidateError) {
                this.isPlanFilled = false;
                this.showToast(this.trans("visualcenter.excelFormPlans.fillFieldsBody"), this.trans("visualcenter.excelFormPlans.errorTitle"), 'danger');
            } else {
                this.showToast(this.trans("visualcenter.excelFormPlans.saveBody"), this.trans("visualcenter.excelFormPlans.validateTitle"), 'Success');
                this.isPlanFilled = true;
            }
            this.isPlanValidateError = false;
        },

        getValidatedPlan() {
            let output = [];
            for (let i = 1; i < 13; i++) {
                let date = moment().year(this.currentPlan.year.year()).month(i - 1).startOf('month').startOf('day');
                let fields = {
                    date: date.format("YYYY-MM-DD HH:mm:ss"),
                    dzo: this.selectedDzo.ticker,
                };
                for (let y = 1; y < this.currentPlan.rows.length; y++) {
                    let row = this.currentPlan.rows[y];
                    let plan = row['column' + (i + 1)] / date.daysInMonth();
                    if (plan === 0) {
                        plan = null;
                    }
                    fields[row['fieldName']] = plan;
                }
                output.push(fields);
            }
            return output;
        },
        async savePlan() {
            let uri = this.localeUrl("/store-yearly-plans");
            let queryOptions = {
                'dzo': this.selectedDzo.ticker,
                'plans': this.outputPlans
            };
            await axios.post(uri, {params:queryOptions});
            this.isPlanFilled = false;
            this.showToast(this.trans("visualcenter.excelFormPlans.successfullySavedBody"), this.trans("visualcenter.excelFormPlans.saveTitle"), 'Success');
        },
        beforeMonthEdit(e) {
            let cell = e.detail;
            let rowIndex = cell.rowIndex;
            let colIndex = cell.prop.replace(/\D/g, "") - 1;
            let value = cell.val.replace(',','.');
            value = parseFloat(value);
            this.disableErrorHighlight(rowIndex,colIndex);
            if (isNaN(value) || value < 0) {
                this.setClassToElement($('#planGrid').find('div[data-row="' + rowIndex + '"][data-col="' + colIndex + '"]'),'cell__color-red');
                this.isPlanValidateError = true;
            }
        },
        beforeMonthRangeEdit(e) {
            let cellOptions = e.detail.data;
            if (!cellOptions) {
                return;
            }
            let row = parseInt(Object.keys(cellOptions)[0]);
            let column = Object.keys(cellOptions[row]);
            let columnName = Object.keys(cellOptions[row]).toString();
            column = column.toString().replace(/\D/g, "") - 1;
            let value = Object.values(cellOptions[row])[0];
            value = value.replace(/ /g, '');
            value = value.replace(',', '.');
            value = parseFloat(value);
            this.disableErrorHighlight(row,column);
            if (isNaN(value) || value < 0) {
                this.setClassToElement($('#planGrid').find('div[data-row="' + row + '"][data-col="' + column + '"]'),'cell__color-red');
                this.isPlanValidateError = true;
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
        }
    }
}
