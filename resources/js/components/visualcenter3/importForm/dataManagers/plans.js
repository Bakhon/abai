import moment from "moment-timezone";
import planRowEmg from "../dzoData/plan_rows_emg.json";
import planRowYo from "../dzoData/plan_rows_yo.json";
import planRowKbm from "../dzoData/plan_rows_kbm.json";
import planRowKoa from "../dzoData/plan_rows_koa.json";
import planRowKtm from "../dzoData/plan_rows_ktm.json";
import planRowMmg from "../dzoData/plan_rows_mmg.json";
import planRowOmg from "../dzoData/plan_rows_omg.json";
import planRowKgm from "../dzoData/plan_rows_kgm.json";
import planRowAg from "../dzoData/plan_rows_ag.json";
import planRowPkk from "../dzoData/plan_rows_pkk.json";

export default {
    data: function () {
        return {
            planDzoMapping : {
                "КОА" : planRowKoa,
                "КТМ" : planRowKtm,
                "КБМ" : planRowKbm,
                "ММГ" : planRowMmg,
                "ОМГ" : planRowOmg,
                "УО" : planRowYo,
                "ЭМГ" : planRowEmg,
                "КГМ" : planRowKgm,
                "АГ" : planRowAg,
                "ПКК" : planRowPkk,
                "ТП" : planRowPkk,
                "КПО" : planRowPkk,
                "НКО" : planRowPkk,
                "ПКИ" : planRowPkk,
                "ТШО" : planRowPkk,
            },
            planColumns: [],
            planRows: _.cloneDeep(planRowEmg),
            plans: [],
            currentPlan: {
                rows: [],
                cells: [],
                columns: [],
                year: moment()
            },
            outputPlans: [],
            isPlanValidateError: false,
            isPlanFilled: false,
            planCompanies: [
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
        };
    },
    methods: {
        async getDzoPlans() {
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
        fillPlanColumns() {
            for (let i=1;i<=13;i++) {
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
                this.currentPlan.columns.push(column);
            }
        },
        fillPlanRows() {
            this.currentPlan.rows = [];
            let header = {
                "column1": "Показатель",
                "column2": 'Январь',
                "column3": 'Февраль',
                "column4": 'Март',
                "column5": 'Апрель',
                "column6": 'Май',
                "column7": 'Июнь',
                "column8": 'Июль',
                "column9": 'Август',
                "column10": 'Сентябрь',
                "column11": 'Октябрь',
                "column12": 'Ноябрь',
                "column13": 'Декабрь',
            };
            this.currentPlan.rows.push(header);
            for (let y in this.planRows) {
                let row = {
                    'column1': y
                }
                for (let i=2;i<=13;i++) {
                    row['column'+i] = 0;
                }
                row['fieldName'] = this.planRows[y];
                this.currentPlan.rows.push(row);
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
        beforePlanEdit(e) {
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
        beforeRangeEdit(e) {
            let cellOptions = e.detail.data;
            if (cellOptions) {
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
            }
        },
        disableErrorHighlight(row,col) {
            this.removeClassFromElement($('#planGrid').find('div[data-row="' + row + '"][data-col="' + col + '"]'),'cell__color-red');
        },
        async handleYearChange() {
            this.currentPlan.year = moment(this.currentPlan.year);
            this.SET_LOADING(true);
            this.plans = await this.getDzoPlans();
            if (this.plans.length > 0) {
                this.handlePlans();
            } else {
                this.fillPlanRows();
            }
            document.querySelector('#planGrid').refresh('all');
            this.SET_LOADING(false);
        },
        async switchDzo(e) {
            this.SET_LOADING(true);
            this.selectedDzo.ticker = e.target.value;
            this.selectedDzo.name = this.getCompanyName();
            this.planRows = _.cloneDeep(this.planDzoMapping[this.selectedDzo.ticker]);
            this.fillPlanRows();
            this.plans = await this.getDzoPlans();
            this.handlePlans();
            document.querySelector('#planGrid').refresh('all');
            this.SET_LOADING(false);
        },
        getCompanyName() {
            let dzoName = '';
            let self = this;
            _.forEach(this.planCompanies, function(dzo) {
                if (dzo.ticker === self.selectedDzo.ticker) {
                    dzoName = dzo.name;
                }
            });
            return dzoName;
        },
    },
    computed: {

    }
}
