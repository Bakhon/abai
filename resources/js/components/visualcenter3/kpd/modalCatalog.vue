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
                    <button type="button" class="modal-bign-button" @click="$modal.hide('modalCatalog')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <table class="modal_table">
                    <tr>
                        <th class="p-4" v-for="header in catalog.table.headers">{{header}}</th>
                    </tr>
                    <tr v-for="row in catalog.table.body">
                        <td class="p-1" v-for="column in row">{{column}}</td>
                    </tr>
                </table>
                <div align="center" class="bottom-buttons col-12 row">
                    <div class="col-1 download-button m-4" @click="$modal.hide('modalCatalog')">ОК</div>
                    <div class="col-1 cancel-button m-4" @click="$modal.hide('modalCatalog')">Отмена</div>
                </div>
            </div>
        </modal>
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
                        'Полярность',
                        'Формула расчета',
                        'Переменные',
                        'Источник данных',
                        'Ответственные за достоверность',
                        'Функции'
                    ],
                    'body': [

                    ]
                }
            },
        };
    },
    async mounted() {
        for (let i=0;i<13;i++) {
            this.catalog.table.body.push([
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ]);
        }
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
        background: #3A4280;
        border: 1px solid #545580;
        max-height: 40px;
        height: 40px;
    }
    tr td {
        border: 1px solid #545580;
        height: 30px;
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
</style>