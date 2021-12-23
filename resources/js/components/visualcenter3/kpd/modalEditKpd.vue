<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalKpdEdit"
                draggable=".modal-bign-header"
                :width="1100"
                :height="580"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">{{kpd.name}}</div>
                    <div class="btn-toolbar">
                        <button type="button" class="modal-bign-button" @click="[isOperationFinished = true,$modal.hide('modalKpdEdit')]">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="edit-block row mt-2">
                    <div class="p-1 col-12 d-flex">
                        <div class="p-1 col-8 d-flex">
                            <div class="col-3 text-left pt-2">Наименование КПД</div>
                            <input class="input_kpd p-2 col-9" type="text" v-model="kpd.current.name">
                        </div>
                        <div class="p-1 col-4 d-flex">
                            <div class="col-5 text-left pt-2">Ед. измерения</div>
                            <input class="input_kpd p-2 col-7" type="text" v-model="kpd.current.unit">
                        </div>
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Описание</div>
                        <input class="input_kpd p-2 col-10" type="text" v-model="kpd.current.description">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Формула расчета</div>
                        <b-form-textarea
                                class="col-10 text-left pt-2 input_kpd"
                                v-model="kpd.current.formula"
                                rows="4"
                        ></b-form-textarea>
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Расшифровка элементов<br>формулы</div>
                        <div class="col-10 text-center p-0">
                            <table class="transcript-table" v-show="kpd.current.elements.length > 0">
                                <thead>
                                    <tr>
                                        <th>Обозначение</th>
                                        <th>Расшифровка</th>
                                        <th>Ед. измерения</th>
                                        <th>Источник информации</th>
                                        <th>Ответственный за предоставление</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="element in kpd.current.elements">
                                        <td>
                                            <b-form-textarea
                                                    class="text-left pt-2 input_kpd"
                                                    v-model="element.name"
                                                    rows="2"
                                            ></b-form-textarea>
                                        </td>
                                        <td>
                                            <b-form-textarea
                                                    class="text-left pt-2 input_kpd"
                                                    v-model="element.transcript"
                                                    rows="2"
                                            ></b-form-textarea>
                                        </td>
                                        <td>
                                            <b-form-textarea
                                                    class="text-left pt-2 input_kpd"
                                                    v-model="element.unit"
                                                    rows="2"
                                            ></b-form-textarea>
                                        </td>
                                        <td>
                                            <b-form-textarea
                                                    class="text-left pt-2 input_kpd"
                                                    v-model="element.source"
                                                    rows="2"
                                            ></b-form-textarea>
                                        </td>
                                        <td>
                                            <b-form-textarea
                                                    class="text-left pt-2 input_kpd"
                                                    v-model="element.responsible"
                                                    rows="2"
                                            ></b-form-textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="modal-bign-button mt-2" @click="addRow">
                                Добавить
                            </button>
                            <button type="button" class="modal-bign-button mt-2" @click="deleteRow">
                                Удалить
                            </button>
                        </div>
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Функция</div>
                        <input class="input_kpd p-2 col-10" type="text" v-model="kpd.current.functions">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Показатель рассчитывает и<br>предоставляет:</div>
                        <input class="input_kpd p-2 col-10" type="text" v-model="kpd.current.result">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Ответственный за<br>выполнение КПД:</div>
                        <input class="input_kpd p-2 col-10" type="text" v-model="kpd.current.responsible">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Владелец</div>
                        <select class="form-select input_kpd p-2 col-10" @change="handleTypeChange($event)">
                            <option v-for="owner in owners" :value="owner.id">{{owner.name}}</option>
                        </select>
                    </div>
                    <div v-if="kpd.current.type !== 'strategic'" class="p-1 col-12 d-flex">
                        <div class="col-2 text-left pt-2">Принадлежность</div>
                        <select class="form-select input_kpd p-2 col-10" @change="kpd.current.parent = $event.target.value">
                            <option v-for="kpd in kpdParents" :value="kpd.id">{{kpd.name}}</option>
                        </select>
                    </div>
                    <div class="p-1 col-12 d-flex mt-2">
                        <div class="col-6 d-flex justify-content-start pt-2">
                            <span>Описание</span>
                            <div class="ml-2 image-upload">
                                <label for="description-document_upload">
                                    <img src="/img/kpd-tree/document.png"/>
                                </label>
                                <input id="description-document_upload" type="file" class="form-control-file ml-2" @change="uploadFile($event,'description_document')">
                            </div>
                            <img v-if="kpd.current.description_document" class="ml-2" src="/img/kpd-tree/success.svg" height="30px">
                        </div>
                        <div class="col-6 text-left pt-2 d-flex justify-content-end">
                            <span>Расчет</span>
                            <div class="ml-2 image-upload">
                                <label for="calculation-document_upload">
                                    <img src="/img/kpd-tree/document.png"/>
                                </label>
                                <input id="calculation-document_upload" type="file" class="form-control-file ml-2" @change="uploadFile($event,'calculation_document')">
                            </div>
                            <img v-if="kpd.current.calculation_document" class="ml-2" src="/img/kpd-tree/success.svg" height="30px">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-1">
                    <button type="button" class="modal-button_save mr-2" @click="store">
                        {{trans('kpd_tree.save')}}
                    </button>
                    <button type="button" class="modal-button_delete mr-2" @click="deleteKpd">
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
                    formula: '',
                    elements: [],
                    functions: '',
                    result: '',
                    responsible: '',
                    type: 'strategic',
                    parent: 'strategic',
                    description_document: '',
                    calculation_document: ''
                }
            },
            owners: [
                {
                    'name': 'Стратегические КПД',
                    'id': 'strategic'
                },
            ],
            kpdParents: [],
            isOperationFinished: false
        };
    },
    methods: {
        addRow() {
            this.kpd.current.elements.push(
                {
                    'name': '',
                    'transcript': '',
                    'unit': '',
                    'source': '',
                    'responsible': ''
                }
            );
            console.log(this.currentKpd);
        },
        deleteRow() {
            this.kpd.current.elements.pop();
        },
        uploadFile(event,field) {
            this.kpd.current[field] = event.target.files[0];
        },
        async store() {
            let uri = this.localeUrl("/kpd-tree-catalog-store");
            let formData = new FormData();
            formData.append('name', this.kpd.current.name);
            formData.append('elements', JSON.stringify(this.kpd.current.elements));
            formData.append('description', this.kpd.current.description);
            formData.append('unit', this.kpd.current.unit);
            formData.append('formula', this.kpd.current.formula);
            formData.append('functions', this.kpd.current.functions);
            formData.append('result', this.kpd.current.result);
            formData.append('responsible', this.kpd.current.responsible);
            formData.append('type', this.kpd.current.type);
            formData.append('parent', this.kpd.current.parent);
            formData.append('description_document', this.kpd.current.description_document);
            formData.append('calculation_document', this.kpd.current.calculation_document);
            await this.axios.post(uri, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                if (response.status !== 200) {
                    this.showToast('Проверьте вложенный файл и данные.','Ошибка!','danger');
                    return;
                }
                this.showToast('Данные успешно сохранены/обновлены.','Успешно','success');
            });
            this.isOperationFinished = true;
            this.$modal.hide('modalKpdEdit');
        },
        async deleteKpd() {
            let uri = this.localeUrl("/kpd-tree-catalog-delete");
            await axios.get(uri, {params:{'id':this.kpd.current.id}});
            this.isOperationFinished = true;
            this.$modal.hide('modalKpdEdit');
        },
        handleTypeChange(e) {
            this.kpd.current.type = e.target.value;
            this.kpd.current.parent = this.kpdList[0].type;
        },
    },
    async mounted() {

    },
    watch: {
        managers: function () {
            this.owners = this.owners.concat(this.managers);
        },
        corporateManager: function () {
            this.owners.push(this.corporateManager);
        },
        kpdList: function() {
            this.kpdParents = this.kpdList;
        },
        currentKpd: function() {
            if (Object.keys(this.currentKpd).length > 0) {
                this.kpd.current = _.cloneDeep(this.currentKpd);
            } else {
                this.kpd.current = {
                    name: '',
                    description: '',
                    unit: '',
                    formula: '',
                    elements: [],
                    functions: '',
                    result: '',
                    responsible: '',
                    type: JSON.stringify({'alias': 'strategic','id':null}),
                    parent: 'strategic',
                    description_document: '',
                    calculation_document: ''
                };
            }
        }
    },
    props: ['managers','corporateManager','kpdList','currentKpd'],
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
    overflow-y: auto;
    max-height: 450px;
}
.input_kpd {
    background: #1A1D46;
    color: white;
    border-radius: 5px;
    border: none;
    width: 100%;
}
.transcript-table {
    th,td {
        border: 1px solid #656A8A !important;
    }
}
.image-upload>input {
    display: none;
}

</style>