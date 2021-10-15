import moment from "moment-timezone";
import planCellEmg from "../dzoData/plan_cells_mapping_emg.json";
import planRowEmg from "../dzoData/plan_rows_emg.json";
//import planFormatEmg from "../dzoData/plan_format_mapping_emg.json";


export default {
    data: function () {
        return {
            planDzoMapping : {
                "КОА" : {
                    rows: [],
                    format: [],
                    cells: [],
                    id: 110
                },
                "КТМ" : {
                    rows: [],
                    format: [],
                    cells: [],
                    id: 107
                },
                "КБМ" : {
                    rows: [],
                    format: [],
                    cells: [],
                    id: 106
                },
                "КГМ" : {
                    rows: [],
                    format: [],
                    cells: [],
                    id: 108
                },
                "ММГ" : {
                    rows: [],
                    format: [],
                    cells: [],
                    id: 109
                },
                "ОМГ" : {
                    rows: [],
                    format: [],
                    cells: [],
                    id: 112
                },
                "УО" : {
                    rows: [],
                    format: [],
                    cells: [],
                    id: 111
                },
                "ЭМГ" : {
                    rows: planRowEmg,
                  //  format: planFormatEmg,
                  //  cells: planCellEmg,
                    id: 113,
                },
            },
            planColumns: [],
            planRows: _.cloneDeep(planRowEmg),
          //  planCellsMapping: _.cloneDeep(planCellEmg),
         //   planRowsFormatMapping: _.cloneDeep(planFormatEmg.rowsFormatMapping),
          //  planColumnsFormatMapping: _.cloneDeep(planFormatEmg.columnsFormatMapping),
            plans: [],
            currentPlan: {
                rows: [],
                cells: [],
                columns: [],
                year: moment().year()
            },
            outputPlans: [],
            isPlanValidateError: false,
            isPlanFilled: false
        };
    },
    methods: {
        async getDzoPlans() {
            let uri = this.localeUrl("/get-plans-by-dzo");
            let queryOptions = {
                'dzo': this.selectedDzo.ticker,
                'year': this.currentPlan.year
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
                    row['column'+i] = "5";
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
                    let daysCount = moment().year(this.currentPlan.year).month(y-2).daysInMonth();
                    row['column'+y] = Math.round(plan[row['fieldName']] * daysCount);
                }
            }
        },
        validatePlan() {
            let systemColumns = ['column1', 'fieldName'];
            let output = [];
            for (let i = 1; i < 13; i++) {
                let date = moment().year(this.currentPlan.year).month(i - 1).startOf('month').startOf('day');
                let fields = {
                    date: date.format(),
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
            this.outputPlans = output;
            if (this.isPlanValidateError) {
                this.isPlanFilled = false;
                this.showToast('Пожалуйста, заполните все поля. Разрешено вводить только числовые значения, либо 0.', 'Ошибка!', 'danger');
            } else {
                this.showToast('Нажмите "Сохранить" для продолжения.', 'Проверено!', 'Success');
                this.isPlanFilled = true;
            }
            this.isPlanValidateError = false;
        },
        async savePlan() {
            let uri = this.localeUrl("/store-yearly-plans");
            let queryOptions = {
                'dzo': this.selectedDzo.ticker,
                'plans': this.outputPlans
            };
            await axios.post(uri, {params:queryOptions});
            this.isPlanFilled = false;
            this.showToast('Данные успешно сохранены.', 'Сохранено!', 'Success');
        },
        beforePlanEdit(e) {
            let cell = e.detail;
            let rowIndex = cell.rowIndex;
            let colIndex = cell.prop.replace(/\D/g, "") - 1;
            let value = cell.val.replace(',','.');
            value = parseFloat(value);
            this.disableErrorHighlight(rowIndex,colIndex);
            if (isNaN(value)) {
                this.setClassToElement($('#planGrid').find('div[data-row="' + rowIndex + '"][data-col="' + colIndex + '"]'),'cell__color-red');
                this.isPlanValidateError = true;
            }
        },
        disableErrorHighlight(row,col) {
            this.removeClassFromElement($('#planGrid').find('div[data-row="' + row + '"][data-col="' + col + '"]'),'cell__color-red');
        }
    },
    computed: {

    }
}
