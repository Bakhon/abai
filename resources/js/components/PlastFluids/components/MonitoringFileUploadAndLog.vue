<template>
  <div class="upload_wrapper">
    <MonitoringFileUpload />
    <MonitoringFileLog />
  </div>
</template>

<script>
import MonitoringFileUpload from "./MonitoringFileUpload.vue";
import MonitoringFileLog from "./MonitoringFileLog.vue";

export default {
  name: "MonitoringFileUploadBlock",
  components: {
    MonitoringFileUpload,
    MonitoringFileLog,
  },
};
</script>

<style scoped>
.upload_wrapper {
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  height: 100%;
  width: 360px;
  flex-shrink: 0;
}
</style>
