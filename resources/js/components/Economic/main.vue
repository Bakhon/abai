<template>
  <div class="container-fluid" v-if="is_data_fetched">
    <div class="row justify-content-between">
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
            <option value>Все ДЗО</option>
            <option value="?org=2.0">АО "ОзенМунайГаз"</option>
            <option value="?org=5.000001017E9">АО "Каражанбасмунай"</option>
            <option value="?org=5.00000202E9">ТОО "КазГерМунай"</option>
            <option value="?org=3.0">АО "ЭмбаМунайГаз"</option>
            <option value="?org=2.000000000004E12">АО "Мангистаумунайгаз</option>
          </select>
        </div>
      </div>
    </div>
    <div class="main row justify-content-between">
      <div class="col-md-3 col-sm-12 bignumber">
        <p class="bignumber-number text-center text-wrap">
          {{averageProfitlessCat1MonthCount}}
          <span class="badge badge-pill">
            <i
              class="fas fa-angle-down"
              style="color:green"
              v-if="persentCount>0"
            ></i>
            <i class="fas fa-angle-up" v-if="persentCount<0" style="color:red"></i>
            <span v-if="persentCount>0">{{persentCount}}%</span>
            <span v-if="persentCount<0">{{-1*persentCount}}%</span>
          </span>
        </p>
        <p
          class="text-center bignumber-title text-wrap"
        >Количество нерентабельных скважин за последний месяц</p>
      </div>
      <div class="col-md-3 col-sm-12 bignumber">
        <p class="bignumber-number text-center text-wrap">- {{year}}</p>
        <p class="text-center bignumber-title text-wrap">Операционные убытки по НРС с начала года</p>
      </div>
      <div class="col-md-3 col-sm-12 bignumber">
        <p class="bignumber-number text-center text-wrap">
          - {{month}}
          <span class="badge badge-pill">
            <i class="fas fa-angle-down" v-if="persent>0" style="color:green"></i>
            <i class="fas fa-angle-up" v-if="persent<0" style="color:red"></i>
            <span v-if="persent>0">{{persent}}%</span>
            <span v-if="persent<0">{{-1*persent}}%</span>
          </span>
        </p>
        <p
          class="text-center bignumber-title text-wrap"
        >Операционные убытки по НРС за последний месяц</p>
      </div>
      <div class="col-md-3 col-sm-12 bignumber">
        <p class="bignumber-number text-center text-wrap">{{prs}}</p>
        <p class="text-center bignumber-title text-wrap">Количество ПРС на НРС с начала года</p>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-5 col-sm-12">
          <!-- charts -->
          <line-component></line-component>
        </div>
        <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
          <!-- charts -->
          <line-component></line-component>
        </div>
        <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
          <!-- charts -->
          <line-component></line-component>
        </div>
        <div class="col-xl-6 ccol-lg-6 col-md-5 col-sm-12">
          <!-- charts -->
          <line-component></line-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
            this.is_data_fetched = true
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
                this.is_data_fetched = true
            }
            else {
                console.log('No data');
            }
        });
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
        is_data_fetched :false
    }
  },
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
  font-size: 15px;
  word-wrap: break-word;
}
</style>
