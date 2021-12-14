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
                                <div class="file-input"
                                     @dragover="dragover"
                                     @dragleave="dragleave"
                                     @drop="drop"
                                     :class="{error: uploadTrue && filelist.length==0}"
                                >
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
                                <div class="form-input">
                                    <input type="text" class="input"
                                           placeholder="Напишите код скважины"
                                           v-model="form.well_num"
                                           @input="checkForm"
                                           :class="{error: uploadTrue && form.well_num=='', errorInput: error_text}"
                                    >
                                    <div class="error-text" v-if="error_text">
                                        {{error_text}}
                                    </div>
                                </div>
                               <div class="form-input">
                                   <input type="number" class="input"
                                          placeholder="Напишите ID отчета"
                                          v-model="form.report_id"
                                          @input="checkForm"
                                          :class="{error: uploadTrue && form.report_id==''}"
                                   >
                               </div>
                               <div class="form-input">
                                   <input type="date" class="input"
                                          placeholder="Дата"
                                          v-model="form.date"
                                          @input="checkForm"
                                          :class="{error: uploadTrue && form.date==''}"
                                   >
                               </div>
                            </div>
                            <div class="import-daily-body-btns">
                                <button :class="{disabled: !uploadTrue }" @click="importFile">{{ trans('digital_drilling.default.import') }}</button>
                                <a :href="this.localeUrl('/digital-drilling')">{{ trans('digital_drilling.default.reset') }}</a>
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
                    report_id: "",
                },
                uploadTrue: false,
                error_text: null
            }
        },
        methods: {
            importFile(){
                if (this.uploadTrue) {
                    let formData = new FormData();
                    formData.append('file', this.filelist[0]);
                    formData.append('uwi', this.form.well_num);
                    formData.append('report_id', this.form.report_id);
                    formData.append('report_date', this.form.date);
                    this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/import_report/',
                        formData).then((response) => {
                        if (response) {
                            this.filelist = [],
                            this.error_text = null
                            this.form = {
                                well_num: "",
                                date: "",
                                report_id: "",
                                filename: ""
                            }
                            this.uploadTrue = false
                            this.$bvToast.toast("Файл успешно импортирован!!", {
                                title: "Отчет",
                                variant: "success",
                                solid: true,
                                toaster: "b-toaster-top-center",
                                autoHideDelay: 8000,
                            });
                        } else {
                            console.log("No data");
                        }
                    }).catch((error) =>{
                        console.log(error)
                        this.error_text = "Формат неправильный(должно быть что-то вроде AIR_0001)"
                    })
                }
            },
            onChange() {
                this.filelist = [...this.$refs.file.files];
                this.checkForm()
            },
            checkForm(){
                if (this.filelist.length>0 && this.check()){
                    this.uploadTrue = true
                }else{
                    this.uploadTrue = false
                }
            },
            check(){
                let is_right = true
                for (let prop in this.form) {
                    if (this.form[prop] == ""){
                        is_right = false
                        break
                    }
                }
                return is_right
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
    .import-daily-body-btns button, .import-daily-body-btns a{
        height: 42px;
        width: 162px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #656A8A;
        border-radius: 10px;
        border: 0;
        color: #FFFFFF;
        text-decoration: none;
    }
    .import-daily-body-btns button{
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
    .form-input{
        margin-bottom: 30px;
        position: relative;
    }
    .errorInput{
        border: 1px solid #F94A5B!important;
    }
    .error-text{
        color: #F94A5B;
    }
    .form input{
        display: block;
        width: 100%;
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