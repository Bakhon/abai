<template>
  <div class="data-analysis-panel">
    <div class="content-holder">
      <div class="content-heading">
        <img
          src="/img/PlastFluids/tableCustomization.svg"
          alt="table settings"
        />
        <p>{{ trans("plast_fluids.table_settings") }}</p>
      </div>
      <div class="content">
        <div class="settings-input-holder">
          <input
            v-model="currentTable"
            :value="2"
            type="radio"
            id="experiments-study"
          />
          <label for="experiments-study">{{
            trans("plast_fluids.research_study")
          }}</label>
        </div>
        <div class="settings-input-holder">
          <input
            v-model="currentTable"
            :value="1"
            type="radio"
            id="sample-study"
          />
          <label for="sample-study">{{
            trans("plast_fluids.sample_study")
          }}</label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { getUploadTemplates } from "../../services/templateService";

export default {
  name: "DataAnalysisStudyPanel",
  data() {
    return {
      currentTable: 2,
      templates: [],
    };
  },
  inject: {
    userID: {
      default: "",
    },
  },
  watch: {
    currentTable(value) {
      this.handleTableData({
        user_id: this.userID,
        report_id: value,
        type: "analysis",
        template: this.findTemplate(value),
      });
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleTableData"]),
    async getTemplates() {
      const postData = new FormData();
      postData.append("user_id", this.userID);
      this.templates = await getUploadTemplates(postData);
    },
    findTemplate(id) {
      const found = this.templates.find((template) => template.id === id);
      return found;
    },
  },
  async mounted() {
    await this.getTemplates();
    this.handleTableData({
      user_id: this.userID,
      report_id: 2,
      type: "analysis",
      template: this.findTemplate(2),
    });
  },
};
</script>

<style scoped>
.data-analysis-panel {
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  background: #272953;
  width: 100%;
  height: 100%;
}

.content-holder {
  width: 100%;
  margin-bottom: 10px;
}

.content-heading {
  width: 100%;
  padding: 6px 10px;
  display: flex;
  align-items: center;
  background-color: #323370;
}

.content-heading > img {
  width: 18px;
  height: 18px;
  margin-right: 8px;
}

.content-heading > p {
  margin: 0;
  font-size: 14px;
}

.content {
  padding: 6px;
  width: 100%;
}

.settings-input-holder {
  padding: 8px 10px;
  display: flex;
  align-items: center;
  background: #363b68;
  border: 1px solid #545580;
}

.settings-input-holder:nth-of-type(1) {
  border-bottom: none;
}

.settings-input-holder:nth-of-type(2) {
  border-top: none;
}

.settings-input-holder > input {
  margin-right: 10px;
  cursor: pointer;
}

.settings-input-holder > label {
  margin: 0;
  font-size: 12px;
}
</style>
