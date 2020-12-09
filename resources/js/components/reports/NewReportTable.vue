<template>
  <div>
    <div>
      <div class="row margin-top">
        <!--<div class="underHeader">-->
        <div class="col-3">
          <div class="form-group1">
            <!--<label class="text-wrap" style="color:white; width:438px;" for="companySelect">Компания</label>-->
            <!--<select
                  style="background-color:#20274e;border-color:#20274e;color:white;"
                  class="form-control"
                  id="companySelect"
                  @change="onChange($event)"
                >-->

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

                <div class="float">Компания</div></option
              >
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
            <!--<label class="text-wrap" style="color:white;" for="companySelect">Выберите месяц</label>-->
            <!-- https://developer.snapappointments.com/bootstrap-select/examples/#basic-examples -->
            <!-- multiple data-selected-text-format="count > 3" title="Выберите месяц" lang="ru" class="selectpicker"-->
            <select
              data-live-search="true"
              style="
                background-color: #333975;
                border-color: #20274e;
                color: white;
              "
              multiple
              data-selected-text-format="count > 3"
              title="Выбрать месяц"
              lang="ru"
              class="selectpicker select-month"
              id="companySelect"
              @change="onChangeMonth($event)"
            >
              <option value="">Выбрать месяц</option>
              <option value="1">январь</option>
              <option value="2">февраль</option>
              <option value="3">март</option>
              <option value="4">апрель</option>
              <option value="5">май</option>
              <option value="6">июнь</option>
              <option value="7">июль</option>
              <option value="8">август</option>
              <option value="9">сентябрь</option>
              <option value="10">октябрь</option>
              <option :disabled="year == 2020" value="11">ноябрь</option>
              <option :disabled="year == 2020" value="12">декабрь</option>
            </select>
          </div>
        </div>

        <div class="col-3">
          <div class="form-group3">
            <!--<label class="text-wrap" style="color:white;" for="companySelect">Выберите год</label>-->
            <select
              style="
                background-color: #333975;
                border-color: #20274e;
                color: white;
              "
              class="form-control"
              id="companySelect"
              @change="onChangeYear($event)"
            >
              <option value=""> Выберите год </option>
              <option value="2020">2020</option>
              <option value="2019">2019</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
            </select>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group4">
            <button
             class="report-btn2"
              :disabled="
                org == '' ||
                month == '' ||
                year == '' ||
                (year == 2020 && month > 10)
              "
              @click="updateData"
             
            >
              Сформировать отчет
            </button>
          </div>
        </div>
        <!-- </div>-->
      </div>
    </div>
    <div :hidden="data == ''">
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
