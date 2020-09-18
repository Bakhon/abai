<template>
  <div class="container-fluid">
    <div class="row justify-content-between">
      <modal name="bign1" :width="1150" :height="400" :adaptive="true">
          <div class="modal-bign">
            <vue-table-dynamic
            :params="params"
            ref="table"
            >
            </vue-table-dynamic>
          </div>
      </modal>
      <modal name="bign2" :width="1150" :height="400" :adaptive="true">
          <div class="modal-bign">
            <vue-table-dynamic
            :params="params"
            ref="table"
            >
            </vue-table-dynamic>
          </div>
      </modal>
      <modal name="bign3" :width="1150" :height="400" :adaptive="true">
          <div class="modal-bign">
            <vue-table-dynamic
            :params="params"
            ref="table"
            >
            </vue-table-dynamic>
          </div></modal>
      <modal name="bign4" :width="1150" :height="400" :adaptive="true">
          <div class="modal-bign">
            <vue-table-dynamic
            :params="params"
            ref="table"
            >
            </vue-table-dynamic>
          </div>
      </modal>
      <div class="col-md-9 col-sm-12">
        <h2 class="subtitle text-wrap">Нерентабельный фонд скважин 2020 год</h2>
      </div>
      <div class="col-md-3 col-sm-12">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Выберите компанию</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChange($event)"
          >
            <option value>АО «НК «КазМунайГаз»</option>
            <option value="?org=2.0">АО «ОзенМунайГаз»</option>
            <option value="?org=5.000001017E9">АО «Каражанбасмунай»</option>
            <option value="?org=5.00000202E9">ТОО «КазГерМунай»</option>
            <option value="?org=3.0">АО «ЭмбаМунайГаз»</option>
            <option value="?org=2.000000000004E12">АО «Мангистаумунайгаз»</option>
          </select>
        </div>
    </div>
    </div>
    <div class="main row justify-content-between" style="padding:10px;">
      <div class="col-md-3 col-sm-12 bignumber" @click="pushBign('bign1')">
        <p class="bignumber-number text-center text-wrap">
          {{averageProfitlessCat1MonthCount}}
          <span class="badge badge-pill">
            <i
              class="fas fa-angle-down"
              style="color:#13B062"
              v-if="persentCount>0"
            ></i>
            <i class="fas fa-angle-up" v-if="persentCount<0" style="color:#AB130E"></i>
            <span v-if="persentCount>0">{{persentCount}}%</span>
            <span v-if="persentCount<0">{{-1*persentCount}}%</span>
          </span>
        </p>
        <p
          class="text-center bignumber-title text-wrap"
        >Количество нерентабельных скважин за последний месяц</p>
      </div>
      <div class="col-md-3 col-sm-12 bignumber" @click="pushBign('bign2')">
        <p class="bignumber-number text-center text-wrap">{{year}}</p>
        <p class="text-center bignumber-title text-wrap">Операционные убытки по НРС с начала года</p>
      </div>
      <div class="col-md-3 col-sm-12 bignumber" @click="pushBign('bign3')">
        <p class="bignumber-number text-center text-wrap">
          {{month}}
          <span class="badge badge-pill">
            <i class="fas fa-angle-down" v-if="persent>0" style="color:#13B062"></i>
            <i class="fas fa-angle-up" v-if="persent<0" style="color:#AB130E"></i>
            <span v-if="persent>0">{{persent}}%</span>
            <span v-if="persent<0">{{-1*persent}}%</span>
          </span>
        </p>
        <p
          class="text-center bignumber-title text-wrap"
        >Операционные убытки по НРС за последний месяц</p>
      </div>
      <div class="col-md-3 col-sm-12 bignumber" @click="pushBign('bign4')">
        <p class="bignumber-number text-center text-wrap">{{prs}}</p>
        <p class="text-center bignumber-title text-wrap">Количество ПРС на НРС с начала года</p>
      </div>
    </div>

    <div class="main container-fluid">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-5 col-sm-12">
          <h5 class="subtitle text-wrap">Распределение добычи нефти по типу рентабельности скважин</h5>
          <chart2-component></chart2-component>
        </div>
        <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
          <h5 class="subtitle text-wrap">Распределение скважин по типу рентабельности</h5>
          <chart1-component></chart1-component>
        </div>
        <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
          <h5 class="subtitle text-wrap">Распределение добычи жидкости по типу рентабельности скважин</h5>
          <chart4-component></chart4-component>
        </div>
        <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
          <h5 class="subtitle text-wrap">Рейтинг ТОП 10 прибыльных и убыточных скважин</h5>
          <chart3-component></chart3-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VModal from 'vue-js-modal';
