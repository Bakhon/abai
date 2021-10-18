<template>
  <div class="upload-status-log">
    <p class="upload-status-title">{{ trans("plast_fluids.download_log") }}</p>
    <div class="log" ref="logDiv">
      <div style="color: red;" v-if="downloadFileData.status === 'error'">
        <p v-if="reportDuplicated">
          {{ trans("plast_fluids.report_duplicated") }}
        </p>
        <p v-else>Ошибка с шаблоном, перепроверьте данные</p>
      </div>
      <div style="color: green;" v-if="downloadFileData.status === 'ok'">
        <p>
          {{
            `${trans("plast_fluids.template_upload_successfully")} ${
              downloadFileData.user
            } ${downloadFileData.template}`
          }}
        </p>
      </div>
      <template v-for="(sheetlog, ind) in fileLog">
        <div v-if="sheetlog[1].length" :key="ind">
          <p>{{ sheetlog[0] }}</p>
          <div class="row-log">
            <p v-for="(rowlog, index) in sheetlog[1]" :key="index">
              {{ rowlog[Object.keys(rowlog)[0]] }}
            </p>
          </div>
        </div>
      </template>
    </div>
    <div class="download-log-button">
      <button
        @click="downloadLog"
        class="log-button"
        :disabled="!fileLog"
        :class="{ disabled: !fileLog }"
      >
        {{ trans("plast_fluids.download_status_log") }}
      </button>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "MonitoringFileLog",
  computed: {
    ...mapState("plastFluidsLocal", [
      "fileLog",
      "reportDuplicated",
      "downloadFileData",
    ]),
  },
  methods: {
    downloadLog() {
      const blob = new Blob(
        [`<html><body>${this.$refs.logDiv.outerHTML}</body></html>`],
        { type: "text/html" }
      );
      let link = document.createElement("a");

      link.download = this.trans("plast_fluids.download_log");
      link.href = URL.createObjectURL(blob);
      link.click();
    },
  },
};
</script>

<style scoped>
.upload-status-log {
  background-color: #272953;
  width: 100%;
  height: 100%;
  padding: 0 11px;
  display: flex;
  flex-flow: column;
}

.upload-status-title {
  font-size: 20px;
  font-weight: 700;
  color: #fff;
  margin: 25px 0 13px 4px;
}

.log {
  background-color: #313560;
  border-radius: 4px;
  height: 100%;
  flex: 1 1 0;
  padding: 14px;
  overflow-y: auto;
}

.log > div {
  color: #fff;
  margin-bottom: 8px;
}

.log > div > p {
  font-size: 18px;
  margin-bottom: 12px;
}

.row-log > p {
  font-size: 14px;
  margin: 8px 0;
}

.download-log-button {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 32px;
  margin: 14px 0;
}

.log-button {
  height: 100%;
  background-color: #3366ff;
  font-size: 14px;
  font-weight: 600;
  text-align: center;
  color: #fff;
  border-radius: 4px;
  padding: 6px 18px;
  border: none;
}

.disabled {
  background-color: #cccccc;
  color: #666666;
  cursor: not-allowed;
}

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
