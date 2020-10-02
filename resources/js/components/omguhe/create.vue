<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label >Месторождение</label>
        <div class="form-label-group">
            <select class="form-control"  name="field" v-model="field" v-show="fields.length > 0">
            <option v-for="row in fields" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>ГУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="gu_id" v-model="gu" @change="chooseGu($event)">
            <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>
            Дата и время

        </label>
        <div class="form-label-group2">
        <datetime
        type="date" v-model="datetimeEmpty" input-class="date"
        value-zone="Asia/Almaty"
        zone="Asia/Almaty"
        :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
        :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
        :hour-step="1"
        :minute-step="5"
        :week-start="1"
        use24-hour
        auto
        >
        </datetime>
        <input type="hidden" name="date" v-model="datetimeEmpty" class="form-control" placeholder="">

        </div>
        <label>Расход ингибитора за месяц, т/мес</label>
        <div class="form-label-group">
            <input type="number" name="monthly_inhibitor_flowrate" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>НГДУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="ngdu_id" v-model="ngdu" @change="chooseNgdu($event)">
            <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>ЗУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="zu_id" v-model="zu" @change="chooseZu($event)">
            <option v-for="row in zus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Фактическая дозировка, г/м3</label>
        <div class="form-label-group">
            <input type="number" name="current_dosage" class="form-control" placeholder="">
        </div>
        <label>Простой дозатора, сутки</label>
        <div class="form-label-group">
            <input type="number" name="out_of_service_оf_dosing" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>ЦДНГ</label>
        <div class="form-label-group">
            <select class="form-control"  name="cdng_id" v-model="cdng" @change="chooseCdng($event)">
            <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Скважина</label>
        <div class="form-label-group">
            <select class="form-control"  name="well_id" v-model="well">
            <option v-for="row in wells" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Суточный расход ингибитора, кг/сут</label>
        <div class="form-label-group">
            <input type="number" name="daily_inhibitor_flowrate" class="form-control" placeholder="">
        </div>
        <label>Причина</label>
        <div class="form-label-group">
            <textarea type="text" name="reason" class="form-control" placeholder="">
            </textarea>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" :disabled="!datetimeEmpty" class="btn btn-success">Сохранить</button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import { Datetime } from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import { Settings } from 'luxon'

Settings.defaultLocale = 'ru'

Vue.use(Datetime)

export default {
    name: "wm-create",
    methods: {
        chooseNgdu(event){
            this.axios.post("/ru/getcdng", {
                ngdu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.cndgs = data.data;
                }
                else {
                    console.log('No data');
                }
            });
        },
        chooseCdng(event){
            this.axios.post("/ru/getgu", {
                cdng_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.gus = data.data;
                }
                else {
                    console.log('No data');
                }
            });
        },
        chooseGu(event){
            this.axios.post("/ru/getzu", {
                gu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.zus = data.data;
                }
                else {
                    console.log('No data');
                }
            });
        },
        chooseZu(event){
            this.axios.post("/ru/getwell", {
                zu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.wells = data.data;
                }
                else {
                    console.log('No data');
                }
            });
        },
  },
  data: function () {
    return {
        otherObjects: {},
        ngdus: {},
        cndgs: {},
        gus: {},
        zus: {},
        wells: {},
        wbs: {},
        srb: {},
        hob: {},
        hb: {},
        fields: [
            {"id":"1", "name" : "Узень"},
            {"id":"2", "name" : "Карамандыбас"}
        ],
        ngdu: null,
        cdng: null,
        gu: null,
        zu: null,
        well: null,
        datetimeEmpty: null,
        wbsmodel: null,
        srbmodel: null,
        hobmodel: null,
        hbmodel: null
    }
  },
  beforeCreate: function () {

    this.axios.get("/ru/getngdu").then((response) => {
        let data = response.data;
        if(data) {
            this.ngdus = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/getwbs").then((response) => {
        let data = response.data;
        if(data) {
            this.wbs = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/getsrb").then((response) => {
        let data = response.data;
        if(data) {
            this.srb = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/gethob").then((response) => {
        let data = response.data;
        if(data) {
            this.hob = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/gethb").then((response) => {
        let data = response.data;
        if(data) {
            this.hb = data.data;
        }
        else {
            console.log('No data');
        }
    });

  }
};
</script>
<style scoped>
    .form-label-group{
        padding-bottom: 30px;
    }
    .form-label-group2{
        padding-bottom: 39px;
    }
</style>