import VueTableDynamic from 'vue-table-dynamic';

Vue.use(VModal, { dynamicDefault: { draggable: true, resizable: true } });

export default {
  name: "economic-component",
  beforeCreate: function () {
    let uri = '/ru/geteconimicdata';
    this.axios.get(uri).then((response) => {
        let data = response.data;
        if(data) {
            this.averageProfitlessCat1MonthCount = data.averageProfitlessCat1MonthCount,
            this.month = data.month,
            this.persent = data.persent,
            this.persentCount = data.persentCount,
            this.prs = data.prs,
            this.year = data.year,
            this.wellsList = data.wellsList,
            this.OperatingProfitMonth = data.OperatingProfitMonth,
            this.OperatingProfitYear = data.OperatingProfitYear,
            this.prs1 = data.prs1,
            this.is_data_fetched = true,
            this.params.data = data.wellsList,
            this.$emit('chart1', data.chart1),
            this.$emit('chart2', data.chart2),
            this.$emit('chart3', data.chart3),
            this.$emit('chart4', data.chart4)
        }
        else {
            console.log('No data');
        }
    });
  },
  methods: {
    onChange(event) {
        let uri = '/ru/geteconimicdata' + event.target.value;
        this.axios.get(uri).then((response) => {
            let data = response.data;
            if(data) {
                this.averageProfitlessCat1MonthCount = data.averageProfitlessCat1MonthCount,
                this.month = data.month,
                this.persent = data.persent,
                this.persentCount = data.persentCount,
                this.prs = data.prs,
                this.year = data.year,
                this.wellsList = data.wellsList,
                this.OperatingProfitMonth = data.OperatingProfitMonth,
                this.OperatingProfitYear = data.OperatingProfitYear,
                this.prs1 = data.prs1,
                this.is_data_fetched = true,
                this.params.data = data.wellsList,
                this.$emit('chart1', data.chart1),
                this.$emit('chart2', data.chart2)
                this.$emit('chart3', data.chart3),
                this.$emit('chart4', data.chart4)
            }
            else {
                console.log('No data');
            }
        });
    },
    pushBign(bign){
        switch (bign) {
            case 'bign1':
                this.params.data = this.wellsList;
                break;
            case 'bign2':
                this.params.data = this.OperatingProfitYear;
                break;
            case 'bign3':
                this.params.data = this.OperatingProfitMonth;
                break;
            case 'bign4':
                this.params.data = this.prs1;
                break;
        }
        this.$modal.show(bign);
    }
  },
  data: function () {
    return {
        averageProfitlessCat1MonthCount: null,
        month: null,
        persent: null,
        persentCount: null,
        prs: null,
        year: null,
        wellsList: null,
        OperatingProfitMonth: null,
        OperatingProfitYear: null,
        prs1: null,
        params: {
            data: [
            ],
            enableSearch: true,
            header: 'row',
            border: true,
            stripe: true,
            pagination: true,
            pageSize: 10,
            pageSizes: [10, 20, 50],
            height: 300
        }
    }
  },
  components: { VueTableDynamic }
};
</script>
<style scoped>
.title,
.subtitle,
.drag-area-title {
  color: white;
}
.table {
  color: #fff !important;
}
.bignumber {
  background-color: #20274e !important;
  border-radius: 15px;
  flex: 0 0 24%;
  margin-bottom: 5px;
}
.bignumber-number {
  color: #fff;
  font-size: 40px;
}
.bignumber-title {
  color: #fff;
  font-size: 20px;
  word-wrap: break-word;
}
.modal-bign{
  /* background-color: #0F1430;
  border: 1px solid #0D2B4D; */
}
</style>
