<template>
  <div>
    <div class="container">
<!--      <div class="row margin-top">-->
      <div class="col margin-top">
        <div class="col-12">
          <div class="form-group1">
            <select
                style="background-color:#333975; border-color:#20274e; color:white;"
                class="form-control"
                id="companySelect"
                :disabled="isLoading"
                v-model="org"
            >
              <option disabled value="">Компания</option>
              <option value="АО ОМГ">АО «ОзенМунайГаз»</option>
              <option value="КБМ">АО «Каражанбасмунай»</option>
              <option value="КазГерМунай">ТОО «КазГерМунай»</option>
              <option value="АО ЭМГ">АО «ЭмбаМунайГаз»</option>
              <option value="ММГ">АО «Мангистаумунайгаз»</option>
            </select>
          </div>
        </div>

        <div class="col-12">
          <div class="form-group2">
            <input class="form-control datepicker"
                   type="month"
                   :disabled="isLoading"
                   v-model="start_date">
          </div>
        </div>

        <div class="col-12">
          <div class="form-group3">
            <input class="form-control datepicker"
                   type="month"
                   :disabled="isLoading"
                   v-model="end_date">
          </div>
        </div>

        <div class="col-12">
          <div class="form-group4">
            <button :disabled="!org || !start_date || !end_date || isLoading"
                    @click="updateData()"
                    class="btn report-btn">Сформировать отчет
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>

export default {
  components: {},
  data() {

    return {
      org: '',
      start_date: null,
      end_date: null,
      isLoading: false
    }

  },
  methods: {
    createDownloadLink(response) {
      let blob = new Blob([response.data], {type:'application/*'})
      let link = document.createElement('a')
      link.href = window.URL.createObjectURL(blob)
      link.download = `${this.start_date}_${this.end_date}_exportTable.xls`
      link.click();
      link.remove();
    },
    updateData() {
      let uri = "/ru/protodata";
      let data = {
        org: this.org,
        start_date: `${this.start_date}-01`,
        end_date: `${this.end_date}-${this.$moment(this.end_date, "YYYY-MM").daysInMonth()}`
      };

      this.isLoading = true;

      this.axios.post(uri, data, {
        responseType:'arraybuffer'
      })
        .then((response) => {
          if (response.data) {
            this.createDownloadLink(response)
          } else {
            console.log("No data");
          }
        })
        .catch((error) => console.log(error))
        .finally(() => this.isLoading = false);
    },
    onChange(event) {
      this.org = event.target.value;
    },
    onChangeMonth(event) {
      this.month = event.target.value;
    },
    onChangeYear(event) {
      this.year = event.target.value;
    },
  },
}
</script>

<style scoped>
.underHeader {
  position: relative;
  Width: 1795px;
  Height: 866px;
}

.underHeader>.col-sm1 {
  width: 438px;
  right: 1500px;
}

/* .underHeader > .col-sm2 > .form-group2 > .dropdown bootstrap-select show-tick{
    width: 438px;
    left: 65px;
    bottom: 51px;
}
.underHeader > .col-sm3 {
    width: 438px;
    left: 515px;
    bottom: 101px;
}
.underHeader > .col-sm4 > .form-group4 > .btn report-btn{
    width: 451px;
    height: 40px;
} */

.background-table {
  /*Width: 1822px;
  Height: 960px;
  position: absolute;
  Top: 60px;
  right: 20px;
  left: 8px;*/
  margin-left: 10px;
  width: 100%;
  height: 90vh;
  background-color: #272953;
}

/* #companySelect {
    background-color: #333975;
    border-color: rgb(32, 39, 78);
    color: white;
    width: 438px;
} */

.fixed-columns {
  left: 0;
  background: #20274e!important;
}

.p-4 {
  background-color: #0F1430;
}

.fixed-table-container {
  background: #20274e;
}

.bootstrap-table .fixed-table-container .table {
  color: white;
}

/*.main {*/
/*  background-color: #0F1430;*/
/*  background-image: url('img/level1/grid.svg');*/
/*  border: 1px solid #0D2B4D;*/
/*  margin-left: 0px !important;*/
/*  padding-top: 20px;*/
/*}*/

.title, .subtitle {
  color: white;
  position: absolute;
  top: 100px;
  left: -18px;
  font-size: 18px;
  font-family: Harmonia Sans Pro Cyr;
}

.top {
  display: none;
}

.table-hover tbody tr:hover {
  color: #d4d4d4 !important;
  background-color: rgba(0, 0, 0, 0.075);
}

.float {
  float: left;
}

.form-control {
  padding: unset!important;
  width: 94%!important;
}

.margin-top {
  margin-top: 5px;
}

.select-month{
  background: rgb(51, 57, 117);
  border-color: rgb(32, 39, 78);
  width: 41vh!important;
}

.report-btn2 {
  background: #2d4fe6;
  color: white;
  border-radius: unset;
  width:100%;
  height: 36px;

}

.margin-top {
  padding: 15px;
}
</style>
