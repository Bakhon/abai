<template>
  <div>
    <div class="flex-wrapper">
      <activity-type />
      <new-template-create />
    </div>    
  </div>
</template>

<script>
import activityType from "../components/uploadMonitoring/activityType";
import newTemplateCreate from "../components/uploadMonitoring/newTemplateCreate";
import sections from "../components/uploadMonitoring/sections";
import tableOfUploads from "../components/uploadMonitoring/tableOfUploads";
import fileUpload from "../components/uploadMonitoring/fileUpload";
import uploadStatus from "../components/uploadMonitoring/uploadStatus";
export default {
  components: {
    activityType,
    newTemplateCreate,
    sections,
    tableOfUploads,
    fileUpload,
    uploadStatus,
  },
};
</script>

<style scoped>

</style>
