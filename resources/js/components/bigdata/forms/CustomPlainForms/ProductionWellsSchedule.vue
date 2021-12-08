<template>
    <div>
        <div class="d-flex justify-content-begin align-items-center text-white p-1">
            <img class="arrow-back pr-3" src="/img/icons/arrow.svg" @click.stop="$emit('changeScheduleVisible')">
            <div>График оперативной информации</div>
        </div>
        <div class="main-block pb-2">
            <div class="d-flex justify-content-between align-items-center text-white p-2">
                <div class="d-flex">
                    <div>
                        <form class="search-form d-flex align-items-center">
                            <v-select
                                class="flex-fill"
                                :filterable="false"
                                :options="options"
                                placeholder="Поиск скважины"
                                @input="selectWell"
                                @search="onSearch"
                            >
                                <template slot="option" slot-scope="option">
                                    <span>{{ option.name }}</span>
                                </template>
                            </v-select>
                        </form>
                    </div>
                    <div v-for="well in wells" class="d-flex align-items-center pl-2 ml-1 wells-list-item">
                        <div>Скважина: {{ well.name }}</div>
                        <img class="cursor-pointer" @click.stop="removeWellSchedule(well)" src="/img/icons/close.svg" alt="">
                    </div>
                    <div class="d-flex align-items-center pl-3">
                        <img class="pr-1" src="/img/icons/page_to_form.svg" alt="">
                        <div>Cформировать</div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="checkbox-inline">
                        <input id="show_events" type="checkbox" :checked="isShowEvents" @change="toggleShowEvents">
                        <label for="show_events" class="pl-1">{{ trans('bd.show_events') }}</label>
                    </div>
                </div>
            </div>
            <div class="content-block-scrollable">
                <div  v-for="well in wells">
                    <ProductionWellsScheduleItem
                        v-if="well.category && well.category.name_ru === productionCategory && well.scheduleData"
                        :well="well"
                        :key="well.id"
                        :isShowEvents="isShowEvents"
                        :scheduleData="well.scheduleData"
                    />
                    <InjectionWellsScheduleItem
                        v-else-if="well.category && well.category.name_ru === injectionCategory && well.scheduleData"
                        :well="well"
                        :key="well.id"
                        :isShowEvents="isShowEvents"
                        :scheduleData="well.scheduleData"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ProductionWellsScheduleItem from "./ProductionWellsScheduleItem";
import InjectionWellsScheduleItem from "./InjectionWellsScheduleItem";
import vSelect from 'vue-select'
import axios from "axios";
import {globalloadingMutations} from '@store/helpers';
import moment from "moment";

export default {
    components: {
        vSelect,
        ProductionWellsScheduleItem,
        InjectionWellsScheduleItem
    },
    props: {
        mainWell: {}
    },
    data: function() {
        return {
            wells: [],
            options: [],
            isShowEvents: true,
            productionCategory: 'Нефтяная',
            injectionCategory: 'Нагнетательная',
            initialPeriod: 90
        }
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        toggleShowEvents() {
            this.isShowEvents = !this.isShowEvents;
        },
        onSearch(search, loading) {
            if (search.length) {
                loading(true);
                this.search(loading, search, this);
            }
        },
        search: _.debounce((loading, search, vm) => {
                axios.get(vm.localeUrl('/api/bigdata/wells/search'),
                    {
                        params: {
                            query: escape(search),
                            selectedUserDzo: vm.selectedUserDzo,
                        }
                    })
                    .then(({data}) => {
                        vm.options = data.items;
                        loading(false);
                    })
            },
            350
        ),
        async selectWell(well) {
            this.SET_LOADING(true);
            if (Object.keys(well).length > 0) {
                const response = await axios.get(this.localeUrl(`/api/bigdata/wells/${well.id}/wellInfo`));
                well['category'] = response.data.category_last;
            }
            this.options = [];
            this.wells.unshift(well);
            for (let i in this.wells) {
                let well = this.wells[i];
                this.wells[i]['scheduleData'] = await this.getScheduleData(well.id,well.category.name_ru);
            }
            this.SET_LOADING(false);
        },
        async getScheduleData(id,type) {
            let queryOptions = {
                'wellId': id,
                'period': this.initialPeriod,
                'type': type
            };
            const response = await axios.get(this.localeUrl('api/bigdata/wells/production-wells-schedule-data'),{params:queryOptions});
            if (type === this.injectionCategory) {
                return {
                    'data': [                     
                        response.data.liquidInjection,
                        response.data.liquidPressure,
                        response.data.events
                    ],
                    'labels': response.data.labels
                };
            } else {
                return {
                    'data': [
                        response.data.ndin,
                        response.data.measLiq,
                        response.data.oil,
                        response.data.measWaterCut,
                        response.data.events
                    ],
                    'labels': response.data.labels
                };
            }

            return {};
        },
        removeWellSchedule(well) {
            this.wells.splice(
                this.wells.indexOf(well), 1
            );
        }
    },
    async mounted() {
        this.SET_LOADING(true);
        this.mainWell['scheduleData'] = await this.getScheduleData(this.mainWell.id,this.mainWell.category.name_ru);
        this.wells.push(this.mainWell);
        this.SET_LOADING(false);
    }
}
</script>
<style lang="scss" scoped>
.main-block {
    background-color: rgba(51, 57, 117, 0.33);
}

.input-border {
    background-color: rgba(51, 57, 117, 1);
    border: 0.4px solid #656A8A;
    border-radius: 2px;
}

.input-border input {
    background-color: rgba(51, 57, 117, 1);
    border: none;
}

.arrow-back {
    transform: rotate(90deg);
}

::-webkit-scrollbar {
    height: 10px;
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #40467E;
}

::-webkit-scrollbar-thumb {
    background: #656A8A;
}

::-webkit-scrollbar-thumb:hover {
    background: #656A8A;
}

::-webkit-scrollbar-corner {
    background: #20274F;
}

.search-form {
    .v-select {
        background: url(/img/bd/search.svg) 20px 45% #272953 no-repeat;
        border: 1px solid #3b4a84;
        min-width: 12rem;

        .vs__search {
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-weight: 400;
            margin-top: 0;
            padding-left: 45px;
        }

        .vs__selected {
            font-family: Roboto, sans-serif;
            font-size: 14px;
            font-weight: 400;
            margin-top: 0;
            padding-left: 45px;
        }

        .vs__actions {
            padding: 0 5px;

            .vs__clear, .vs__open-indicator {
                display: none;
            }

            .vs__spinner, .vs__spinner:after {
                border-color: rgba(238, 238, 238, 0.7);
                border-left-color: rgba(170, 170, 170, 0.7);
            }
        }

        .vs__dropdown-toggle {
            border: none;
        }
    }
}

.content-block-scrollable {
    height: 70vh;
    overflow-y: scroll;
}

.wells-list-item {
    border-radius: 10px;
    border: 1px solid #3b4a84;
}
</style>
