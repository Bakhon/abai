<template>
    <div class="page-wrapper">
        <div class="block-container row">
            <div class="col-12 header-title p-2">
                Таблица согласований операционных активов
            </div>
        </div>
        <div class="content-container">
            <div class="block-container row mt-10px">
                <div class="col-12 header-title row m-0 table-header">
                    <span class="col-3 p-2">Необходимо согласовать</span>
                    <span class="col-9 p-2">Список изменений</span>
                </div>
                <div class="col-4 menu-block">
                    <div class="header-title row m-0 mt-3">
                        <div
                                v-for="(item,index) in compared"
                                :class="[item.selected ? 'selected-company' : '', 'col-12 row approve-list p-2 mt-1']"
                                @click="selectCompany(item.dzoName,index)"
                        >
                            <span class="col-1 right-arrow mt-2 ml-4"></span>
                            <span class="col-3">
                                {{item.date}}
                            </span>
                            <span class="col-6">
                                {{dzoCompanies[item.dzoName]}}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-8 details-block">
                    <div class="header-title row m-0 mt-3">
                        <div
                                class="row change-list"
                                v-if="Object.keys(currentDzo).length > 0"
                        >
                            <span class="col-2 column-title">Исполнитель: </span>
                            <span class="column-parameter col-6">{{currentDzo.userName}}</span>
                            <div class="col-4 row">
                                <span class="col-5 menu__button m-1 button_approve">Согласовать</span>
                                <span class="col-5 menu__button m-1 button_decline">Отменить</span>
                            </div>
                            <span class="col-2 column-title">Причина: </span>
                            <span class="column-parameter col-10">{{currentDzo.reason}}</span>
                            <span class="col-12 header-title p-2">Планируемые изменения</span>
                            <div class="col-12 row p-1 m-0 table_header">
                                <span class="col-3">ДЗО/Месторождение</span>
                                <span class="col-5">Параметр</span>
                                <span class="col-2">Текущее значение</span>
                                <span class="col-2">Новое значение</span>
                            </div>
                            <div
                                    v-for="(item, name) in currentDzo.difference"
                                    class="row col-12 m-0 mt-1 p-1 difference-list"
                            >
                                <div v-if="name !== 'import_field'" class="col-12 row p-0 m-0">
                                    <span class="col-3 table_body">ДЗО</span>
                                    <span class="col-5 table_body">{{name}}</span>
                                    <span class="col-2 table_body">{{item.actualDetail}}</span>
                                    <span class="col-2 table_body">{{item.currentDetail}}</span>
                                </div>
                                <div
                                        v-else
                                        v-for="(value, name) in item"
                                        class="col-12 row m-0"
                                        v-if="Object.keys(value).length > 0"
                                >
                                    <span class="col-3 table_body">{{name}}</span>
                                    <div
                                            v-for="(field, fieldName) in value"
                                            class="col-9 table_body row m-0 p-0"
                                    >
                                        <span class="col-7 table_body">{{fieldName}}</span>
                                        <span class="col-3 table_body child-actual">{{field.actualDetail}}</span>
                                        <span class="col-2 table_body child-current">{{field.currentDetail}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
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
        }
    },
    methods: {
        selectCompany(dzoName,index) {
            _.forEach(this.compared, (item) => {
                _.set(item, 'selected', false);
            });
            if (this.compared[index]) {
                this.compared[index].selected = true;
                this.currentDzo = this.compared[index];
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
                    'selected': false
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
</script>

<style scoped lang="scss">
    .content-container {
        min-height: 878px;
        background: #272953;
    }
    .page-wrapper {
        font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
        position: relative;
        min-height: calc(100vh - 78px);
        color: white;
        text-align: center;
    }
    .block-container {
        background: #272953;
        flex-wrap: wrap;
        margin: 0;
    }
    .header-title {
        font-weight: bold;
        font-size: 20px;
        text-align: center;
    }
    .approve-list {

    }
    .approve-list:hover {
        background: #2E50E9;
        margin-left: 2px;
    }
    .selected-company {
        background: #2E50E9;
    }
    .right-arrow {
        background: url(/img/visualcenter3/right-arrow.png) no-repeat;
    }
    .change-list {
        text-align: left;
    }
    .column-title {
        font-size: 17px;
        font-weight: bold;
    }
    .column-parameter {
        font-size: 15px;
        font-weight: 100;
    }
    .table-header {
        border-bottom: 2px solid #808080;
    }
    .menu-block {
        min-height: 820px;
        border-right: 2px solid #808080;
    }
    .details-block {
        min-height: 820px;
    }
    .table_body {
        text-align: center;
        font-size: 15px;
        font-weight: 100;
    }
    .table_header {
        font-size: 17px;
        font-weight: bold;
        text-align: center;
        background: #333975;
    }
    .difference-list {
        color: black;
        &:nth-child(even) {
            background: #e6e6e6;
        }
        &:nth-child(odd){
            background: white;
        }
    }
    .child-actual {
        margin-left: -25px;
    }
    .child-current {
        margin-left: 15px;
    }
    .menu__button {
        font-weight: 500;
        cursor: pointer;
        border-radius: 8px;
        text-align: center;
        font-size: 15px;
    }
    .button_approve {
        background: #00b353;
    }
    .button_decline {
        background: #E31E24;
    }
</style>