<template>
  <div class="filter-container">
    <cat-loader v-show="isLoading"/>
    <div class="form-group1 filter-group select">
      <select
          class="form-control filter-input select"
          id="companySelect"
          :disabled="isLoading"
          v-model="org"
      >
        <option disabled value="">Выберите компанию</option>
        <option value="АО ОМГ">АО «ОзенМунайГаз»</option>
        <option value="КБМ">АО «Каражанбасмунай»</option>
        <option value="КазГерМунай">ТОО «КазГерМунай»</option>
        <option value="АО ЭМГ">АО «ЭмбаМунайГаз»</option>
        <option value="ММГ">АО «Мангистаумунайгаз»</option>
      </select>
    </div>

    <div class="form-group2 filter-group">
      <label for="start_date">Выберите начальную дату</label>
      <datetime
          id="start_date"
          type="date"
          v-model="start_date"
          value-zone="Asia/Almaty"
          zone="Asia/Almaty"
          input-class="form-control filter-input"
          format="LLLL yyyy"
          :phrases="{ok: '', cancel: ''}"
          :disabled="isLoading"
          auto
          :flow="['year', 'month']"
      >
      </datetime>
    </div>

    <div class="form-group3 filter-group">
      <label for="end_date">Выберите конечную дату</label>
        <datetime
            id="end_date"
            type="date"
            v-model="end_date"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            input-class="form-control filter-input"
            format="LLLL yyyy"
            :phrases="{ok: '', cancel: ''}"
            :disabled="isLoading"
            auto
            :flow="['year', 'month']"
        >
        </datetime>

    </div>

    <div class="form-group3 result-link text-center">
          <a v-if="resultLink !== null && !isLoading" :href="resultLink"  target="_blank" class="download_report">Скачать отчёт</a>
      </div>

    <div class="form-group4">
      <button :disabled="!org || !start_date || !end_date || isLoading"
              @click="updateData()"
              class="btn get-report-button">
        <span>
          <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.7066 5.70711L10.2925 1.2929C10.105 1.10536 9.85061 1 9.58539 1L1.99979 1.00002C1.44751 1.00002 0.999797 1.44774 0.999797 2.00002L0.999797 18C0.999797 18.5523 1.44751 19 1.9998 19L13.9995 19C14.5518 19 14.9995 18.5523 14.9995 18L14.9995 6.41421C14.9995 6.14899 14.8942 5.89464 14.7066 5.70711Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9.11768 1V6.02353C9.11768 6.57581 9.56539 7.02353 10.1177 7.02353H14.9999" stroke="white" stroke-width="1.4" stroke-linejoin="round"/>
            <path d="M4.37372 13.1938C4.66705 13.1938 4.90572 13.2885 5.08972 13.4778C5.27372 13.6645 5.36572 13.9085 5.36572 14.2098C5.36572 14.2685 5.36305 14.3218 5.35772 14.3698H4.01372C4.01372 14.4792 4.05105 14.5725 4.12572 14.6498C4.20039 14.7245 4.29239 14.7618 4.40172 14.7618C4.55105 14.7618 4.65639 14.7018 4.71772 14.5818H5.34172C5.27505 14.7818 5.16305 14.9418 5.00572 15.0618C4.84839 15.1818 4.64305 15.2418 4.38972 15.2418C4.10439 15.2418 3.86172 15.1472 3.66172 14.9578C3.46439 14.7685 3.36572 14.5192 3.36572 14.2098C3.36572 13.9165 3.45372 13.6738 3.62972 13.4818C3.80839 13.2898 4.05639 13.1938 4.37372 13.1938ZM4.36572 13.6298C4.26705 13.6298 4.18705 13.6605 4.12572 13.7218C4.06439 13.7805 4.02839 13.8538 4.01772 13.9418H4.71372C4.70305 13.8512 4.66572 13.7765 4.60172 13.7178C4.54039 13.6592 4.46172 13.6298 4.36572 13.6298ZM5.42922 15.1738L6.11722 14.2178L5.46522 13.2578H6.20922L6.39722 13.5978C6.42922 13.6565 6.45855 13.7258 6.48522 13.8058H6.50122C6.53855 13.6938 6.56255 13.6272 6.57322 13.6058L6.74522 13.2578H7.48522L6.83722 14.2058L7.50522 15.1738H6.73322L6.54922 14.8338C6.50389 14.7458 6.47855 14.6738 6.47322 14.6178H6.45722C6.44122 14.6765 6.41189 14.7498 6.36922 14.8378L6.18522 15.1738H5.42922ZM8.5735 13.1938C8.8295 13.1938 9.04017 13.2725 9.2055 13.4298C9.37083 13.5845 9.4695 13.7672 9.5015 13.9778H8.8495C8.83617 13.9112 8.80283 13.8578 8.7495 13.8178C8.69883 13.7778 8.6375 13.7578 8.5655 13.7578C8.44817 13.7578 8.3615 13.8005 8.3055 13.8858C8.25217 13.9712 8.2255 14.0805 8.2255 14.2138C8.2255 14.3472 8.25483 14.4578 8.3135 14.5458C8.37217 14.6312 8.46017 14.6738 8.5775 14.6738C8.65217 14.6738 8.71483 14.6525 8.7655 14.6098C8.81883 14.5645 8.85483 14.5072 8.8735 14.4378H9.5375C9.47883 14.6805 9.36683 14.8752 9.2015 15.0218C9.03883 15.1685 8.82683 15.2418 8.5655 15.2418C8.28017 15.2418 8.0375 15.1472 7.8375 14.9578C7.64017 14.7685 7.5415 14.5192 7.5415 14.2098C7.5415 13.9218 7.63483 13.6805 7.8215 13.4858C8.00817 13.2912 8.25883 13.1938 8.5735 13.1938ZM10.7604 13.1938C11.0538 13.1938 11.2924 13.2885 11.4764 13.4778C11.6604 13.6645 11.7524 13.9085 11.7524 14.2098C11.7524 14.2685 11.7498 14.3218 11.7444 14.3698H10.4004C10.4004 14.4792 10.4378 14.5725 10.5124 14.6498C10.5871 14.7245 10.6791 14.7618 10.7884 14.7618C10.9378 14.7618 11.0431 14.7018 11.1044 14.5818H11.7284C11.6618 14.7818 11.5498 14.9418 11.3924 15.0618C11.2351 15.1818 11.0298 15.2418 10.7764 15.2418C10.4911 15.2418 10.2484 15.1472 10.0484 14.9578C9.8511 14.7685 9.75244 14.5192 9.75244 14.2098C9.75244 13.9165 9.84044 13.6738 10.0164 13.4818C10.1951 13.2898 10.4431 13.1938 10.7604 13.1938ZM10.7524 13.6298C10.6538 13.6298 10.5738 13.6605 10.5124 13.7218C10.4511 13.7805 10.4151 13.8538 10.4044 13.9418H11.1004C11.0898 13.8512 11.0524 13.7765 10.9884 13.7178C10.9271 13.6592 10.8484 13.6298 10.7524 13.6298ZM12.107 15.1738V12.2938H12.783V15.1738H12.107Z" fill="white"/>
          </svg>
        </span>
        &nbsp;Выгрузить в Excel
      </button>
    </div>
  </div>
