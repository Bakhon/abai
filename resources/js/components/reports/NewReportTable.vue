<template>
  <div>
    <div>
      <div class="row margin-top">
        <div class="col-3">
          <div class="form-group1">
            <select
              style="
                background-color: #333975;
                border-color: #20274e;
                color: white;
              "
              class="form-control"
              id="companySelect"
              @change="onChange($event)"
            >
              <option value="">
                <div class="float margin-top">
                  <svg
                    width="24"
                    height="25"
                    viewBox="0 0 24 25"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.8281 8.03125L17.8282 21.0014H21.9945L21.9945 8.03125H17.8281ZM19.3136 10.4187H20.4853V11.5819H19.3136V10.4187ZM20.4853 16.8329H19.3136V15.6697H20.4853V16.8329ZM20.5015 14.2074H19.3298V13.0441H20.5015V14.2074Z"
                      fill="white"
                    />
                    <path
                      d="M17.8394 5.00195H21.9971V6.86698H17.8394V5.00195Z"
                      fill="white"
                    />
                    <path
                      d="M2.00008 3.91418L2 21.0003L6.18574 21.0002L6.18582 5.09622L2.00008 3.91418ZM3.50583 7.79565H4.67757V8.95892H3.50583V7.79565ZM4.67878 16.8354H3.50704V15.6722H4.67878V16.8354ZM4.67878 14.2099H3.50704V13.0467H4.67878V14.2099ZM4.68624 11.5844H3.5145V10.4211H4.68624V11.5844Z"
                      fill="white"
                    />
                    <path
                      d="M10.2417 17.8008H11.4134V20.9998H10.2417V17.8008Z"
                      fill="white"
                    />
                    <path
                      d="M12.5864 17.8008H13.7582V20.9998H12.5864V17.8008Z"
                      fill="white"
                    />
                    <path
                      d="M7.46826 3V21H9.0708V16.6377H14.9295V21H16.6597V3H7.46826ZM10.2425 14.8929H9.0708V12.4209H10.2425V14.8929ZM10.2425 11.2576H9.0708V8.7857H10.2425V11.2576ZM10.2425 7.62243H9.0708V5.15049H10.2425V7.62243ZM12.586 14.8929H11.4143V12.4209H12.586V14.8929ZM12.586 11.2576H11.4143V8.7857H12.586V11.2576ZM12.586 7.62243H11.4143V5.15049H12.586V7.62243ZM14.9295 14.8929H13.7577V12.4209H14.9295V14.8929ZM14.9295 11.2576H13.7577V8.7857H14.9295V11.2576ZM14.9295 7.62243H13.7577V5.15049H14.9295V7.62243Z"
                      fill="white"
                    />
                  </svg>
                </div>
                <div class="float">Компания</div></option>
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
            <input class="form-control datepicker" type="date" v-model="start_date">
          </div>
        </div>

        <div class="col-3">
          <div class="form-group3">
            <input class="form-control datepicker" type="date" v-model="end_date">
          </div>
        </div>
        <div class="col-3">
          <div class="form-group4">
            <button v-if="org && start_date && end_date"
             class="report-btn2"
              @click="updateData">
              Сформировать отчет
            </button>
          </div>
        </div>
        <!-- </div>-->
      </div>
    </div>
    <div class="table">
      <BootstrapTable
        :columns="columns"
        :data="data"
        :options="options"
        :height="100"
      />
    </div>
  </div>
</template>

<script src="./NewReportTable.js"></script>
<style scoped>
.datepicker {
    background-color: rgb(51, 57, 117);
    color: #fff;
    border: none;
}
.table {
    padding: 15px;
}
</style>
