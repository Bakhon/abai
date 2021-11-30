<template>
  <div
    class="monitoring-table-div"
    :class="{ center: !currentSubsoilField[0] }"
  >
    <template v-if="currentSubsoilField[0] && currentSubsoilField[0].field_id">
      <div class="table-title-holder">
        <p class="monitoring-table-title">
          {{ currentTemplate ? currentTemplate["name_" + currentLang] : "" }}
        </p>
        <div class="buttons-holder">
          <button @click="handleTemplateDownload">
            <img
              src="/img/PlastFluids/data_upload.svg"
              alt="download template"
            />
          </button>
          <button @click="isOpenModal = true">
            <img src="/img/PlastFluids/settings.svg" alt="customize table" />
          </button>
        </div>
      </div>
      <BaseTable
        :fields="tableFields"
        :items="tableRows"
        pagination
        filter
        sticky
      />
    </template>
    <p v-else>{{ trans("plast_fluids.no_field_selected") }}</p>
    <Modal
      v-if="isOpenModal"
      @close-modal="isOpenModal = false"
      :templateName="
        currentTemplate ? currentTemplate['name_' + currentLang] : ''
      "
      :fields="tableFields"
    />
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import BaseTable from "./BaseTable.vue";
import Modal from "./MonitoringDownloadTableModal.vue";
import { downloadExcelFile, convertToFormData } from "../helpers";
import { getTemplateFile } from "../services/templateService";

export default {
  name: "MonitoringDownloadTable",
  data() {
    return {
      isOpenModal: false,
    };
  },
  inject: {
    userID: {
      default: "",
    },
  },
  components: {
    BaseTable,
    Modal,
  },
  computed: {
    ...mapState("plastFluidsLocal", [
      "currentTemplate",
      "tableFields",
      "tableRows",
    ]),
    ...mapState("plastFluids", ["currentSubsoilField"]),
  },
  watch: {
    currentSubsoilField: {
      handler(value) {
        this.handleTableData({
          field_id: value[0].field_id,
          user_id: this.userID,
        });
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleTableData"]),
    async handleTemplateDownload() {
      const postData = convertToFormData({
        user_id: this.userID,
        field_id: this.currentSubsoilField[0].field_id,
        report_id: this.currentTemplate.id,
        horizons: "None",
        blocks: "None",
      });
      const file = await getTemplateFile(postData);
      downloadExcelFile(this.currentTemplate["name_" + this.currentLang], file);
    },
  },
  mounted() {
    if (
      this.currentSubsoilField[0]?.field_id &&
      !this.tableRows.length &&
      !this.tableFields.length
    ) {
      this.handleTableData({
        field_id: this.currentSubsoilField[0].field_id,
        user_id: this.userID,
      });
    }
  },
};
</script>

<style scoped>
.monitoring-table-div {
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  flex: 2 1 auto;
  padding: 15px;
  background: #272953;
  margin: 0 0 0 10px;
}

.monitoring-table-div > p {
  font-size: 34px;
  color: #fff;
}

.table-title-holder {
  display: flex;
  width: 100%;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 17px;
}

.buttons-holder {
  display: flex;
  align-items: center;
}

.buttons-holder > button {
  border: none;
  background-color: unset;
  width: 18px;
  height: 18px;
}

.buttons-holder > button:nth-of-type(1) {
  margin-right: 10px;
}

.buttons-holder > button > img {
  width: 100%;
  height: 100%;
}

.monitoring-table-title {
  margin: 0;
  font-weight: bold;
  font-size: 22px;
  color: #fff;
  height: 30px;
}

.center {
  justify-content: center;
  align-items: center;
}
</style>
