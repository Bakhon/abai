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
                    <div class="checkbox-inline pl-3">
                        <input id="show_full_history" type="checkbox">
                        <label for="show_full_history" class="pl-1">{{ trans('bd.show_full_history') }}</label>
                    </div>
                </div>
            </div>
            <div class="content-block-scrollable">
                <ProductionWellsScheduleItem
                    v-for="(well, index) in wells"
                    :well="well"
                    :key="index"
                    :isShowEvents="isShowEvents"
                />
            </div>
        </div>
    </div>
</template>
<script>
import ProductionWellsScheduleItem from "./ProductionWellsScheduleItem";
import vSelect from 'vue-select'
import axios from "axios";

export default {
    components: {
        vSelect,
        ProductionWellsScheduleItem
    },
    props: {
        mainWell: {}
    },
    data: function() {
        return {
            wells: [],
            options: [],
            isShowEvents: true
        }
    },
    methods: {
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
        selectWell(well) {
            this.options = [];
            this.wells.unshift(well)
        },
        removeWellSchedule(well) {
            this.wells.splice(
                this.wells.indexOf(well), 1
            );
        }
    },
    mounted() {
        this.wells.push(this.mainWell);
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
