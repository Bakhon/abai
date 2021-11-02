<template>
  <div class="wrapper">
    <div class="top-wrapper">
      <Header />
    </div>
    <div class="central-wrapper">
      <MonitoringLeftBlock :templates="templates" />
      <MonitoringDataTable
        :currentSubsoil="currentSubsoil[0]"
        :currentSubsoilField="currentSubsoilField[0]"
      />
      <MonitoringFileUploadAndLog />
    </div>
  </div>
</template>

<script>
import Header from "../components/Header.vue";
import MonitoringLeftBlock from "../components/MonitoringLeftBlock.vue";
import MonitoringDataTable from "../components/MonitoringDataTable.vue";
import MonitoringFileUploadAndLog from "../components/MonitoringFileUploadAndLog.vue";
import { mapState } from "vuex";
import { getDownloadTemplates } from "../services/templateService";
import { convertTemplateData } from "../helpers";

export default {
  name: "UploadMonitoring",
  components: {
    Header,
    MonitoringLeftBlock,
    MonitoringDataTable,
    MonitoringFileUploadAndLog,
  },
  props: {
    user: Object,
  },
  data() {
    return {
      templates: [],
    };
  },
  provide() {
    return {
      name: this.user.name,
      id: this.user.id,
      type: 'download',
    };
  },
  computed: {
    ...mapState("plastFluids", ["currentSubsoil", "currentSubsoilField"]),
  },
  methods: {
    async getTemplates() {
      const data = await getDownloadTemplates();
      this.templates = convertTemplateData(data, this.currentLang);
    },
  },
  mounted() {
    this.getTemplates();
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

.top-wrapper {
  width: 100%;
}

.central-wrapper {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
}
</style>
