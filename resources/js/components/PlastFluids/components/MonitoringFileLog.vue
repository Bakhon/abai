<template>
  <div class="upload-status-log">
    <p class="upload-status-title">{{ trans("plast_fluids.download_log") }}</p>
    <div class="log"></div>
    <div class="download-log-button">
      <button>
        Скачать лог загрузки
      </button>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  name: "MonitoringFileLog",
  computed: {
    ...mapState("plastFluidsLocal", ["fileLog", "reportDuplicated"]),
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
  flex: 1 1 auto;
  padding: 14px;
}

.download-log-button {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 32px;
  margin: 14px 0;
}

.download-log-button > button {
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
</style>
