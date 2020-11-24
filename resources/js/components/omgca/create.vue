<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label >Год</label>
        <div class="form-label-group">
            <select class="form-control"  name="year" v-model="year" v-show="years.length > 0">
            <option v-for="row in years" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Qв, тыс.м³/год</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="q_v" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>ГУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="gu_id" v-model="gu" @change="chooseGu($event)">
            <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>Планируемая дозировка, г/м3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="plan_dosage" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" :disabled="!year" class="btn btn-success">Сохранить</button>
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
                    this.well = null
                }
                else {
                    console.log('No data');
                }
            });

            this.axios.post("/ru/getgucdngngdufield", {
                gu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.cdng = data.cdng;
                    this.ngdu = data.ngdu;
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
        years: [
            {"id":"2019-01-01", "name" : "2019"},
            {"id":"2020-01-01", "name" : "2020"}
        ],
        field: null,
        year: null,
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

    this.axios.get("/ru/getcdng").then((response) => {
        let data = response.data;
        if(data) {
            this.cndgs = data.data;
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

    this.axios.get("/ru/getallgus").then((response) => {
        let data = response.data;
        if(data) {
            this.gus = data.data;
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
