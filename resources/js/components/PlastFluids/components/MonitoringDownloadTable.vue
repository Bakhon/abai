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
          <button
            v-if="!currentTemplate.custom_template"
            @click.stop="isOpenModal = true"
          >
            <img src="/img/PlastFluids/settings.svg" alt="customize table" />
          </button>
          <button v-else @click="isDeleteTemplateModalOpen = true">
            <img
              src="/img/PlastFluids/delete.svg"
              alt="delete custom template"
            />
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
      v-if="!currentTemplate.custom_template"
      v-show="isOpenModal"
      @close-modal="isOpenModal = false"
      @add-custom-template="isTemplateNameModalOpen = true"
      :templateName="
        currentTemplate ? currentTemplate['name_' + currentLang] : ''
      "
      :fields="tableFields"
      :checkedFields.sync="checkedFields"
    />
    <BaseModal
      v-if="!currentTemplate.custom_template"
      v-show="isTemplateNameModalOpen"
      type="edit"
      heading="Введите название шаблона"
      inputLabel="Название"
      :inputValue.sync="customTemplateName"
      @close-modal="isTemplateNameModalOpen = false"
      @modal-response="handleCustomTemplateSave"
    />
    <BaseModal
      v-if="currentTemplate.custom_template"
      v-show="isDeleteTemplateModalOpen"
      type="delete"
      :heading="
        `${trans('plast_fluids.sure_want_to_delete_optional')}
          ${currentTemplate['name_' + currentLang]}?`
      "
      @close-modal="isDeleteTemplateModalOpen = false"
      @modal-response="handleCustomTemplateDelete"
    />
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import BaseTable from "./BaseTable.vue";
import BaseModal from "./BaseModal.vue";
import Modal from "./MonitoringDownloadTableModal.vue";
import {
  downloadExcelFile,
  convertToFormData,
  compareNumbers,
} from "../helpers";
import {
  getTemplateFile,
  saveCustomTemplate,
  deleteCustomTemplate,
} from "../services/templateService";

export default {
  name: "MonitoringDownloadTable",
  data() {
    return {
      isOpenModal: false,
      isTemplateNameModalOpen: false,
      isDeleteTemplateModalOpen: false,
      customTemplateName: "",
      checkedFields: [],
    };
  },
  inject: {
    userID: {
      default: "",
    },
    userName: {
      default: "",
    },
  },
  components: {
    BaseTable,
    BaseModal,
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
      handler() {
        this.handleTableData({
          user_id: this.userID,
          type: "upload",
        });
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleTableData", "getTemplates"]),
    async handleCustomTemplateSave() {
      try {
        const payload = {
          columns: this.checkedFields.sort(compareNumbers),
          user: this.userName,
          user_id: this.userID,
          parent_template_id: this.currentTemplate.id,
          name: this.customTemplateName,
          description: "",
        };
        const response = await saveCustomTemplate(payload);
        this.getTemplates({
          userID: this.userID,
          lang: this.currentLang,
          templateID: response.id,
        });
        this.handleTableData({
          user_id: this.userID,
          report_id: response.id,
          type: "upload",
        });
      } catch (error) {
        alert(this.trans("plast_fluids.unexpected_error"));
      }
    },
    async handleCustomTemplateDelete() {
      try {
        const payload = {
          custom_template_id: this.currentTemplate.id,
          user_id: this.userID,
        };
        await deleteCustomTemplate(payload);
        this.getTemplates({
          userID: this.userID,
          lang: this.currentLang,
          templateID: 1,
        });
        this.handleTableData({
          user_id: this.userID,
          type: "upload",
        });
      } catch (error) {
        alert(this.trans("plast_fluids.unexpected_error"));
      }
    },
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
        user_id: this.userID,
        type: "upload",
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
