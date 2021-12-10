<template>
    <div >
        <div class="container-main">
            <div class="col-sm-12">
                <div class="daily-raport-block">
                    <div class="import-daily-raport">
                        <div class="header">
                            <div class="header-left">
                                <div class="header-icon">
                                    <img src="/img/digital-drilling/import-icon.png" alt="">
                                </div>
                                <div class="header-title">
                                    {{ trans('digital_drilling.default.import_daily-report') }}
                                </div>
                            </div>
                            <div class="header-close">
                                <a :href="this.localeUrl('/digital-drilling')">{{ trans('digital_drilling.default.close') }}</a>
                            </div>
                        </div>
                        <div class="import-daily-body">
                            <div class="import-daily-body">
                                <div class="file-input" @dragover="dragover" @dragleave="dragleave" @drop="drop">
                                    <input type="file" multiple name="fields[assetsFieldHandle][]" id="assetsFieldHandle"
                                           class="w-px h-px opacity-0 overflow-hidden absolute" @change="onChange" ref="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                    <label for="assetsFieldHandle" v-if="!filelist.length">
                                        <div class="report-btn">
                                            <img src="/img/digital-drilling/file.png" alt="">
                                            <div class="report-text">{{ trans('digital_drilling.default.select_file') }}</div>
                                        </div>
                                        <div class="report-detail" >
                                            {{ trans('digital_drilling.default.or') }} <br>
                                            {{ trans('digital_drilling.default.drag_here') }}
                                        </div>
                                    </label>
                                    <ul v-if="filelist.length" v-cloak>
                                        <li class="text-sm p-1">
                                            <span class="file-name">
                                                {{filelist[0].name}}
                                            </span>

                                            <button class="ml-2 remove-file" type="button" @click="remove(0)" title="Remove file">Удалить</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form">
                                <input type="number" class="input" placeholder="Напишите номер скважины" v-model="form.well_num" @input="checkForm">
                                <input type="date" class="input" placeholder="Дата" v-model="form.date" @input="checkForm">
                            </div>
                            <div class="import-daily-body-btns">
                                <button :class="{disabled: !uploadTrue }" @click="importFile">{{ trans('digital_drilling.default.import') }}</button>
                                <button>{{ trans('digital_drilling.default.reset') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "ImportDailyRaport",
        data(){
            return{
                filelist: [],
                form: {
                    well_num: "",
                    date: "",
                },
                uploadTrue: false
            }
        },
        methods: {
            importFile(){
                if (this.uploadTrue) {
                    let formData = new FormData();
                    formData.append('file', this.filelist[0]);
                    formData.append('well_num', this.form.well_num);
                    formData.append('file', this.form.date);
                    console.log(formData)
                }
            },
            onChange() {
                this.filelist = [...this.$refs.file.files];
                this.checkForm()
            },
            checkForm(){
                if (this.filelist.length>0 && this.form.date != "" && this.form.well_num != ""){
                    this.uploadTrue = true
                }else{
                    this.uploadTrue = false
                }
            },
            remove(i) {
                this.filelist = []
                this.checkForm()
                // this.filelist.splice(i, 1);
            },
            dragover(event) {
                event.preventDefault();
                if (!event.currentTarget.classList.contains('bg-green-300')) {
                    this.addDeleteClass()
                }
            },
            dragleave(event) {
               this.addDeleteClass()
            },
            drop(event) {
                event.preventDefault();
                this.$refs.file.files = event.dataTransfer.files;
                this.onChange()

            },
            addDeleteClass(){
                event.currentTarget.classList.add('bg-gray-100');
                event.currentTarget.classList.remove('bg-green-300');
            },
        }
    }
</script>

<style scoped>
    [v-cloak] {
        display: none;
    }
    .daily-raport{
        position: relative;
        z-index: -1;
    }
    .daily-raport-block{
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }
    .import-daily-raport{
        background: #272953;
        width: 500px;
        border-radius: 4px;
        padding: 17px 14px;
    }
    .import-daily-raport .header{
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }
    .header-left{
        display: flex;
        align-items: center;
    }
    .import-daily-raport .header-close{

    }
    .import-daily-raport .header-close a{
        background: #656A8A;
        border: 0;
        border-radius: 10px;
        font-family: Harmonia Sans Pro Cyr;
        font-style: normal;
        font-weight: bold;
        font-size: 14px;
        line-height: 17px;
        color: #FFFFFF;
        padding: 4px 13px;
        text-decoration: none;
        cursor: pointer;
    }

    .import-daily-raport .header-title{
        font-family: Harmonia Sans Pro Cyr;
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 19px;

        color: #FFFFFF;
        margin-left: 15px;
    }
    .import-daily-body{
        color: #FFFFFF;
        margin: 30px 0;
    }
    .file-input{
        background: rgba(49, 53, 96, 0.6);
        border: 1px solid #454D7D;
        border-radius: 4px;
        padding: 10px;
        position: relative;
        z-index: 10;
    }
    .file-input input[type='file']{
        opacity: 0;
    }
    .file-input label{
        height: 190px;
        width: 100%;
        border: 1px dashed #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .file-input label .report-btn{
        display: flex;
        align-items: center;
        background: #878BA9;
        border-radius: 4px;
        color: #FFFFFF;
        width: auto;
        padding: 9px 14px;
    }
    .file-input label .report-detail{
        text-align: center;
        font-size: 14px;
        line-height: 17px;

        color: #FFFFFF;
    }
    .file-input label .report-btn img{
        margin-right: 10px;
    }
    .file-input ul{
        list-style: none;
    }
    .import-daily-body-btns{
        width: 360px;
        display: flex;
        align-items: center;
        margin: 50px auto 10px;
    }
    .import-daily-body-btns button{
        height: 42px;
        width: 162px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #656A8A;
        border-radius: 10px;
        border: 0;
        color: #FFFFFF;
    }
    .import-daily-body-btns button:first-child{
        background: #2E50E9;
        margin-right: 20px;
    }
    .import-daily-body-btns button.disabled{
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #666666;
        cursor: default;
    }
    .text-sm{
        display: flex;
        align-items: center;
    }
    .text-sm .file-name{
        margin-right: 12px;
        max-width: 250px;
        overflow: hidden;
        display: block;
        text-overflow: ellipsis;
        white-space: nowrap;
        position: relative;
    }
    .text-sm .file-name:hover {
        text-overflow: clip;
        white-space: normal;
        word-break: break-all;
    }
    .form input[type='date']::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }
    .form input{
        display: block;
        width: 100%;
        margin-bottom: 30px;
        background: #1F2142;
        border: 1px solid #454FA1;
        border-radius: 4px;
        padding: 7px;
        color: #ffffff;
    }
    .form input::placeholder{
        color: #ffffffa3;
    }
    .form input.error{
        border-color: red;
    }
    .form input:focus{
        outline: none;
    }
    .remove-file{
        padding: 5px;
        line-height: 1;
        border: 0;
        color: #ffffff;
        background: #c63e4b;
        border-radius: 5px;
        font-weight: 600;
    }

</style>