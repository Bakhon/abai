<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalCatalog"
                draggable=".modal-bign-header"
                :width="1500"
                :height="800"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">{{catalog.name}}</div>
                    <div class="btn-toolbar">
                        <button type="button" class="modal-button_add mr-2" @click="[selectedKpd = {},$modal.show('modalKpdEdit')]">
                            {{trans('kpd_tree.add')}}
                        </button>
                        <button type="button" class="modal-bign-button" @click="$modal.hide('modalCatalog')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="table-container">
                    <table class="modal_table">
                        <tr>
                            <th class="p-4" v-for="header in catalog.table.headers">{{header}}</th>
                        </tr>
                        <tr v-if="kpdList.length > 0" v-for="row in kpdList" @click="[selectedKpd = row,$modal.show('modalKpdEdit')]">
                            <td class="p-1">{{row.name}}</td>
                            <td class="p-1">{{row.description}}</td>
                            <td class="p-1">{{row.unit}}</td>
                            <td class="p-1">{{row.functions}}</td>
                            <td class="p-1">{{row.result}}</td>
                            <td class="p-1">{{row.responsible}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </modal>
        <kpd-modal-kpd-edit ref="editKpd" :managers="managers" :corporate-manager="corporateManager" :kpd-list="kpdList" :current-kpd="selectedKpd"></kpd-modal-kpd-edit>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            catalog: {
                'name': 'Каталог КПД',
                'table': {
                    'headers': [
                        'Наименование КПД',
                        'Описание',
                        'Ед. измерения',
                        'Функция',
                        'Рассчитывает и предоставляет',
                        'Ответственные за выполнение КПД',
                    ],
                },
            },
            kpdList: [],
            selectedKpd: {}
        };
    },
    methods: {
        async getKpdList() {
            let uri = this.localeUrl("/kpd-tree-catalog");
            const response = await axios.get(uri);
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
    },
    async mounted() {
        this.kpdList = await this.getKpdList();
        _.forEach(this.kpdList, (item,index) => {
            let elements = item.kpd_elements;
            this.kpdList[index]['elements'] = item.kpd_elements;
            delete this.kpdList[index]['kpd_elements'];
        });
        this.$watch(
            () => {
                if (this.$refs.editKpd) {
                    return this.$refs.editKpd.isOperationFinished
                }
            },
            async (update) => {
                if (update) {
                    this.kpdList = await this.getKpdList();
                    _.forEach(this.kpdList, (item,index) => {
                        let elements = item.kpd_elements;
                        this.kpdList[index]['elements'] = item.kpd_elements;
                        delete this.kpdList[index]['kpd_elements'];
                    });
                }
            }
        );
    },
    props: ['managers','corporateManager'],
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal_table {
    width: 100%;
    tr:first-child th {
        background: #3A4280;
        border: 1px solid #545580;
        max-height: 40px;
        height: 40px;
        max-width: 220px;
    }
    tr td {
        border: 1px solid #545580;
        height: 30px;
        max-width: 220px;
        word-wrap: break-word;
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
}
.modal-button_add {
    border: none;
    outline: none;
    background: #2d995b;
    color: white;
    font-weight: normal;
    font-size: 16px;
    width: 100px;
    border-radius: 8px;
}
.table-container {
    max-height: 740px;
    overflow-y: auto;
}
</style>