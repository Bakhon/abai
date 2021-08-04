import moment from "moment";
import fieldsMapping from './fields_mapping.json';
export default {
    data: function () {
        return {
            allProduction: [],
            difference: [],
            compared: [],
            systemFields: ['id','is_corrected','is_approved','date','user_name','change_reason','dzo_import_data_id'],
            dzoCompanies: {
                'ЭМГ': 'АО "Эмбамунайгаз"',
                'КОА': 'ТОО "Казахойл Актобе"',
                'КТМ': 'ТОО "Казахтуркмунай"',
                'КБМ': 'АО "КАРАЖАНБАСМУНАЙ"',
                'ММГ': 'АО "Мангистаумунайгаз"',
                'ОМГ': 'АО "ОзенМунайГаз"',
                'УО': 'ТОО "Урихтау Оперейтинг"',
            },
            currentDzo: {},
            names: fieldsMapping,
            currentStatus: ''
        }
    },
    methods: {
        async approve() {
            let queryOptions = {'actualId': this.currentDzo.actualId, 'currentId': this.currentDzo.currentId};
            console.log(queryOptions);
            this.currentDzo.processed = true;
            this.compared[this.currentDzo.index].processed = true;
            this.currentStatus = 'Согласовано';
            this.currentDzo = {};
            let uri = this.localeUrl("/approve-daily-correction", {params:queryOptions});
            await axios.get(uri,{params:queryOptions});
        },
        async decline() {
            let queryOptions = {'currentId': this.currentDzo.currentId};
            this.currentDzo.processed = true;
            this.compared[this.currentDzo.index].processed = true;
            this.currentStatus = 'Отменено';
            this.currentDzo = {};
            let uri = this.localeUrl("/decline-daily-correction", {params:queryOptions});
            await axios.get(uri,{params:queryOptions});
        },
        selectCompany(dzoName,index) {
            _.forEach(this.compared, (item) => {
                _.set(item, 'selected', false);
            });
            if (this.compared[index]) {
                this.compared[index].selected = true;
                this.currentDzo = this.compared[index];
                this.currentDzo.index = index;
            }
        },
        async getForApprove() {
            let uri = this.localeUrl("/get-daily-production-for-approve");
            const response = await axios.get(uri);
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },
        getCompared() {
            let compared = [];
            _.forEach(this.allProduction.forApprove, (approveItem) => {
                let date = moment(approveItem.date).startOf('day').format('DD.MM.YYYY');
                let actual = this.getActual(approveItem.dzo_name,date);
                let approve = {
                    'date': date,
                    'dzoName': approveItem.dzo_name,
                    'userName': approveItem.user_name,
                    'reason': approveItem.change_reason,
                    'selected': false,
                    'currentId': approveItem.id,
                    'actualId': actual.id
                };
                approve.difference = this.getDifference(approveItem,actual);
                compared.push(approve);
            });
            return compared;
        },
        getActual(dzoName,approveDate) {
            let actualIndex = this.allProduction.actual.findIndex((item) => {
                let date = moment(item.date).startOf('day').format('DD.MM.YYYY');
                return date === approveDate && dzoName === item.dzo_name;
            });
            if (actualIndex > -1) {
                return this.allProduction.actual[actualIndex];
            }
            return {};
        },
        getDifference(current, actual) {
            let difference = {};
            _.forEach(Object.keys(current), (currentKey) => {
                if (['import_decrease_reason','import_downtime_reason'].includes(currentKey)) {
                    let childDifference = this.getChildDifference(current[currentKey],actual[currentKey]);
                    difference = {...difference, ...childDifference};
                } else if (currentKey === 'import_field') {
                    difference[currentKey] = this.getChildFields(current[currentKey],actual[currentKey]);
                } else if (this.systemFields.includes(currentKey)) {
                    return;
                } else {
                    if (current[currentKey] !== actual[currentKey]) {
                        difference[currentKey] = {
                            currentDetail: current[currentKey],
                            actualDetail: actual[currentKey]
                        };
                    }
                }
            });
            return difference;
        },
        getChildDifference(current, actual) {
            let difference = {};
            _.forEach(Object.keys(current), (currentKey) => {
                if (this.systemFields.includes(currentKey)) {
                    return;
                }
                let currentDetail = current[currentKey];
                let actualDetail = actual[currentKey];
                if (currentDetail !== actualDetail) {
                    difference[currentKey] = {
                        'currentDetail':  currentDetail,
                        'actualDetail': actualDetail,
                    };
                }
            });
            return difference;
        },
        getChildFields(currentFields, actualFields) {
            let difference = {};
            _.forEach(currentFields, (field, index) => {
                difference[field['field_name']] = this.getChildDifference(field,actualFields[index]);
            });
            return difference;
        }
    },
    async mounted() {
        this.allProduction = await this.getForApprove();
        this.compared = this.getCompared();
    }
}