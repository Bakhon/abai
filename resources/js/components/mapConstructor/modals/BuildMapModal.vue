<template>
    <div class="h-100 p-3">
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link active" data-toggle="tab" href="#data">Данные</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#settings">Настройки</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="data" class="tab-pane fade show active">
                <div class="input-group mt-4 pl-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Выбор данных:</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" ref="bubblesFile"
                               aria-describedby="inputGroupFileAddon01" @change="handleBubbleFileChange()">
                        <label class="custom-file-label text-right" for="inputGroupFile01">{{ bubblesFileName }}</label>
                    </div>
                </div>
            </div>
            <div id="settings" class="tab-pane fade">
                <div class="input-group mt-4 pl-2">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="diaType">Тип диаграммы:</label>
                    </div>
                    <select class="custom-select text-right" id="diaType">
                        <option value="1" selected>Круговые</option>
                        <option value="2" disabled>Столбчатая</option>
                    </select>
                </div>
                <div class="input-group mt-4 pl-2">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="coordsSystem">Система координат:</label>
                    </div>
                    <select class="custom-select text-right" id="coordsSystem">
                        <option value="1" disabled>Прямоугольная</option>
                        <option value="2" selected>Угловая</option>
                    </select>
                </div>
                <div class="input-group mt-4 pl-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" @change="lineFileDisabled = !lineFileDisabled">
                        </div>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon02">Загрузить границу:</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile02" ref="lineFile"
                               aria-describedby="inputGroupFileAddon02" :disabled="lineFileDisabled"
                               @change="handleLineFileChange()">
                        <label class="custom-file-label text-right"
                               :class="{'disabled': lineFileDisabled}"
                               for="inputGroupFile02">{{ lineFileName }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 d-flex flex-row-reverse w-100">
            <button type="button" class="btn btn-secondary" @click="$emit('close')"> {{ trans('map_constructor.cancel') }}</button>
            <button type="button" class="btn btn-primary mr-1" @click="buildMapHandler"> {{ trans('map_constructor.build') }}</button>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            buildMap: Function,
        },
        data: function () {
            return {
                bubblesFileName: 'Выберите файл',
                lineFileName: 'Выберите файл',
                bubblesFileData: null,
                lineFileData: null,
                lineFileDisabled: true,
            }
        },
        methods: {
            handleBubbleFileChange() {
                this.bubblesFileData = this.$refs.bubblesFile.files[0];
                this.bubblesFileName = this.bubblesFileData.name;
            },
            handleLineFileChange() {
                this.lineFileData = this.$refs.lineFile.files[0];
                this.lineFileName = this.lineFileData.name;
            },
            buildMapHandler() {
                this.buildMap();
            }
        }
    }
</script>
<style scoped>
.card {
    background-color: rgb(70, 73, 142);
}
.nav-link {
    color: #fff ;
    border-top-color: rgb(51, 57, 117);
    border-right-color: rgb(51, 57, 117);
    border-left-color: rgb(51, 57, 117);
    border-bottom-color: white;
}
.nav-link.active {
    color: #fff ;
    background-color: rgb(51, 57, 117);
    border-bottom-color: rgb(51, 57, 117);
}
.custom-file-label::after {
    content: none;
}
.input-group-text {
    color: #fff ;
    background-color: rgb(51, 57, 117);
}
.custom-file-label.disabled {
    color: rgb(51, 57, 117);
    background-color: rgb(51, 57, 117);
}
</style>