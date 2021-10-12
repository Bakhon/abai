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
                    cells: planCellEmg,
                    id: 113,
                },
            },
            planColumns: [],
            planRows: _.cloneDeep(planRowEmg),
            planCellsMapping: _.cloneDeep(planCellEmg),
         //   planRowsFormatMapping: _.cloneDeep(planFormatEmg.rowsFormatMapping),
          //  planColumnsFormatMapping: _.cloneDeep(planFormatEmg.columnsFormatMapping),
            plans: [],
            currentPlan: {
                rows: [],
                cells: _.cloneDeep(planCellEmg),
                columns: [],
                year: moment().year()
            },
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
            let firstRow = {
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
            this.currentPlan.rows.push(firstRow);
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
                    let daysCount = moment().year(this.currentPlan.year).month(y-1).daysInMonth();
                    row['column'+y] = Math.round(plan[row['fieldName']] * daysCount);
                }
            }
        }
    },
    computed: {

    }
}
