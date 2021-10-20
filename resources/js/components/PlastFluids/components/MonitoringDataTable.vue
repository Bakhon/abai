<template>
  <div class="monitoring-table-div">
    <p class="monitoring-table-title">
      {{ trans("plast_fluids.downloads_monitoring") }}
    </p>
    <div class="loader-holder" v-if="loading">
      <SmallCatLoader :loading="loading" page="upload" />
    </div>
    <BaseTable
      :fields="fields"
      :items="items"
      :allPageCount="allPageCount"
      :currentPage="currentPage"
      @sort-by-arrow-filter="sortByKey"
      @show-items-per-page="showItemsPerPage"
      tableType="upload"
      pagination
      filter
      sticky
    />
  </div>
</template>

<script>
import BaseTable from "./BaseTable.vue";
import SmallCatLoader from "./SmallCatLoader.vue";
import { getTemplateHistory } from "../services/templateService";
import { mapState } from "vuex";

export default {
  name: "MonitoringDataTable",
  components: {
    SmallCatLoader,
    BaseTable,
  },
  computed: {
    ...mapState("plastFluidsLocal", ["loading"]),
  },
  props: {
    currentSubsoil: Object,
    currentSubsoilField: Object,
  },
  data() {
    return {
      fields: [
        {
          key: "upload_datetime",
          name: this.trans("plast_fluids.upload_date"),
        },
        {
          key: "author",
          name: this.trans("plast_fluids.download_author"),
        },
        {
          key: "subsoil_user",
          name: this.trans("plast_fluids.subsurface_user"),
        },
        {
          key: "oil_field",
          name: this.trans("plast_fluids.field"),
        },
        {
          key: "selection_date_start",
          name: this.trans("plast_fluids.selection_date_start"),
        },
        {
          key: "selection_date_end",
          name: this.trans("plast_fluids.selection_date_end"),
        },
        {
          key: "template_type",
          name: this.trans("plast_fluids.data_type"),
        },
      ],
      items: [],
      currentPage: 1,
      allPageCount: 1,
      tableDataFilterOptions: {
        id_owner: this.currentSubsoil?.owner_id || "all",
        id_field: this.currentSubsoilField?.field_id || "all",
        row_on_page: 30,
        page_number: 1,
        author: "None",
        subsoil_user: "None",
        oil_field: "None",
        upload_datetime: "None",
        selection_date_start: "None",
        selection_date_end: "None",
        template_type: "None",
        loaded_samples_number: "None",
      },
    };
  },
  watch: {
    currentSubsoil(value) {
      this.tableDataFilterOptions = {
        ...this.tableDataFilterOptions,
        id_owner: value?.owner_id || "all",
        id_field: "all",
      };
      this.handleTemplateHistory();
    },
    currentSubsoilField(value) {
      this.tableDataFilterOptions = {
        ...this.tableDataFilterOptions,
        id_field: value?.field_id || "all",
      };
      this.handleTemplateHistory();
    },
  },
  methods: {
    showItemsPerPage(val) {
      this.tableDataFilterOptions = {
        ...this.tableDataFilterOptions,
        row_on_page: val,
      };
      this.handleTemplateHistory();
    },
    sortByKey({ key, type }) {
      const copyTableDataFilterOptions = {
        ...this.tableDataFilterOptions,
        [key]: type === "up" ? "Up" : "Down",
      };
      this.handleTemplateHistory(copyTableDataFilterOptions);
    },
    async handleTemplateHistory(
      tableDataFilters = this.tableDataFilterOptions
    ) {
      const postData = new FormData();
      for (let key in tableDataFilters) {
        postData.append(key, tableDataFilters[key]);
      }
      const responseData = await getTemplateHistory(postData);
      this.allPageCount = responseData.pages_count;
      this.items = responseData.data;
    },
  },
  mounted() {
    this.handleTemplateHistory();
  },
};
</script>

<style scoped>
.monitoring-table-div {
  display: flex;
  flex-flow: column;
  position: relative;
  justify-content: space-between;
  flex: 2 1 auto;
  padding: 15px;
  background: #272953;
  margin: 0 10px;
}

.monitoring-table-title {
  margin-bottom: 17px;
  width: 100%;
  text-align: start;
  font-weight: bold;
  font-size: 22px;
  color: #fff;
  height: 30px;
}

.loader-holder {
  position: absolute;
  width: 100%;
  height: calc(100% - 47px);
  z-index: 100;
}
</style>
