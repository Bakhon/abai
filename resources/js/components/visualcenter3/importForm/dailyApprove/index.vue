<template>
    <div class="page-wrapper">
        <div class="block-container row">
            <div class="col-12 header-title p-2">
                Таблица согласований операционных активов
            </div>
        </div>
        <div class="block-container row mt-10px">
            <div class="col-4 header-title">
                Необходимо согласовать
            </div>
            <div class="col-8 header-title">
                Список изменений
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
            systemFields: ['id','is_corrected','is_approved','date','user_name','change_reason','dzo_import_data_id']
        }
    },

    methods: {
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
                    'reason': approveItem.change_reason
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
                    difference[currentKey] = this.getChildDifference(current[currentKey],actual[currentKey]);
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
            let difference = [];
            _.forEach(Object.keys(current), (currentKey) => {
                if (this.systemFields.includes(currentKey)) {
                    return;
                }
                let currentDetail = current[currentKey];
                let actualDetail = actual[currentKey];
                if (currentDetail !== actualDetail) {
                    difference.push({
                        'currentDetail':  currentDetail,
                        'actualDetail': actualDetail,
                        'field': currentKey
                    });
                }
            });
            return difference;
        },
        getChildFields(currentFields, actualFields) {
            let difference = [];
            _.forEach(currentFields, (field, index) => {
                difference.push({
                    name: field['field_name'],
                    fields: this.getChildDifference(field,actualFields[index])
                });
            });
            return difference;
        }
    },
    async mounted() {
        this.allProduction = await this.getForApprove();
        console.log(this.allProduction);
        this.compared = this.getCompared();
        console.log(this.compared);
    }
}
</script>

<style scoped>
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
    }
</style>