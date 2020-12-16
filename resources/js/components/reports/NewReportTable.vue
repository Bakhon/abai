<template>
  <div>
    <div class="container">
      <div class="row margin-top">
        <div class="col-3">
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

        <div class="col-3">
          <div class="form-group2">
            <input class="form-control datepicker"
                   type="month"
                   :disabled="isLoading"
                   v-model="start_date">
          </div>
        </div>

        <div class="col-3">
          <div class="form-group3">
            <input class="form-control datepicker"
                   type="month"
                   :disabled="isLoading"
                   v-model="end_date">
          </div>
        </div>

        <div class="col-3">
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
