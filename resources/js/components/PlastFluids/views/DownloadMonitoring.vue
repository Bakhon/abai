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
import { mapState, mapMutations } from "vuex";
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
  props: {
    user: Object,
  },
  provide() {
    return {
      userID: this.user.id,
    };
  },
  data() {
    return {
      templates: [],
    };
  },
  computed: {
    ...mapState("plastFluidsLocal", ["loading"]),
  },
  methods: {
    ...mapMutations("plastFluidsLocal", ["SET_CURRENT_TEMPLATE"]),
    async getTemplates() {
      const payload = new FormData();
      payload.append("user_id", this.user.id);
      const data = await getUploadTemplates(payload);
      this.templates = convertTemplateData(data, this.currentLang);
      const initTemplate = data.find((template) => template.id === 1);
      this.SET_CURRENT_TEMPLATE(initTemplate);
    },
  },
  mounted() {
    this.getTemplates();
  },
};
</script>

<style scoped>
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
