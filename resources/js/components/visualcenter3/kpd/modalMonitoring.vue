<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalMonitoring"
                draggable=".modal-bign-header"
                :width="1700"
                :height="700"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header d-flex">
                    <img v-if="managerInfo" :src="'/img/kpd-tree/managers/' + managerInfo.avatar" class="manager-icon ml-5"></img>
                    <div v-if="managerInfo" class="modal-bign-title modal_header">{{managerInfo.name}}</div>
                    <button type="button" class="modal-bign-button" @click="$modal.hide('modalMonitoring')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <table class="modal_table mt-5">
                    <tr>
                        <th rowspan="2" class="p-2">№<br>п/п</th>
                        <th rowspan="2" class="p-2">Наименование КПД</th>
                        <th rowspan="2" class="p-2">Единица<br>измерения</th>
                        <th rowspan="2" class="p-2">Вес</th>
                        <th rowspan="2" class="p-2">
                            <div class="d-flex">
                                <div class="col-4">Порог<br>(50%)</div>
                                <div class="col-4">Цель<br>(100%)</div>
                                <div class="col-4">Вызов<br>(125%)</div>
                            </div>
                        </th>
                        <th colspan="4" class="p-2">Результаты</th>
                        <th rowspan="2" class="p-2">Комментарии</th>
                    </tr>
                    <tr>
                        <th class="p-2">Дата</th>
                        <th class="p-2">Факт</th>
                        <th class="p-2">Оценка<br>(баллы)</th>
                        <th class="p-2">Вклад<br>в суммарную<br>результативность</th>
                    </tr>
                    <tr v-for="(kpd,index) in kpdList">
                        <td class="p-2">{{index + 1}}</td>
                        <td class="p-2">{{kpd.name}}</td>
                        <td class="p-2">{{kpd.unit}}</td>
                        <td class="p-2">{{kpd.weight}}</td>
                        <td class="p-2">
                            <div class="col-12 p-0 row m-0">
                                <div class="col-12 d-flex justify-content-around p-0">
                                    <div class="col-3">
                                        <input :disabled="isPlanFilled(kpd.step)" class="input-field text-center p-1" type="text" v-model="kpd.step">
                                    </div>
                                    <div class="col-3">
                                        <input :disabled="isPlanFilled(kpd.target)" class="input-field text-center p-1" type="text" :value="kpd.target">
                                    </div>
                                    <div class="col-3">
                                        <input :disabled="isPlanFilled(kpd.maximum)" class="input-field text-center p-1" type="text" :value="kpd.maximum">
                                    </div>
                                </div>
                                <div class="mt-2 col-12 progress progress_template p-0 row m-0">
                                    <div
                                            :class="[getProgressBarFillingColor(30),'progress-bar progress-bar_filling']"
                                            :style="{width: 30 + '%',}"
                                            role="progressbar"
                                            :aria-valuenow="30"
                                            :aria-valuemin="kpd.step"
                                            :aria-valuemax="kpd.maximum"
                                    >
                                    </div>
                                    <div class="col-12 d-flex justify-content-around p-0">
                                        <div class="progress-splitter"></div>
                                        <div class="progress-splitter"></div>
                                        <div class="progress-splitter"></div>
                                    </div>
                                </div>
                                <div
                                        :style="{ 'padding-left': `${getCurrentFact(kpd.kpd_fact,kpd.maximum)}px` }"
                                        :class="[getProgressBarTitleColor(getCurrentFact(kpd.kpd_fact,kpd.maximum)),' mt-2 col-12 p-0']"
                                >
                                    {{getCurrentFact(kpd.kpd_fact,kpd.maximum)}}
                                </div>
                            </div>
                        </td>
                        <td class="p-2">
                            <el-date-picker
                                v-model="factDates[index].date"
                                type="date"
                                format="dd.MM.yyyy"
                                popper-class="custom-date-picker"
                                @input="changeFactDate($event,index,kpd.kpd_fact)"
                            >
                            </el-date-picker

                        </td>

                        <td class="p-2">
                            <input class="input-field text-center p-1" type="text" v-model="factDates[index].fact">
                        </td>
                        <td class="p-2">оценка</td>
                        <td class="p-2">вклад</td>
                        <td class="p-2">
                            <b-form-textarea
                                    class="col-12 text-left p-1 input_kpd"
                                    v-model="factDates[index].comments"
                                    rows="2"
                            ></b-form-textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>100%</td>
                        <td></td>
                        <td colspan="4">
                            Итоговая результативность
                            <span class="summary ml-4">74%</span>
                        </td>
                        <td></td>
                    </tr>
                </table>
                <div align="center" class="bottom-buttons col-12 row">
                    <div class="col-1 download-button m-4" @click="updateKpd">ОК</div>
                    <div class="col-1 cancel-button m-4" @click="$modal.hide('modalMonitoring')">Отмена</div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import moment from "moment-timezone";
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            kpdList: [],
            newKpdFact: {
                'date': moment(),
                'fact': '',
                'id': null,
                'comments': ''
            },
            factDates: []
        };
    },
    methods: {
        async getKpdList() {
            let uri = this.localeUrl("/get-kpd-by-manager");
            const response = await axios.get(uri,{params:{'type':this.managerInfo.id}});
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        async updateKpd() {
            _.forEach(this.factDates, (factDate, index) => {
               if (factDate.fact !== '') {
                   this.kpdList[index]['kpd_fact'].push(factDate);
               }
            });
            let uri = this.localeUrl("/store-updated-kpd");
            await axios.post(uri,this.kpdList);
            this.$modal.hide('modalMonitoring');
        },
        getProgressBarFillingColor(progress) {
            if (progress < 0) {
                return 'progress-bar_filling__low';
            } else if (progress <= 70) {
                return 'progress-bar_filling__medium';
            } else if (progress > 70) {
                return 'progress-bar_filling__high';
            }
        },
        getProgressBarTitleColor(progress) {
            if (progress < 0) {
                return 'progress-bar_title__low';
            } else if (progress <= 70) {
                return 'progress-bar_title__medium';
            } else if (progress > 70) {
                return 'progress-bar_title__high';
            }
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        getCurrentFact(facts,maximum) {
            let summary = 10;
            if (facts && facts.length > 0) {
                summary = _.sumBy(facts,'fact');
            }
            return summary;
        },
        isPlanFilled(plan) {
            return plan !== null;
        },
        changeFactDate(event,index,facts) {
            let filtered = _.filter(facts, (fact) => {
                return moment(fact.date).format('DD.MM.YYYY') === moment(event).format('DD.MM.YYYY');
            });
            if (filtered.length > 0) {
                if (filtered[0].fact === null) {
                    filtered[0].fact = '';
                }
                this.factDates[index].fact = _.cloneDeep(filtered[0].fact);
            } else {
                let newDate = _.cloneDeep(this.newKpdFact);
                newDate.date = moment(event);
                this.factDates[index] = newDate;
            }
        }
    },
    async mounted() {

    },
    props: ['managerInfo'],
    watch: {
        managerInfo: async function () {
            if (this.managerInfo) {
                this.SET_LOADING(true);
                this.kpdList = await this.getKpdList();
                _.forEach(this.kpdList, (kpd) => {
                   if (kpd.kpd_fact.length === 0) {
                       this.factDates.push(_.cloneDeep(this.newKpdFact));
                   } else {
                       let sorted = _.orderBy(kpd.kpd_fact, ['date'],['asc']);
                       this.factDates.push(_.cloneDeep(sorted.at(-1)));
                   }
                });
                this.SET_LOADING(false);
            }
        },
    }
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal_table {
    width: 100%;

    tr:first-child th {
        &:first-child {
            width: 60px;
        }
        &:nth-child(2) {
            width: 250px;
        }
        &:nth-child(3) {
            width: 100px;
        }
        &:nth-child(4) {
            width: 60px;
        }
        &:nth-child(5), &:nth-child(6) {
            width: 400px;
        }
    }
    tr:nth-child(2) th {
        width: 145px;
    }
    tr th {
        background: #3A4280;
        border: 1px solid #545580;
    }
    tr td {
        border: 1px solid #545580;
    }
    tr:last-child {
        td:not(:first-child){
            border: none;
            background: #3A4280;
        }
        td:not(:last-child){
            border: none;
            background: #3A4280;
        }
        td:first-child {
            border-left: 1px solid #545580;
        }
    }
    tr:nth-child(even) {
        background: #272953;
    }
    tr:nth-child(odd) {
        background: #2B2E5C;
    }
}
.download-button {
    background: #3366FF;
    border-radius: 5px;
}
.cancel-button {
    background: #40467E;
    border-radius: 5px;
}
.bottom-buttons {
    position: absolute;
    bottom: 0;
    justify-content: center;
    div {
        cursor: pointer;
    }
}
.manager-icon {
    height: 70px;
}
.summary {
    color: #FF8736;
    font-size: 20px;
}
.progress.progress_template {
    background-color: #A4A8BF !important;
    height: 2px !important;
}
.progress-bar_filling__low {
    background-color: #F12F42 !important;
    color: #F12F42 !important;
}
.progress-bar_filling__medium {
    background-color: #FF8736 !important;
    color: #FF8736 !important;
}
.progress-bar_filling__high {
    background-color: #009847 !important;
    color: #009847 !important;
}
.progress-bar_title__low {
    color: #F12F42 !important;
}
.progress-bar_title__medium {
    color: #FF8736 !important;
}
.progress-bar_title__high {
    color: #009847 !important;
}
.progress-splitter {
    width: 5px;
    height: 5px;
    background-color: #656A8A;
}
.input-field {
    background: #1A1D46;
    color: white;
    border-radius: 5px;
    border: none;
    width: 100%;
}
.input_kpd {
    background: #1A1D46;
    color: white;
    border-radius: 5px;
    border: none;
    width: 100%;
}
.not-visible {
    display: none;
}
</style>