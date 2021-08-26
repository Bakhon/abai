<template>
  <div class="monitoring-table-div">
    <p class="monitoring-table-title">
      {{ trans("plast_fluids.downloads_monitoring") }}
    </p>
    <BaseTable
      :fields="fields"
      :items="computedTableData"
      @sort-by-arrow-filter="sortByKey"
      @show-items-per-page="showItemsPerPage"
      pagination
      filter
      sticky
    />
  </div>
</template>

<script>
import BaseTable from "./BaseTable.vue";
import { getTemplateHistory } from "../services/templateService";
import moment from "moment";

export default {
  name: "MonitoringDataTable",
  components: {
    BaseTable,
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
      tableDataFilterOptions: {
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
  computed: {
    computedTableData() {
      const data = this.items.map((item) => ({
        ...item,
        upload_datetime: moment(item.upload_datetime).format("YYYY-MM-DD"),
      }));
      return data;
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
</style>
