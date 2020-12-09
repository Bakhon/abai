import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.esm.js'
import 'tableexport.jquery.plugin'
import 'bootstrap-select/dist/css/bootstrap-select.min.css';
import 'bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.css'
import 'bootstrap-table/dist/bootstrap-table.min.css'


export default {
    components: {
        BootstrapTable
    },
    data() {
        return {
            start_date: null,
            end_date: null,
            result: null,
            org: null,
            columns: [
                [
                    {
                        title: 'Месторождение',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'НГДУ',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'ЦДНГ',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'ГУ',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'Отвод',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'ЗУ/ГЗУ',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'Номер скважины',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'Год бурения',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'Горизонт',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'Блок',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'Действующие интервалы перфорации',
                        rowspan: 3,
                        align: 'center'
                    },
                    {
                        title: 'Факт с начала года',
                        colspan: 6,
                        align: 'center'
                    }
                ],
                [{
                    title: 'Техрежим',
                    colspan: 3,
                    align: 'center'
                },
                {
                    title: 'Qж, м3/сут',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Qн, т/сут',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Обв, %',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Дата исследования',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Заключение',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Hдин, м',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Pзатр, атм',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Pзаб, атм',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Pбуф, атм',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Pмакс.нагрузки, кг',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Отработанные дни',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Qн, т',
                    rowspan: 2,
                    align: 'center'
                }, {
                    title: 'Qж, м3',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Примечание',
                    colspan: 2,
                    align: 'center'
                },
                {
                    title: 'Кол-во ПРС',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Qж, м3/сут',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Qн, т/сут',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Обв, %',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Отработанные дни',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Qн, т',
                    rowspan: 2,
                    align: 'center'
                },
                {
                    title: 'Qж, м3',
                    rowspan: 2,
                    align: 'center'
                }
                ],
                [
                    {
                        title: 'Qж, м3/сут',
                        align: 'center'
                    },
                    {
                        title: 'Обв, %',
                        align: 'center'
                    },
                    {
                        title: 'Qн, т/сут',
                        align: 'center'
                    },
                    {
                        title: 'Пробы',
                        align: 'center'
                    },
                    {
                        title: 'Простои',
                        align: 'center'
                    },
                ],

            ],
            data: [],
            options: {
                // search: true,
                // pagination: true,
                showColumns: true,
                // showExport: true,
                // locale: 'ru-RU',
                // exportTypes: ['excel', 'csv'],
                // exportDataType: 'all',
                // visible: true
            }
        }
    },
    methods: {
        updateData() {
            let uri = '/ru/protodata';
            this.axios.post("/ru/protodata", {
                org: this.org,
                start_date: this.start_date,
                end_date: this.end_date
            })
                .then((response) => {
                    let data = response.data;
                    if (data) {
                        this.result = data,
                            this.generateTableData(data);
                    } else {
                        console.log("No data");
                    }
                });
        },
        onChange(event) {
            this.org = event.target.value;
        },
        generateTableHeader(row) {
            var months = [];
            row.forEach(element => {
                months.push(element.dt);
            });
            var reversed = months.reverse()
            reversed.forEach(element => {
                var obj = {
                    title: element,
                    // colspan: 19,
                    align: 'center'
                };
                this.columns[0].splice(11, 0, obj);
            });
            console.log(this.columns);
        },
        generateTableData(data) {
            this.generateTableHeader(data[Object.keys(data)[0]]);
            // for (const [key, value] of Object.entries(data)) {
            //     console.log(value);
            // }
        }
    },
}
