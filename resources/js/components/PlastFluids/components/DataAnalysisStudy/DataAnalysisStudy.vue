<template>
  <div class="data-analysis-study">
    <div class="study-table-title-holder">
      <div class="study-table-title">
        <div>
          <img
            src="/img/PlastFluids/tableIcon.png"
            alt="detailed research statistics"
          />
          <p>{{ trans("plast_fluids.analysis_study_table_title") }}</p>
        </div>
        <button @click="handleTableDownload">
          <img src="/img/PlastFluids/data_upload.svg" alt="download table" />
        </button>
      </div>
    </div>
    <div class="study-table-holder">
      <BaseTable tableType="study" :fields="tableFields" :items="tableRows" />
    </div>
  </div>
</template>

<script>
import BaseTable from "../BaseTable.vue";
import { mapState, mapActions } from "vuex";
import { getTemplateFile } from "../../services/templateService";
import { convertToFormData, downloadExcelFile } from "../../helpers";

export default {
  name: "DataAnalysisStudy",
  components: {
    BaseTable,
  },
  inject: {
    userID: {
      default: "",
    },
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    ...mapState("plastFluidsLocal", [
      "currentTemplate",
      "currentBlocks",
      "tableFields",
      "tableRows",
    ]),
  },
  watch: {
    currentSubsoilField: {
      handler() {
        this.handleTableData({
          user_id: this.userID,
          report_id: this.currentTemplate.id,
          type: "analysis",
        });
      },
      deep: true,
    },
    currentSubsoilHorizon() {
      this.handleTableData({
        user_id: this.userID,
        report_id: this.currentTemplate.id,
        type: "analysis",
      });
    },
    currentBlocks() {
      this.handleTableData({
        user_id: this.userID,
        report_id: this.currentTemplate.id,
        type: "analysis",
      });
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleTableData"]),
    async handleTableDownload() {
      let horizonIDs = "None";
      let blockIDs = "None";
      if (this.currentSubsoilHorizon.length)
        horizonIDs = this.currentSubsoilHorizon.map(
          (horizon) => horizon.horizon_id
        );
      if (this.currentBlocks.length)
        blockIDs = this.currentBlocks.map((block) => block.block_id);

      const postData = convertToFormData({
        user_id: this.userID,
        field_id: this.currentSubsoilField[0].field_id,
        report_id: this.currentTemplate.id,
        horizons: horizonIDs,
        blocks: blockIDs,
      });

      const file = await getTemplateFile(postData);
      downloadExcelFile(this.currentTemplate["name_" + this.currentLang], file);
    },
  },
};
</script>

<style scoped>
.data-analysis-study {
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 100%;
}

.study-table-title-holder {
  border: 6px solid #272953;
  border-bottom: none;
  width: 100%;
  height: 40px;
}

.study-table-title {
  width: 100%;
  height: 100%;
  background: #323370;
  border: 1px solid #545580;
  padding: 8px 11px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.study-table-title > div {
  display: flex;
  align-items: center;
}

.study-table-title > div > img {
  width: 18px;
  height: 14px;
  margin-right: 9px;
}

.study-table-title > div > p {
  margin: 0;
  font-size: 16px;
  color: #fff;
}

.study-table-title > button {
  border: none;
  background-color: unset;
  width: 18px;
  height: 18px;
  display: flex;
}

.study-table-title > button > img {
  width: 100%;
  height: 100%;
}

.study-table-holder {
  border: 6px solid #272953;
  padding: 4px;
  width: 100%;
  max-height: calc(100% - 40px);
}
</style>
