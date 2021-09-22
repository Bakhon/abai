<template>
    <div class="page-wrapper">
        <div class="row">
            <div class="col-12 mt-5">Загрузка исторических данных</div>
        </div>
        <div class="d-flex flex-row-reverse">
            <div :class="[selectedDzo.length === 0 ? 'button_disabled' : '','col-2 m-2 mt-5']">
                <button type="button" class="btn btn-primary" @click="store">Загрузить</button>
            </div>
            <div class="col-2 m-2 mt-5">
                <select class="custom-select" @input="selectedDzo = $event.target.value">
                    <option selected>Выберите ДЗО</option>
                    <option v-for="dzo in dzoList" :value="dzo">{{dzo}}</option>
                </select>
                <select class="custom-select" @input="selectedType = $event.target.value">
                    <option selected>Выберите Тип</option>
                    <option v-for="(key,type) in types" :value="key">{{type}}</option>
                </select>
                <input type="file" class="form-control-file mt-2" @change="selectFile">
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-4"></div>
            <div class="col-4">
                Отчет о выполнении операции:
            </div>
            <div class="col-4"></div>
            <div class="col-4"></div>
            <div class="row col-4 report-table">
                <div class="col-6 p-2">
                    Загружено записей: {{storedRecords}}
                </div>
                <div class="col-6 p-2">
                    Ошибка при загрузке: {{errors}}
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</template>

<script>
    import moment from "moment-timezone";

    export default {
        data: function () {
            return {
                dzoList: [
                    'КБМ',
                    'ММГ',
                    'ОМГ',
                    'КТМ'
                ],
                selectedDzo: '',
                selectedType: 'DzoImportOtm',
                storedRecords: 0,
                errors: 0,
                inputFile: null,
                types: {
                    'OTM': 'DzoImportOtm',
                    'Химизация': 'DzoImportChemistry',
                    'Производственные показатели': 'DzoImportData'
                }
            }
        },
        methods: {
            selectFile(event) {
                this.inputFile = event.target.files[0];
                console.log(this.inputFile);
            },
            async store() {
                let uri = this.localeUrl("/store-historical-data");
                let formData = new FormData();
                formData.append("file", this.inputFile);
                formData.append('type', this.selectedType);
                formData.append('dzo', this.selectedDzo);
                await this.axios.post(uri, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }).then((response) => {
                    if (response.status === 200) {
                        console.log('200')
                    } else {
                        console.log('error')
                    }
                });
            },
        }
    }
</script>

<style lang="scss" scoped>
.page-wrapper {
    font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
    position: relative;
    min-height: calc(100vh - 78px);
    background: #272953;
    color: white;
    text-align: center;
    font-size: 16px;
}
.button_disabled {
    pointer-events: none;
    opacity: 0.4;
}
.report-table {
    border: 1px solid #696e96;
    div:first-child {
        border-right: 1px solid #696e96;
    }
}
</style>
