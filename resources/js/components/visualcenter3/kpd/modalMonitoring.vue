<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalMonitoring"
                draggable=".modal-bign-header"
                :width="1700"
                :height="720"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header d-flex">
                    <img v-if="managerInfo" :src="'/img/kpd-tree/managers/' + managerInfo.avatar" class="manager-icon ml-5"></img>
                    <div v-if="managerInfo" class="modal-bign-title modal_header">{{managerInfo.title}}</div><br>
                    <button type="button" class="modal-bign-button" @click="$modal.hide('modalMonitoring')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <div class="modal-bign-header d-flex">
                    <div v-if="managerInfo" class="modal-bign-title modal_header">{{managerInfo.name}}</div>
                </div>
                <div class="scroll">
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
                            <td class="p-2">
                                <input v-if="!kpd.isWeightFilled" class="input-field text-center p-1" type="text" v-model="kpd.weight">
                                <div class="text-center p-1" v-else>{{kpd.weight}}</div>
                            </td>
                            <td class="p-2">
                                <div class="col-12 p-0 row m-0">
                                    <div class="col-12 d-flex justify-content-around p-0">
                                        <div class="col-3">
                                            <input v-if="!kpd.isPlanFilled" class="input-field text-center p-1" type="text" v-model="kpd.step">
                                            <div class="text-center p-1" v-else>{{kpd.step}}</div>
                                        </div>
                                        <div class="col-3">
                                            <input v-if="!kpd.isPlanFilled" class="input-field text-center p-1" type="text" v-model="kpd.target">
                                            <div class="text-center p-1" v-else>{{kpd.target}}</div>
                                        </div>
                                        <div class="col-3">
                                            <input v-if="!kpd.isPlanFilled" class="input-field text-center p-1" type="text" v-model="kpd.maximum">
                                            <div class="text-center p-1" v-else>{{kpd.maximum}}</div>
                                        </div>
                                    </div>
                                    <div class="progress-wrapper p-0 mt-2">
                                        <div class="progress-bar-kpd">
                                            <div class="kpd-bar">
                                                <div :class="[getProgressBarFillingColor(kpd),'kpd_height__3']" :style="{width: getCurrentPosition(kpd) + '%'}"></div>
                                            </div>
                                            <div :class="[getProgressBarFillingColor(kpd),'kpd-point']" :style="{left: getCurrentPosition(kpd,18)+ '%'}"></div>
                                            <div class="col-12 d-flex justify-content-around p-0">
                                                <div class="kpd-bullet"></div>
                                                <div class="kpd-bullet"></div>
                                                <div class="kpd-bullet"></div>
                                            </div>
                                        </div>
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
                            <td class="p-2">{{kpd.rating}}</td>
                            <td class="p-2">{{kpd.summary}}</td>
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
                            <td>{{totalWeight}}%</td>
                            <td></td>
                            <td></td>
                            <td colspan="2">
                                Итоговая результативность
                            </td>
                            <td class="summary ml-4">{{totalSummary}}%</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div align="center" class="bottom-buttons col-12 row">
                    <div class="col-1 download-button m-4" @click="updateKpd">Сохранить</div>
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
            factDates: [],
            isOperationFinished: false,
        };
    },
    methods: {
        async getKpdList() {
            let uri = this.localeUrl("/get-kpd-by-manager");
            let managerId = this.managerInfo.id;
            if (this.managerType === 'corporate') {
                managerId = this.managerType;
            }
            const response = await axios.get(uri,{params:{'type':managerId}});
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
            this.isOperationFinished = true;
            this.$modal.hide('modalMonitoring');
        },
        getProgressBarFillingColor(kpd) {
            let fact = parseFloat(kpd.fact);
            let step = parseFloat(kpd.step);
            let target = parseFloat(kpd.target);

            let isDate =false;
            if (kpd.step !== null && kpd.step !== '-') {
                isDate = kpd.step.includes('.');
            } else if (kpd.target !== null && kpd.target !== '-') {
                isDate = kpd.target.includes('.');
            } else if (kpd.maximum !== null && kpd.maximum !== '-') {
                isDate = kpd.maximum.includes('.');
            }
            if (isDate) {
                step = moment(kpd.step, 'DD.MM.YYYY').toDate().getTime();
                target = moment(kpd.target, 'DD.MM.YYYY').toDate().getTime();
            }

            if (fact < step) {
                return 'progress-bar_filling__low';
            } else if (fact >= step && fact < target) {
                return 'progress-bar_filling__medium';
            } else if (fact >= target) {
                return 'progress-bar_filling__high';
            }
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        getCurrentFact(facts,kpd) {
            let summary = 0;
            if (facts && facts.length > 0) {
                summary = _.sumBy(facts,'fact');
            }
            return summary * 100 / this.getMaximum(kpd);
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
        },
        getKpdEfficiency(step,target,maximum,fact) {
            step = parseFloat(step);
            target = parseFloat(target);
            maximum = parseFloat(maximum);
            fact = parseFloat(fact);
            if (isNaN(fact)) {
                return 0;
            }
            if ((fact < step) || (step === null || target === null || maximum === null || fact === null)) {
                return 5;
            }
            if (fact === step) {
                return 50;
            }
            if (fact > step && fact < target) {
                return (fact - step) / (target - step) * 50 + 50;
            }
            if (fact === target) {
                return 100;
            }
            if (fact > target && fact < maximum) {
                return (fact - target) / (maximum - target) * 25 + 100;
            }

            if (fact >= maximum) {
                return 125;
            }
        },
        getCurrentPosition(kpd) {
            let fact = parseFloat(kpd.fact);
            let step = parseFloat(kpd.step);
            let target = parseFloat(kpd.target);
            let maximum = parseFloat(kpd.maximum);
            let maximumKpd = this.getMaximum(kpd);
            let isDate = false;
            if (kpd.step !== null && kpd.step !== '-') {
                isDate = kpd.step.includes('.');
            } else if (kpd.target !== null && kpd.target !== '-') {
                isDate = kpd.target.includes('.');
            } else if (kpd.maximum !== null && kpd.maximum !== '-') {
                isDate = kpd.maximum.includes('.');
            }
            if (isDate) {
                step = moment(kpd.step, 'DD.MM.YYYY').toDate().getTime();
                target = moment(kpd.target, 'DD.MM.YYYY').toDate().getTime();
                maximum = moment(kpd.maximum, 'DD.MM.YYYY').toDate().getTime();
                maximumKpd = moment(maximumKpd, 'DD.MM.YYYY').toDate().getTime();
            }

            if (fact < step) {
                return fact * 10 / step;
            }
            let absolutePosition = 100;

            if (fact <= maximumKpd) {
                absolutePosition = absolutePosition - 18;
            }
            if (fact <= target) {
                absolutePosition = absolutePosition - 21;
            }
            if (isNaN(maximum)) {
                absolutePosition = absolutePosition - 42;
            }

            let position = fact * absolutePosition / maximumKpd;

            if (position > 100) {
                position = 100;
            }
            return position;
        },
        getMaximum(kpd) {
            if (kpd.maximum !== '-') {
                return kpd.maximum;
            }
            if (kpd.target !== '-') {
                return kpd.target;
            }
            return kpd.step;
        },
    },
    async mounted() {

    },
    props: ['managerInfo','managerType'],
    watch: {
        managerInfo: async function () {
            this.isOperationFinished = false;
            this.kpdList = [];
            this.factDates = [];
            if (this.managerInfo) {
                this.SET_LOADING(true);
                this.kpdList = await this.getKpdList();
                _.forEach(this.kpdList, (kpd,index) => {
                   if (kpd.kpd_fact.length === 0) {
                       this.factDates.push(_.cloneDeep(this.newKpdFact));
                   } else {
                       let sorted = _.orderBy(kpd.kpd_fact, ['date'],['asc']);
                       this.factDates.push(_.cloneDeep(sorted.at(-1)));
                   }
                   if (kpd.step !== '' && kpd.step !== null && kpd.target !== '' && kpd.target !== null && kpd.maximum !== '' && kpd.maximum !== null) {
                       kpd.isPlanFilled = true;
                   }
                   if (kpd.weight !== '' && kpd.weight !== null) {
                       kpd.isWeightFilled = true;
                   }
                   kpd.rating = Math.round(this.getKpdEfficiency(kpd.step,kpd.target,kpd.maximum,this.factDates[index].fact));
                   kpd.summary = kpd.rating * (kpd.weight / 100);

                   kpd['fact'] = _.sumBy(kpd.kpd_fact,  item => Number(item.fact));
                   if (isNaN(kpd['fact'])) {
                       kpd['fact'] = moment(kpd.kpd_fact.at(-1).fact,'DD.MM.YYYY').toDate().getTime();
                   }
                });
                
                this.SET_LOADING(false);
            }
        },
    },
    computed: {
        totalSummary() {
            return _.sumBy(this.kpdList, 'summary');
        },
        totalWeight() {
            return _.sumBy(this.kpdList,  item => Number(item.weight));
        }
    }
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.scroll {
    overflow-y: auto;
    max-height: 550px;
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
        &:nth-child(5), &:nth-child(6) {
            width: 400px;
        }
    }
    tr:nth-child(2) th {
        width: 148px;
    }
    tr th {
        background: #323370;
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
        background: #454D7D;
    }
    tr:nth-child(odd) {
        background: #272953;
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
//progress bar
.progress-wrapper{
    width: 400px;
}

.progress-bar-kpd {
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
}

.kpd-bar {
    position: absolute;
    top: 50%;
    left: 50%;
    background: #999;
    width: 100%;
    height: 3px;
    border-radius: 10px;
    transform: translate(-50%, -50%);
    overflow: hidden;

    &__fill {
        display: block;
        background: #00ADEF;
        height: 100%;
    }
}

.kpd-bullet {
    background: #999;
    width: 1px;
    height: 25px;
    transition: 0.3s ease;

    .point--complete &,
    .point--active & {
        background: #999;
    }
}
.kpd-point {
    position: absolute;
    z-index: 2;
    top: 7px;
    height: 10px;
    width: 10px;
    border-radius: 1.2em;
}
.kpd_height__3 {
    height: 3px;
}
</style>