<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalDocuments"
                draggable=".modal-bign-header"
                :width="1500"
                :height="800"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">{{documents.name}}</div>
                    <button type="button" class="modal-bign-button" @click="$modal.hide('modalDocuments')">
                        {{trans('pgno.zakrit')}}
                    </button>
                </div>
                <table class="modal_table">
                    <tr>
                        <th class="p-4" v-for="header in documents.table.headers">{{header}}</th>
                    </tr>
                    <tr v-for="row in documents.table.body">
                        <td class="p-1" v-for="column in row">{{column}}</td>
                        <td>
                            <div class="download-button m-4">Скачать</div>
                        </td>
                    </tr>
                </table>
                <div align="center" class="bottom-buttons col-12 row">
                    <div class="col-1 download-button m-4" @click="$modal.hide('modalDocuments')">ОК</div>
                    <div class="col-1 cancel-button m-4" @click="$modal.hide('modalDocuments')">Отмена</div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            documents: {
                'name': 'Нормативные документы',
                'table': {
                    'headers': [
                        '№',
                        'Наименование документа',
                        'Описание',
                        'Утверждено',
                        'Скачать'
                    ],
                    'body': [
                        [
                            1,
                            'Правила оценки эффективности деятельности руководящих и управленческих работников, руководителя службы внутреннего аудита и копроративного секретаря АО НК “КазМунайГаз”.',
                            'Определение порядка и ответсвенности участников процесса оценки эффективности деятельности руководящих и управленческих работников КМГ.',
                            'Протокол СД КМГ №16/2016 от 23.11.2016 г.'
                        ],
                        [
                            2,
                            'Рабочая инструкция по формированию карт мотивационных ключевых показателей деятельности в АО НК “КазМунайГаз”.',
                            'Определение и описание процесса по формированию карт мотивационных КПД в КМГ.',
                            'Приказ председателя правления КМГ'
                        ],
                        [
                            3,
                            'Правила оплаты руководящих работников, работников службы внутреннего контроля и Копроративного секретаря  АО НК “КазМунайГаз”.',
                            '',
                            ''
                        ]
                    ]
                }
            },
        };
    },
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal_table {
    width: 100%;
    table-layout: fixed;
    tr:first-child {
        th {
            background: #3A4280;
            border: 1px solid #545580;
            width: 200px;
        }
        th:first-child {
            width: 10px;
        }
        th:nth-child(2) {
            width: 300px;
        }
        th:last-child {
            width: 100px;
        }
    }
    tr {
        td {
            border: 1px solid #545580;
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
}
</style>