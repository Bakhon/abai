<template>
  <div
    class="monitoring-table-div"
    :class="{ center: isEmpty(currentSubsoilField[0]) }"
  >
    <template v-if="currentSubsoilField[0] && currentSubsoilField[0].field_id">
      <div class="table-title-holder">
        <p class="monitoring-table-title">
          {{
            isEmpty(currentTemplate)
              ? trans("plast_fluids.research_exploration")
              : currentTemplate["name_" + currentLang]
          }}
        </p>
        <button @click="isOpenModal = true">
          <img src="/img/PlastFluids/settings.svg" alt="customize table" />
        </button>
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
        isEmpty(currentTemplate)
          ? trans('plast_fluids.research_exploration')
          : currentTemplate['name_' + currentLang]
      "
      :fields="tableFields"
    />
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import BaseTable from "./BaseTable.vue";
import Modal from "./MonitoringDownloadTableModal.vue";
import _ from "lodash";

export default {
  name: "MonitoringDownloadTable",
  data() {
    return {
      isOpenModal: false,
    };
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
        this.handleTableData({ field_id: value[0].field_id });
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleTableData"]),
    isEmpty(obj) {
      return _.isEmpty(obj);
    },
  },
  mounted() {
    if (
      this.currentSubsoilField[0].field_id &&
      !this.tableRows.length &&
      !this.tableFields.length
    )
      this.handleTableData({ field_id: this.currentSubsoilField[0].field_id });
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

.table-title-holder > button {
  border: none;
  background-color: unset;
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
