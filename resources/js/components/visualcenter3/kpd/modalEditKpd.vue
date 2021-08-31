<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalKpdEdit"
                draggable=".modal-bign-header"
                :width="700"
                :height="580"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">{{kpd.name}}</div>
                    <div class="btn-toolbar">
                        <button type="button" class="modal-bign-button" @click="$modal.hide('modalKpdEdit')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="edit-block row mt-2">
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Наименование КПД</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.name">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Описание</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.description">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Ед. измерения</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.unit">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Полярность</div>
                        <div class="col-7 d-flex justify-content-center">
                            <div
                                    :class="[polaritySelected.isGrowth ? 'polarity_selected' : 'polarity_not-selected','indicator-growth px-4']"
                                    @click="switchPolarity('isGrowth')"
                            ></div>
                            <div
                                    :class="[polaritySelected.isFall ? 'polarity_selected' : 'polarity_not-selected','indicator-fall px-4']"
                                    @click="switchPolarity('isFall')"
                            ></div>
                        </div>
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Формула расчета</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.formula">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Переменные</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.variables">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Источник данных</div>
                        <select class="input_kpd p-2 col-7" @change="kpd.current.source = $event.target.value">
                            <option v-for="source in sourceDictionary" :value="source">
                                {{source}}
                            </option>
                        </select>
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Ответственные за достоверность</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.responsible">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Функции</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.functions">
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div class="status__red" v-if="status.length > 0">{{status}}</div>
                </div>
                <div class="d-flex justify-content-center mt-1">
                    <button type="button" class="modal-button_save mr-2" @click="store">
                        {{trans('kpd_tree.save')}}
                    </button>
                    <button type="button" class="modal-button_delete mr-2" @click="$modal.show('modalKpdEdit')">
                        {{trans('kpd_tree.delete')}}
                    </button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            kpd: {
                'name': 'Редактирование КПД',
                current: {
                    name: '',
                    description: '',
                    unit: '',
                    polarity: '',
                    formula: '',
                    variables: '',
                    source: '',
                    responsible: '',
                    functions: '',
                    type: 3
                }
            },
            sourceDictionary: [
                'Протокол СД',
                'Протокол КИП'
            ],
            polaritySelected: {
                isGrowth: false,
                isFall: false
            },
            status: ''
        };
    },
    methods: {
        switchPolarity(type) {
            Object.keys(this.polaritySelected).forEach((i) => this.polaritySelected[i] = false);
            this.polaritySelected[type] = true;
            this.kpd.current.polarity = type;
        },
        async store() {
            let uri = this.localeUrl("/kpd-tree-catalog-store");
            this.kpd.current.polarity = this.kpd.current.polarity.replace('is','').toLowerCase();
            this.axios.post(uri, this.kpd.current).then((response) => {
                if (response.status === 200) {
                    this.$modal.hide('modalKpdEdit')
                } else {
                    this.status = 'Ошибки при сохранении. Проверьте данные!';
                }
            });

        }
    },
    mounted() {
        this.kpd.current.source = this.sourceDictionary[0];
    },
    props: ['kpdList'],
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal-button_save {
    border: none;
    outline: none;
    background: #2d995b;
    color: white;
    font-weight: normal;
    font-size: 16px;
    width: 100px;
    border-radius: 8px;
}
.modal-button_delete {
    border: none;
    outline: none;
    background: #C82333;
    color: white;
    font-weight: normal;
    font-size: 16px;
    width: 100px;
    border-radius: 8px;
}
.edit-block {

}
.status__red {
    color: #C82333;
}
.input_kpd {
    background: #1A1D46;
    color: white;
    border-radius: 5px;
    border: none;
    width: 100%;
}
.indicator-growth {
    background: url(/img/visualcenter3/green-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
}

.indicator-fall {
    background: url(/img/visualcenter3/red-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
}
.polarity_selected {
    filter: brightness(150%);
}
.polarity_not-selected {
    filter: brightness(50%);
}
</style>