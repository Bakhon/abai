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
import { mapState, mapMutations, mapActions } from "vuex";
import Header from "../components/Header.vue";
import MonitoringLeftBlock from "../components/MonitoringLeftBlock.vue";
import MonitoringDownloadTable from "../components/MonitoringDownloadTable.vue";
import SmallCatLoader from "../components/SmallCatLoader.vue";

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
      userName: this.user.name,
    };
  },
  computed: {
    ...mapState("plastFluidsLocal", ["loading", "templates"]),
  },
  methods: {
    ...mapMutations("plastFluidsLocal", ["SET_CURRENT_TEMPLATE"]),
    ...mapActions("plastFluidsLocal", ["getTemplates"]),
  },
  mounted() {
    this.getTemplates({
      userID: this.user.id,
      lang: this.currentLang,
      templateID: 1,
    });
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