</template>

<script>

import Vue from "vue";
import {Datetime} from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';
import {formatDate} from './FormatDate.js'

Vue.use(Datetime)

export default {
  components: {
  },

  data() {

    return {
      org: '',
      start_date: null,
      end_date: null,
      isLoading: false,
      resultLink: null
    }

  },
  methods: {
    createDownloadLink(response) {
        this.resultLink = response.data.report_link
    },
    updateData() {
      this.isLoading = true;

      let uri = "http://172.20.103.157:8082/monthly/production/";
        // let uri = "http://0.0.0.0:8090/monthly/production/";
      let data = {
        dzo: this.org,
        period: 'monthly',
        report_date_start: formatDate.format_to_first_day_of_month(this.start_date),
        report_date_end: formatDate.format_to_first_day_of_month(this.endDate)
      };

      let json_data = JSON.stringify(data);

      this.axios.post(uri, json_data, {
          responseType:'json',
          headers: {
            'Content-Type': 'application/json'
          }
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

.bootstrap-table .fixed-table-container .table {
  color: white;
}

.table-hover tbody tr:hover {
  color: #d4d4d4 !important;
  background-color: rgba(0, 0, 0, 0.075);
}

.float {
  float: left;
}

/*.form-control {*/
/*  padding: unset!important;*/
/*}*/

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
.download_report {
  color: white;
  font-size: 28px;
  text-decoration: underline;
  font-weight: bold;
}
</style>
