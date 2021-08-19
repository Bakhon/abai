<template>
  <div class="wrapper">
    <div class="top_wrapper">
      <div class="select_wrapper_left">
        <img
          src="/img/plastFluids/downloadsMonitoring.svg"
          alt="downloads monitoring"
        />
        <select class="select_left">
          <option>{{ trans("plast_fluids.downloads_monitoring") }}</option>
        </select>
      </div>
      <div class="select_wrapper_right">
        <svg
          width="20"
          height="20"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M7.33434 2.2999C6.61637 2.2999 6.03434 2.88193 6.03434 3.5999V7.99993C6.03434 8.38653 5.72094 8.69993 5.33434 8.69993C4.94774 8.69993 4.63434 8.38653 4.63434 7.99993V3.5999C4.63434 2.10873 5.84317 0.899902 7.33434 0.899902H16.4049C17.896 0.899902 19.1049 2.10873 19.1049 3.5999V12.6704C19.1049 14.1616 17.8961 15.3704 16.4049 15.3704H12.0004C11.6138 15.3704 11.3004 15.057 11.3004 14.6704C11.3004 14.2838 11.6138 13.9704 12.0004 13.9704H16.4049C17.1229 13.9704 17.7049 13.3884 17.7049 12.6704V3.5999C17.7049 2.88193 17.1229 2.2999 16.4049 2.2999H7.33434ZM5.33434 10.236C5.72094 10.236 6.03434 10.5494 6.03434 10.936V13.9705H9.06927C9.45587 13.9705 9.76927 14.2839 9.76927 14.6705C9.76927 15.0571 9.45587 15.3705 9.06927 15.3705H6.03434V18.4049C6.03434 18.7915 5.72094 19.1049 5.33434 19.1049C4.94774 19.1049 4.63434 18.7915 4.63434 18.4049V15.3705H1.60039C1.21379 15.3705 0.900391 15.0571 0.900391 14.6705C0.900391 14.2839 1.21379 13.9705 1.60039 13.9705H4.63434V10.936C4.63434 10.5494 4.94774 10.236 5.33434 10.236Z"
            fill="white"
          />
        </svg>

        <select class="select_right">
          <option>{{
            trans("plast_fluids.creating_new_download_templates")
          }}</option>
        </select>
      </div>
    </div>
    <div class="central_wrapper">
      <MonitoringLeftBlock />
      <div class="monitoring_wrapper">
        <div class="monitoring_select">
          <div>
            <img src="/img/plastFluids/backArrow.svg" alt="go back" />
            {{ trans("plast_fluids.downloads_monitoring") }}
          </div>
        </div>
        <div class="service_wrapper">
          <MonitoringDataTable />
          <MonitoringFileUpload />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MonitoringLeftBlock from "../components/MonitoringLeftBlock.vue";
import MonitoringDataTable from "../components/MonitoringDataTable.vue";
import MonitoringFileUpload from "../components/MonitoringFileUpload.vue";
import { mapState } from "vuex";

export default {
  name: "UploadMonitoring",
  components: {
    MonitoringLeftBlock,
    MonitoringDataTable,
    MonitoringFileUpload,
  },
  data() {
    return {
      templates: null,
    };
  },
  computed: {
    ...mapState("plastFluids", ["pickedSubsoilChildRadio"]),
  },
};
</script>

<style scoped>
:root {
  box-sizing: border-box;
}

*,
::before,
::after {
  box-sizing: inherit;
}

a {
  text-decoration: none;
  color: #fff;
}

.wrapper {
  margin: 0px;
  padding: 0px;
  width: 100%;
  height: 100%;
  border: none;
}

.top_wrapper {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 100%;
}

.select_wrapper_left {
  width: 100%;
  height: 40px;
  border-radius: 4px;
  margin-bottom: 15px;
  margin-right: 7.5px;
  display: flex;
  align-items: center;
  flex-direction: row;
  padding: 0px 25px;
  background-color: #2e50e9;
}

.select_wrapper_right {
  width: 100%;
  height: 40px;
  border-radius: 4px;
  margin-bottom: 15px;
  margin-left: 7.5px;
  display: flex;
  align-items: center;
  padding: 0px 25px;
  flex-direction: row;
  background-color: #333975;
}

.top_wrapper select {
  font-size: 16px;
  font-style: normal;
  font-weight: 700;
  line-height: 19px;
  letter-spacing: 0em;
  text-align: left;
  width: 100%;
  height: 100%;
  color: aliceblue;
  border: none;
}

.select_left {
  background-color: #2e50e9;
}

.select_right {
  background-color: #333975;
}

.central_wrapper {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: calc(100% - 55px);
}

.monitoring_wrapper {
  width: calc((1457 / (1457+15+350) * 100%));
  background-color: #272953;
  display: flex;
  flex-direction: column;
}

.service_wrapper {
  display: flex;
  flex-direction: row;
}

.monitoring_select > div {
  padding-top: 20px;
  padding-left: 25px;
  font-size: 22px;
  font-style: normal;
  font-weight: 700;
  line-height: 26px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
}
</style>
