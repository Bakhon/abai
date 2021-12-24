<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalManagers"
                draggable=".modal-bign-header"
                :width="900"
                :height="600"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">Список Директоров</div>
                    <div class="btn-toolbar">
                        <button
                                type="button"
                                :class="[selectedType === 'manager' ? 'button__selected' : '','modal-bign-button mr-2 button-width__150']"
                                @click="switchManagerType('manager')"
                        >
                            Члены Правления
                        </button>
                        <button
                                type="button"
                                :class="[selectedType === 'deputy' ? 'button__selected' : '','modal-bign-button mr-2 button-width__150']"
                                @click="switchManagerType('deputy')"
                        >
                            Заместители
                        </button>
                        <button type="button" class="modal-bign-button mr-2" @click="[selectedManager = {},$modal.show('modalManager')]">
                            Добавить
                        </button>
                        <button type="button" class="modal-bign-button" @click="$modal.hide('modalManagers')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="row text-left" v-for="manager in managers">
                    <div class="col-12 row p-2 pl-5">
                        <div class="col-8">{{manager.name}}</div>
                        <button type="button" class="modal-button_add col-2" @click="[selectManager(manager),$modal.show('modalManager')]">
                            Управление
                        </button>
                    </div>
                </div>
            </div>
        </modal>
        <modal-manager ref="userCreation" :manager-info="selectedManager"></modal-manager>
    </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            managers: [],
            selectedManager: {},
            selectedType: 'manager'
        };
    },
    methods: {
        async getManagers(type) {
            let uri = this.localeUrl("/get-kpd-managers");
            const response = await axios.get(uri,{params:{'type':type}});
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        selectManager(manager) {
            this.selectedManager = manager;
        },
        async switchManagerType(type) {
            this.selectedType = type;
            this.managers = await this.getManagers(type);
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
    },
    async mounted() {
        this.managers = await this.getManagers(this.selectedType);
        console.log(this.managers);
        this.$watch(
            () => {
                return this.$refs.userCreation.isOperationFinished
            },
            async (status) => {
                if (status) {
                    this.managers = await this.getManagers(this.selectedType);
                }
            }
        );
    },
    props: ['type'],
    watch: {
        type: async function () {
            this.SET_LOADING(true);
            this.selectedType = this.type;
            this.managers = await this.getManagers(this.selectedType);
            this.SET_LOADING(false);
        },
    }
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal-button_add {
    border: none;
    background: #2d995b;
    color: white;
    border-radius: 8px;
}
.button__disabled {
    pointer-events: none;
    opacity: 0.4;
}
.button__selected {
    background: #009900;
}
.button-width__150 {
    width: 150px;
}
</style>