<template>
  <div class="monitoring-table-div">
    <p class="monitoring-table-title">
      {{ trans("plast_fluids.downloads_monitoring") }}
    </p>
    <BaseTable
      :fields="fields"
      :items="computedTableData"
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
          name: "Дата загрузки",
        },
        {
          key: "author",
          name: "Автор загрузки",
        },
        {
          key: "subsoil_user",
          name: "Недропользователь",
        },
        {
          key: "oil_field",
          name: "Месторождение",
        },
        {
          key: "selection_date_start",
          name: "Дата отбора начало",
        },
        {
          key: "selection_date_end",
          name: "Дата отбора конец",
        },
        {
          key: "template_type",
          name: "Тип данных",
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
    async handleTemplateHistory() {
      const postData = new FormData();
      for (let key in this.tableDataFilterOptions) {
        postData.append(key, this.tableDataFilterOptions[key]);
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
