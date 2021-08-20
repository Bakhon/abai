import moment from "moment";
import fieldsMapping from './fields_mapping.json';
import {globalloadingMutations} from '@store/helpers';
export default {
    data: function () {
        return {
            allProduction: [],
            difference: [],
            compared: [],
            systemFields: [
                'id',
                'is_corrected',
                'is_approved',
                'date',
                'user_name',
                'change_reason',
                'dzo_import_data_id',
                'is_approved_by_first_master',
                'is_approved_by_second_master'
            ],
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
            currentStatus: '',
            approvers: {
                'firstMaster': {
                    'name': 'Сенсізбай А. Н.',
                    'field': 'is_approved_by_first_master',
                    'isFinalApprove': false
                },
                'secondMaster': {
                    'name': 'Кенжебаев Н. Х.',
                    'field': 'is_approved_by_second_master',
                    'isFinalApprove': false
                },
                'mainMaster': {
                    'name': 'Кутжанов А.А.',
                    'field': 'is_approved',
                    'isFinalApprove': true
                }
            },
            statusTransition: [
                'visualcenter.dailyApprove.approve',
                'visualcenter.dailyApprove.approved'
            ],
        }
    },
    methods: {
        async approve(master) {
            let queryOptions = {
                'actualId': this.currentDzo.actualId,
                'currentId': this.currentDzo.currentId,
                'currentApproverField': master.field,
                'dzo_name': this.currentDzo.dzoName,
                'date': this.currentDzo.date,
                'user_name': this.currentDzo.userName,
                'change_reason': this.currentDzo.reason,
                'isFinalApprove': master.isFinalApprove
            };
            this.currentDzo.isProcessed = true;
            this.compared[this.currentDzo.index].isProcessed = true;
            this.currentStatus = this.trans("visualcenter.dailyApprove.approved")
            this.currentDzo = {};
            let uri = this.localeUrl("/approve-daily-correction", {params:queryOptions});
            await axios.get(uri,{params:queryOptions});
        },
        async decline() {
            let queryOptions = {
                'currentId': this.currentDzo.currentId,
                'dzo_name': this.currentDzo.dzoName,
                'date': this.currentDzo.date,
                'user_name': this.currentDzo.userName,
                'change_reason': this.currentDzo.reason,
            };
            this.currentDzo.isProcessed = true;
            this.compared[this.currentDzo.index].isProcessed = true;
            this.currentStatus = this.trans("visualcenter.dailyApprove.cancelled");
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
                if (Object.keys(actual).length === 0) {
                    return;
                }
                let approve = {
                    'date': date,
                    'dzoName': approveItem.dzo_name,
                    'userName': approveItem.user_name,
                    'reason': approveItem.change_reason,
                    'selected': false,
                    'currentId': approveItem.id,
                    'actualId': actual.id,
                    'isFirstMasterApproved': approveItem.is_approved_by_first_master,
                    'isSecondMasterApproved': approveItem.is_approved_by_second_master,
                    'firstMasterApproveTranslation': this.statusTransition[0],
                    'secondMasterApproveTranslation': this.statusTransition[0],
                };
                if (approve.isFirstMasterApproved) {
                    approve.firstMasterApproveTranslation = this.statusTransition[1]
                }
                if (approve.isSecondMasterApproved) {
                    approve.secondMasterApproveTranslation = this.statusTransition[1]
                }
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
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
    },
    async mounted() {
        this.SET_LOADING(true);
        this.allProduction = await this.getForApprove();
        this.compared = this.getCompared();
        this.SET_LOADING(false);
    }
}