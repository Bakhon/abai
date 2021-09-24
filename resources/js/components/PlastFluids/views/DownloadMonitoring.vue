<template>
  <div class="wrapper">
    <div class="top-wrapper">
      <Header />
    </div>
    <div class="central-wrapper">
      <MonitoringLeftBlock :templates="templates" />
      <SmallCatLoader v-if="loading" :loading="loading" />
      <MonitoringDownloadTable v-else />
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Header from "../components/Header.vue";
import MonitoringLeftBlock from "../components/MonitoringLeftBlock.vue";
import MonitoringDownloadTable from "../components/MonitoringDownloadTable.vue";
import SmallCatLoader from "../components/SmallCatLoader.vue";
import { getUploadTemplates } from "../services/templateService";
import { convertTemplateData } from "../helpers";

export default {
  name: "DownloadMonitoring",
  components: {
    Header,
    MonitoringLeftBlock,
    MonitoringDownloadTable,
    SmallCatLoader,
  },
  data() {
    return {
      templates: [],
      currentPage: 1,
      perPage: 15,
      pageOptions: [15, 20, 25, { value: 100, text: "Показать больше" }],
    };
  },
  computed: {
    ...mapState("plastFluidsLocal", ["loading"]),
  },
  methods: {
    async getTemplates() {
      const data = await getUploadTemplates();
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

.top-wrapper {
  width: 100%;
}

.wrapper {
  margin: 0px;
  padding: 0px;
  width: 100%;
  height: 100%;
  border: none;
}

.central-wrapper {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
}
</style>
